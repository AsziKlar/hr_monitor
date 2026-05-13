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

                <h2 class="mt-4 text-2xl font-bold">
                    {{ $latestAnnouncement->title}}
                </h2>

                <p class="mt-4 text-blue-900/70 leading-relaxed">
                    {{ $latestAnnouncement->body }}
                </p>

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

        {{-- Overview Cards --}}
        <div class="mt-8">
        

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">

            @foreach ($mechanisms as $mechanism)
                
                @php
                    $draft =  $latest_draft_per_mechanism[$mechanism->id] ?? null;
                @endphp

                <div class="rounded-3xl bg-blue-500 p-6 text-white shadow-sm" title="{{ $mechanism->name }}">

                    <div class="flex items-center justify-between gap-3">

                        <p class="text-xl font-bold text-right">
                            {{ $draft?->mechanism?->name ?? $mechanism->description }}
                        </p>
                    </div>

                    <p class="mt-2 text-right font-semibold">
                        {{ $draft?->status?->name ?? 'No Submission Yet' }}
                    </p>

                </div>

            @endforeach

        </div>
    </div>

        {{-- Recent Submissions --}}
        <div class="mt-8 rounded-4xl bg-white p-6 md:p-8 shadow-sm ring-1 ring-slate-100">
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-2xl font-bold">Recent Submissions</h2>

                <a href="#" class="rounded-2xl border border-slate-200 px-5 py-3 text-sm font-semibold hover:bg-slate-50">
                    View All
                </a>
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

                        <div class="flex gap-3 text-slate-500">
                            <button>✏️</button>
                            <button>🗑</button>
                        </div>
                    </div>
                </div>
                @endforeach
                


            </div>
        </div>

    </div>
</section>


@else



 <!-- page content -->
    <section class="p-6">
        <!-- mechanism to be reviewed card -->
        <div class="text-blue-950 flex flex-row gap-2 justify-between">
        
          <div class="flex-1 rounded-4xl bg-blue-200/40 p-6 shadow-sm">
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

          <div class="flex-1 rounded-4xl bg-blue-200/40 p-6 shadow-sm">
              <p class="text-2xl font-bold text-blue-600 uppercase tracking-wider">SPMS</p>
              <div class="mt-2">
              <div>
                  <p class="text-4xl font-bold">{{ $drafts_to_be_reviewed[2]->count() }}</p>
              </div>
              <div class="mt-2">
                  <p class="mt-2 inline-block rounded-full bg-yellow-200 p-2 text-xs font-bold text-yellow-700">To be Reviewed</p>
              </div>
              </div>
          </div>

          <div class="flex-1 rounded-4xl bg-blue-200/40 p-6 shadow-sm">
              <p class="text-2xl font-bold text-blue-600 uppercase tracking-wider">PRAISE</p>
              <div class="mt-2">
              <div>
                  <p class="text-4xl font-bold">{{ $drafts_to_be_reviewed[3]->count() }}</p>
              </div>
              <div class="mt-2">
                  <p class="mt-2 inline-block rounded-full bg-yellow-200 p-2 text-xs font-bold text-yellow-700">To be Reviewed</p>
              </div>
              </div>
          </div>

          <div class="flex-1 rounded-4xl bg-blue-200/40 p-6 shadow-sm">
              <p class="text-2xl font-bold text-blue-600 uppercase tracking-wider">GM</p>
              <div class="mt-2">
              <div>
                  <p class="text-4xl font-bold">{{ $drafts_to_be_reviewed[4]->count() }}</p>
              </div>
              <div class="mt-2">
                  <p class="mt-2 inline-block rounded-full bg-yellow-200 p-2 text-xs font-bold text-yellow-700">To be Reviewed</p>
              </div>
              </div>
          </div>

          <div class="flex-1 rounded-4xl bg-blue-200/40 p-6 shadow-sm">
              <p class="text-2xl font-bold text-blue-600 uppercase tracking-wider">L&D</p>
              <div class="mt-2">
              <div>
                  <p class="text-4xl font-bold">{{ $drafts_to_be_reviewed[5]->count() }}</p>
              </div>
              <div class="mt-2">
                  <p class="mt-2 inline-block rounded-full bg-yellow-200 p-2 text-xs font-bold text-yellow-700">To be Reviewed</p>
              </div>
              </div>
          </div>

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

                        <div class="relative h-[180px] mt-2">
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
                    <p class="text-sm">No. of agencies that completed all mechanisms</p>
                </div>

                <div class="h-75">
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
                    <p class="text-sm"></p>
                </div>

                  <div class="h-[300px] overflow-y-auto">

                      <table class="w-full table-auto border-collapse">

                          <thead class="sticky top-0 bg-white">
                              <tr class="border-b border-slate-300/50">

                                  <th class="p-2 text-left text-slate-700/50">Agency</th>
                                  <th class="p-2 text-left text-slate-700/50">Mechanism</th>
                                  <th class="p-2 text-left text-slate-700/50">Date</th>
                                  <th class="p-2 text-left text-slate-700/50">Period</th>

                              </tr>
                          </thead>

                          <tbody>

                              @foreach ($drafts as $draft)
                                  <tr class="border-b hover:bg-slate-50">
                                      <td class="p-2">
                                          {{ $draft->agency->name }}
                                      </td>
                                      <td class="p-2">
                                          {{ $draft->mechanism->description }}
                                      </td>
                                      <td class="p-2">
                                          {{ $draft->created_at->format('m/d/y') }}
                                      </td>
                                      <td class="p-2">
                                          {{ $draft->created_at->diffForHumans() }}
                                      </td>

                                  </tr>

                              @endforeach

                          </tbody>

                      </table>

                  </div>

              </div>
          </div>
        </div> 



    </section>



    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- charts -->
    <script>
      // bar chart
      const mechanismBarCtx = document.getElementById('mechanismBarChart').getContext('2d');
      new Chart(mechanismBarCtx, {
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

      @foreach ($mechanisms as $mechanism)
        new Chart(
          document.getElementById('approvedChart-{{ $mechanism->id }}'),
          {
            type: 'doughnut',
            data: {
              labels: ['Approved', 'Not Approved'],
              datasets: [{
                data: [
                  {{ $approved_count[$mechanism->id] }},
                  {{ $total_drafts_num[$mechanism->id]-$approved_count[$mechanism->id] }}
                ],
                backgroundColor: [
                  '#24bf99', '#b01c1c'
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
      @endforeach
    </script>
  @endif
 </x-app-layout>
    