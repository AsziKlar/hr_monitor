<div id="addFieldOfficeModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
    
    <div class="w-full max-w-xl rounded-4xl bg-white p-8 shadow-2xl">

        <form method="POST" action="{{ route('admin.field-office.add') }}" onsubmit="this.querySelector('button[type=submit]').disabled = true;
                    this.querySelector('button[type=submit]').innerText = 'Processing...';
            ">
            @csrf
            @method('PATCH')

            <div>

                <h2 class="text-3xl font-bold text-blue-950">
                    Add Field Office
                </h2>

                <div class="mt-4 h-[1px] w-full bg-slate-200"></div>

                <div class="mt-6">
                    <input
                        type="text"
                        name="field_office_name"
                        placeholder="Enter field office name..."
                        class="w-full rounded-2xl border border-slate-300 px-4 py-4 text-sm outline-none transition focus:ring-2 focus:ring-blue-200"
                    >
                </div>

            </div>

            <div class="mt-8 flex justify-between gap-4">

                <button
                    type="button"
                    onclick="closeAddFieldOfficeModal()"
                    class="w-full rounded-2xl border border-slate-300 px-6 py-3 font-bold text-blue-950 transition hover:bg-slate-100"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="w-full rounded-2xl bg-red-800 px-6 py-3 font-bold text-white transition hover:bg-red-900"
                >
                    Save
                </button>

            </div>

        </form>

    </div>

</div>