<x-app-layout>

    <section class="p-6 pb-0">
        <div class="flex justify-end">

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


    <section class="p-6">
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
                            <span x-show="!open">Show</span>
                            <span x-show="open">Hide</span>
                        </button>
                    </div>

                    {{-- Scrollable Content --}}
                    <div x-show="open" class="max-h-[350px] space-y-3 overflow-y-auto pr-2">

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

                                <button class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-orange-100 transition hover:scale-105 hover:bg-orange-200">
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