
<div id="createAnnouncementModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">

    
    <div class="w-full max-w-3xl rounded-4xl bg-white shadow-2xl overflow-hidden">

        
        <div class="p-8">
            <h2 class="text-3xl font-bold text-blue-950">Create Announcement</h2>
            <p class="mt-1 text-lg text-slate-400">
                Write and publish a new system announcement.
            </p>
        </div>

        <form method="POST" action="{{ route('store.announcements') }}">
            @csrf

            
            <div class="border-y border-slate-200 bg-slate-100/20 p-8">

                <div>
                    <label class="font-bold text-blue-950">Title</label>
                    <input 
                        type="text" 
                        name="title"
                        placeholder="Enter announcement title"
                        class="mt-2 w-full bg-white rounded-2xl border border-slate-300 p-4 text-lg focus:border-blue-500 focus:ring-blue-500"
                    >
                </div>


                <div class="mt-5">
                    <label class="font-bold text-blue-950">Announcement Body</label>
                    <textarea 
                        name="body"
                        rows="6"
                        placeholder="Write the announcement here..."
                        class="mt-2 w-full bg-white resize-none rounded-2xl border border-slate-300 p-4 text-lg focus:border-blue-500 focus:ring-blue-500"
                    ></textarea>
                </div>

            </div>

            <!-- Footer -->
            <div class="flex justify-end gap-4 p-6">
                <button 
                    type="button"
                    onclick="closeCreateAnnouncementModal()"
                    class="rounded-2xl border border-slate-300 px-6 py-3 font-bold text-blue-950 hover:bg-slate-100"
                >
                    Cancel
                </button>

                <button 
                    type="submit"
                    class="rounded-2xl bg-red-800 px-6 py-3 font-bold text-white hover:bg-red-900"
                >
                    Publish
                </button>
            </div>

        </form>

    </div>
</div>