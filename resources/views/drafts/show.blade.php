<x-app-layout>
     <!-- seacrhchd bar -->
        <section class="p-6">
          <div class="flex-grow flex gap-4 items-center rounded-4xl bg-white p-6 shadow-gray-400 ring-1 ring-slate-100">
            <div class="flex text-blue-950 gap-4 flex-grow">
              <div class="flex-1 gap-4">
                <div class="flex-1 gap-8">
                  <p class="text-2xl font-bold ">{{ $draft->mechanism->name }}</p>
                </div>
                <div class="flex-1 gap-4 mt-3">
                  <div class="flex gap-7 flex-grow">
                    <div class="flex-1">
                      <p class="text-1xl text-gray-600">Agency:</p>
                      <p class="text-1xl font-bold text-slate-800">Agency 1</p>
                    </div>
                    <div class="flex-1">
                      <p class="text-1xl text-gray-600">Category</p>
                      <p class="text-1xl font-bold text-slate-800">MSP</p>
                    </div>
                    <div class="flex-1">
                      <p class="text-1xl text-gray-600">Date Submitted</p>
                      <p class="text-1xl font-bold text-slate-800">September 11, 2001</p>
                    </div>
                    <div class="flex justify-center items-center gap-3">
                      <p class="text-1xl text-gray-600">Status: </p>
                      @if ($draft->status->id == 1)
                      <span class="rounded-full bg-yellow-200 px-3 py-1 text-[14px] font-bold text-yellow-900">
                        To be Reviewed
                      </span>
                    @elseif ($draft->status->id == 2)
                      <span class="rounded-full bg-red-200 px-3 py-1 text-[14px] font-bold text-red-900 border-b border-slate-300">
                        Needs Revision
                      </span>
                    @else
                      <span class="rounded-full bg-green-200 px-3 py-1 text-[14px] font-bold text-green-900 border-b border-slate-300">
                        Approved
                      </span>
                    @endif
                    </div>
                  </div>
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
</x-app-layout>