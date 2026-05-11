<x-app-layout>
    <section class="p-6">
          <div class="flex gap-4 items-center rounded-4xl bg-white p-6 shadow-gray-400 ring-1 ring-slate-100">
            <div class="flex h-4 w-full items-center rounded-4xl bg-slate-100 p-6 shadow-gray-400 ring-1 ring-slate-200">
              <input class="w-full outline-none type='text' placeholder" placeholder='Search submission...'/>
            </div>

            <form method="GET" action="{{ route('admin.drafts.index', $mechanism) }}">
                <select name="status" onchange="this.form.submit()" class="select select-bordered rounded-[16px] bg-slate-100 text-1xl min-w-[170px] ring-2 ring-slate-200 p-3">
                    <option disabled selected>Filter by Status</option>
                    <option value="1" {{ request('status') == 1 ? 'selected' : ''}}>To be Reviewed</option>
                    <option value="2" {{ request('status') == 2 ? 'selected' : ''}}>Needs Revision</option>
                    <option value="3" {{ request('status') == 3 ? 'selected' : ''}}>Approved</option>
                </select>
            </form>
             


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