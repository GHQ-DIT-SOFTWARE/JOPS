<?php




namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DutyOfficerAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Services\ActivityLogService;
use App\Models\DutyRoster;
use Carbon\Carbon; 

class CommunicationController extends Controller
{
    public function sendSms(User $user, Request $request)
    {
        try {
            if (empty($user->phone)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Officer does not have a phone number'
                ]);
            }

            $dutyAccount = DutyOfficerAccount::where('user_id', $user->id)
                ->where('duty_month', now()->format('Y-m-01'))
                ->first();

            if (!$dutyAccount || empty($dutyAccount->show_temp_password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No temporary password found for this officer'
                ]);
            }

            $formattedNumber = $this->formatGhanaPhoneNumber($user->phone);

            if (!$formattedNumber) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid phone number format'
                ]);
            }

            $message = "Hello {$user->fname}, your GHQ Duty Roster credentials have been created. Service No: {$user->service_no}, Temp Password: {$dutyAccount->show_temp_password}. This password expires in 5 minutes.";

            $smsSent = $this->sendViaSmsGateway($formattedNumber, $message);

            if ($smsSent) {
                // Log the activity
                ActivityLogService::logSmsSent($user, $message, auth()->user(), $request);
                
                Log::info("SMS sent to officer: {$user->fname} ({$formattedNumber})");

                return response()->json([
                    'success' => true,
                    'message' => 'SMS sent successfully'
                ]);
            } else {
                throw new \Exception('SMS gateway returned failure');
            }

        } catch (\Exception $e) {
            Log::error("Failed to send SMS to {$user->phone}: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to send SMS: ' . $e->getMessage()
            ]);
        }
    }

    public function sendEmail(User $user, Request $request)
{
    try {
        // Check if the user has an email address
        if (empty($user->email)) {
            return response()->json([
                'success' => false,
                'message' => 'Officer does not have an email address'
            ]);
        }

        // Fetch the duty roster account for the current month
        $dutyAccount = DutyOfficerAccount::where('user_id', $user->id)
            ->where('duty_month', now()->format('Y-m-01'))
            ->first();

        // Check if the duty account exists
        if (!$dutyAccount) {
            return response()->json([
                'success' => false,
                'message' => 'No duty roster found for this officer'
            ]);
        }

        // Retrieve the duty dates for this officer
        $dutyDates = DutyRoster::where('user_id', $user->id)
            ->whereMonth('duty_date', now()->month)
            ->whereYear('duty_date', now()->year)
            ->pluck('duty_date');
        
        // Format the duty dates
        $formattedDates = $dutyDates->map(function($date) {
            return Carbon::parse($date)->format('M j, Y');
        })->toArray();

        $datesList = implode("\n", $formattedDates);
        
        // Prepare the email message
        $subject = "Your Duty Roster for " . now()->format('M/Y');
        $message = "
            Dear {$user->fname},\n\n
            Your duty roster for " . now()->format('M/Y') . " has been published.\n\n
            You are scheduled for duty on the following dates:\n
            {$datesList}\n\n
            Please make necessary arrangements.\n\n
            Thank you,\n
            Duty Roster System
        ";

        // Send the email using Laravel's Mail facade
        Mail::raw($message, function ($mail) use ($user, $subject) {
            $mail->to($user->email)
                 ->subject($subject);
        });

        // Log the activity
        ActivityLogService::logEmailSent($user, 'Duty Roster for ' . now()->format('M/Y'), auth()->user(), $request);

        Log::info("Email sent to officer: {$user->fname} ({$user->email})");

        return response()->json([
            'success' => true,
            'message' => 'Email sent successfully'
        ]);
    } catch (\Exception $e) {
        // Handle the error
        Log::error("Failed to send duty roster email to {$user->email}: " . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Failed to send email: ' . $e->getMessage()
        ]);
    }
}


    public function sendBulkSms(Request $request)
    {
        try {
            $userIds = $request->input('user_ids', []);
            $users = User::whereIn('id', $userIds)->get();

            $successCount = 0;
            $failCount = 0;

            foreach ($users as $user) {
                if (empty($user->phone)) {
                    $failCount++;
                    continue;
                }

                $formattedNumber = $this->formatGhanaPhoneNumber($user->phone);

                if (!$formattedNumber) {
                    $failCount++;
                    continue;
                }

                $dutyAccount = DutyOfficerAccount::where('user_id', $user->id)
                    ->where('duty_month', now()->format('Y-m-01'))
                    ->first();

                if (!$dutyAccount || empty($dutyAccount->show_temp_password)) {
                    $failCount++;
                    continue;
                }

                try {
                    $message = "Hello {$user->fname}, your GHQ Duty Roster credentials. Service No: {$user->service_no}, Temp Password: {$dutyAccount->show_temp_password}. Expires in 5 minutes.";
                    
                    $smsSent = $this->sendViaSmsGateway($formattedNumber, $message);

                    if ($smsSent) {
                        $successCount++;
                        ActivityLogService::logSmsSent($user, $message, auth()->user(), $request);
                        Log::info("Bulk SMS sent to: {$user->fname} ({$formattedNumber})");
                    } else {
                        $failCount++;
                    }

                } catch (\Exception $e) {
                    $failCount++;
                    Log::error("Failed bulk SMS to {$formattedNumber}: " . $e->getMessage());
                }
            }

            // Log bulk operation
            ActivityLogService::logBulkCommunication('sms', $successCount, auth()->user(), $request);

            return response()->json([
                'success' => true,
                'message' => "SMS sent: {$successCount} successful, {$failCount} failed"
            ]);

        } catch (\Exception $e) {
            Log::error("Bulk SMS error: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Bulk SMS operation failed: ' . $e->getMessage()
            ]);
        }
    }

    public function sendBulkEmail(Request $request)
{
    try {
        $userIds = $request->input('user_ids', []);
        $users = User::whereIn('id', $userIds)->get();

        $successCount = 0;
        $failCount = 0;

        foreach ($users as $user) {
            if (empty($user->email)) {
                $failCount++;
                continue;
            }

            $dutyAccount = DutyOfficerAccount::where('user_id', $user->id)
                ->where('duty_month', now()->format('Y-m-01'))
                ->first();

            if (!$dutyAccount) {
                $failCount++;
                continue;
            }

            try {
                // Retrieve the duty dates for this officer
                $dutyDates = DutyRoster::where('user_id', $user->id)
                    ->whereMonth('duty_date', now()->month)
                    ->whereYear('duty_date', now()->year)
                    ->pluck('duty_date');
                
                // Format the duty dates
                $formattedDates = $dutyDates->map(function($date) {
                    return Carbon::parse($date)->format('M j, Y');
                })->toArray();

                $datesList = implode("\n", $formattedDates);
                
                // Prepare the email message
                $subject = "Your Duty Roster for " . now()->format('M/Y');
                $message = "
                    Dear {$user->fname},\n\n
                    Your duty roster for " . now()->format('M/Y') . " has been published.\n\n
                    You are scheduled for duty on the following dates:\n
                    {$datesList}\n\n
                    Please make necessary arrangements.\n\n
                    Thank you,\n
                    Duty Roster System
                ";

                // Send the email using Laravel's Mail facade
                Mail::raw($message, function ($mail) use ($user, $subject) {
                    $mail->to($user->email)
                         ->subject($subject);
                });

                $successCount++;
                ActivityLogService::logEmailSent($user, 'Duty Roster for ' . now()->format('M/Y'), auth()->user(), $request);
                Log::info("Bulk email sent to: {$user->fname} ({$user->email})");

            } catch (\Exception $e) {
                $failCount++;
                Log::error("Failed bulk email to {$user->email}: " . $e->getMessage());
            }
        }

        // Log bulk operation
        ActivityLogService::logBulkCommunication('email', $successCount, auth()->user(), $request);

        return response()->json([
            'success' => true,
            'message' => "Emails sent: {$successCount} successful, {$failCount} failed"
        ]);

    } catch (\Exception $e) {
        Log::error("Bulk email error: " . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Bulk email operation failed: ' . $e->getMessage()
        ]);
    }
}


    // ... keep the existing helper methods (formatGhanaPhoneNumber, sendViaSmsGateway)
    
    /**
     * Format Ghanaian phone numbers to international format
     */
    private function formatGhanaPhoneNumber($phone)
    {
        $phone = preg_replace('/\D/', '', $phone);

        if (str_starts_with($phone, '0')) {
            return '+233' . substr($phone, 1);
        }

        if (str_starts_with($phone, '233') && strlen($phone) === 12) {
            return '+' . $phone;
        }

        if (str_starts_with($phone, '+233') && strlen($phone) === 13) {
            return $phone;
        }

        return null;
    }



    // Reusable SMS sending helper method
