<div id="editAgencyModal" class="fixed inset-0 z-[999999] hidden items-center justify-center bg-black/40 p-4">
    <div class="w-full max-w-xl overflow-hidden rounded-3xl bg-white shadow-2xl">

        
        <div class="p-4">
            <h2 class="text-3xl font-bold text-blue-950">
               Edit Agency Details
            </h2>
        </div>

        <form method="POST" action="{{ route('agency.update', $agency) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="border-y border-slate-200 bg-slate-100/20 p-8">
                <div>
                    <label class="font-bold text-blue-950">
                       Agency Name
                    </label>

                    <input  type="text" 
                            name="name"
                            value="{{ $agency->name }}"
                            placeholder="Choose a field office"
                            class="mt-2 w-full rounded-2xl border border-slate-300 bg-white p-4 focus:border-blue-500 focus:ring-blue-500"
                            required>
                </div>

                <div class="mt-5 grid grid-cols-2 gap-4">
                    <div>
                        <label class="font-bold text-blue-950">
                            Abbreviation
                        </label>

                        <input 
                            type="text" 
                            name="abbreviation"
                            value="{{ $agency->abbreviation }}"
                            placeholder="e.g. CSC"
                            class="mt-2 w-full rounded-2xl border border-slate-300 bg-white p-4 focus:border-blue-500 focus:ring-blue-500"
                            required
                        >
                    </div>
                    <div>
                        <label class="font-bold text-blue-950">
                            Field Office
                        </label>
                        <select
                            name="field_office_id"
                            class="mt-2 w-full rounded-2xl border border-slate-300 bg-white p-4 focus:border-blue-500 focus:ring-blue-500"
                            value="{{ $agency->abbreviation }}"
                            required
                        >
                            <option value="" disabled selected>Select Field Office</option>

                            @foreach ($fieldOffices as $fieldOffice)
                                <option value="{{ $fieldOffice->id }}" @selected($agency->field_office_id == $fieldOffice->id)>
                                    {{ $fieldOffice->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                </div>
                <div class="mt-5 grid grid-cols-2 gap-4">

                    <div>
                        <label class="font-bold text-blue-950">
                            Email Address
                        </label>

                        <input 
                            type="email" 
                            name="email_address"
                            value="{{ $agency->email_address }}"
                            placeholder="Enter Email Address"
                            class="mt-2 w-full rounded-2xl border border-slate-300 bg-white p-4 focus:border-blue-500 focus:ring-blue-500"
                            required
                        >
                        @error('email_address')
                            <p class="mt-2 text-sm font-semibold text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="font-bold text-blue-950">
                            Agency Head
                        </label>

                        <input 
                            type="text" 
                            name="head"
                            value="{{ $agency->head }}"
                            placeholder="Enter Agency Head"
                            class="mt-2 w-full rounded-2xl border border-slate-300 bg-white p-4 focus:border-blue-500 focus:ring-blue-500"
                            required
                        >
                    </div>
                </div>
                <div>
                    <label class="font-bold text-blue-950">
                        Choose an Agency Photo
                    </label>

                    <input 
                        type="file"
                        name="photo"
                        accept="image/*"
                        class="mt-2 block w-full rounded-2xl border border-slate-300 bg-white p-4 text-slate-700 file:mr-4 file:rounded-xl file:border-0 file:bg-red-800 file:px-4 file:py-2 file:font-bold file:text-white hover:file:bg-red-700"
                    >
                    @error('photo')
                        <p class="mt-2 text-sm font-semibold text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            
            <div class="flex justify-end gap-4 p-6">

                <button 
                    type="button"
                    onclick="closeEditAgencyModal()"
                    class="rounded-2xl border border-slate-300 px-6 py-3 font-bold text-blue-950 hover:bg-slate-100"
                >
                    Cancel
                </button>

                <button 
                    type="submit"
                    class="rounded-2xl bg-red-800 px-6 py-3 font-bold text-white hover:bg-red-900"
                >
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document
            .getElementById('editAgencyModal')
            .classList.remove('hidden');

        document
            .getElementById('editAgencyModal')
            .classList.add('flex');
    });
</script>
@endif