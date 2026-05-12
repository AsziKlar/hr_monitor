<x-app-layout>
        <section class="p-6">
    <div class="rounded-4xl bg-white p-8 shadow-gray-400 ring-1 ring-slate-100">

        <div class="flex items-start justify-between gap-4">

            <div>
                <h1 class="text-2xl font-bold text-blue-950">
                    {{ $draft->mechanism->name }} Records
                </h1>

                <p class="mt-2 text-lg text-blue-950/50">
                    Submitted by {{ $draft->agency->name }}
                </p>
            </div>

            @if (auth()->user()->role->name != 'HRMO')
                <div class="flex gap-3">
                    
                    <form action="{{ route('draft.approve', $draft->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <button 
                            type="submit"
                            class="rounded-2xl bg-emerald-500 px-6 py-3 font-bold text-white hover:bg-emerald-600">
                            Approve
                        </button>
                    </form>

                    <form action="{{ route('draft.revision', $draft->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button  type="submit" class="rounded-2xl bg-red-800 px-6 py-3 font-bold text-white hover:bg-red-900">
                            Needs Revision
                        </button>
                    </form>

                </div>
            @else
                @if ($draft->status->name === 'To be Reviewed')
                <x-modals.update-draft  :draft="$draft" />
                        <button onclick="openUpdateDraftModal()"
                            class="rounded-2xl bg-red-800 px-6 py-3 font-bold text-white hover:bg-red-900"
                        >
                            Replace File
                        </button>
                @endif
            @endif

        </div>

        <div class="mt-7 grid grid-cols-1 gap-6 md:grid-cols-4">

            <div>
                <p class="text-lg text-blue-950/70">Agency:</p>
                <p class="text-lg font-bold text-blue-950">
                    {{ $draft->agency->name }}
                </p>
            </div>

            <div>
                <p class="text-lg text-blue-950/70">Category:</p>
                <p class="text-lg font-bold text-blue-950">
                    {{ $draft->mechanism->code ?? 'MSP' }}
                </p>
            </div>

            <div>
                <p class="text-lg text-blue-950/70">Date Submitted:</p>
                <p class="text-lg font-bold text-blue-950">
                    {{ $draft->created_at->format('F d, Y') }}
                </p>
            </div>

            <div class="flex items-center gap-3">
                <p class="text-lg text-blue-950/70">Status:</p>

                @if ($draft->status->id == 1)
                    <span class="rounded-full bg-yellow-300 px-4 py-2 text-sm font-bold text-yellow-900">
                        To be Reviewed
                    </span>
                @elseif ($draft->status->id == 2)
                    <span class="rounded-full bg-red-200 px-4 py-2 text-sm font-bold text-red-900">
                        Needs Revision
                    </span>
                @else
                    <span class="rounded-full bg-green-200 px-4 py-2 text-sm font-bold text-green-900">
                        Approved
                    </span>
                @endif
            </div>

        </div>

    </div>
</section>


        <!-- DOCUMENT -->

       <section class="p-6">

    <div class="rounded-2xl bg-white p-6 shadow-gray-400 ring-1 ring-slate-100">

        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-2xl font-bold text-blue-950">
                {{ $draft->file_name }}
            </h3>

           <a   href="{{ asset('storage/' . $draft->file_path) }}"
                download
                class="rounded-2xl bg-slate-100 px-4 py-2 font-bold text-slate-600 ring-2 ring-slate-300 transition hover:scale-[1.03] hover:bg-slate-200 inline-block">
                Download File
            </a>
        </div>

        <div class="overflow-hidden rounded-2xl ring-1 ring-slate-200">
            <iframe 
                src="{{ asset('storage/' . $draft->file_path) }}" 
                class="h-[calc(100vh-180px)] w-full"
            ></iframe>
        </div>

    </div>

</section>
<script>
            function openUpdateDraftModal() {
                document.getElementById('updateDraftModal')
                    .classList.remove('hidden');

                document.getElementById('updateDraftModal')
                    .classList.add('flex');
            }

            function closeUpdateDraftModal() {
                document.getElementById('updateDraftModal')
                    .classList.add('hidden');

                document.getElementById('updateDraftModal')
                    .classList.remove('flex');
            }
        </script>
</x-app-layout>