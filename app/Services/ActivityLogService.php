<?php
namespace App\Services;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\DutyRoster;
use Illuminate\Database\Eloquent\Model;

class ActivityLogService
{
    /**
     * Log an activity
     */
    public static function log(
        string $action,
        Model $model = null,
        User $user = null,
        string $description = '',
        array $details = [],
        Request $request = null
    ): ActivityLog {
        $user = $user ?? auth()->user();
        $ipAddress = $request ? $request->ip() : request()->ip();
        
        $logData = [
            'action' => $action,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model ? $model->id : null,
            'description' => $description,
            'details' => $details,
            'date_time' => now(),
            'ip_address' => $ipAddress,
            'user_agent' => $request ? $request->userAgent() : request()->userAgent(),
        ];
        
        // Only add user information if available
        if ($user) {
            $logData['user_id'] = $user->id;
            $logData['service_no'] = $user->service_no;
            $logData['name'] = $user->fname;
        }
        
        return ActivityLog::create($logData);
    }

    // ==================== AUTHENTICATION LOGGING ====================

    /**
     * Log user login
     */
    public static function logLogin(User $user, Request $request = null)
    {
        return self::log(
            'logged_in',
            null,
            $user,
            "Logged in as " . $user->roleName(),
            [
                'login_time' => now()->toDateTimeString(),
                'session_id' => session()->getId()
            ],
            $request
        );
    }

    /**
     * Log user logout
     */
    public static function logLogout(User $user, Request $request = null)
    {
        return self::log(
            'logged_out',
            null,
            $user,
            "Logged out as " . $user->roleName(),
            [
                'logout_time' => now()->toDateTimeString(),
                'session_id' => session()->getId()
            ],
            $request
        );
    }

    /**
     * Log failed login attempt
     */
    public static function logFailedLogin(string $serviceNo, Request $request = null)
    {
        $ipAddress = $request ? $request->ip() : request()->ip();
        
        return ActivityLog::create([
            'service_no' => $serviceNo,
            'action' => 'login_failed',
            'description' => "Failed login attempt",
            'details' => [
                'attempted_service_no' => $serviceNo,
                'attempt_time' => now()->toDateTimeString(),
                'user_agent' => $request ? $request->userAgent() : request()->userAgent(),
                'ip_address' => $ipAddress
            ],
            'date_time' => now(),
            'ip_address' => $ipAddress,
            'user_agent' => $request ? $request->userAgent() : request()->userAgent(),
        ]);
    }

    /**
     * Log password change
     */
    public static function logPasswordChange(User $user, Request $request = null)
    {
        return self::log(
            'password_changed',
            null,
            $user,
            "Changed password",
            [
                'change_time' => now()->toDateTimeString()
            ],
            $request
        );
    }

    // ==================== DUTY ROSTER LOGGING ====================

    /**
     * Log a duty roster submission
     */
    public static function logRosterSubmission($month, $year, User $user = null, Request $request = null)
    {
        return self::log(
            'submitted',
            null,
            $user,
            "Submitted duty roster for {$month}-{$year}",
            ['month' => $month, 'year' => $year],
            $request
        );
    }

    /**
     * Log a duty roster publication
     */
    public static function logRosterPublication($month, $year, User $user = null, Request $request = null)
    {
        return self::log(
            'published',
            null,
            $user,
            "Published duty roster for {$month}-{$year}",
            ['month' => $month, 'year' => $year],
            $request
        );
    }

    /**
     * Log a duty replacement
     */
    public static function logReplacement(
        DutyRoster $dutyRoster,
        User $replacedUser,
        User $newUser,
        User $performedBy = null,
        Request $request = null
    ) {
        return self::log(
            'replaced',
            $dutyRoster,
            $performedBy,
            "Replaced {$replacedUser->fname} with {$newUser->fname} on duty",
            [
                'duty_date' => $dutyRoster->duty_date->format('Y-m-d'),
                'replaced_user_id' => $replacedUser->id,
                'replaced_user_name' => $replacedUser->fname,
                'new_user_id' => $newUser->id,
                'new_user_name' => $newUser->fname,
            ],
            $request
        );
    }

