<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = DB::table('medical_users')->count();
        $totalDoctors = DB::table('medical_users')->where('role', 'doctor')->count();
        $totalPatients = DB::table('medical_users')->where('role', 'patient')->count();
        $totalHospitals = DB::table('hospitals')->count();
        $totalAppointments = DB::table('appointments')->count();

        $recentUsers = DB::table('medical_users')
            ->select('user_id', 'first_name', 'last_name', 'role', 'created_at')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentHospitals = DB::table('hospitals')
            ->select('id', 'name', 'address', 'created_at')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentAppointments = DB::table('appointments as a')
            ->join('medical_users as p', 'a.user_id', '=', 'p.user_id')
            ->join('medical_users as d', 'a.doctor_id', '=', 'd.user_id')
            ->select(
                'a.id',
                'p.first_name as patient_name',
                'd.first_name as doctor_name',
                'a.date',
                'a.time',
                'a.status'
            )
            ->orderBy('a.created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalDoctors',
            'totalPatients',
            'totalHospitals',
            'totalAppointments',
            'recentUsers',
            'recentHospitals',
            'recentAppointments'
        ));
    }

    public function users()
    {
        $users = DB::table('medical_users')
            ->select('user_id', 'first_name', 'last_name', 'email', 'role', 'created_at')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:medical_users,email',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,doctor,patient'
        ]);

        $user = new User();
        $user->first_name = $validated['first_name'];
        $user->last_name = $validated['last_name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->role = $validated['role'];
        $user->save();

        return redirect()->route('admin.users')
            ->with('success', 'User created successfully');
    }

    public function editUser($userId)
    {
        $user = User::findOrFail($userId);
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:medical_users,email,' . $userId . ',user_id',
            'role' => 'required|in:admin,doctor,patient'
        ]);

        $user->update($validated);

        return redirect()->route('admin.users')
            ->with('success', 'User updated successfully');
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        return redirect()->route('admin.users')
            ->with('success', 'User deleted successfully');
    }

    public function hospitals()
    {
        $hospitals = Hospital::paginate(10);
        return view('admin.hospitals.index', compact('hospitals'));
    }

    public function createHospital()
    {
        return view('admin.hospitals.create');
    }

    public function storeHospital(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:hospitals,email',
        ]);

        Hospital::create($validated);

        return redirect()->route('admin.hospitals')
            ->with('success', 'Hospital created successfully');
    }

    public function editHospital($hospitalId)
    {
        $hospital = Hospital::findOrFail($hospitalId);
        return view('admin.hospitals.edit', compact('hospital'));
    }

    public function updateHospital(Request $request, $hospitalId)
    {
        $hospital = Hospital::findOrFail($hospitalId);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:hospitals,email,' . $hospitalId,
        ]);

        $hospital->update($validated);

        return redirect()->route('admin.hospitals')
            ->with('success', 'Hospital updated successfully');
    }

    public function deleteHospital($hospitalId)
    {
        $hospital = Hospital::findOrFail($hospitalId);
        $hospital->delete();

        return redirect()->route('admin.hospitals')
            ->with('success', 'Hospital deleted successfully');
    }

    public function appointments()
    {
        $appointments = DB::table('appointments as a')
            ->join('medical_users as p', 'a.user_id', '=', 'p.user_id')
            ->join('medical_users as d', 'a.doctor_id', '=', 'd.user_id')
            ->select(
                'a.id',
                'p.first_name as patient_first_name',
                'p.last_name as patient_last_name',
                'd.first_name as doctor_first_name',
                'd.last_name as doctor_last_name',
                'a.date',
                'a.time',
                'a.status',
                'a.created_at'
            )
            ->orderBy('a.date', 'desc')
            ->paginate(10);

        return view('admin.appointments.index', compact('appointments'));
    }

    public function showAppointment($id)
    {
        $appointment = DB::table('appointments as a')
            ->join('medical_users as p', 'a.user_id', '=', 'p.user_id')
            ->join('medical_users as d', 'a.doctor_id', '=', 'd.user_id')
            ->select(
                'a.*',
                'p.first_name as patient_first_name',
                'p.last_name as patient_last_name',
                'p.email as patient_email',
                'd.first_name as doctor_first_name',
                'd.last_name as doctor_last_name',
                'd.email as doctor_email'
            )
            ->where('a.id', $id)
            ->first();

        if (!$appointment) {
            return redirect()->route('admin.appointments')
                ->with('error', 'Appointment not found.');
        }

        return view('admin.appointments.show', compact('appointment'));
    }

    public function createAppointment()
    {
        $doctors = DB::table('medical_users')
            ->where('role', 'doctor')
            ->select('user_id', 'first_name', 'last_name')
            ->get();

        $patients = DB::table('medical_users')
            ->where('role', 'patient')
            ->select('user_id', 'first_name', 'last_name')
            ->get();

        return view('admin.appointments.create', compact('doctors', 'patients'));
    }

    public function storeAppointment(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:medical_users,user_id',
            'doctor_id' => 'required|exists:medical_users,user_id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'type' => 'required|in:in-person,video',
            'notes' => 'nullable|string'
        ]);

        DB::table('appointments')->insert([
            'user_id' => $validated['patient_id'],
            'doctor_id' => $validated['doctor_id'],
            'date' => $validated['date'],
            'time' => $validated['time'],
            'type' => $validated['type'],
            'notes' => $validated['notes'],
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('admin.appointments')
            ->with('success', 'Appointment created successfully.');
    }

    public function editAppointment($id)
    {
        $appointment = DB::table('appointments')->where('id', $id)->first();
        
        if (!$appointment) {
            return redirect()->route('admin.appointments')
                ->with('error', 'Appointment not found.');
        }

        $doctors = DB::table('medical_users')
            ->where('role', 'doctor')
            ->select('user_id', 'first_name', 'last_name')
            ->get();

        $patients = DB::table('medical_users')
            ->where('role', 'patient')
            ->select('user_id', 'first_name', 'last_name')
            ->get();

        return view('admin.appointments.edit', compact('appointment', 'doctors', 'patients'));
    }

    public function updateAppointment(Request $request, $id)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:medical_users,user_id',
            'doctor_id' => 'required|exists:medical_users,user_id',
            'date' => 'required|date',
            'time' => 'required',
            'type' => 'required|in:in-person,video',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'notes' => 'nullable|string'
        ]);

        DB::table('appointments')
            ->where('id', $id)
            ->update([
                'user_id' => $validated['patient_id'],
                'doctor_id' => $validated['doctor_id'],
                'date' => $validated['date'],
                'time' => $validated['time'],
                'type' => $validated['type'],
                'status' => $validated['status'],
                'notes' => $validated['notes'],
                'updated_at' => now()
            ]);

        return redirect()->route('admin.appointments')
            ->with('success', 'Appointment updated successfully.');
    }

    public function deleteAppointment($id)
    {
        DB::table('appointments')->where('id', $id)->delete();

        return redirect()->route('admin.appointments')
            ->with('success', 'Appointment deleted successfully.');
    }    public function doctors()
    {
        $doctors = DB::table('medical_users')
            ->where('role', 'doctor')
            ->select(
                'user_id',
                'first_name',
                'last_name',
                'email',
                'specialization'
            )
            ->orderBy('first_name')
            ->paginate(10);

        return view('admin.doctors.index', compact('doctors'));
    }

    public function createDoctor()
    {
        $hospitals = DB::table('hospitals')
            ->select('id', 'name')
            ->get();
            
        return view('admin.doctors.create', compact('hospitals'));
    }

    public function storeDoctor(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:medical_users,email',
            'password' => 'required|min:8',
            'specialization' => 'required|string|max:255',
            'hospital_id' => 'required|exists:hospitals,id'
        ]);

        $doctor = new User();
        $doctor->first_name = $validated['first_name'];
        $doctor->last_name = $validated['last_name'];
        $doctor->email = $validated['email'];
        $doctor->password = Hash::make($validated['password']);
        $doctor->role = 'doctor';
        $doctor->specialization = $validated['specialization'];
        $doctor->hospital_id = $validated['hospital_id'];
        $doctor->status = 'active';
        $doctor->save();

        return redirect()->route('admin.doctors')
            ->with('success', 'Doctor created successfully');
    }

    public function editDoctor($userId)
    {
        $doctor = User::where('user_id', $userId)
            ->where('role', 'doctor')
            ->firstOrFail();
            
        $hospitals = DB::table('hospitals')
            ->select('id', 'name')
            ->get();

        return view('admin.doctors.edit', compact('doctor', 'hospitals'));
    }

    public function updateDoctor(Request $request, $userId)
    {
        $doctor = User::where('user_id', $userId)
            ->where('role', 'doctor')
            ->firstOrFail();

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:medical_users,email,' . $userId . ',user_id',
            'specialization' => 'required|string|max:255',
            'hospital_id' => 'required|exists:hospitals,id',
            'status' => 'required|in:active,inactive'
        ]);

        $doctor->update($validated);

        return redirect()->route('admin.doctors')
            ->with('success', 'Doctor updated successfully');
    }

    public function deleteDoctor($userId)
    {
        $doctor = User::where('user_id', $userId)
            ->where('role', 'doctor')
            ->firstOrFail();

        // Check if doctor has any appointments
        $hasAppointments = DB::table('appointments')
            ->where('doctor_id', $userId)
            ->exists();

        if ($hasAppointments) {
            return redirect()->route('admin.doctors')
                ->with('error', 'Cannot delete doctor with existing appointments');
        }

        $doctor->delete();

        return redirect()->route('admin.doctors')
            ->with('success', 'Doctor deleted successfully');
    }
}