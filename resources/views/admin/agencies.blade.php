<x-app-layout>
    <!-- seacrhchd bar -->
    <section class="sticky top-0 z-40 mt-6 mx-6">
        <div class="flex gap-4 items-center rounded-4xl bg-white p-6 shadow-gray-400 ring-1 ring-slate-100">
        <div class="flex-1 text-blue-950 gap-2 justify-between">
            <p class="text-2xl font-bold ">Agency Directory</p>
        </div>
        <form method="GET" class="w-full max-w-[320px]">
            <div class="flex items-center rounded-full bg-slate-100 py-3 px-2 shadow-gray-400 ring-1 ring-slate-200">
                <img src="{{ asset('images/search.svg') }}" class="opacity-20" />
                <input id="searchInput"
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search agency..."
                    autofocus
                    oninput="clearTimeout(this.delay); this.delay = setTimeout(() => this.form.submit(), 400)"
                    class="w-full bg-transparent outline-none pl-1"
                >

            </div>
        </form>
        <form method="GET" action="{{ route('agencies.index') }}">
                <select name="fieldOffice" onchange="this.form.submit()" class="select select-bordered rounded-full bg-slate-100 text-1xl min-w-[170px] ring-2 ring-slate-200 p-3">
                    
                    <option value="">All Agencies</option>
                    @foreach ($fieldOffices as $fieldOffice)
                        <option value="{{ $fieldOffice->id }}" {{ request('fieldOffice') == $fieldOffice->id ? 'selected' : ''}}>{{ $fieldOffice->name }}</option>
                    @endforeach

                </select>
        </form>
        @if (auth()->user()->role->id == 1)
            <x-modals.create-agency :fieldOffices="$fieldOffices"/>
            <button onclick="openCreateAgencyModal()"
                    class="flex items-center rounded-4xl transition hover:scale-[1.05] hover:bg-red-700 bg-red-800">
                <span class="text-1xl font-bold text-white p-3">+ Add New Agency</span>
            </button>
        @endif
       
        </div>
    </section>


   <section class="mx-6 mt-4">
        @forelse ($agencies as $agency)
            <div class="grid grid-cols-1 gap-3 mt-1">
                <a class="block duration-300 ease-in-out hover:-translate-y-1 hover:bg-blue-100 hover:shadow-blue-200/50 flex gap-3 items-center rounded-xl bg-white p-4 shadow-md ring-1 ring-slate-100"
                href="{{ route('agency.show', $agency) }}">
                     @if ($agency->photo)
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-full text-2xl font-bold text-white">
                            <img src="{{ asset('storage/' . $agency->photo) }}" class="h-full w-full object-cover">
                        </div>
                    @else
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-full bg-gradient-to-br from-red-700 to-red-900 text-sm font-bold text-white shadow-md">
                            {{ $agency->abbreviation }}
                        </div>
                    @endif
                    <div class="flex-1">
                        <p class="text-lg font-bold">
                            {{ $agency->name }}
                        </p>

                        <p class="text-sm font-semibold text-red-800">
                            Field Office: {{ $agency->fieldOffice->name }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-600">
                            Agency Head:
                            <span class="font-bold text-slate-800">
                                {{ $agency->head }}
                            </span>
                        </p>
                        <p class="text-sm text-gray-600">
                            Email:
                            <span class="font-bold text-slate-800">
                                {{ $agency->email_address }}
                            </span>
                        </p>
                    </div>
                </a>
            </div>
        @empty
            <div class="flex-1"><h2 class="text-center text-gray-400">No Agencies yet in this field office.</h2></div>
        @endforelse
    </section>
    <script>
            function openCreateAgencyModal() {
                document.getElementById('createAgencyModal')
                    .classList.remove('hidden');

                document.getElementById('createAgencyModal')
                    .classList.add('flex');
            }

            function closeCreateAgencyModal() {
                document.getElementById('createAgencyModal')
                    .classList.add('hidden');

                document.getElementById('createAgencyModal')
                    .classList.remove('flex');
            }
        </script>
</x-app-layout>

<script>
    const searchInput = document.getElementById('searchInput');

    if (searchInput) {
        searchInput.focus();
        searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
    }
</script>