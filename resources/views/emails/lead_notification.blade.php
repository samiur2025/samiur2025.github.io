<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Lead Received</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; color: #333; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; border-top: 4px solid #00f0ff; }
        h2 { margin-top: 0; }
        .field { margin-bottom: 15px; }
        .label { font-weight: bold; color: #555; font-size: 12px; text-transform: uppercase; }
        .value { background: #f9f9f9; padding: 10px; border-radius: 4px; margin-top: 5px; white-space: pre-wrap; }
    </style>
</head>
<body>
    <div class="container">
        <h2>You have a new lead!</h2>
        <p>A new client has just submitted a contact form on your portfolio.</p>
        
        <div class="field">
            <div class="label">Name</div>
            <div class="value">{{ $lead->name }}</div>
        </div>
        
        <div class="field">
            <div class="label">Email Address</div>
            <div class="value">{{ $lead->email }}</div>
        </div>
        
        <div class="field">
            <div class="label">Project Description</div>
            <div class="value">{{ $lead->description }}</div>
        </div>
        
        <div class="field">
            <div class="label">Date Submitted</div>
            <div class="value">{{ $lead->created_at->format('M d, Y h:i A') }}</div>
        </div>
        
        <p style="margin-top: 20px;">
            <a href="{{ url('/admin') }}" style="display: inline-block; padding: 10px 20px; background: #0c0c14; color: #fff; text-decoration: none; border-radius: 4px;">View in Dashboard</a>
        </p>
    </div>
</body>
</html>
