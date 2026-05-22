<x-app-layout>

    <section class="p-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <x-modals.add-field-office />
            <button onclick="openAddFieldOfficeModal()"
                type="button"
                class="flex items-center justify-center gap-2 self-start rounded-full bg-gradient-to-br from-red-700 to-red-900 px-5 py-3 text-base font-bold text-white shadow-sm transition hover:scale-[1.02]"
            >
                <span class="text-lg">＋</span>

                Add Field Office
            </button>
           

            <form method="GET" class="w-full max-w-sm">
                <div class="flex items-center rounded-full bg-white px-4 py-3 shadow-sm ring-1 ring-slate-100">

                    <img 
                        src="{{ asset('images/search.svg') }}" 
                        class="h-5 w-5 opacity-40"
                    >

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search..."
                        class="w-full bg-transparent pl-3 text-sm outline-none"
                    >

                </div>
            </form>
            

        </div>
    </section>
   
       


    <section class="p-6" x-data="{ showAll: false }">
         <div class="flex">
            <div class="ml-auto">
                <button
                    type="button"
                    @click="showAll = !showAll"
                    class="mb-4 rounded-2xl bg-blue-950 px-5 py-3 text-sm font-bold text-white transition hover:bg-blue-900"
                >
                    <span x-show="!showAll">Show All</span>
                    <span x-show="showAll">Hide All</span>
                </button>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">

            @forelse ($field_offices as $field_office)
                
                <div x-data="{ open: false }" class="flex flex-col rounded-4xl bg-white p-6 shadow-sm ring-1 ring-slate-100">
                    
                    {{-- Header --}}
                    <div class="mb-5 flex items-center justify-between gap-4">

                        <div>
                            <h2 class="text-2xl font-bold text-blue-950">
                                {{ $field_office->name }}
                            </h2>

                            <p class="text-slate-500">
                                No. of agencies: {{ $field_office->agencies->count() }}
                            </p>
                        </div>

                        <button
                            type="button"
                            @click="open = !open"
                            class="rounded-full bg-blue-950 px-4 py-2 text-sm font-bold text-white transition hover:bg-blue-900"
                        >
                            <span x-show="!(open || showAll)">Show</span>
                            <span x-show="open || showAll">Hide</span>
                        </button>
                    </div>

                    {{-- Scrollable Content --}}
                    <div x-show="open || showAll" class="max-h-[350px] space-y-3 overflow-y-auto pr-2">

                        @forelse ($field_office->agencies as $agency)

                            <div class="flex items-center gap-4 rounded-2xl bg-slate-50 p-4">

                                <div class="flex-1">
                                    <p class="font-bold text-blue-950">
                                        {{ $agency->name }}
                                    </p>

                                    <p class="text-sm text-slate-500">
                                        {{ $agency->email_address }}
                                    </p>
                                </div>
                                <x-modals.change-field_office :agency="$agency" :fieldOffices="$all_field_offices"/>
                                <button onclick="openChangeFieldOfficeModal({{ $agency->id }})" type="button" class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-orange-100 transition hover:scale-105 hover:bg-orange-200" >
                                    <img 
                                        src="{{ asset('images/folder-sync.svg') }}" 
                                        class="h-4 w-4"
                                    >
                                </button>

                            </div>

                        @empty

                            <p class="text-slate-400">
                                No agencies found.
                            </p>

                        @endforelse

                    </div>
                </div>

            @empty

                <p>No field offices found.</p>

            @endforelse
        
        </div>
    </section>

</x-app-layout>

<script>
    function openChangeFieldOfficeModal(agencyId){
        document.getElementById('changeFieldOfficeModal-' + agencyId).classList.remove('hidden');
        document.getElementById('changeFieldOfficeModal-' + agencyId).classList.add('flex');

    }

    function closeChangeFieldOfficeModal(agencyId){
        document.getElementById('changeFieldOfficeModal-' + agencyId).classList.add('hidden');
        document.getElementById('changeFieldOfficeModal-' + agencyId).classList.remove('flex');
    }
</script>

<script>
    function openAddFieldOfficeModal(){
        document.getElementById('addFieldOfficeModal').classList.remove('hidden');
        document.getElementById('addFieldOfficeModal').classList.add('flex');
        
    }

    function closeAddFieldOfficeModal(){
        document.getElementById('addFieldOfficeModal').classList.add('hidden');
        document.getElementById('addFieldOfficeModal').classList.remove('flex');
        
    }
</script>