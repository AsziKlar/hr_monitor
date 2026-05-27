<div id="unarchiveAgencyModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
    <div class="w-full max-w-2xl rounded-4xl bg-white p-6 shadow-2xl">

        <div class="text-center">
            <h2 class="text-2xl font-bold text-blue-950">
                Unarchive Account
            </h2>

            <p class="mt-3 text-slate-600">
                Do you want to unarchive the account of

                <span class="font-bold text-red-800">
                    {{ $agency->name }}
                </span>?
            </p>
        </div>

        <div class="mt-8 flex items-center justify-between">

            <button
                type="button"
                onclick="closeUnarchiveAgencyModal()"
                class="rounded-2xl border border-slate-300 px-6 py-3 font-bold text-blue-950 transition hover:bg-slate-100"
            >
                Cancel
            </button>

            <form method="POST" action="{{ route('agency.unarchive', $agency)}} ">
                @csrf
                @method('PATCH')

                <button
                    type="submit"
                    class="rounded-2xl bg-red-800 px-6 py-3 font-bold text-white transition hover:bg-red-700"
                >
                    Unarchive
                </button>
            </form>

        </div>

    </div>
</div>