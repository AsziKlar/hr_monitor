<x-app-layout>
    <!-- seacrhchd bar -->
    <section class="sticky top-0 z-40 p-6">
        <div class="flex gap-4 items-center rounded-4xl bg-white p-6 shadow-gray-400 ring-1 ring-slate-100">
        <div class="flex-1 text-blue-950 gap-2 justify-between">
            <p class="text-2xl font-bold ">Agency Directory</p>
            <p class="text-1xl text-gray-400">Manage agency information, field offices, official emails, and agency heads.</p>
        </div>
        <div class="flex h-4 w-full max-w-[320px] items-center rounded-4xl bg-slate-100 p-6 shadow-gray-400 ring-1 ring-slate-200">
            <input class="w-full outline-none type='text' placeholder" placeholder='Search agency...'/>
        </div>
        <x-modals.create-agency :fieldOffices="$fieldOffices"/>
        <button onclick="openCreateAgencyModal()"
                class="flex items-center rounded-4xl transition hover:scale-[1.05] hover:bg-red-700 bg-red-800">
            <span class="text-1xl font-bold text-white p-3">+ Add New Agency</span>
        </button>
        </div>
    </section>


    <section class="p-6">
        @foreach ($agencies as $agency)
            <div class="grid grid-cols-1 gap-4">
                <a class="block duration-300 ease-in-out hover:-translate-y-2 hover:bg-blue-100 hover:shadow-blue-200/50 flex gap-4 items-center rounded-2xl bg-white p-6 shadow-gray-400 ring-1 ring-slate-100" href="">
                    <img class="h-16 w-16 rounded-2xl object-cover ring-2 ring-red-200" src="csc_logo.png">
                    <div class="flex-1 ">
                    <p class="text-2xl font-bold ">{{ $agency->name }}</p>
                    <p class="text-1xl font-bold text-red-800">Field Office: {{ $agency->fieldOffice->name}}</p>
                    
                    </div>

                    <div class="text-right">
                    <p class="text-1xl text-gray-600">Agency Head: <span class="text-1xl font-bold text-slate-800">{{ $agency->head }}</span></p>
                    <p class="text-1xl text-gray-600">Email Address: <span class="text-1xl font-bold text-slate-800">{{ $agency->email_address}}</span></p>
                    
                    </div>
                </a>
             </div>
        @endforeach
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