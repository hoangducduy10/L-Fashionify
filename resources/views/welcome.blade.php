<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Platform</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #4CAF50;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .content {
            padding: 20px;
            text-align: center;
        }
        .content h2 {
            color: #4CAF50;
            font-size: 22px;
        }
        .content p {
            font-size: 16px;
            line-height: 1.5;
            margin-top: 10px;
        }
        .footer {
            background-color: #f8f8f8;
            padding: 15px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }
        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }
        .button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 25px;
            font-size: 16px;
            text-align: center;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Welcome to Our Platform</h1>
        </div>
        <div class="content">
            <h2>Welcome, {{ $name }}!</h2>
            <p>Thank you for registering on our platform. We are excited to have you with us!</p>
        </div>
        <div class="footer">
            <p>If you did not register for an account, please ignore this email.</p>
            <p>For more information, visit our <a href="https://www.lecommerce.com">website</a>.</p>
        </div>
    </div>
</body>
</html>
