<div id="editCommentModal-{{ $comment->id }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
    <div class="w-full max-w-xl rounded-4xl bg-white p-8 shadow-2xl">

        <h2 class="text-2xl font-bold text-blue-950">
            Edit Comment
        </h2>

        <form method="POST" action="{{ route('comments.update', $comment) }}" class="mt-6">
            @csrf
            @method('PATCH')

            <textarea
                name="comment"
                rows="5"
                class="w-full rounded-2xl border border-slate-300 p-4 focus:border-blue-500 focus:ring-blue-500"
                required
            >{{ old('comment', $comment->comment) }}</textarea>

            <div class="mt-6 flex justify-end gap-4">
                <button
                    type="button"
                    onclick="closeEditCommentModal({{ $comment->id }})"
                    class="rounded-2xl border border-slate-300 px-6 py-3 font-bold text-blue-950 hover:bg-slate-100"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="rounded-2xl bg-red-800 px-6 py-3 font-bold text-white hover:bg-red-900"
                >
                    Save Changes
                </button>
            </div>
        </form>

    </div>
</div>