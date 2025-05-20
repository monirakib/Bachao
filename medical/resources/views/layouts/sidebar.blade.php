<div class="sidebar">
    <div class="mb-4">
        <h4 class="text-xl font-semibold text-gray-800">Doctor Dashboard</h4>
    </div>
    
    <nav>
        <a href="{{ route('doctor.dashboard') }}" 
           class="menu-item {{ request()->routeIs('doctor.dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <a href="{{ route('doctor.appointments') }}" 
           class="menu-item {{ request()->routeIs('doctor.appointments') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt"></i> Appointments
        </a>
        <a href="{{ route('doctor.patients') }}" 
           class="menu-item {{ request()->routeIs('doctor.patients') ? 'active' : '' }}">
            <i class="fas fa-user-injured"></i> Patients
        </a>
        <a href="{{ route('doctor.records') }}" 
           class="menu-item {{ request()->routeIs('doctor.records') ? 'active' : '' }}">
            <i class="fas fa-notes-medical"></i> Medical Records
        </a>
        <a href="{{ route('doctor.telemedicine') }}" 
           class="menu-item {{ request()->routeIs('doctor.telemedicine') ? 'active' : '' }}">
            <i class="fas fa-video"></i> Telemedicine
        </a>
        <a href="{{ route('doctor.settings') }}" 
           class="menu-item {{ request()->routeIs('doctor.settings') ? 'active' : '' }}">
            <i class="fas fa-cog"></i> Settings
        </a>
    </nav>
</div>