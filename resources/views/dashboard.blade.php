 <x-app-layout>
 <!-- page content -->
    <section class="p-6">
        <!-- mechanism to be reviewed card -->
        
        <div class="text-blue-950 flex flex-row gap-2 justify-between">
        
          <div class="flex-1 rounded-4xl bg-blue-200/40 p-6 shadow-sm ring-1 ring-blue-200">
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

          <div class="flex-1 rounded-4xl bg-fuchsia-200/40 p-6 shadow-sm ring-1 ring-fuchsia-200">
              <p class="text-2xl font-bold text-fuchsia-600 uppercase tracking-wider">SPMS</p>
              <div class="mt-2">
              <div>
                  <p class="text-4xl font-bold">{{ $drafts_to_be_reviewed[2]->count() }}</p>
              </div>
              <div class="mt-2">
                  <p class="mt-2 inline-block rounded-full bg-yellow-200 p-2 text-xs font-bold text-yellow-700">To be Reviewed</p>
              </div>
              </div>
          </div>

          <div class="flex-1 rounded-4xl bg-amber-200/20 p-6 shadow-sm ring-1 ring-amber-200">
              <p class="text-2xl font-bold text-amber-600 uppercase tracking-wider">PRAISE</p>
              <div class="mt-2">
              <div>
                  <p class="text-4xl font-bold">{{ $drafts_to_be_reviewed[3]->count() }}</p>
              </div>
              <div class="mt-2">
                  <p class="mt-2 inline-block rounded-full bg-yellow-200 p-2 text-xs font-bold text-yellow-700">To be Reviewed</p>
              </div>
              </div>
          </div>

          <div class="flex-1 rounded-4xl bg-purple-200/20 p-6 shadow-sm ring-1 ring-purple-200">
              <p class="text-2xl font-bold text-purple-600 uppercase tracking-wider">MSP</p>
              <div class="mt-2">
              <div>
                  <p class="text-4xl font-bold">{{ $drafts_to_be_reviewed[4]->count() }}</p>
              </div>
              <div class="mt-2">
                  <p class="mt-2 inline-block rounded-full bg-yellow-200 p-2 text-xs font-bold text-yellow-700">To be Reviewed</p>
              </div>
              </div>
          </div>

          <div class="flex-1 rounded-4xl bg-emerald-200/20 p-6 shadow-sm ring-1 ring-emerald-200">
              <p class="text-2xl font-bold text-emerald-600 uppercase tracking-wider">GM</p>
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
                    <p class="text-sm">Overview of mechanisms completed</p>
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

                                  <th class="p-2 text-left text-slate-700/30">Agency</th>
                                  <th class="p-2 text-left text-slate-700/30">Mechanism</th>
                                  <th class="p-2 text-left text-slate-700/30">Date</th>
                                  <th class="p-2 text-left text-slate-700/30">Period</th>

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
                                          {{ $draft->create_at->diffForHumans() }}
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
      const mechanismBarChart = new Chart(mechanismBarCtx, {
          type: 'bar',
          data: {
              labels: ['Field Office 1', 'Field Office 2', 'Field Office 3', 'Field Office 4'],
              datasets: [{
                  label: '',
                  data: [12, 19, 3, 5],
                  backgroundColor: [
                    '#3B5BDB',
                    '#E6C84F',
                    '#8B5CF6',
                    '#34B28A',
                  ], 
                  borderColor: [
                    '#3B5BDB',
                    '#E6C84F',
                    '#8B5CF6',
                    '#34B28A',
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
              maintainAspectRatio: false
            }
              
          }
        );
      @endforeach
    </script>
 </x-app-layout>
    