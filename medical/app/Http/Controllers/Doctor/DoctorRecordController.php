<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DoctorRecordController extends Controller
{
    private function getAllRecords()
    {
        return DB::table('medical_records')
            ->join('medical_users', 'medical_records.user_id', '=', 'medical_users.user_id')
            ->where('medical_records.doctor_id', Auth::id())
            ->select(
                'medical_records.*',
                'medical_users.first_name as patient_first_name',
                'medical_users.last_name as patient_last_name',
                'medical_users.email as patient_email'
            )
            ->orderBy('medical_records.created_at', 'desc')
            ->paginate(10);
    }

    public function index()
    {
        $allRecords = $this->getAllRecords();
        return view('doctor.records.index', compact('allRecords'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $records = DB::table('medical_records')
            ->join('medical_users', 'medical_records.user_id', '=', 'medical_users.user_id')
            ->where('medical_users.email', $request->email)
            ->where('medical_records.doctor_id', Auth::id())
            ->select(
                'medical_records.*',
                'medical_users.first_name as patient_first_name',
                'medical_users.last_name as patient_last_name',
                'medical_users.email as patient_email'
            )
            ->orderBy('medical_records.created_at', 'desc')
            ->get();

        $allRecords = $this->getAllRecords();
        
        return view('doctor.records.index', compact('records', 'allRecords'));
    }
}