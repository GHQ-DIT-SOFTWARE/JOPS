<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>GHQ Duty Roster Credentials</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #3f80ea; color: white; padding: 20px; text-align: center; }
        .content { background: #f9f9f9; padding: 20px; border-radius: 5px; }
        .credentials { background: #fff; padding: 15px; border: 1px solid #ddd; border-radius: 5px; margin: 15px 0; }
        .warning { background: #fff3cd; color: #856404; padding: 10px; border-radius: 5px; border: 1px solid #ffeaa7; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>GHQ Duty Roster System</h1>
        </div>
        
        <div class="content">
            <h2>Hello {{ $officer->fname }},</h2>
            
            <p>Your credentials for the GHQ Duty Roster System have been created.</p>
            
            <div class="credentials">
                <h3>Your Login Details:</h3>
                <p><strong>Service Number:</strong> {{ $officer->service_no }}</p>
                <p><strong>Temporary Password:</strong> {{ $temp_password }}</p>
                @if($expires_at)
                <p><strong>Password Expires:</strong> {{ $expires_at->format('Y-m-d H:i:s') }}</p>
                @endif
            </div>
            
            <div class="warning">
                <strong>Important:</strong> This is a temporary password. Please change it after your first login.
                The password will expire in 5 minutes for security reasons.
            </div>
            
            <p>You can access the system at: <a href="{{ url('/') }}">{{ url('/') }}</a></p>
            
            <p>If you have any issues logging in, please contact your unit administrator.</p>
            
            <p>Thank you,<br>GHQ Duty Roster System</p>
        </div>
    </div>
</body>
</html>