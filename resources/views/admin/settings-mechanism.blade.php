<x-app-layout>

    <section class="p-6">
          <div class="flex items-center justify-between rounded-4xl bg-white p-6 shadow-gray-400 ring-1 ring-slate-100">
              <div class="text-blue-950">
                  <p class="text-2xl font-bold">
                      Batch Control
                  </p>

                  <p class="text-gray-400">
                      Select a mechanism
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

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">

        @foreach ($mechanisms as $mechanism)

            <a href="{{ route('admin.settings.agencies', $mechanism)}}" class="rounded-[2rem] bg-white p-6 shadow-lg shadow-slate-200 ring-1 ring-slate-100 transition hover:-translate-y-1 hover:shadow-slate-300">

                <div class="flex items-start justify-between">

                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-yellow-50">
                        <img 
                            src="{{ asset('images/mechanism-icon.svg') }}"
                            class="h-8 w-8"
                        >
                    </div>

                    <div class="rounded-full bg-yellow-50 px-3 py-1 text-sm font-bold text-yellow-600">
                        View
                    </div>

                </div>

                <div class="mt-6">

                    <p class="text-2xl font-bold text-blue-950">
                        {{ $mechanism->name }}
                    </p>

                    <p class="mt-3 leading-7 text-slate-500">
                        {{ $mechanism->description ?? 'View submitted documents and track review progress.' }}
                    </p>

                </div>

            </a>

        @endforeach

    </div>

</section>

</x-app-layout>