    /**
     * Log duty assignment
     */
    public static function logDutyAssignment(
        DutyRoster $dutyRoster,
        User $assignedUser,
        User $performedBy = null,
        bool $isExtra = false,
        Request $request = null
    ) {
        return self::log(
            $isExtra ? 'extra_duty' : 'assigned',
            $dutyRoster,
            $performedBy,
            $isExtra ? 
                "Assigned extra duty to {$assignedUser->fname}" : 
                "Assigned duty to {$assignedUser->fname}",
            [
                'duty_date' => $dutyRoster->duty_date->format('Y-m-d'),
                'assigned_user_id' => $assignedUser->id,
                'assigned_user_name' => $assignedUser->fname,
                'is_extra' => $isExtra,
            ],
            $request
        );
    }

    /**
     * Log duty removal
     */
    public static function logDutyRemoval(
        DutyRoster $dutyRoster,
        User $removedUser,
        User $performedBy = null,
        Request $request = null
    ) {
        return self::log(
            'removed',
            $dutyRoster,
            $performedBy,
            "Removed {$removedUser->fname} from duty",
            [
                'duty_date' => $dutyRoster->duty_date->format('Y-m-d'),
                'removed_user_id' => $removedUser->id,
                'removed_user_name' => $removedUser->fname,
            ],
            $request
        );
    }

    // ==================== USER MANAGEMENT LOGGING ====================

    /**
     * Log user creation
     */
    public static function logUserCreation(User $createdUser, User $performedBy = null, Request $request = null)
    {
        return self::log(
            'user_created',
            $createdUser,
            $performedBy,
            "Created user account for {$createdUser->fname}",
            [
                'created_user_id' => $createdUser->id,
                'created_user_name' => $createdUser->fname,
                'created_user_role' => $createdUser->roleName(),
            ],
            $request
        );
    }

    /**
     * Log user update
     */
    public static function logUserUpdate(User $updatedUser, array $changes, User $performedBy = null, Request $request = null)
    {
        return self::log(
            'user_updated',
            $updatedUser,
            $performedBy,
            "Updated user account for {$updatedUser->fname}",
            [
                'updated_user_id' => $updatedUser->id,
                'updated_user_name' => $updatedUser->fname,
                'changes' => $changes,
            ],
            $request
        );
    }

    /**
     * Log user deletion
     */
    public static function logUserDeletion(User $deletedUser, User $performedBy = null, Request $request = null)
    {
        return self::log(
            'user_deleted',
            null,
            $performedBy,
            "Deleted user account for {$deletedUser->fname}",
            [
                'deleted_user_id' => $deletedUser->id,
                'deleted_user_name' => $deletedUser->fname,
                'deleted_user_role' => $deletedUser->roleName(),
            ],
            $request
        );
    }

    // ==================== ACCOUNT MANAGEMENT LOGGING ====================

    /**
     * Log account creation for duty officers
     */
    public static function logAccountCreation(User $officer, User $performedBy = null, Request $request = null)
    {
        return self::log(
            'account_created',
            $officer,
            $performedBy,
            "Created account for duty officer {$officer->fname}",
            [
                'officer_id' => $officer->id,
                'officer_name' => $officer->fname,
                'officer_service_no' => $officer->service_no,
            ],
            $request
        );
    }

    /**
     * Log temporary password generation
     */
    public static function logTempPasswordGeneration(User $officer, User $performedBy = null, Request $request = null)
    {
        return self::log(
            'temp_password_generated',
            $officer,
            $performedBy,
            "Generated temporary password for {$officer->fname}",
            [
                'officer_id' => $officer->id,
                'officer_name' => $officer->fname,
                'generation_time' => now()->toDateTimeString(),
            ],
            $request
        );
    }

    // ==================== COMMUNICATION LOGGING ====================

    /**
     * Log SMS sent to user
     */
    public static function logSmsSent(User $recipient, string $message, User $performedBy = null, Request $request = null)
    {
        return self::log(
            'sms_sent',
            $recipient,
            $performedBy,
            "Sent SMS to {$recipient->fname}",
            [
                'recipient_id' => $recipient->id,
                'recipient_name' => $recipient->fname,
                'recipient_phone' => $recipient->phone,
                'message_length' => strlen($message),
                'message_preview' => substr($message, 0, 100) . (strlen($message) > 100 ? '...' : ''),
            ],
            $request
        );
    }

