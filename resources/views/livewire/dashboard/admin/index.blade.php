<div wire:poll.5s="loadDashboard">
    <div class=" flex flex-row gap-5 justify-between mb-7">

        <a class="flex-1" href="{{ route('admin.drafts.index', $mechanisms[0]) }}">
            <div class="rounded-4xl bg-blue-200/40 p-6 shadow-sm">
                <p class="text-2xl font-bold text-blue-600 uppercase tracking-wider">MSP</p>
                <div class="mt-2">
                    <div>
                        <p class="text-4xl font-bold">{{ $drafts_to_be_reviewed[1]->count() }}</p>
                    </div>
                    <div class="mt-2">
                        <p class="mt-2 inline-block rounded-full bg-yellow-200 p-2 text-xs font-bold text-yellow-700">To be Reviewed</p>
                    </div>
                </div>
            </div>
        </a>

        <a class="flex-1" href="{{ route('admin.drafts.index', $mechanisms[1]) }}">
            <div class="flex-1 rounded-4xl bg-emerald-100 p-6 shadow-sm">
                <p class="text-2xl font-bold text-emerald-700 uppercase tracking-wider">SPMS</p>
                <div class="mt-2">
                <div>
                    <p class="text-4xl font-bold ">{{ $drafts_to_be_reviewed[2]->count() }}</p>
                </div>
                <div class="mt-2">
                    <p class="mt-2 inline-block rounded-full bg-yellow-200 p-2 text-xs font-bold text-yellow-700">To be Reviewed</p>
                </div>
                </div>
            </div>
        </a>

        <a class="flex-1" href="{{ route('admin.drafts.index', $mechanisms[2]) }}">
            <div class="flex-1 rounded-4xl bg-violet-100 p-6 shadow-sm">
                <p class="text-2xl font-bold text-violet-700 uppercase tracking-wider">PRAISE</p>
                <div class="mt-2">
                <div>
                    <p class="text-4xl font-bold">{{ $drafts_to_be_reviewed[3]->count() }}</p>
                </div>
                <div class="mt-2">
                    <p class="mt-2 inline-block rounded-full bg-yellow-200 p-2 text-xs font-bold text-yellow-700">To be Reviewed</p>
                </div>
                </div>
            </div>
        </a>

        <a class="flex-1" href="{{ route('admin.drafts.index', $mechanisms[3]) }}">
            <div class="flex-1 rounded-4xl bg-red-100 p-6 shadow-sm">
                <p class="text-2xl font-bold text-red-700 uppercase tracking-wider">GM</p>
                <div class="mt-2">
                <div>
                    <p class="text-4xl font-bold">{{ $drafts_to_be_reviewed[4]->count() }}</p>
                </div>
                <div class="mt-2">
                    <p class="mt-2 inline-block rounded-full bg-yellow-200 p-2 text-xs font-bold text-yellow-700">To be Reviewed</p>
                </div>
                </div>
            </div>
        </a>

    </div>


    <div class="mt-4 rounded-4xl bg-white p-6 shadow-gray-400 ring-1 ring-slate-100">
        <div class="mb-4">
            <h2 class="text-xl font-bold">Summary of Approved Mechanisms</h2>
        </div>

        <div class="text-blue-950 flex flex-row gap-4 justify-between">
            @foreach ($mechanisms as $mechanism)

                <div class="flex-1 min-w-0 text-center">
                    <h2 class="text-sm font-bold uppercase tracking-wider">
                        {{ $mechanism->description }}
                    </h2>

                    <div class="relative h-[180px] mt-2" wire:ignore>
                        <canvas id="approvedChart-{{ $mechanism->id }}"></canvas>
                    </div>
                </div>

            @endforeach
        </div>
    </div>



    <div class="mt-6 grid grid-cols-2 gap-4 justify-between">
        <!-- barchart -->
        <div class="rounded-4xl bg-white p-6 shadow-gray-400 ring-1 ring-slate-100">
            <div>
                <div class="mb-4">
                    <h2 class="text-xl font-bold">Field Office Compliance</h2>
                <p class="text-sm text-slate-700/40">No. of agencies that completed all mechanisms</p>
                </div>

                <div class="h-75" wire:ignore>
                    <canvas id='mechanismBarChart' style="display: block; box-sizing: border-box; height: 300px; width: 481px;" width="601" height="375">
                    </canvas>
                </div>

            </div>
        </div>

        {{-- oldest submission table --}}
        <div class="rounded-4xl bg-white p-6 shadow-gray-400 ring-1 ring-slate-100">
            <div>
                <div class="mb-4">
                    <h2 class="text-xl font-bold">Oldest Submissions</h2>
                    <p class="text-sm text-slate-700/40">Drafts to be reviewed</p>
                </div>

                <div class="h-[300px] overflow-y-auto">

                    <table class="w-full table-auto border-collapse">

                        <thead class="sticky top-0 bg-white">
                            <tr class="border-b border-slate-300">

                                <th class="p-2 text-left text-slate-700/50">Agency</th>
                                <th class="p-2 text-left text-slate-700/50">Mechanism</th>
                                <th class="p-2 text-left text-slate-700/50">Date</th>
                                <th class="p-2 text-left text-slate-700/50">Period</th>

                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($drafts as $draft)
                            
                                <tr onclick="window.location='{{ route('drafts.show', $draft->id) }}'" class="cursor-pointer border-b border-slate-100 transition hover:bg-slate-50">
                                    
                                    <td class="p-2">{{ $draft->agency->name }}</td>
                                    <td class="p-2">{{ $draft->mechanism->description }}</td>
                                    <td class="p-2">{{ $draft->created_at->format('m/d/y') }}</td>
                                    <td class="p-2"><p class="text-xs">{{ $draft->created_at->diffForHumans() }}</p></td>
                                    
                                </tr>
                            
                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>
        </div>
    </div> 
