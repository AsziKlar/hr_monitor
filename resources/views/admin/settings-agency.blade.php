<x-app-layout>
    <section class="sticky top-0 z-40 mt-6 mx-6">
        <div class="flex gap-4 items-center rounded-4xl bg-white p-6 shadow-gray-400 ring-1 ring-slate-100">
        <div class="flex-1 text-blue-950 gap-2 justify-between">
            <p class="text-2xl font-bold ">Agency Directory</p>
        </div>
        <form method="GET" class="w-full max-w-[320px]">
            <div class="flex items-center rounded-full bg-slate-100 py-3 px-2 shadow-gray-400 ring-1 ring-slate-200">
                <img src="{{ asset('images/search.svg') }}" class="opacity-20" />
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search agency..."
                    class="w-full bg-transparent outline-none pl-1"
                >

            </div>
        </form>
       
  
           
            <button onclick="openResetAllMechanismModal()"
                    class="flex items-center rounded-4xl transition hover:scale-[1.05] hover:bg-red-700 bg-red-800">
                <span class="text-1xl font-bold text-white p-3">Reset All Agencies</span>
            </button>
     
       
        </div>
    </section>


      <section class="p-6">
          <div class="gap-4 flex rounded-[30px] bg-white p-6 shadow-gray-400 ring-1 ring-slate-100">
          <div class="overflow-x-auto flex flex-grow gap-2">
            <table class="table-auto flex-grow items-center justify-center border-collapse border-slate-400">
              <thead class="text-left">
                <tr class="text-1xl uppercase text-[#96A3BA] border-b border-slate-400">
                  <th class="font-bold">Agency</th>
                  <th class="font-bold">Action</th>
                </tr>
              </thead>
              <tbody class="text-1xl text-slate-700 items-center justify-center gap-3 flex-1">

              @forelse ($agencies as $agency)
              
                <tr class="hover:bg-slate-100 border-b border-slate-200 h-12">
                  <td class="font-bold">{{ $agency->name}}</td>
                  <td>
                    <x-modals.reset-mechanism :agency="$agency" :mechanism="$mechanism"/>
                    <button type="button" onclick="openResetMechanismModal({{ $agency->id }})" class="text-blue-500  font-semibold hover:underline">Reset Mechanism</button>
                  </td>
                </tr>
              
                  
              @empty
                  
              
                    <tr>
                        <td colspan="6" class="py-10 text-center text-slate-400 font-semibold">
                            No drafts submitted
                        </td>
                    </tr>
              @endforelse

              </tbody>
            </table>
          </div>
        </div>
        </section>
</x-app-layout>

<script>
  function openResetMechanismModal(agencyId) {
    document.getElementById('resetMechanismModal-' + agencyId).classList.remove('hidden');

    document.getElementById('resetMechanismModal-' + agencyId).classList.add('flex');
  }

  function closeResetMechanismModal(agencyId) {
    document.getElementById('resetMechanismModal-' + agencyId).classList.add('hidden');
    document.getElementById('resetMechanismModal-' + agencyId).classList.remove('flex');
  }
</script>