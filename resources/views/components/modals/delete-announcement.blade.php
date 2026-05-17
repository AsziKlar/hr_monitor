<div id="deleteAnnouncementModal-{{ $announcement->id }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
    <div class="w-full max-w-xl rounded-4xl bg-white p-8 shadow-2xl">

        <div class="text-center">
            <h2 class="text-2xl font-bold text-blue-950">
                Delete Announcement
            </h2>

            <p class="mt-3 text-slate-600">
                Are you sure you want to delete this announcement?
            </p>
        </div>

        <div class="mt-6 rounded-2xl bg-slate-100 p-4 text-sm text-slate-700">
            {{ $announcement->title }}
        </div>

        <div class="mt-8 flex justify-between">
            <button 
                type="button"
                onclick="closeDeleteAnnouncementModal({{ $announcement->id }})"
                class="rounded-2xl border border-slate-300 px-6 py-3 font-bold text-blue-950 hover:bg-slate-100"
            >
                Cancel
            </button>

            <form method="POST" action="{{ route('announcements.destroy', $announcement) }}">
                @csrf
                @method('DELETE')

                <button 
                    type="submit"
                    class="rounded-2xl bg-red-800 px-6 py-3 font-bold text-white hover:bg-red-900"
                >
                    Delete
                </button>
            </form>
        </div>

    </div>
</div>