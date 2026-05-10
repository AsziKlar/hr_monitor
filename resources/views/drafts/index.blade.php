<x-app-layout>
    <section class="p-6">
          <div class="flex gap-4 items-center rounded-4xl bg-white p-6 shadow-gray-400 ring-1 ring-slate-100">
            <div class="flex h-4 w-full items-center rounded-4xl bg-slate-100 p-6 shadow-gray-400 ring-1 ring-slate-200">
              {{-- <svg class="lucide lucide-search text-slate-400" viewBox="0 0 24 24" stroke="currentColor" xmlns="http://www.w3.org/2000/svg" height='24' width='24'/> --}}
              <input class="w-full outline-none type='text' placeholder" placeholder='Search submission...'/>
            </div>
            <select class="select select-bordered rounded-[16px] bg-slate-100 text-1xl min-w-[170px] ring-2 ring-slate-200 p-3">
                <option selected="" disabled="">Filter by Status</option>
                <option>To be Reviewed</option>
                <option>Needs Revision</option>
                <option>Approved</option>
              </select>
              <x-modals.create-draft  :mechanism-id="$mechanism_id" />

            @if (auth()->user()->role->name === 'HRMO')
              @if ($latestDraft && ($latestDraft->status->name === 'To be Reviewed' || $latestDraft->status->name === 'Approved'))
                <button disabled  title="You can only submit another draft once the recent draft has been reviewed." class="flex items-center justify-center rounded-4xl min-w-[240px] cursor-not-allowed bg-slate-300 opacity-70">
                    <span class="text-1xl font-bold text-white p-3">
                        + Add New Submission
                    </span>
                </button>

              @else
                <button onclick="openCreateDraftModal()"
                        class="flex items-center justify-center rounded-4xl min-w-[240px] transition hover:scale-[1.05] hover:bg-red-700 bg-red-800">
                    <span class="text-1xl font-bold text-white p-3">
                        + Add New Submission
                    </span>
                </button>
              @endif
            @endif

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

        <script>
            function openCreateDraftModal() {
                document.getElementById('createDraftModal')
                    .classList.remove('hidden');

                document.getElementById('createDraftModal')
                    .classList.add('flex');
            }

            function closeCreateDraftModal() {
                document.getElementById('createDraftModal')
                    .classList.add('hidden');

                document.getElementById('createDraftModal')
                    .classList.remove('flex');
            }
        </script>
</x-app-layout>