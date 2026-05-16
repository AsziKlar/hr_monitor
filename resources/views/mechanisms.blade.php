<x-app-layout>

        <main class=" bg-slate-100 flex-1 overflow-y-auto">
        
        <section class="p-6">
          <div class="flex items-center justify-between rounded-4xl bg-white p-6 shadow-gray-400 ring-1 ring-slate-100">
              <div class="text-blue-950">
                  <p class="text-2xl font-bold">
                      Mechanisms
                  </p>

                  <p class="text-gray-400">
                      Select a mechanism to view all submitted documents
                  </p>
              </div>
              @if (auth()->user()->role === 'Administrator')
                <a class="flex items-center gap-2 rounded-2xl bg-gradient-to-br from-red-700 to-red-900 px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:scale-[1.02]" href="">
                    <img src="{{ asset('images/settings.svg') }}" class="h-5 w-5 brightness-0 invert">

                    Settings
                </a>
              @endif
          </div>
      </section>

        <section class="p-6">

            
            <div class="grid grid-cols-2 grid-rows-4 gap-4">

                @foreach ($mechanisms as $mechanism)

                <a  class="flex min-h-[180px] items-center gap-6 rounded-[2rem] bg-white p-6 shadow-lg shadow-slate-200 ring-1 ring-slate-100 transition duration-300 ease-in-out hover:-translate-y-2 hover:shadow-slate-300"
                    href="{{ auth()->user()->role->name === 'HRMO'
                        ? route('hrmo.drafts.index', $mechanism)
                        : route('admin.drafts.index', $mechanism) }}">

                  
                    <div class="flex h-28 w-28 shrink-0 items-center justify-center rounded-[1.5rem] bg-yellow-50">
                        <img 
                            src="{{ asset('images/mechanism-icon.svg') }}" 
                            class="h-12 w-12"
                        >
                    </div>

                    {{-- Text --}}
                    <div class="flex-1">
                        <p class="text-2xl font-bold leading-snug text-blue-950">
                            {{ $mechanism->name }}
                        </p>

                        <p class="mt-4 leading-7 text-slate-500">
                            {{ $mechanism->description ?? 'View submitted documents and track review progress.' }}
                        </p>

                        <p class="mt-5 font-bold text-yellow-600">

                          idk what to put here
                        </p>
                    </div>

                    {{-- Arrow --}}
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-yellow-50 text-2xl font-bold text-yellow-600">
                        ›
                    </div>

                </a>

                @endforeach
            
            
            </div>
            
        </section>
      </main>
</x-app-layout>