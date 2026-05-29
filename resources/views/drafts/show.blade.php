<x-app-layout>
    <section class="px-6 mb-5">
        <x-back-button />
        <div class="rounded-4xl bg-white p-8 shadow-gray-400 ring-1 ring-slate-100">

            <div class="flex items-start justify-between gap-4">

                <div>
                    <h1 class="text-2xl font-bold text-blue-950">
                        {{ $draft->mechanism->name }} 
                    </h1>

                    {{-- <p class="mt-2 text-lg text-blue-950/50">
                        Submitted by {{ $draft->agency->name }}
                    </p> --}}
                </div>

                @if (in_array(auth()->user()->role->id, [1,2]))
                    <div class="flex gap-3">

                        <form action="{{ route('draft.approve', $draft->id) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                onclick="this.disabled=true; this.form.submit();"
                                @disabled($draft->status->name == 'Approved')
                                class="rounded-2xl px-6 py-3 font-bold text-white
                                    {{ $draft->status->name == 'Approved'
                                        ? 'cursor-not-allowed bg-gray-400'
                                        : 'bg-emerald-500 hover:bg-emerald-600' }}">
                                {{ $draft->status->name == 'Approved' ? 'Approved' : 'Approve' }}
                            </button>
                        </form>

                        <form action="{{ route('draft.revision', $draft->id) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                onclick="this.disabled=true; this.form.submit();"
                                @disabled($draft->status->name == 'Needs Revision')
                                class="rounded-2xl px-6 py-3 font-bold text-white
                                    {{ $draft->status->name == 'Needs Revision'
                                        ? 'cursor-not-allowed bg-gray-400'
                                        : 'bg-red-800 hover:bg-red-900' }}">
                                {{ $draft->status->name == 'Needs Revision' ? 'Marked for Revision' : 'Needs Revision' }}
                            </button>
                        </form>

                    </div>
                @endif

                @if ($draft->status->name === 'To be Reviewed' && auth()->user()->role->id == 4)
                <x-modals.update-draft  :draft="$draft" />
                        <button onclick="openUpdateDraftModal()"
                            class="rounded-2xl bg-red-800 px-6 py-3 font-bold text-white hover:bg-red-900"
                        >
                            Replace File
                        </button>
                @endif
                

            </div>

            <div class="mt-7 grid grid-cols-1 gap-6 md:grid-cols-4">

                <div>
                    <p class="text-lg text-blue-950/70">Agency:</p>
                    <p class="text-lg font-bold text-blue-950">
                        {{ $draft->agency->name }}
                    </p>
                </div>

                <div>
                    <p class="text-lg text-blue-950/70">Submitted by:</p>
                    <p class="text-lg font-bold text-blue-950">
                        {{ $draft->user?->name }}
                        @if($draft->user->archived_at)
                            <span class="rounded-full bg-slate-300 px-2 py-1 text-[10px] font-bold text-slate-700">
                                Archived
                            </span>
                        @endif
                    </p>
                </div>

                <div>
                    <p class="text-lg text-blue-950/70">Date Submitted:</p>
                    <p class="text-lg font-bold text-blue-950">
                        {{ $draft->created_at->format('F d, Y') }}
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <p class="text-lg text-blue-950/70">Status:</p>

                    @if ($draft->status->id == 1)
                        <span class="rounded-full bg-yellow-300 px-4 py-2 text-sm font-bold text-yellow-900">
                            To be Reviewed
                        </span>
                    @elseif ($draft->status->id == 2)
                        <span class="rounded-full bg-red-200 px-4 py-2 text-sm font-bold text-red-900">
                            Needs Revision
                        </span>
                    @else
                        <span class="rounded-full bg-green-200 px-4 py-2 text-sm font-bold text-green-900">
                            Approved
                        </span>
                    @endif
                </div>

            </div>

        </div>
    </section>


        <!-- DOCUMENT -->

    <section class="p-6 py-1">

        <div class="flex h-[calc(100vh-100px)] gap-6">

            {{-- PDF Viewer --}}
            <div class="flex flex-1 flex-col rounded-4xl bg-white p-6 shadow-gray-400 ring-1 ring-slate-100">

                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-blue-950">
                        {{ $draft->file_name }}
                    </h3>

                    <a href="{{ asset('storage/' . $draft->file_path) }}"
                        download
                        class="inline-block rounded-2xl bg-slate-100 px-4 py-2 font-bold text-slate-600 ring-2 ring-slate-300 transition hover:scale-[1.03] hover:bg-slate-200">
                        Download File
                    </a>
                </div>

                {{-- iframe fills remaining height --}}
                <div class="flex-1 overflow-hidden rounded-2xl ring-1 ring-slate-200">
                    <iframe 
                        src="{{ asset('storage/' . $draft->file_path) }}" 
                        class="h-full w-full"
                    ></iframe>
                </div>
            </div>


            {{-- Comments Section --}}
            <div class="flex w-1/4 flex-col rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">

                {{-- Header --}}
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-blue-950">
                        Comments
                    </h2>
                </div>

                {{-- Comment List --}}
                <div class="flex-1 space-y-4 overflow-y-auto pr-2">

                    @forelse ($comments as $comment)

                        <div class="rounded-2xl bg-slate-50 p-4">

                            <div class="flex gap-3">

                                {{-- Profile --}}
                               @php
                                    $nameParts = collect(explode(' ', trim($comment?->user?->name ?? '')))->filter();

                                    $initials = strtoupper(
                                        ($nameParts->first()[0] ?? '?') .
                                        ($nameParts->last()[0] ?? '')
                                    );
                                @endphp

                                @if ($comment->user->role->name == 'HRMO')
                                    @php
                                        $agency = $comment?->user?->agency;
                                    @endphp

                                    @if (!$agency || !$agency->photo)
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-red-700 to-red-900 text-sm font-bold text-white">
                                            {{ $initials }}
                                        </div>
                                    @else
                                        <div class="flex h-10 w-10 shrink-0 overflow-hidden items-center justify-center rounded-full text-sm font-bold text-white">
                                            <img src="{{ asset('storage/' . $agency->photo) }}" class="h-full w-full object-cover">
                                        </div>
                                    @endif
                                @else
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-blue-700 to-blue-900 text-sm font-bold text-white">
                                        {{ $initials }}
                                    </div>
                                @endif
                                

                                {{-- Content --}}
                                <div class="min-w-0 flex-1">

                                    <p class="font-bold text-sm text-blue-950">
                                        {{ $comment?->user?->name }}
                                         @if ($comment->user->archived_at)
                                        <span class="rounded-full bg-slate-300 px-2 py-1 text-[10px] font-bold text-slate-700">
                                            Archived
                                        </span>
                                    @endif
                                    </p>
                                   

                                    <p class="mt-1 text-sm leading-relaxed text-slate-600">
                                        {{ $comment?->comment }}
                                    </p>

                                    {{-- Buttons --}}
                                    @if (auth()->user()->id == $comment->user->id) 
                                        <x-modals.edit-comment :comment="$comment"/>
                                        <x-modals.delete-comment :comment="$comment" />
                                        <div class="mt-3 flex gap-2">

                                            <button onclick="openEditCommentModal({{ $comment->id }})"class="rounded-lg bg-blue-50 px-3 py-1 text-xs font-bold text-blue-600 transition hover:bg-blue-100">
                                                Edit
                                            </button>

                                            <button onclick="openDeleteCommentModal({{ $comment->id }})" class="rounded-lg bg-red-50 px-3 py-1 text-xs font-bold text-red-600 transition hover:bg-red-100">
                                                Trash
                                            </button>

                                        </div>
                                    @endif

                                </div>

                            </div>
                        </div>

                    @empty

                        <p class="text-center text-sm text-slate-500">
                            No comments yet.
                        </p>

                    @endforelse


                    {{-- Add Comment Form --}}
                    <form action="{{ route('drafts.comment.store', $draft->id ) }}" method="POST">
                        @csrf

                        <div class="mb-5 rounded-2xl bg-slate-50 p-4">

                            <textarea
                                placeholder="Write a comment"
                                name="comment"
                                class="min-h-[100px] w-full resize-none rounded-xl border border-slate-200 bg-white p-4 text-sm text-slate-700 outline-none transition focus:border-blue-400"
                            ></textarea>

                            <div class="mt-3 flex justify-end">

                                <button
                                    type="submit"
                                    class="rounded-xl bg-gradient-to-br from-red-700 to-red-900 px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:scale-[1.02]"
                                >
                                    Add Comment
                                </button>

                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>

    </section>

