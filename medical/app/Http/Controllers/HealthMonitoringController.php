<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HealthMonitoringController extends Controller
{
    private $medicalResponses = [
        // Respiratory Infections
        'respiratory' => [
            'response' => 'Based on your symptoms, it could be a respiratory infection. Common symptoms include: • Cough with/without mucus • Fever and chills • Shortness of breath • Chest pain. Recommended actions: • Get plenty of rest • Stay hydrated • Take paracetamol for fever • Consider antibiotics only if prescribed. Please consult a doctor if symptoms are severe.',
            'keywords' => ['cough', 'breath', 'pneumonia', 'bronchitis', 'chest pain', 'mucus']
        ],
        
        // Diarrheal Diseases
        'diarrhea' => [
            'response' => 'For diarrheal conditions: • Take Oral Rehydration Solution (ORS) • Consider zinc supplements • Avoid contaminated food/water • Stay hydrated. Warning signs: frequent watery stools, dehydration, severe abdominal cramps. Seek medical help if symptoms persist over 3 days.',
            'keywords' => ['diarrhea', 'loose stool', 'dehydration', 'stomach pain', 'vomiting']
        ],
        
        // Dengue
        'dengue' => [
            'response' => '🚨 Your symptoms suggest possible dengue fever. Watch for: • High fever • Severe headache • Eye pain • Joint/muscle pain • Rash. IMPORTANT: • Take paracetamol only (no aspirin) • Drink plenty of fluids • Monitor for bleeding • Seek immediate medical care if symptoms worsen.',
            'keywords' => ['dengue', 'high fever', 'eye pain', 'joint pain', 'rash']
        ],
        
        // Tuberculosis
        'tuberculosis' => [
            'response' => '🚨 Your symptoms suggest possible TB. Key signs: • Persistent cough (>3 weeks) • Weight loss • Night sweats • Fever • Blood in cough. IMPORTANT: Visit a DOTS center immediately for proper diagnosis and treatment. TB requires 6-month antibiotic treatment.',
            'keywords' => ['tb', 'tuberculosis', 'persistent cough', 'night sweat', 'blood cough']
        ],
        
        // Malaria
        'malaria' => [
            'response' => '🚨 Possible malaria symptoms detected. Watch for: • Recurring fever with chills • Headache • Muscle pain • Nausea. URGENT: Get tested for malaria. Treatment includes antimalarial drugs. Use mosquito nets and repellents for prevention.',
            'keywords' => ['malaria', 'recurring fever', 'chills', 'mosquito']
        ],
        
        // Hepatitis
        'hepatitis' => [
            'response' => '🚨 Your symptoms suggest possible hepatitis. Signs include: • Jaundice (yellow skin/eyes) • Fatigue • Right-side abdominal pain • Dark urine. IMPORTANT: • Seek medical care • Avoid alcohol • Rest • Stay hydrated. Different types require different treatments.',
            'keywords' => ['hepatitis', 'jaundice', 'yellow', 'liver', 'dark urine']
        ],
        
        // Hypertension
        'hypertension' => [
            'response' => 'For high blood pressure management: • Reduce salt intake • Exercise regularly • Avoid smoking • Take prescribed medications • Monitor BP regularly. Warning signs: severe headache, dizziness, nosebleeds. Regular check-ups are essential.',
            'keywords' => ['hypertension', 'high blood pressure', 'bp high', 'headache', 'dizziness']
        ],
        
        // Diabetes
        'diabetes' => [
            'response' => 'For diabetes management: • Monitor blood sugar regularly • Control diet (reduce sugar/carbs) • Exercise daily • Take prescribed medications. Warning signs: frequent urination, excessive thirst/hunger, fatigue. Regular doctor visits are important.',
            'keywords' => ['diabetes', 'blood sugar', 'thirst', 'frequent urination']
        ],
        
        // Skin Diseases
        'skin' => [
            'response' => 'For skin conditions: • Maintain good hygiene • Use prescribed creams • Avoid scratching • Wear clean clothes. Common issues: fungal infections, scabies, eczema. See a doctor if condition worsens or spreads.',
            'keywords' => ['skin', 'rash', 'itch', 'fungal', 'scabies', 'eczema']
        ],
        
        // Malnutrition
        'malnutrition' => [
            'response' => 'For malnutrition concerns: • Eat nutrient-rich foods • Include proteins and vitamins • Consider supplements • Get medical evaluation. Important for children\'s growth and development. Seek nutritionist advice for proper diet plan.',
            'keywords' => ['malnutrition', 'weakness', 'underweight', 'nutrition', 'stunted']
        ],
        
        // Emergency conditions
        'emergency' => [
            'response' => '🚨 MEDICAL EMERGENCY! Your symptoms require immediate medical attention. Please: 1. Call emergency services (999) 2. Visit nearest hospital emergency room 3. Don\'t delay seeking help.',
            'keywords' => ['heart attack', 'stroke', 'severe bleeding', 'unconscious', 'cannot breathe', 'emergency']
        ],
        
        // Default response
        'default' => [
            'response' => 'I understand your health concern. While I can provide general information, please consult a healthcare professional for proper medical advice. For emergencies, call 999 or visit the nearest hospital.',
            'keywords' => []
        ]
    ];

    public function index()
    {
        $user = Auth::user();

       
        $metrics = DB::table('health_metrics')
            ->where('user_id', $user->user_id)
            ->where('measured_at', '>=', Carbon::now()->subDays(30))
            ->orderBy('measured_at')
            ->get();

       
        $weightMetrics = $metrics->whereNotNull('weight');
        $weight_dates = $weightMetrics->map(function($metric) {
            return Carbon::parse($metric->measured_at)->format('M d');
        })->values();
        $weight_data = $weightMetrics->pluck('weight')->values();
        $latest_weight = $weightMetrics->last() ? $weightMetrics->last()->weight : null;

        $bpMetrics = $metrics->whereNotNull('blood_pressure');
        $bp_dates = $bpMetrics->map(function($metric) {
            return Carbon::parse($metric->measured_at)->format('M d');
        })->values();
        $bp_systolic = $bpMetrics->map(function($metric) {
            return explode('/', $metric->blood_pressure)[0];
        })->values();
        $bp_diastolic = $bpMetrics->map(function($metric) {
            return explode('/', $metric->blood_pressure)[1];
        })->values();
        $latest_bp = $bpMetrics->last() ? $bpMetrics->last()->blood_pressure : null;

    
        $hrMetrics = $metrics->whereNotNull('heart_rate');
        $hr_dates = $hrMetrics->map(function($metric) {
            return Carbon::parse($metric->measured_at)->format('M d');
        })->values();
        $hr_data = $hrMetrics->pluck('heart_rate')->values();
        $latest_hr = $hrMetrics->last() ? $hrMetrics->last()->heart_rate : null;

        $reminders = DB::table('medication_reminders')
            ->where('user_id', $user->user_id)
            ->where('status', 'active')
            ->where('end_date', '>=', Carbon::today())
            ->get();

        $recommendations = $this->generateRecommendations($metrics);

        return view('health.monitor', compact(
            'weight_dates',
            'weight_data',
            'latest_weight',
            'bp_dates',
            'bp_systolic',
            'bp_diastolic',
            'latest_bp',
            'hr_dates',
            'hr_data',
            'latest_hr',
            'reminders',
            'recommendations'
        ));
    }

    // Update the generateRecommendations method
    function generateRecommendations($metrics)
    {
        $recommendations = collect();

        if ($metrics->isNotEmpty()) {
            $latest = $metrics->last();

            // Weight recommendations
            if ($latest->weight && isset($latest->weight)) {
                if ($latest->weight > $metrics->avg('weight') + 2) {
                    $recommendations->push((object)[
                        'icon' => 'fa-weight',
                        'title' => 'Weight Alert',
                        'description' => 'Your weight has increased significantly. Consider consulting a healthcare provider.'
                    ]);
                }
            }

            // Blood pressure recommendations
            if ($latest->blood_pressure) {
                list($systolic, $diastolic) = explode('/', $latest->blood_pressure);
                if ($systolic > 140 || $diastolic > 90) {
                    $recommendations->push((object)[
                        'icon' => 'fa-heart',
                        'title' => 'BP Alert',
                        'description' => 'Your blood pressure is elevated. Please consult your doctor.'
                    ]);
                }
            }

            // Heart rate recommendations
            if ($latest->heart_rate && $latest->heart_rate > 100) {
                $recommendations->push((object)[
                    'icon' => 'fa-heartbeat',
                    'title' => 'Heart Rate Alert',
                    'description' => 'Your heart rate is elevated. Consider medical evaluation.'
                ]);
            }
        }

        return $recommendations;
    }
   
    public function logMetric(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'value' => 'required'
        ]);

        DB::table('health_metrics')->insert([
            'user_id' => Auth::id(),
            $request->type => $request->value,
            'measured_at' => now()
        ]);

        return response()->json(['success' => true]);
    }

    public function addMedication(Request $request)
    {
        $request->validate([
            'medication_name' => 'required|string',
            'dosage' => 'required|string',
            'frequency' => 'required|string',
            'reminder_time' => 'required'
        ]);

        DB::table('medication_reminders')->insert([
            'user_id' => Auth::id(),
            'medication_name' => $request->medication_name,
            'dosage' => $request->dosage,
            'frequency' => $request->frequency,
            'reminder_time' => $request->reminder_time,
            'start_date' => now(),
            'status' => 'active'
        ]);

        return redirect()->back()->with('success', 'Medication reminder added successfully');
    }

    public function gpt(Request $request)
    {
        $message = strtolower($request->input('message'));

        // Check for blood pressure value in the message (e.g., "my blood pressure is 120/80" or "bp is 140")
        if (preg_match('/(\d{2,3})\s*\/\s*(\d{2,3})/', $message, $matches)) {
            // Format: systolic/diastolic
            $systolic = (int)$matches[1];
            $diastolic = (int)$matches[2];
            $response = $this->getBpAdvice($systolic, $diastolic);
            return response()->json(['status' => 'success', 'response' => $response]);
        } elseif (preg_match('/blood pressure is (\d{2,3})/', $message, $matches) || preg_match('/bp is (\d{2,3})/', $message, $matches)) {
            // Only one value provided, assume systolic
            $systolic = (int)$matches[1];
            $response = $this->getBpAdvice($systolic, null);
            return response()->json(['status' => 'success', 'response' => $response]);
        }

        // ...existing keyword/response logic...

        // Default response
        return response()->json([
            'status' => 'success',
            'response' => $this->medicalResponses['default']['response']
        ]);
    }

    // Add this helper method to your controller:
    private function getBpAdvice($systolic, $diastolic = null)
    {
        if ($diastolic !== null) {
            if ($systolic < 90 || $diastolic < 60) {
                return "Your blood pressure ($systolic/$diastolic mmHg) is considered low. If you feel dizzy or unwell, consult a healthcare provider.";
            } elseif ($systolic < 120 && $diastolic < 80) {
                return "Your blood pressure ($systolic/$diastolic mmHg) is in the normal range. Keep up a healthy lifestyle!";
            } elseif ($systolic < 130 && $diastolic < 80) {
                return "Your blood pressure ($systolic/$diastolic mmHg) is elevated. Monitor regularly and maintain a healthy lifestyle.";
            } elseif ($systolic < 140 || $diastolic < 90) {
                return "Your blood pressure ($systolic/$diastolic mmHg) is in Hypertension Stage 1. Consider lifestyle changes and consult your doctor.";
            } else {
                return "Your blood pressure ($systolic/$diastolic mmHg) is in Hypertension Stage 2. Please consult your healthcare provider for advice.";
            }
        } else {
            // Only systolic provided
            if ($systolic < 90) {
                return "A systolic blood pressure of $systolic mmHg is considered low. If you feel unwell, consult a healthcare provider.";
            } elseif ($systolic < 120) {
                return "A systolic blood pressure of $systolic mmHg is normal.";
            } elseif ($systolic < 130) {
                return "A systolic blood pressure of $systolic mmHg is elevated. Monitor regularly.";
            } elseif ($systolic < 140) {
                return "A systolic blood pressure of $systolic mmHg is Hypertension Stage 1. Consider lifestyle changes and consult your doctor.";
            } else {
                return "A systolic blood pressure of $systolic mmHg is Hypertension Stage 2. Please consult your healthcare provider.";
            }
        }
    }

    private function findBestResponse($message)
    {
        foreach ($this->medicalResponses['emergency']['keywords'] as $keyword) {
            if (strpos($message, $keyword) !== false) { // Use strpos for compatibility
                return $this->medicalResponses['emergency']['response'];
            }
        }

        // Check other conditions
        foreach ($this->medicalResponses as $condition => $data) {
            if ($condition === 'emergency') continue;

            foreach ($data['keywords'] as $keyword) {
                if (strpos($message, $keyword) !== false) { // Use strpos for compatibility
                    return $data['response'];
                }
            }
        }

        // Default response if no keywords match
        return $this->medicalResponses['default']['response'];
    }
}