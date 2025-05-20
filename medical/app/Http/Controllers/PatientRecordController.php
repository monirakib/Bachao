<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class PatientRecordController extends Controller
{
    public function index()
    {
        $records = DB::select("
            SELECT 
                mr.*,
                CONCAT(doc.first_name, ' ', doc.last_name) as doctor_name,
                COALESCE(doc.specialization, 'General Physician') as doctor_specialization
            FROM medical_records mr
            LEFT JOIN medical_users doc ON mr.doctor_id = doc.user_id
            WHERE mr.user_id = ?
            ORDER BY mr.created_at DESC
        ", [Auth::id()]);

        return view('patient.records', ['records' => $records]);
    }

    public function show($id)
    {
        $record = DB::select("
            SELECT 
                mr.*,
                CONCAT(doc.first_name, ' ', doc.last_name) as doctor_name,
                COALESCE(doc.specialization, 'General Physician') as doctor_specialization
            FROM medical_records mr
            LEFT JOIN medical_users doc ON mr.doctor_id = doc.user_id
            WHERE mr.id = ? AND mr.user_id = ?
            LIMIT 1
        ", [$id, Auth::id()]);

        if (empty($record)) {
            abort(404);
        }

        return view('patient.records.show', ['record' => $record[0]]);
    }

    public function share(Request $request, $id)
    {
        // Validate the request
        $validated = $request->validate([
            'share_with' => 'required|array',
            'share_with.*' => 'required|in:hospital,pharmacy,insurance',
            'provider_email' => 'required|email',
            'valid_until' => 'required|date|after:today',
            'notes' => 'nullable|string|max:500',
            'consent' => 'required|accepted'
        ]);

        try {
            // Check if record exists and belongs to user
            $record = DB::select("
                SELECT * FROM medical_records 
                WHERE id = ? AND user_id = ? 
                LIMIT 1
            ", [$id, Auth::id()]);

            if (empty($record)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Record not found'
                ], 404);
            }

            // Save share record
            DB::insert("
                INSERT INTO medical_record_shares 
                (medical_record_id, shared_with, provider_email, valid_until, notes, created_at)
                VALUES (?, ?, ?, ?, ?, NOW())
            ", [
                $id,
                json_encode($validated['share_with']),
                $validated['provider_email'],
                $validated['valid_until'],
                $validated['notes'] ?? null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Record shared successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error sharing record: ' . $e->getMessage()
            ], 500);
        }
    }
}