<!DOCTYPE html>
<html>
<head>
    <title>Shared Medical Record - Medical Services</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100..900;1,100..900&family=Murecho:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Copy styles from show.blade.php but remove edit/share buttons */
        /* Add a watermark showing "Shared Record" */
    </style>
</head>
<body>
    <div class="records-container">
        <div class="record-card">
            <div class="record-header">
                <h1><i class="fas fa-file-medical"></i> Shared Medical Record</h1>
                <div class="share-info">
                    <p>Valid until: {{ \Carbon\Carbon::parse($share->valid_until)->format('F j, Y') }}</p>
                </div>
            </div>

            <div class="record-content">
                <div class="patient-info">
                    <h2>Patient Information</h2>
                    <p>Name: {{ $record->patient_name }}</p>
                </div>

                <div class="record-details">
                    <h2>Record Details</h2>
                    <p><strong>Type:</strong> {{ $record->record_type }}</p>
                    <p><strong>Description:</strong> {!! nl2br(e($record->description)) !!}</p>
                    
                    @if($record->diagnosis)
                        <p><strong>Diagnosis:</strong> {!! nl2br(e($record->diagnosis)) !!}</p>
                    @endif
                    
                    @if($record->treatment)
                        <p><strong>Treatment:</strong> {!! nl2br(e($record->treatment)) !!}</p>
                    @endif
                </div>

                <div class="doctor-info">
                    <h2>Healthcare Provider</h2>
                    <p>Doctor: {{ $record->doctor_name }}</p>
                    <p>Specialization: {{ $record->doctor_specialization }}</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>