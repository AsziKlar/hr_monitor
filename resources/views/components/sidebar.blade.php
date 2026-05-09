<aside id="sidebar" class="fixed w-64 h-screen text-white top-0 left-0 bg-blue-950/95 px-5 py-5 rounded-r-2xl overflow-hidden transition-all duration-300 ease-in-out transition-none z-50">
    <div class="min-w-[14rem] flex h-full flex-col">
    <!-- logo and staff details  -->
    <!--<div class="mb-8 flex items-center gap-1 px-1">
        <img class="h-12 w-12 object-contain rounded-xl bg-white/5 p-1" src="csc_logo.png" alt="logo">
        
        <div>
        <h2 class="text-xl font-bold leading-tight">CSC REGION X</h2>
        <p class="text-sm text-gray-400 leading-tight">HR Mechanism Tracker</p>
        </div>
    </div>-->
    <!-- staff details  -->
    <div class="rounded-3xl bg-white/10 mt-4 px-4 py-3 shawdow-inner ring-1 ring-white/10">
        <div class="flex items-center gap-3">
        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-radial-[at_25%_25%] from-red-800 to-red-900 to-75% text-sm font-bold text-white shadow-lg">
            LC
        </div>
        <div>
            <p class="text-base font-bold leading-tight">Lucian Cagata</p>
            <p class="text-xs text-white/70">CSC Admin</p>
        </div>
        </div>
    </div>

    <nav class="space-y-2 text-sm">
        <p class="text-[11px] text-white/50 mt-6">NAVIGATION</p>
        <a class="flex items-center gap-3 p-3 rounded-2xl bg-radial-[at_25%_25%] from-red-800 to-red-900 to-75% font-bold text-white shadow-lg shadow-red-900/20" href="">
            Dashboard
        </a>

        <a class="flex items-center gap-3 p-3 rounded-2xl font-bold transition hover:bg-white/10 " href="mechanisms.html">
            Mechanisms
        </a>

        <a class="flex items-center gap-3 p-3 rounded-2xl font-bold transition hover:bg-white/10 " href="agencies.html">
            Agencies Directory
        </a>

        <p class="text-[11px] text-white/50 mt-6">ADMINISTRATIVE TOOLS</p>

        <a class="flex items-center gap-3 p-3 rounded-2xl font-bold transition hover:bg-white/10 " href="accmng.html">
            Manage Account
        </a>

        <a class="flex items-center gap-3 p-3 rounded-2xl font-bold transition hover:bg-white/10 " href="announcement.html">
            Make Announcement
        </a>
    </nav>
    <div class="mt-auto pt-6">
        <a class="flex items-center gap-3 p-3 rounded-2xl text-sm font-bold transition hover:bg-white/10 " href="login.html">
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                class="flex w-full items-center gap-3 rounded-2xl p-3 text-sm font-bold transition hover:bg-white/10">
                <span>Logout</span>
            </button>
        </form>
        </a>
    </div>
    </div>
</aside>
