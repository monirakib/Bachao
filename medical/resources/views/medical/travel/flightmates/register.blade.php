<!DOCTYPE html>
<html>
<head>
    <title>Register as Flight Mate - Medical Travel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Murecho:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Murecho', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .header {
            background: linear-gradient(to right, #dd2476, #ff512f);
            padding: 1.5rem 0;
            margin-bottom: 2rem;
        }

        .registration-form {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .form-control:focus {
            border-color: #dd2476;
            box-shadow: 0 0 0 0.25rem rgba(221, 36, 118, 0.25);
        }

        .btn-submit {
            background: linear-gradient(to right, #dd2476, #ff512f);
            border: none;
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 25px;
            transition: all 0.3s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(221, 36, 118, 0.2);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="text-white mb-0">
                    <i class="fas fa-user-plus me-2"></i>Register as Flight Mate
                </h2>
                <a href="{{ route('medical.travel.flightmate') }}" class="btn btn-outline-light">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="registration-form">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('medical.travel.flightmate.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label">Service Type</label>
                            <select name="service_type" class="form-select" required>
                                <option value="">Select service type</option>
                                <option value="translator">Translator</option>
                                <option value="travel_agent">Travel Agent</option>
                                <option value="medical_assistant">Medical Assistant</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Languages</label>
                            <input type="text" name="languages" class="form-control" 
                                placeholder="e.g. English, Bengali, Hindi" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Experience (Years)</label>
                            <input type="text" name="experience" class="form-control" 
                                placeholder="Years of experience in this field" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Hourly Rate (BDT)</label>
                            <input type="number" name="hourly_rate" class="form-control" 
                                placeholder="Your hourly rate" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Certifications/Qualifications</label>
                            <textarea name="certification" class="form-control" rows="3" 
                                placeholder="List your relevant certifications and qualifications"></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-submit">
                                <i class="fas fa-check-circle me-2"></i>Register as Flight Mate
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>