<div id="editAdminProfileModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
    <div class="w-full max-w-xl rounded-4xl bg-white p-8 shadow-2xl">

        <h2 class="text-2xl font-bold text-blue-950">
            Edit Profile
        </h2>

        <form method="POST" action="{{ route('admin.admin-profile.update') }}" class="mt-6">
            @csrf
            @method('PATCH')

            <div>
                <label class="font-bold text-blue-950">Name</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', auth()->user()->name) }}"
                    class="mt-2 w-full rounded-2xl border border-slate-300 p-4"
                    required
                >
            </div>

            <div class="mt-5">
                <label class="font-bold text-blue-950">Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email', auth()->user()->email) }}"
                    class="mt-2 w-full rounded-2xl border border-slate-300 p-4"
                    required
                >
            </div>

            <div class="mt-5">
                <label class="font-bold text-blue-950">Password (Leave blank if no change)</label>
                <input
                    type="password"
                    name="password"
                    value=""
                    class="mt-2 w-full rounded-2xl border border-slate-300 p-4"
                >
            </div>

            <div class="mt-6 flex justify-end gap-4">
                <button
                    type="button"
                    onclick="closeEditAdminProfileModal()"
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