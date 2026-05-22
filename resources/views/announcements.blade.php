<x-app-layout>
        
        <!-- seacrhchd bar -->
        <section class="p-6 bg-slate-100 flex-1 overflow-y-auto">
          <div class="flex gap-4 items-center rounded-4xl bg-white p-6 shadow-gray-400 ring-1 ring-slate-100">
            <div class="flex-1 text-blue-950 gap-2 justify-between">
              <p class="text-2xl font-bold ">Announcement Board</p>
              <p class="text-1xl text-gray-400">Publish official notices, reminders, and updates for agencies and CSC personnel.</p>
            </div>

            <x-modals.create-announcement />
            <button onclick="openCreateAnnouncementModal()" class="flex items-center rounded-4xl transition hover:scale-[1.05] hover:bg-red-700 bg-red-800">
              <span class="text-1xl font-bold text-white p-3">+ Create Announcement</span>
            </button>
          </div>
        </section>

        @foreach ($announcements as $announcement)
            <section class="px-6 pt-2">
                <div class="flex gap-4 items-start rounded-4xl bg-white p-6 shadow-gray-400 ring-1 ring-slate-100">
                    <div class="flex text-blue-950 gap-4 grow">

                        <div class="flex-1 gap-4 grow justify-between">
                            <div class="flex-1 gap-8">
                            <div class="flex gap-2">
                                <h3 class="text-2xl font-bold ">{{ $announcement->title }}</h3>
                            </div>
                            <p class="text-gray-500">{{ $announcement->body }}</p>
                            </div>
                            <div class="flex-1 gap-4 mt-1">
                            <div class="flex flex-wrap justify-start gap-7">
                            
                                <div class="flex">
                                <p class="text-1xl text-gray-600">Date Posted:
                                    <span class="text-1xl font-bold text-slate-800">{{ $announcement->created_at->format('M d, Y') }}</span>
                                </p>
                                </div>
                                <div class="flex">
                                <p class="text-1xl text-gray-600">Posted By:
                                    <span class="text-1xl font-bold text-slate-800">{{ $announcement->user->name}}</span>
                                </p>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="items-start flex gap-4 shrink ">
                    {{-- <button class="flex items-center rounded-2xl transition hover:scale-[1.07] bg-slate-100 ring-2 ring-slate-300 hover:bg-slate-200 hover:ring-slate-400 text-slate-600 hover:text-slate-700">
                        <span class="font-bold text-slate-600 py-2 px-5">Edit</span>
                    </button> --}}

                    <x-modals.delete-announcement :announcement="$announcement"/>
                    <button type="button" onclick="openDeleteAnnouncementModal({{ $announcement->id }})" class="flex items-center rounded-2xl transition hover:scale-[1.07] bg-red-100 ring-2 text-red-600 ring-red-300 hover:bg-red-200 hover:ring-red-400 hover:text-red-700">
                        <span class="font-bold py-2 px-5">Delete</span>
                    </button>

                    </div>
                </div>
            </section>
        @endforeach

   
</x-app-layout>
 <script>
    function openCreateAnnouncementModal() {
        document.getElementById('createAnnouncementModal')
            .classList.remove('hidden');

        document.getElementById('createAnnouncementModal')
            .classList.add('flex');
    }

    function closeCreateAnnouncementModal() {
        document.getElementById('createAnnouncementModal')
            .classList.add('hidden');

        document.getElementById('createAnnouncementModal')
            .classList.remove('flex');
    }
</script>

<script>
    function openDeleteAnnouncementModal(announcementId) {
        document.getElementById(`deleteAnnouncementModal-${announcementId}`).classList.remove('hidden');
        document.getElementById(`deleteAnnouncementModal-${announcementId}`).classList.add('flex');
    }

    function closeDeleteAnnouncementModal(announcementId) {
        document.getElementById(`deleteAnnouncementModal-${announcementId}`).classList.add('hidden');
        document.getElementById(`deleteAnnouncementModal-${announcementId}`).classList.remove('flex');
    }
</script>