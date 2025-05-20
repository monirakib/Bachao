<!DOCTYPE html>
<html>
<head>
    <title>Medical Record Shared</title>
</head>
<body>
    <h2>Medical Record Access</h2>
    <p>{{ $patientName }} has shared their medical record with you.</p>
    
    <p>You can access the record until: {{ $validUntil }}</p>
    
    @if($notes)
    <p><strong>Additional Notes:</strong><br>
    {{ $notes }}</p>
    @endif

    <p>Click the link below to view the record:</p>
    <a href="{{ $url }}">View Medical Record</a>

    <p>This link will expire on {{ $validUntil }}.</p>
</body>
</html>