<x-app-layout>
<section class="min-h-screen bg-slate-100 p-6 font-sans text-blue-950">

    {{-- Logged-in Admin Card --}}
    <div class="flex items-center justify-between rounded-[2rem] bg-white p-8 shadow-sm">
        
        <div class="flex items-center gap-6">
            
            {{-- Gradient Avatar --}}
            <div class="flex h-24 w-24 items-center justify-center rounded-full bg-gradient-to-br from-red-700 to-red-900 text-3xl font-bold text-white shadow-lg">
                {{ strtoupper(collect(explode(' ', $user->name))->first()[0] . collect(explode(' ', $user->name))->last()[0]) }}
            </div>

            <div>
                <h1 class="text-3xl font-bold">{{ $user->name }}</h1>

                <p class="mt-1 font-bold text-red-800">
                    {{ $user->role->name}}
                </p>

                <div class="mt-5 grid grid-cols-3 gap-16 text-sm">
                    
                    <div>
                        <p class="text-slate-500">Email address:</p>
                        <p class="font-bold">{{ $user->email }}</p>
                    </div>

                    <div>
                        <p class="text-slate-500">Password:</p>
                        <p class="inline-block bg-blue-50 rounded-xl px-2 text-xs text-blue-600 text-center transition hover:bg-slate-50">change</p>
                    </div>

                    <div>
                        <p class="text-slate-500">Role:</p>
                        <p class="font-bold">Admin</p>
                    </div>

                </div>
            </div>
        </div>



        <div class="flex gap-3">

            <button class="rounded-xl border border-slate-300 px-5 py-2 text-sm font-bold text-blue-950 transition hover:bg-slate-50">
                Edit Info
            </button>

        </div>
    </div>



    <div class="mt-8 flex items-center justify-between">

        <x-modals.create-account :agencies="$agencies" :roles="$roles"/>
        <button onclick="openCreateUserModal()" class="flex items-center gap-2 rounded-2xl bg-gradient-to-br from-red-700 to-red-900 px-5 py-3 text-sm font-bold text-white shadow-md transition hover:scale-[1.01]">
            <span class="text-lg">+</span>
            Add New Account
        </button>


        <form method="GET" class="w-full max-w-md">
            <div class="flex items-center rounded-2xl bg-white px-5 py-3 shadow-sm ring-1 ring-slate-200">
                
                {{-- <span class="mr-3 text-slate-400">⌕</span> --}}
                <img src="{{ asset('images/search.svg') }}" class="pr-3 opacity-30" />

                <input id="searchInput"
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search staff account..."
                    autofocus
                    oninput="clearTimeout(this.delay); this.delay = setTimeout(() => this.form.submit(), 400)"
                    class="w-full bg-transparent text-slate-600 outline-none placeholder:text-slate-400"
                >
            </div>
        </form>
    </div>


    <div class="mt-8 space-y-6">

        @forelse ($users as $account)
            <div class="flex items-center justify-between rounded-[2rem] bg-white p-6 shadow-sm">

                <div class="flex items-center gap-5">


                    <div class="flex h-20 w-20 items-center justify-center rounded-full bg-gradient-to-br from-blue-50 to-blue-100 text-2xl font-bold text-blue-600 ring-2 ring-blue-100">
                        {{ strtoupper(collect(explode(' ', $account->name))->first()[0] . collect(explode(' ', $account->name))->last()[0]) }}
                    </div>

                    <div>
                        <h2 class="text-2xl font-bold">{{ $account->name }}</h2>
                        
                        <p class="text-slate-500">
                            Agency: 
                            <span class="font-bold text-blue-950">
                                @if ($account->agency?->id === null)
                                    Civil Service Commission
                                @else
                                    {{$account->agency->name}}
                                @endif
                            </span>
                        </p>

                        <p class="text-slate-500">
                            Email:
                            <span class="font-bold text-blue-950">
                                {{ $account->email }}
                            </span>
                        </p>

                        <p class="text-slate-500">
                            Role:
                            <span class="font-bold text-blue-950">
                                {{ $account->role->name }}
                            </span>
                        </p>
                    </div>
                </div>


                <div class="flex gap-3">

                    <button class="rounded-xl border border-slate-300 px-5 py-2 text-sm font-bold transition hover:bg-slate-50">
                        Edit Info
                    </button>

                    <button class="rounded-xl bg-gradient-to-br from-red-50 to-red-100 px-5 py-2 text-sm font-bold text-red-700 transition hover:from-red-100 hover:to-red-200">
                        Archive Account
                    </button>

                </div>
            </div>
        @empty
            <p class="text=text-center">No Users</p>
        @endforelse
        
       


    </div>
</section>
</x-app-layout>
   
<script>
        function openCreateUserModal() {
            document.getElementById('createUserModal')
                .classList.remove('hidden');

            document.getElementById('createUserModal')
                .classList.add('flex');
        }

        function closeCreateUserModal() {
            document.getElementById('createUserModal')
                .classList.add('hidden');

            document.getElementById('createUserModal')
                .classList.remove('flex');
        }
</script>

<script>
    const searchInput = document.getElementById('searchInput');

    if (searchInput) {
        searchInput.focus();
        searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
    }
</script>