protected function sendViaSmsGateway($recipient, string $message): bool
{
    // Handle both objects and strings
    if (is_object($recipient) && property_exists($recipient, 'phone')) {
        $phone = $recipient->phone;
    } else {
        $phone = $recipient; // Assume it's already a phone number
    }

    if (!$phone) {
        Log::error("sendViaSmsGateway called with invalid phone: " . print_r($recipient, true));
        return false;
    }

    // Format the phone number
    $formattedPhone = $this->formatGhanaPhoneNumber($phone);
    
    if (!$formattedPhone) {
        Log::error("Invalid phone number format: " . $phone);
        return false;
    }

    $apiKey = env('MNOTIFY_API_KEY');
    $sender = env('MNOTIFY_SENDER_ID', 'GHQJOPS');
    $url = "https://api.mnotify.com/api/sms/quick?key={$apiKey}";

    $payload = [
        'recipient' => [$formattedPhone],
        'sender' => $sender,
        'message' => $message,
        'is_schedule' => 'false',
    ];

    try {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($url, $payload);

        Log::info('📤 MNotify SMS Attempt', [
            'status' => $response->status(),
            'body' => $response->body(),
            'payload' => $payload,
        ]);

        return $response->successful();
    } catch (\Exception $e) {
        Log::error("❗ Exception while sending SMS to $formattedPhone: " . $e->getMessage());
        return false;
    }
}




// public function testEmail()
// {
//     try {
//         $subject = 'Test Email';
//         $message = 'This is a test email to verify SMTP settings with Brevo.';

//         Mail::raw($message, function($mail) use ($subject) {
//             $mail->to('ojamkwab@gmail.com') // Replace with your actual test email
//                  ->subject($subject);
//         });

//         return response()->json([
//             'success' => true,
//             'message' => 'Test email sent successfully'
//         ]);

//     } catch (\Exception $e) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Failed to send test email: ' . $e->getMessage()
//         ]);
//     }
// }

}