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

        <section class="p-6 py-1">

            
            <div class="grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($mechanisms as $mechanism)

                    @php
                        $arts = [
                            'MSP' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-900', 'icon' => 'images/file-badge.svg'],
                            'SPMS' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-900', 'icon' => 'images/notepad-text.svg'],
                            'PRAISE' => ['bg' => 'bg-violet-100', 'text' => 'text-violet-900', 'icon' => 'images/trophy.svg'],
                            'GM' => ['bg' => 'bg-red-100', 'text' => 'text-red-900', 'icon' => 'images/scale.svg'],
                            'L&D' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-900', 'icon' => 'images/blocks.svg']
                        ];

                        $art = $arts[$mechanism->description];
                    @endphp

                    <a  
                        class="relative flex min-h-[210px] items-center gap-5 rounded-[2rem] bg-white p-6 pr-20 shadow-lg shadow-slate-200 ring-1 ring-slate-100 transition duration-300 ease-in-out hover:-translate-y-2 hover:shadow-slate-300"
                        href="{{ auth()->user()->role->name === 'HRMO'
                            ? route('hrmo.drafts.index', $mechanism)
                            : route('admin.drafts.index', $mechanism) }}"
                    >

                        <div class="flex h-24 w-24 shrink-0 items-center justify-center rounded-[1.5rem] {{ $art['bg'] }}">
                            <img 
                                src="{{ asset($art['icon']) }}" 
                                class="h-10 w-10"
                            >
                        </div>

                        <div class="min-w-0 flex-1">
                            <p class="text-xl font-bold leading-snug text-blue-950">
                                {{ $mechanism->name }}
                            </p>

                            <p class="mt-3 text-base text-slate-500">
                                {{ $mechanism->description }}
                            </p>
                        </div>

                        <div class="absolute right-6 top-1/2 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full {{ $art['bg'] }} text-2xl font-bold {{ $art['text'] }}">
                            ›
                        </div>

                    </a>

                @endforeach
            
            
            </div>
            
        </section>
      </main>
</x-app-layout>