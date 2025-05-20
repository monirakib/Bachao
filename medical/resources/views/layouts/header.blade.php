<div class="header1">
    <div class="logo">
        <img src="{{ asset('pics/medical/medichain_logo.png') }}" alt="Logo">
    </div>
    <div class="user-section">
        <a href="{{ route('dashboard') }}" class="back-button">
            <i class="fas fa-arrow-left"></i> Back to Home
        </a>
        <div class="guest">
            @auth
                <div class="profile-dropdown">
                    <img class="guest-logo" src="{{ asset('pics/guest-removebg-preview.png') }}" alt="User Profile" onclick="toggleProfileMenu()">
                    <div id="profileMenu" class="profile-menu">
                        <a href="{{ route('profile.edit') }}" class="profile-menu-item">
                            <i class="fas fa-user-edit"></i> Edit Profile
                        </a>
                        <hr class="profile-divider">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="profile-menu-item">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
                <span class="user-name">{{ Auth::user()->first_name }}</span>
                @if(Auth::user()->role === 'doctor')
                    <a href="{{ route('doctor.dashboard') }}" class="login-button">
                        <i class="fas fa-user-md"></i> Doctor Panel
                    </a>
                @endif
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="login-button">
                        <i class="fas fa-user-shield"></i> Admin Panel
                    </a>
                @endif
            @else
                <img class="guest-logo" src="{{ asset('pics/guest-removebg-preview.png') }}" alt="Guest">
                <span class="user-name">Guest</span>
                <a href="{{ route('login') }}" class="login-button">Login</a>
            @endauth
        </div>
    </div>
</div>

<style>
.header1 {
    background: linear-gradient(to right, #dd2476, #ff512f);
    height: 110px;
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
    height: 130px;
    width: 100px;
}

.user-section {
    display: flex;
    align-items: center;
    gap: 15px;
}

.guest {
    display: flex;
    align-items: center;
    gap: 10px;
}

.guest-logo {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    cursor: pointer;
    border: 2px solid rgba(255, 255, 255, 0.3);
    transition: all 0.3s ease;
}

.guest-logo:hover {
    transform: scale(1.1);
    border-color: rgba(255, 255, 255, 0.6);
}

.back-button {
    padding: 10px 20px;
    background: rgba(255, 255, 255, 0.1);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 25px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.back-button:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateX(-5px);
}

.user-name {
    color: white;
    font-weight: 500;
}

.login-button {
    padding: 8px 16px;
    border-radius: 25px;
    background: rgba(255, 255, 255, 0.1);
    color: white;
    text-decoration: none;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
    font-size: 0.9em;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.login-button:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-2px);
}

.login-button i {
    font-size: 0.9em;
}

.profile-dropdown {
    position: relative;
    display: inline-block;
}

.profile-menu {
    display: none;
    position: absolute;
    top: 45px;
    right: 0;
    background: white;
    min-width: 200px;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    z-index: 1000;
    animation: menuSlide 0.3s ease;
}

@keyframes menuSlide {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.profile-menu-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 20px;
    color: #2c3e50;
    text-decoration: none;
    font-size: 0.9em;
    transition: all 0.3s ease;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
}

.profile-menu-item:hover {
    background: #f8f9fa;
    color: #dd2476;
}

.profile-divider {
    margin: 5px 0;
    border: none;
    border-top: 1px solid #eee;
}
</style>

<script>
function toggleProfileMenu() {
    const menu = document.getElementById('profileMenu');
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
}

document.addEventListener('click', function(event) {
    if (!event.target.matches('.guest-logo')) {
        const menu = document.getElementById('profileMenu');
        if (menu && menu.style.display === 'block') {
            menu.style.display = 'none';
        }
    }
});
</script>