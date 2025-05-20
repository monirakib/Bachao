<!DOCTYPE html>
<html>
<head>
    <title>Medical Record Shared</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(to right, #dd2476, #ff512f);
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
        }
        .content {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background: #dd2476;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Medical Record Access</h1>
    </div>
    
    <div class="content">
        <p>Dear Healthcare Provider,</p>
        
        <p>{{ $patientName }} has shared their medical record with you.</p>
        
        <p><strong>Record Details:</strong></p>
        <ul>
            <li>Record Type: {{ $recordType }}</li>
            <li>Date Created: {{ $dateCreated }}</li>
            <li>Valid Until: {{ $validUntil }}</li>
        </ul>
        
        @if($notes)
        <p><strong>Additional Notes:</strong><br>
        {{ $notes }}</p>
        @endif

        <p>Click the button below to view the complete record:</p>
        
        <a href="{{ $url }}" class="button">View Medical Record</a>
        
        <p><small>This link will expire on {{ $validUntil }}. Please ensure you access it before then.</small></p>
    </div>
</body>
</html>