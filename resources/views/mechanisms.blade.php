<x-app-layout>

        <main class=" bg-slate-100 flex-1 overflow-y-auto">
        
        <section class="p-6">
          <div class="flex gap-4 items-center rounded-4xl bg-white p-6 shadow-gray-400 ring-1 ring-slate-100">
            <div class="flex-1 text-blue-950 gap-2 justify-between">
              <p class="text-2xl font-bold ">Mechanisms</p>
              <p class="text-1xl text-gray-400">Select a mechanism to view all submitted documents</p>
            </div>
          </div>
        </section>

        <section class="p-6">

            
            <div class="grid grid-cols-2 grid-rows-4 gap-4">

                @foreach ($mechanisms as $mechanism)

                <a  class="block duration-300 ease-in-out hover:-translate-y-2 flex gap-4 items-center rounded-2xl bg-white p-6 shadow-lg shadow-gray-200 hover:shadow-gray-500 ring-1 ring-slate-100" 
                    href="
                    {{ auth()->user()->role->name === 'HRMO'
                          ? route('hrmo.drafts.index', $mechanism) 
                          : route('admin.drafts.index', $mechanism)}}">
                
                        <div class="flex-1 ">
                        <p class="text-2xl font-bold ">{{ $mechanism->name}}</p>
                        <p class="text-1xl text-gray-400"></p>
                        </div>
                    <div class="bg-yellow-100 h-12 w-12 rounded-4xl"></div>
                </a>

                @endforeach
            
            
            </div>
            
        </section>
      </main>
</x-app-layout>