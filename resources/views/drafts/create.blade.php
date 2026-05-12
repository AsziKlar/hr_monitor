<x-app-layout>
     <!-- seacrhchd bar -->
        <section class="p-6">
          <div class="flex-grow flex gap-4 items-center rounded-4xl bg-white p-6 shadow-gray-400 ring-1 ring-slate-100">
            <div class="flex text-blue-950 gap-4 flex-grow">
              <div class="flex-1 gap-4">
                <div class="flex-1 gap-8">
                  <p class="text-2xl font-bold ">{{ $mechanism->name }}</p>
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
                      <p class="text-1xl font-bold text-yellow-900 bg-yellow-200 rounded-2xl p-2">To Be Reviewed</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </section>


        <!-- DOCUMENT -->

        <section class="p-6">
          <div class="flex gap-2 ">
            <div class="flex-1 flex-grow-3 gap-4 items-center rounded-2xl bg-white p-6 shadow-gray-400 ring-1 ring-slate-100 text-slate-800">
              <div class="flex gap-4 items-center justify-between ">
                <h3 class="text-2xl font-bold text-blue-950">Document</h3>
                <button class="flex items-center rounded-2xl transition hover:scale-[1.07] bg-slate-100 ring-2 ring-slate-300 hover:bg-slate-200 hover:ring-slate-400 text-slate-600 hover:text-slate-700">
                  <span class="font-bold text-slate-600 px-2 py-1">Download File</span>
                </button>
              </div>
            </div>
            <div class="flex-1 flex-grow-2 gap-4 items-center rounded-2xl bg-white p-6 shadow-gray-400 ring-1 ring-slate-100 text-slate-800">
              <div class="flex gap-4 items-center justify-between ">
                <h3 class="text-2xl font-bold text-blue-950">Comments</h3>
              </div>
              <div class="bg-slate-100 rounded-2xl flex-1 p-3">
                <p class="text-slate-600 font-bold">John Doe</p>
                <p class="text-slate-400 ">Reviewer | September 14, 2001 | 9:10 AM</p>
                <p class="text-slate-600 mt-2 text-sm">No. Just, genuinely stop. Don't even bother continuing.</p>
              </div>
            </div>
          </div>
        </section>
</x-app-layout>