</div>



@script
<script>
    if (window.mechanismBarChart instanceof Chart) {
        window.mechanismBarChart.destroy();
    }

    const mechanismBarCtx = document.getElementById('mechanismBarChart');

    if (mechanismBarCtx) {
        window.mechanismBarChart = new Chart(mechanismBarCtx, {
            type: 'bar',
            data: {
                labels: @json($field_office_names),
                datasets: [{
                    label: 'Completed Agencies',
                    data: @json($field_office_counts),
                    backgroundColor: [
                        '#3B5BDB',
                        '#E6C84F',
                        '#8B5CF6',
                        '#34B28A',
                        '#10B981',
                    ],
                    borderColor: [
                        '#3B5BDB',
                        '#E6C84F',
                        '#8B5CF6',
                        '#34B28A',
                        '#10B981',
                    ],
                    borderWidth: 1,
                    borderRadius: 15
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    }

    @foreach ($mechanisms as $mechanism)
        if (window['approvedChart{{ $mechanism->id }}'] instanceof Chart) {
            window['approvedChart{{ $mechanism->id }}'].destroy();
        }

        const approvedCtx{{ $mechanism->id }} = document.getElementById('approvedChart-{{ $mechanism->id }}');

        if (approvedCtx{{ $mechanism->id }}) {
            window['approvedChart{{ $mechanism->id }}'] = new Chart(
                approvedCtx{{ $mechanism->id }},
                {
                    type: 'doughnut',
                    data: {
                        labels: ['Approved', 'Not Approved'],
                        datasets: [{
                            data: [
                                {{ $approved_count[$mechanism->id] }},
                                {{ $total_drafts_num[$mechanism->id] - $approved_count[$mechanism->id] }}
                            ],
                            backgroundColor: [
                                '#24bf99',
                                '#b01c1c'
                            ],
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                }
            );
        }
    @endforeach
</script>
@endscript