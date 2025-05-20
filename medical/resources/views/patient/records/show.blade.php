<!DOCTYPE html>
<html>
<head>
    <title>Medical Record Details - Medical Services</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100..900;1,100..900&family=Murecho:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Murecho', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .header1 {
            background: linear-gradient(to right, #dd2476, #ff512f);
            height: 90px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 50px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .logo img {
            height: 120px;
            width: 100px;
        }

        .user-section {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .back-button, .print-button {
            padding: 10px 20px;
            background: white;
            color: #dd2476;
            border: 2px solid #dd2476;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .back-button:hover, .print-button:hover {
            background: #dd2476;
            color: white;
        }

        .share-button {
            padding: 10px 20px;
            background: white;
            color: #dd2476;
            border: 2px solid #dd2476;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .share-button:hover {
            background: #dd2476;
            color: white;
        }

        .records-container {
            margin-top: 120px;
            padding: 20px;
            max-width: 1000px;
            margin-left: auto;
            margin-right: auto;
        }

        .record-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .page-title {
            color: #2c3e50;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .record-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .record-doctor {
            font-size: 1.2em;
            color: #2c3e50;
        }

        .doctor-specialization {
            font-size: 0.9em;
            color: #7f8c8d;
            margin-top: 5px;
        }

        .record-content {
            margin-bottom: 25px;
        }

        .record-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
        }

        .record-text {
            color: #34495e;
            line-height: 1.6;
        }

        .record-footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: flex-end;
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
        }

        .status-active {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .status-completed {
            background: #ede7f6;
            color: #4527a0;
        }

        .background-clips {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: -1;
            opacity: 0.1;
        }

        @media print {
            body {
                background: white;
                padding: 20px;
            }

            .header1, .back-button, .print-button {
                display: none;
            }

            .records-container {
                margin-top: 0;
            }

            .record-card {
                box-shadow: none;
                border: 1px solid #ddd;
            }

            .page-title {
                text-align: center;
                margin-bottom: 30px;
            }

            .record-content {
                page-break-inside: avoid;
            }

            @page {
                margin: 2cm;
            }

            .status-badge {
                border: 1px solid #000;
                background: none !important;
                color: #000 !important;
            }

            .print-header {
                display: block !important;
            }
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
        }

        .modal-content {
            position: relative;
            background: white;
            width: 90%;
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .close-modal {
            position: absolute;
            right: 20px;
            top: 15px;
            font-size: 24px;
            cursor: pointer;
            color: #666;
        }

        .share-section {
            margin: 20px 0;
        }

        .share-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin: 15px 0;
        }

        .share-option {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #2c3e50;
            font-weight: 600;
        }

        .form-group input, .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
        }

        .consent-section {
            margin: 20px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .consent-checkbox {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .share-submit-button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(to right, #dd2476, #ff512f);
            color: white;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .share-submit-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(221, 36, 118, 0.3);
        }
    </style>
</head>
<body>
    <nav class="header1">
        <div class="logo">
            <img src="{{ asset('pics/medical/medichain_logo.png') }}" alt="Logo">
        </div>
        <div class="user-section">
            <a href="{{ route('patient.records') }}" class="back-button">
                <i class="fas fa-arrow-left"></i> Back to Records
            </a>
            <button onclick="window.print()" class="print-button">
                <i class="fas fa-print"></i> Print Record
            </button>
            <button onclick="showShareModal()" class="share-button">
                <i class="fas fa-share-alt"></i> Share Record
            </button>
            <span style="color: white;">Welcome, {{ Auth::user()->first_name }}</span>
        </div>
    </nav>

    <div class="records-container">
        <div class="record-card">
            <!-- Add this section for print header -->
            <div class="print-header" style="display: none;">
                <div style="text-align: center; margin-bottom: 20px;">
                    <img src="{{ asset('pics/medical/medichain_logo.png') }}" alt="Logo" style="height: 60px;">
                    <h2 style="margin: 10px 0;">Medical Services</h2>
                    <p>123 Healthcare Avenue, Medical District</p>
                    <p>Phone: (123) 456-7890 | Email: info@medical-services.com</p>
                    <hr style="margin: 20px 0;">
                </div>
            </div>
            <!-- ...rest of your existing record card content... -->
            <h1 class="page-title">
                <i class="fas fa-file-medical"></i>
                Medical Record Details
            </h1>
            
            <div class="record-header">
                <div class="record-doctor">
                    <i class="fas fa-user-md"></i>
                    {{ $record->doctor_name ?? 'Not Assigned' }}
                    <div class="doctor-specialization">
                        {{ $record->doctor_specialization }}
                    </div>
                </div>
                <div class="record-date">
                    <i class="far fa-calendar-alt"></i>
                    {{ \Carbon\Carbon::parse($record->created_at)->format('F j, Y') }}
                </div>
            </div>

            <div class="record-content">
                <div class="record-label">Record Type</div>
                <div class="record-text">{{ $record->record_type }}</div>
            </div>

            <div class="record-content">
                <div class="record-label">Description</div>
                <div class="record-text">{!! nl2br(e($record->description)) !!}</div>
            </div>

            @if($record->diagnosis)
                <div class="record-content">
                    <div class="record-label">Diagnosis</div>
                    <div class="record-text">{!! nl2br(e($record->diagnosis)) !!}</div>
                </div>
            @endif

            @if($record->treatment)
                <div class="record-content">
                    <div class="record-label">Treatment Plan</div>
                    <div class="record-text">{!! nl2br(e($record->treatment)) !!}</div>
                </div>
            @endif

            <div class="record-footer">
                <span class="status-badge {{ $record->status === 'active' ? 'status-active' : 'status-completed' }}">
                    {{ ucfirst($record->status) }}
                </span>
            </div>
        </div>
    </div>

    <video autoplay loop muted plays-inline class="background-clips">
        <source src="{{ asset('pics/medical/medical_dashboard.mp4') }}" type="video/mp4">
    </video>

    <div id="shareModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeShareModal()">&times;</span>
            <h2><i class="fas fa-share-alt"></i> Share Medical Record</h2>
            
            <form id="shareForm" action="{{ route('patient.records.share', $record->id) }}" method="POST">
                @csrf
                <div class="share-section">
                    <h3>Share with Healthcare Providers</h3>
                    <div class="share-options">
                        <label class="share-option">
                            <input type="checkbox" name="share_with[]" value="hospital">
                            <i class="fas fa-hospital"></i> Hospitals
                        </label>
                        <label class="share-option">
                            <input type="checkbox" name="share_with[]" value="pharmacy">
                            <i class="fas fa-pills"></i> Pharmacies
                        </label>
                        <label class="share-option">
                            <input type="checkbox" name="share_with[]" value="insurance">
                            <i class="fas fa-shield-alt"></i> Insurance Providers
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Provider Email</label>
                    <input type="email" name="provider_email" required placeholder="Enter provider's email">
                </div>

                <div class="form-group">
                    <label>Valid Until</label>
                    <input type="date" name="valid_until" required min="{{ date('Y-m-d') }}">
                </div>

                <div class="form-group">
                    <label>Additional Notes</label>
                    <textarea name="notes" placeholder="Any specific instructions or notes"></textarea>
                </div>

                <div class="consent-section">
                    <label class="consent-checkbox">
                        <input type="checkbox" required name="consent">
                        I consent to share my medical record with the selected healthcare provider
                    </label>
                </div>

                <button type="submit" class="share-submit-button">
                    <i class="fas fa-paper-plane"></i> Share Record
                </button>
            </form>
        </div>
    </div>

    <script>
        window.onbeforeprint = function() {
            document.querySelector('.print-header').style.display = 'block';
        };

        window.onafterprint = function() {
            document.querySelector('.print-header').style.display = 'none';
        };

        function showShareModal() {
            document.getElementById('shareModal').style.display = 'block';
        }

        function closeShareModal() {
            document.getElementById('shareModal').style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            let modal = document.getElementById('shareModal');
            if (event.target == modal) {
                closeShareModal();
            }
        }

        // Form submission handling
        document.getElementById('shareForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // You can handle the form submission with AJAX here
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    alert('Record shared successfully!');
                    closeShareModal();
                } else {
                    alert('Error sharing record: ' + data.message);
                }
            })
            .catch(error => {
                alert('Error sharing record. Please try again.');
            });
        });
    </script>
</body>
</html>