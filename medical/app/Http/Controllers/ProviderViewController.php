<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProviderViewController extends Controller
{
    public function show($recordId, $token)
    {
        // Decode and validate token
        $decoded = explode('_', base64_decode($token));
        
        if (count($decoded) !== 2 || $decoded[1] != $recordId) {
            abort(403, 'Invalid access token');
        }

        $providerEmail = $decoded[0];

        // Check if share exists and is valid
        $share = DB::select("
            SELECT * FROM medical_record_shares 
            WHERE medical_record_id = ? 
            AND provider_email = ? 
            AND valid_until >= CURDATE()
            LIMIT 1
        ", [$recordId, $providerEmail]);

        if (empty($share)) {
            abort(403, 'Share expired or not found');
        }

        // Get record with patient and doctor info
        $record = DB::select("
            SELECT 
                mr.*,
                CONCAT(p.first_name, ' ', p.last_name) as patient_name,
                CONCAT(d.first_name, ' ', d.last_name) as doctor_name,
                d.specialization as doctor_specialization
            FROM medical_records mr
            JOIN medical_users p ON mr.user_id = p.user_id
            LEFT JOIN medical_users d ON mr.doctor_id = d.user_id
            WHERE mr.id = ?
            LIMIT 1
        ", [$recordId]);

        if (empty($record)) {
            abort(404, 'Record not found');
        }

        return view('provider.view-record', [
            'record' => $record[0],
            'share' => $share[0]
        ]);
    }
}