</x-app-layout>
<script>
    function openUpdateDraftModal() {
        document.getElementById('updateDraftModal').classList.remove('hidden');

        document.getElementById('updateDraftModal').classList.add('flex');
    }

    function closeUpdateDraftModal() {
        document.getElementById('updateDraftModal').classList.add('hidden');

        document.getElementById('updateDraftModal').classList.remove('flex');
    }
</script>

<script>
    function openEditCommentModal(commentId) {
        document.getElementById('editCommentModal-' + commentId).classList.remove('hidden');

        document.getElementById('editCommentModal-' + commentId).classList.add('flex');
    }
    function closeEditCommentModal(commentId) {
        document.getElementById('editCommentModal-' + commentId).classList.add('hidden');

        document.getElementById('editCommentModal-' + commentId).classList.remove('flex');
    }
</script>

<script>
    function openDeleteCommentModal(commentId) {
        document.getElementById('deleteCommentModal-' + commentId).classList.remove('hidden');

        document.getElementById('deleteCommentModal-' + commentId).classList.add('flex');
    }
    function closeDeleteCommentModal(commentId) {
        document.getElementById('deleteCommentModal-' + commentId).classList.add('hidden');

        document.getElementById('deleteCommentModal-' + commentId).classList.remove('flex');
    }
</script>