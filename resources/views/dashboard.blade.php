<x-app-layout>

    @if(auth()->user()->role->name === 'HRMO')
        <section>
            
        {{-- HRMO Dashboard --}}
            <div class="min-h-screen bg-slate-100 p-4 md:p-6 lg:p-8 text-blue-950">     
                {{-- Top Section --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    {{-- Welcome Card --}}
                    <div class="lg:col-span-2 rounded-4xl bg-blue-200/60 p-8 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                        <div>
                            <h1 class="text-3xl font-bold">
                                Hi, {{ auth()->user()->name }}
                            </h1>
                            <p class="mt-3 max-w-xl text-lg text-blue-900/80">
                                Ready to submit your requirements and track {{ auth()->user()->agency->name }}'s review progress?
                            </p>
                        </div>

                        <div class="flex h-32 w-32 items-center justify-center rounded-3xl bg-white/40">
                            <svg class="h-16 w-16 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4"/>
                                <rect x="3" y="4" width="18" height="14" rx="2"/>
                                <path d="M8 21h8M12 18v3"/>
                            </svg>
                        </div>
                    </div>

                    {{-- for the quick reminder --}}
                    <div class="rounded-4xl bg-white p-8 shadow-sm ring-1 ring-slate-100">
                        <p class="flex items-center gap-2 font-semibold text-slate-500">
                            <img src="{{ asset('images/megaphone.svg') }}" alt="Search Icon" class="h-5 w-5">
                            Latest Announcement
                        </p>

                        @if ($latestAnnouncement)
                            <h2 class="mt-4 text-2xl font-bold">
                                {{ $latestAnnouncement?->title}}
                            </h2>

                            <p class="mt-4 text-blue-900/70 leading-relaxed">
                                {{ $latestAnnouncement?->body }}
                            </p>
                        @else
                            <p class="mt-4 text-slate-500/70 leading-relaxed">
                                No Announcement yet
                            </p>
                        @endif

                        {{-- <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="rounded-3xl bg-slate-50 p-5">
                                <p class="text-sm text-slate-500">Deadline</p>
                                <p class="mt-2 font-bold">April 05, 2026</p>
                            </div>

                            <div class="rounded-3xl bg-slate-50 p-5">
                                <p class="text-sm text-slate-500">Status</p>
                                <p class="mt-2 font-bold text-red-700">Pending Upload</p>
                            </div>
                        </div> --}}
                    </div>
                </div>


                <div class="mt-8">
                

                    <div class="flex flex-row gap-5 justify-between mb-7">

                        @foreach ($mechanisms as $mechanism)
                            @php
                                if ($mechanism->description === 'L&D'){
                                    break;
                                }
                            
                                    $draft = $latest_draft_per_mechanism[$mechanism->id] ?? null;

                                    $styles = [
                                        'MSP' => [
                                            'card' => 'bg-blue-200/40',
                                            'text' => 'text-blue-600',
                                        ],
                                        'SPMS' => [
                                            'card' => 'bg-emerald-100',
                                            'text' => 'text-emerald-700',
                                        ],
                                        'PRAISE' => [
                                            'card' => 'bg-violet-100',
                                            'text' => 'text-violet-700',
                                        ],
                                        'GM' => [
                                            'card' => 'bg-red-100',
                                            'text' => 'text-red-700',
                                        ],
                                        'LDP' => [
                                            'card' => 'bg-yellow-100',
                                            'text' => 'text-yellow-700',
                                        ],
                                    ];

                                    $style = $styles[$mechanism->description] ?? [
                                        'card' => 'bg-slate-100',
                                        'text' => 'text-slate-700',
                                    ];

                                    $status_style = [
                                        'To be Reviewed' => [
                                            'tag' => 'bg-yellow-100',
                                            'font-color' => 'text-yellow-700',
                                        ],

                                        'Needs Revision' => [
                                            'tag' => 'bg-red-100',
                                            'font-color' => 'text-red-700',
                                        ],

                                        'Approved' => [
                                            'tag' => 'bg-emerald-100',
                                            'font-color' => 'text-emerald-700',
                                        ]
                                    ];



                            @endphp
                            <a href="{{ $draft ? route('drafts.show', $draft?->id) : '' }}"  class="flex-1 {{ !$draft ? 'pointer-events-none' : '' }}">
                                <div class="flex-1 rounded-4xl {{ $style['card'] }} p-6 shadow-sm">

                                    <p class="text-2xl font-bold uppercase tracking-wider {{ $style['text'] }}">
                                        {{ $mechanism->description }}
                                    </p>

                                    <div class="mt-2">

                                        {{-- <div>
                                            <p class="text-xs font-bold text-slate-900">
                                                {{ $draft?->status?->name ?? 'No Submission Yet' }}
                                            </p>
                                        </div> --}}

                                        <p class="inline-block rounded-full px-3 py-2 text-xs font-bold 
                                            {{ $status_style[$draft?->status?->name]['tag'] ?? 'bg-slate-100' }}
                                            {{ $status_style[$draft?->status?->name]['font-color'] ?? 'text-slate-700' }}">
                                            
                                            {{ $draft?->status?->name ?? 'No Draft Submitted' }}

                                        </p>
                                    </div>

                                </div>
                            </a>
                        @endforeach

                    </div>
                </div>

                {{-- Recent Submissions --}}
                <div class="mt-8 rounded-4xl bg-white p-6 md:p-8 shadow-sm ring-1 ring-slate-100">
                    <div class="mb-6 flex items-center justify-between">
                        <h2 class="text-2xl font-bold">Recent Submissions</h2>

                        {{-- <a href="#" class="rounded-2xl border border-slate-200 px-5 py-3 text-sm font-semibold hover:bg-slate-50">
                            View All
                        </a> --}}
                    </div>

                    <div class="space-y-5">

                        {{-- item submission --}}
                        @foreach ($latestSubmissions as $submission)
                            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5 rounded-3xl border border-slate-100 p-5 md:p-6">
                            <div class="flex flex-col sm:flex-row gap-5">

                                <div>
                                    <h3 class="text-xl font-bold">{{ $submission->mechanism->name }}</h3>
                                    <p class="mt-3 font-bold">{{ $submission->file_name }}</p>
                                    <p class="mt-2 max-w-3xl text-blue-900/70 leading-relaxed">{{ $submission->description }}</p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between lg:justify-end gap-8">
                                <div class="text-left lg:text-right">
                                    <p class="font-bold">{{ $submission->status->name}}</p>
                                    <p class="text-sm text-slate-500">{{ $submission->created_at->format('M d, Y') }}</p>
                                </div>

                            </div>
                        </div>
                        @endforeach
                        


                    </div>
                </div>

            </div>
        </section>


    @else




    <section class="p-6">
       
        <livewire:dashboard.admin.index />

    </section>



        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

       
    @endif
 </x-app-layout>
    