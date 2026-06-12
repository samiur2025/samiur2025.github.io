<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank you for reaching out!</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            color: #333333;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .header {
            background: linear-gradient(135deg, #00f0ff, #ff2a6d);
            padding: 40px 30px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .content {
            padding: 40px 30px;
            line-height: 1.6;
        }
        .content p {
            margin: 0 0 20px;
            font-size: 16px;
        }
        .footer {
            background-color: #f9f9f9;
            padding: 20px 30px;
            text-align: center;
            font-size: 14px;
            color: #888888;
            border-top: 1px solid #eeeeee;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #0c0c14;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Thank you for your interest!</h1>
        </div>
        <div class="content">
            <p>Hi {{ $lead->name }},</p>
            <p>Thank you for reaching out to me! I have received your project details and I am thrilled to explore how I can help you achieve your goals.</p>
            <p>I will review your request thoroughly and get back to you as soon as possible, usually within 24 hours, to discuss the next steps.</p>
            <p>In the meantime, feel free to check out some of my previous work or services on my portfolio.</p>
            <center>
                <a href="{{ url('/') }}" class="btn">Visit My Portfolio</a>
            </center>
            <br>
            <p>Best regards,<br><strong>Samiur Rahman</strong></p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Samiur Rahman. All rights reserved.
        </div>
    </div>
</body>
</html>
