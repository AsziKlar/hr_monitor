<x-app-layout>
<section class="px-6">
    <x-back-button />
    <div class="rounded-[28px] bg-white px-6 py-6 shadow-sm ring-1 ring-slate-100">
        <div class="flex items-center gap-6">
            
            @if ($agency->photo)
            <div class="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-full text-2xl font-bold text-white">
                <img src="{{ asset('storage/' . $agency->photo) }}" class="h-full w-full object-cover">
            </div>
            @else
            <div class="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-full bg-gradient-to-br from-red-700 to-red-900 text-2xl font-bold text-white shadow-md">
                {{ $agency->abbreviation }}
            </div>
            @endif
            


            <div class="flex-1">
                <h1 class="text-2xl font-bold tracking-tight text-blue-950">{{ $agency->name }}</h1>
                <div class="mt-4 flex items-center gap-6">

                    <div>
                        <p class="text-sm text-slate-500">
                            Abbreviation
                        </p>

                        <p class="text-base font-bold text-blue-950">
                            {{ $agency->abbreviation }}
                        </p>
                    </div>

                    <div class="h-10 w-px bg-slate-200"></div>
                    <div>
                        <p class="text-sm text-slate-500">
                            Agency Head
                        </p>

                        <p class="text-base font-bold text-blue-950">
                            {{ $agency->head }}
                        </p>
                    </div>

                    <div class="h-10 w-px bg-slate-200"></div>
                    <div>
                        <p class="text-sm text-slate-500">
                            HRMO
                        </p>

                        <p class="text-base font-bold text-blue-950">
                            {{ $agency_hrmo?->name ?? 'No HRMO yet' }}
                        </p>
                    </div>

                    <div class="h-10 w-px bg-slate-200"></div>
                    <div>
                        <p class="text-sm text-slate-500">
                            Email Address
                        </p>

                        <p class="text-base font-bold text-blue-950">
                            {{ $agency->email_address }}
                        </p>
                    </div>

                    <div class="h-10 w-px bg-slate-200"></div>
                    <div>
                        <p class="text-sm text-slate-500">
                            Field Office
                        </p>

                        <p class="text-base font-bold text-blue-950">
                            {{ $agency->fieldOffice?->name ?? 'Not assigned' }}
                        </p>
                    </div>

                    <div class="h-10 w-px bg-slate-200"></div>
                    <div>
                        <p class="text-sm text-slate-500">
                            Approved Mechanisms
                        </p>

                        <p class="text-base font-bold text-blue-700">
                            {{ $approvedCount }} / 4
                        </p>
                    </div>
                    @if (in_array(auth()->user()->role->id, [1,4]))
                        <x-modals.edit-agency :fieldOffices="$fieldOffices" :agency="$agency"/>
                        <button onclick="openEditAgencyModal()"
                                class="ml-auto flex items-center justify-center rounded-4xl min-w-[100px] transition hover:scale-[1.05] hover:bg-red-700 bg-blue-800/70">
                            <span class="text-1xl font-bold text-white p-3">
                                Edit
                            </span>
                        </button>
                    @endif
                </div>
                
            </div>

        </div>

    </div>

</section>

        <!-- TABLE LISTTTTTTTTTT -->

        <section class="p-6">
          <div class="gap-4 flex rounded-[30px] bg-white p-6 shadow-gray-400 ring-1 ring-slate-100">
          <div class="overflow-x-auto flex flex-grow gap-2">
            <table class="table-auto flex-grow items-center justify-center border-collapse border-slate-400">
              <thead class="text-left">
                <tr class="text-1xl uppercase text-[#96A3BA] border-b border-slate-400">
                  <th class="font-bold">Submission Title</th>
                  <th class="font-bold">Agency</th>
                  <th class="font-bold">Category</th>
                  <th class="font-bold">Date Submitted</th>
                  <th class="font-bold">Status</th>
                  <th class="font-bold">Action</th>
                </tr>
              </thead>
              <tbody class="text-1xl text-slate-700 items-center justify-center gap-3 flex-1">

              @forelse ($drafts as $draft)
              
                <tr class="hover:bg-slate-100 border-b border-slate-200 h-12">
                  <td class="font-bold">{{$draft->file_name}}</td>
                  <td>{{$draft->agency->name}}</td>
                  <td>{{$draft->mechanism->description}}</td>
                  <td>{{$draft->created_at->format('F d, Y')}}</td>

                  <td>
                    
                    @if ($draft->status->id == 1)
                      <span class="rounded-full bg-yellow-200 px-3 py-1 text-[12px] font-bold text-yellow-900">
                        To be Reviewed
                      </span>
                    @elseif ($draft->status->id == 2)
                      <span class="rounded-full bg-red-200 px-3 py-1 text-[12px] font-bold text-red-900 border-b border-slate-300">
                        Needs Revision
                      </span>
                    @else
                      <span class="rounded-full bg-green-200 px-3 py-1 text-[12px] font-bold text-green-900 border-b border-slate-300">
                        Approved
                      </span>
                    @endif
            
                  </td>

                  <td>
                    <a class="text-blue-500  font-semibold hover:underline" href="{{ route('drafts.show', $draft->id) }}">View</a>
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
    function openEditAgencyModal() {
        document.getElementById('editAgencyModal')
            .classList.remove('hidden');

        document.getElementById('editAgencyModal')
            .classList.add('flex');
    }

    function closeEditAgencyModal() {
        document.getElementById('editAgencyModal')
            .classList.add('hidden');

        document.getElementById('editAgencyModal')
            .classList.remove('flex');
    }
</script>