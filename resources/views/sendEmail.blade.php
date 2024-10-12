<!DOCTYPE html>
<html>
<head>
    <title>{{ $subject }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }
        h2 {
            color: #4CAF50;
        }
        p {
            font-size: 16px;
        }
        .otp {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin: 20px 0;
        }
        .footer {
            font-size: 12px;
            color: #888;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Password Reset Request</h2>
        <p>Hello,</p>
        <p>You requested to reset your password. Please use the following OTP (One Time Password) to proceed:</p>
        <p class="otp">{{ $messageBody }}</p>
        <p>This OTP will expire in 3 minutes.</p>
        <p>If you did not request a password reset, please ignore this email.</p>
        <div class="footer">
            <p>Regards,</p>
            <p>Quest Colombo Team</p>
        </div>
    </div>
</body>
</html>
