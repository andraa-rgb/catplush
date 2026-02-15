<nav class="bg-white border-b-2 border-purple-200 shadow-sm sticky top-0 z-40">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo/Brand -->
                <div class="shrink-0 flex items-center gap-3">
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-2 hover:opacity-80 transition">
                        <div class="text-2xl">📚</div>
                        <div>
                            <div class="font-black text-primary-700">Lab WICIDA</div>
                            <div class="text-xs text-gray-600">Jadwal Dosen</div>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        <!-- Dosen Navigation -->
                        @if(in_array(Auth::user()->role, ['staf', 'kepala_lab']))
                            <a href="{{ route('dashboard') }}" class="px-4 py-2 border-b-2 {{ request()->routeIs('dashboard') ? 'border-primary-600 text-primary-700 font-bold' : 'border-transparent text-gray-600 hover:text-primary-600 hover:border-purple-200' }} transition">
                                📊 Dashboard
                            </a>
                        @endif

                        <!-- Admin Navigation -->
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 border-b-2 {{ request()->routeIs('admin.dashboard') ? 'border-primary-600 text-primary-700 font-bold' : 'border-transparent text-gray-600 hover:text-primary-600 hover:border-purple-200' }} transition">
                                👥 Kelola Dosen
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <div class="relative inline-block text-left">
                        <button onclick="toggleDropdown()" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-light text-primary-700 font-semibold rounded-lg hover:bg-primary-100 transition border border-purple-200">
                            <span>👤 {{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                            </svg>
                        </button>

                        <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 rounded-lg shadow-lg bg-white border border-purple-200 py-2 z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-purple-50 hover:text-primary-700">
                                ⚙️ Profil
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-purple-50 hover:text-primary-700">
                                    🚪 Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="btn-primary text-sm">
                        🔐 Login
                    </a>
                @endguest
            </div>

            <!-- Hamburger Menu -->
            <div class="-me-2 flex items-center sm:hidden">
                <button onclick="toggleMobileMenu()" class="inline-flex items-center justify-center p-2 rounded-lg text-primary-600 hover:bg-purple-100 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path id="menuIcon" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path id="closeIcon" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden sm:hidden bg-gradient-light border-t border-purple-200">
        <div class="px-4 py-3 space-y-2">
            @auth
                @if(in_array(Auth::user()->role, ['staf', 'kepala_lab']))
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 bg-primary-600 text-white rounded-lg font-semibold">
                        📊 Dashboard
                    </a>
                @endif

                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 bg-primary-600 text-white rounded-lg font-semibold">
                        👥 Kelola Dosen
                    </a>
                @endif

                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 bg-white text-gray-700 rounded-lg border border-purple-200">
                    ⚙️ Profil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 bg-white text-gray-700 rounded-lg border border-purple-200 text-left">
                        🚪 Logout
                    </button>
                </form>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="block px-4 py-2 bg-primary-600 text-white rounded-lg font-semibold text-center">
                    🔐 Login
                </a>
            @endguest
        </div>
    </div>
</nav>

<script>
function toggleDropdown() {
    const menu = document.getElementById('dropdownMenu');
    menu.classList.toggle('hidden');
}

function toggleMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    const menuIcon = document.getElementById('menuIcon');
    const closeIcon = document.getElementById('closeIcon');
    
    menu.classList.toggle('hidden');
    menuIcon.classList.toggle('hidden');
    closeIcon.classList.toggle('hidden');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('dropdownMenu');
    const button = event.target.closest('button');
    
    if (dropdown && !dropdown.contains(event.target) && !button?.onclick?.toString().includes('toggleDropdown')) {
        dropdown.classList.add('hidden');
    }
});
</script>