    /**
     * Log email sent to user
     */
    public static function logEmailSent(User $recipient, string $subject, User $performedBy = null, Request $request = null)
    {
        return self::log(
            'email_sent',
            $recipient,
            $performedBy,
            "Sent email to {$recipient->fname}",
            [
                'recipient_id' => $recipient->id,
                'recipient_name' => $recipient->fname,
                'recipient_email' => $recipient->email,
                'email_subject' => $subject,
            ],
            $request
        );
    }

    /**
     * Log bulk communication
     */
    public static function logBulkCommunication(string $type, int $recipientCount, User $performedBy = null, Request $request = null)
    {
        return self::log(
            'bulk_communication',
            null,
            $performedBy,
            "Sent bulk {$type} to {$recipientCount} recipients",
            [
                'communication_type' => $type,
                'recipient_count' => $recipientCount,
                'sent_time' => now()->toDateTimeString(),
            ],
            $request
        );
    }

    // ==================== SYSTEM & SECURITY LOGGING ====================

    /**
     * Log unauthorized access attempt
     */
    public static function logUnauthorizedAccess(string $route, User $user = null, Request $request = null)
    {
        return self::log(
            'unauthorized_access',
            null,
            $user,
            "Attempted unauthorized access to {$route}",
            [
                'attempted_route' => $route,
                'attempt_time' => now()->toDateTimeString(),
                'user_role' => $user ? $user->roleName() : 'Unknown',
            ],
            $request
        );
    }

    /**
     * Log system error
     */
    public static function logSystemError(string $errorMessage, string $location, Request $request = null)
    {
        $ipAddress = $request ? $request->ip() : request()->ip();
        
        return ActivityLog::create([
            'action' => 'system_error',
            'description' => "System error occurred",
            'details' => [
                'error_message' => $errorMessage,
                'error_location' => $location,
                'error_time' => now()->toDateTimeString(),
                'ip_address' => $ipAddress,
            ],
            'date_time' => now(),
            'ip_address' => $ipAddress,
            'user_agent' => $request ? $request->userAgent() : request()->userAgent(),
        ]);
    }

    /**
     * Log database operation
     */
    public static function logDatabaseOperation(string $operation, string $table, array $data = [], User $performedBy = null, Request $request = null)
    {
        return self::log(
            'database_operation',
            null,
            $performedBy,
            "Performed {$operation} operation on {$table}",
            [
                'operation' => $operation,
                'table' => $table,
                'data' => $data,
                'operation_time' => now()->toDateTimeString(),
            ],
            $request
        );
    }

    // ==================== GENERAL PURPOSE LOGGING ====================

    /**
     * Log general user activity
     */
    public static function logUserActivity(
        string $action,
        string $description,
        User $user = null,
        array $details = [],
        Request $request = null
    ) {
        return self::log(
            $action,
            null,
            $user,
            $description,
            $details,
            $request
        );
    }

    /**
     * Log system activity (no user associated)
     */
    public static function logSystemActivity(
        string $action,
        string $description,
        array $details = [],
        Request $request = null
    ) {
        $ipAddress = $request ? $request->ip() : request()->ip();
        
        return ActivityLog::create([
            'action' => $action,
            'description' => $description,
            'details' => $details,
            'date_time' => now(),
            'ip_address' => $ipAddress,
            'user_agent' => $request ? $request->userAgent() : request()->userAgent(),
        ]);
    }

    // ==================== BULK OPERATIONS LOGGING ====================

    /**
     * Log bulk user operations
     */
    public static function logBulkOperation(string $operation, int $count, array $details = [], User $performedBy = null, Request $request = null)
    {
        return self::log(
            'bulk_operation',
            null,
            $performedBy,
            "Performed bulk {$operation} on {$count} items",
            array_merge([
                'operation' => $operation,
                'item_count' => $count,
                'operation_time' => now()->toDateTimeString(),
            ], $details),
            $request
        );
    }
}