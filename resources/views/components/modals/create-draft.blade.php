
<div id="createAnnouncementModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">

    
    <div class="w-full max-w-3xl rounded-4xl bg-white shadow-2xl overflow-hidden">

        
        <div class="p-8">
            <h2 class="text-3xl font-bold text-blue-950">Create Draft</h2>
        </div>

        <form method="POST" action="{{ route('drafts.store') }}" enctype="multipart/form-data">
            @csrf

            
            <div class="border-y border-slate-200 bg-slate-100/20 p-8">

                <div>
                    <label class="font-bold text-blue-950">
                        Choose a PDF File
                    </label>

                    <input 
                        type="hidden"
                        name="mechanism_id"
                        value="{{ $mechanismId }}"
                    >

                    <input 
                        type="file"
                        name="file"
                        accept=".pdf"
                        class="mt-2 block w-full rounded-2xl border border-slate-300 bg-white p-4 text-slate-700 file:mr-4 file:rounded-xl file:border-0 file:bg-red-800 file:px-4 file:py-2 file:font-bold file:text-white hover:file:bg-red-700"
                    >
                </div>


                <div class="mt-5">
                    <label class="font-bold text-blue-950">Description</label>
                    <textarea 
                        name="description"
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
                    Submit
                </button>
            </div>

        </form>

    </div>
</div>