<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $services = [
            [
                'icon' => 'fa-file-medical',
                'title' => 'Patient Records',
                'description' => 'Access your complete medical history, prescriptions, and treatment records securely.',
                'route' => 'patient.records',
                'button_text' => 'View Records'
            ],
            [
                'icon' => 'fa-calendar-check',
                'title' => 'Appointments',
                'description' => 'Schedule, view, and manage your medical appointments.',
                'route' => 'appointments',
                'button_text' => 'Manage Appointments'
            ],
            // Add more services as needed
        ];
        return view('dashboard', compact('services'));
    }
}