<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Helpers\Traits\SendsSMS;
use App\Mail\OfficerCommunication;
use App\Mail\BulkOfficerCommunication;

class CommunicationController extends Controller
{
    use SendsSMS;

    /**
     * Send email to specific user
     */
    public function sendEmail(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject' => 'sometimes|string|max:255',
            'message' => 'sometimes|string'
        ]);

        $user = User::findOrFail($validated['user_id']);

        try {
            $subject = $validated['subject'] ?? 'Officer Communication';
            $messageContent = $validated['message'] ?? 'This is a test email to officer.';

            Mail::to($user->email)
                ->send(new OfficerCommunication($subject, $messageContent));

            Log::info("Email sent successfully", [
                'user_id' => $user->id,
                'email' => $user->email
            ]);

            return back()->with('success', "Email sent to {$user->fname}");

        } catch (\Exception $e) {
            Log::error("Failed to send email", [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', "Failed to send email: " . $e->getMessage());
        }
    }

    /**
 * Send SMS to specific user
 */
public function sendSms(User $user)
{
    try {
        $serviceNo = $user->service_no ?? 'N/A';
        $rank = $user->display_rank ?? 'N/A';
        $fname = $user->fname ?? 'Officer';

        $smsText = "📢 Service No: $serviceNo – $rank $fname: Your account has been successfully created. Please log in and follow the instructions provided.\n\n– Directorate of Information Technology – GHQ(DIT)";

        Log::info("Attempting to send SMS", [
            'user_id' => $user->id,
            'phone' => $user->phone
        ]);

        $sent = $this->sendSMS($user, $smsText);

        if ($sent) {
            $user->update(['last_sms_sent_at' => now()]);
            Log::info("SMS sent successfully", ['user_id' => $user->id]);
            return response()->json([
                'success' => true, 
                'message' => 'SMS sent successfully to ' . $user->fname
            ]);
        }

        Log::error("Failed to send SMS", ['user_id' => $user->id]);
        return response()->json([
            'success' => false, 
            'message' => 'Failed to send SMS. Please check phone number format.'
        ], 500);

    } catch (\Exception $e) {
        Log::error("Exception in sendSms", [
            'user_id' => $user->id,
            'error' => $e->getMessage()
        ]);
        
        return response()->json([
            'success' => false, 
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Send bulk communications
 */
public function sendBulk(Request $request)
{
    try {
        $validated = $request->validate([
            'type' => 'required|in:email,sms',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $users = User::whereIn('id', $validated['user_ids'])->get();
        $type = $validated['type'];

        Log::info("Starting bulk communication", [
            'type' => $type,
            'user_count' => $users->count()
        ]);

        $results = ['success' => 0, 'failed' => 0, 'details' => []];

        foreach ($users as $user) {
            try {
                if ($type === 'sms') {
                    // Use the same SMS logic as single send
                    $serviceNo = $user->service_no ?? 'N/A';
                    $rank = $user->display_rank ?? 'N/A';
                    $fname = $user->fname ?? 'Officer';
                    
                    $smsText = "📢 Service No: $serviceNo – $rank $fname: Your account has been successfully created. Please log in and follow the instructions provided.\n\n– Directorate of Information Technology – GHQ(DIT)";

                    $sent = $this->sendSMS($user, $smsText);
                    
                    if ($sent) {
                        $user->update(['last_sms_sent_at' => now()]);
                        $results['success']++;
                        $results['details'][] = "SMS sent to {$user->phone}";
                    } else {
                        $results['failed']++;
                        $results['details'][] = "Failed to send SMS to {$user->phone}";
                    }
                }
                
            } catch (\Exception $e) {
                $results['failed']++;
                $results['details'][] = "Error for {$user->phone}: " . $e->getMessage();
                Log::error("Failed to send {$type}", [
                    'user_id' => $user->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        Log::info("Bulk communication completed", $results);

        return response()->json([
            'success' => true,
            'message' => "{$results['success']} SMS messages sent successfully. {$results['failed']} failed.",
            'details' => $results['details']
        ]);

    } catch (\Exception $e) {
        Log::error("Bulk communication error", ['error' => $e->getMessage()]);
        
        return response()->json([
            'success' => false,
            'message' => 'Error processing bulk request: ' . $e->getMessage()
        ], 500);
    }
}

   

    /**
     * Get user communication preferences
     */
    public function getUserCommunicationInfo(User $user)
    {
        return response()->json([
            'email' => $user->email,
            'phone' => $user->phone,
            'has_email' => !empty($user->email),
            'has_phone' => !empty($user->phone),
            'last_sms_sent_at' => $user->last_sms_sent_at,
            'last_email_sent_at' => $user->last_email_sent_at
        ]);
    }
}