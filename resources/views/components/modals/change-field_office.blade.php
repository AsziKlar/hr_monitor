<div id="changeFieldOfficeModal-{{ $agency->id }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
    
    <div class="w-full max-w-2xl rounded-4xl bg-white p-8 shadow-2xl">

        <form method="POST" action="{{ route('admin.field-office.update', [$agency]) }}" onsubmit="this.querySelector('button[type=submit]').disabled = true;
                    this.querySelector('button[type=submit]').innerText = 'Processing...';
            ">
            @csrf
            @method('PATCH')

            <div class="px-6 text-center">

                <h2 class="text-3xl font-bold text-blue-950">
                    Change Field Office
                </h2>

                <h3 class="mt-2 text-xl font-bold text-slate-700">
                    Agency: {{ $agency->name }}
                </h3>

                <p class="mt-6 text-slate-600">
                    From
                </p>

                <div class="mt-2 inline-block rounded-full bg-red-100 px-5 py-2 font-bold text-red-800">
                    {{ $agency->fieldOffice->name }}
                </div>

                <p class="mt-4 text-slate-600">
                    To
                </p>

                <div class="mt-3">
                    <select
                        name="field_office_id"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-4 text-sm outline-none transition focus:ring-2 focus:ring-blue-200"
                    >
                        @foreach ($fieldOffices as $field_office)
                            <option
                                value="{{ $field_office->id }}"
                                @selected($agency->field_office_id === $field_office->id)
                            >
                                {{ $field_office->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="mt-8 flex justify-between gap-4">

                <button
                    type="button"
                    onclick="closeChangeFieldOfficeModal({{ $agency->id }})"
                    class="w-full rounded-2xl border border-slate-300 px-6 py-3 font-bold text-blue-950 transition hover:bg-slate-100"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="w-full rounded-2xl bg-red-800 px-6 py-3 font-bold text-white transition hover:bg-red-900"
                >
                    Change
                </button>

            </div>

        </form>

    </div>

</div>