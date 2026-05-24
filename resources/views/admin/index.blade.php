<x-app-layout>
    <section class="px-6">
      <x-back-button />
          <div class="flex gap-4 items-center rounded-4xl bg-white p-6 shadow-gray-400 ring-1 ring-slate-100">

            <form method="GET" action="{{ route('admin.drafts.index', $mechanism) }}" class="w-full">
    
                <div class="flex gap-4 items-center">

                    <div class="flex h-12 w-60 items-center rounded-4xl bg-slate-100 px-6 ring-1 ring-slate-200">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search agency or category..."
                            class="w-full bg-transparent outline-none placeholder:text-slate-400"
                        />
                    </div>

                </div>

            </form>

            <form method="GET" action="{{ route('admin.drafts.index', $mechanism) }}">
                <select name="status" onchange="this.form.submit()" class="select select-bordered rounded-[16px] bg-slate-100 text-1xl min-w-[170px] ring-2 ring-slate-200 p-3">
                    <option option="">All Agencies</option>
                    <option value="1" {{ request('status') == 1 ? 'selected' : ''}}>To be Reviewed</option>
                    <option value="2" {{ request('status') == 2 ? 'selected' : ''}}>Needs Revision</option>
                    <option value="3" {{ request('status') == 3 ? 'selected' : ''}}>Approved</option>
                </select>
            </form>
             


          </div>
        </section>

        <!-- TABLE LISTTTTTTTTTT -->

        <section class="p-6">
          <div class="rounded-[30px] bg-white p-6 shadow-gray-400 ring-1 ring-slate-100">
              <div class="max-h-[65vh] overflow-y-auto overflow-x-auto">
                  <table class="w-full table-fixed border-collapse border-slate-400">
                      <thead class="sticky top-0 z-10 bg-white text-left">
                          <tr class="text-1xl uppercase text-[#96A3BA] border-b border-slate-400">
                              <th class="font-bold py-3">Submission Title</th>
                              <th class="font-bold py-3">Agency</th>
                              <th class="font-bold py-3">Category</th>
                              <th class="font-bold py-3">Date Submitted</th>
                              <th class="font-bold py-3">Status</th>
                              <th class="font-bold py-3">Action</th>
                          </tr>
                      </thead>

                      <tbody class="text-1xl text-slate-700">
                          @forelse ($drafts as $draft)
                              <tr class="hover:bg-slate-100 border-b border-slate-200 h-12">
                                  <td title="{{ $draft->file_name }}" class="font-bold">
                                        {{ Str::limit($draft->file_name, 20, '...') }}
                                    </td>
                                  <td title="{{ $draft->agency->name }}">{{ Str::limit($draft->agency->name, 20, '...') }}</td>
                                  <td>{{ $draft->mechanism->description }}</td>
                                  <td>{{ $draft->created_at->format('F d, Y') }}</td>

                                  <td>
                                      @if ($draft->status->id == 1)
                                          <span class="rounded-full bg-yellow-200 px-3 py-1 text-[12px] font-bold text-yellow-900">
                                              To be Reviewed
                                          </span>
                                      @elseif ($draft->status->id == 2)
                                          <span class="rounded-full bg-red-200 px-3 py-1 text-[12px] font-bold text-red-900">
                                              Needs Revision
                                          </span>
                                      @else
                                          <span class="rounded-full bg-green-200 px-3 py-1 text-[12px] font-bold text-green-900">
                                              Approved
                                          </span>
                                      @endif
                                  </td>

                                  <td>
                                      <a class="text-blue-500 font-semibold hover:underline" href="{{ route('drafts.show', $draft->id) }}">
                                          View
                                      </a>
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