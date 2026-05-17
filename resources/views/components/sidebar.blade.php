<aside id="sidebar" class="fixed w-64 h-screen text-white top-0 left-0 bg-blue-950/95 px-3 pb-5 rounded-r-2xl overflow-hidden transition-all duration-300 ease-in-out transition-none z-50">
    <div class="min-w-[14rem] flex h-full flex-col">
    <div class="rounded-3xl bg-white/10 mt-4 px-4 py-3 shawdow-inner ring-1 ring-white/10">
        <div class="flex items-center gap-3">
                    @if (auth()->user()->role->name === 'HRMO' && auth()->user()->agency->photo)
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-full text-2xl font-bold text-white">
                            <img src="{{ asset('storage/' . auth()->user()->agency->photo) }}" class="h-full w-full object-cover">
                        </div>
                    @elseif(in_array(auth()->user()->role->name, ['Administrator', 'Processor', 'Reviewer']))
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-radial-[at_25%_25%] from-red-800 to-red-900 to-75% text-sm font-bold text-white shadow-lg">
                                {{ strtoupper(collect(explode(' ', auth()->user()->name))->first()[0] . collect(explode(' ', auth()->user()->name))->last()[0]) }}
                            </div>
                    @else
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-full bg-gradient-to-br from-red-700 to-red-900 text-sm font-bold text-white shadow-md">
                                {{ auth()->user()->agency->abbreviation }}
                            </div>
                    @endif
        <div>
            <p class="text-base font-bold leading-tight">{{ collect(explode(' ', auth()->user()->name))->first() . ' ' . collect(explode(' ', auth()->user()->name))->last() }} </p>
            @if (auth()->user()->role->id == 4)
                <p class="text-xs text-white/70">{{ auth()->user()->agency->abbreviation }} (HRMO)</p>
            @else
                <p class="text-xs text-white/70">{{ auth()->user()->role->name }} </p>
            @endif
        </div>
        </div>
    </div>

    <nav class="space-y-2 text-base">
        <p class="text-[11px] text-white/50 mt-6">NAVIGATION</p>

        @php
            $active = 'flex items-center gap-3 p-3 rounded-2xl bg-radial-[at_25%_25%] from-red-800 to-red-900 to-75% font-bold text-white shadow-lg shadow-red-900/20';

            $inactive = 'flex items-center gap-3 p-3 rounded-2xl font-bold transition hover:bg-white/10';

            // $mechanismRoute = auth()->user()->role->name === 'HRMO'
            //     ? 'hrmo.mechanisms'
            //     : 'mechanisms';

            $dashboardRoute = auth()->user()->role->name === 'HRMO'
                ? 'hrmo.dashboard'
                : 'dashboard';
            

        @endphp

        <a  class="{{ request()->routeIs($dashboardRoute) ? $active : $inactive }}"
            href="{{ route($dashboardRoute) }}">
            <img src="{{ asset('images/layout-dashboard.svg') }}" />
            Dashboard
        </a>

        <a  class="{{ request()->routeIs('mechanisms', 'admin.drafts.index') ? $active : $inactive }}" 
            href="{{ route('mechanisms') }}">
            <img src="{{ asset('images/library-big.svg') }}" />
            Mechanisms
        </a>
        @if (auth()->user()->role->id == 4)
         <a class="flex items-center gap-3 p-3 rounded-2xl font-bold transition hover:bg-white/10 " href="{{ route('agency.profile.show') }}">
            <img src="{{ asset('images/book-search.svg') }}" />
            Agency Profile
        </a>
        @endif

        @if (in_array(auth()->user()->role->id, [1,2,3]))
            <a class="{{ request()->routeIs('agencies.index', 'agency.show') ? $active : $inactive }}"  href="{{ route('agencies.index') }}">
                <img src="{{ asset('images/folder-tree.svg') }}" />
                Agencies Directory
            </a>
        @endif

        @if (auth()->user()->role->id == 1)
            <p class="text-[11px] text-white/50 mt-6">ADMINISTRATIVE TOOLS</p>

            <a class="{{ request()->routeIs('admin.account.index') ? $active : $inactive }}" href="{{ route('admin.account.index') }}">
                <img src="{{ asset('images/user-round-search.svg') }}" />
                Manage Account
            </a>

            <a  class="{{ request()->routeIs('announcements') ? $active : $inactive }}" 
                href="{{ route('announcements') }}">
                <img src="{{ asset('images/book-a.svg') }}" />
                Make Announcement
            </a>
            <a  class="{{ request()->routeIs('settings') ? $active : $inactive }}" 
                href="{{ route('admin.settings.mechanisms') }}">
                <img src="{{ asset('images/settings.svg') }}" />
                Other Settings
            </a>

            <a  class="{{ request()->routeIs('admin.field-office.index') ? $active : $inactive }}" 
                href="{{ route('admin.field-office.index') }}">
                <img src="{{ asset('images/settings.svg') }}" />
                Field Office Settings
            </a>
        @endif
    </nav>
    <div class="mt-auto pt-6">

        
        <form method="POST" action="{{ route('logout') }}">
            @csrf

         <button class="flex items-center gap-2 rounded-2xl bg-blue-950 pl-2 pr-3 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-blue-900">
            <img src="{{ asset('images/log-out.svg') }}" class="h-5 w-5 brightness-0 invert pl-1">

            Logout
        </button>
        </form>

    </div>
    </div>
</aside>
