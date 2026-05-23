
<x-app-layout>
    <x-modals.edit-profile :agency="$agency" :fieldOffices="$field_offices" />

    <section class="sticky top-0 z-40 mx-6 mt-6">
        <div class="rounded-[40px] bg-white p-10 shadow-gray-400 ring-1 ring-slate-100">

            <!-- Agency Card -->
        <div class="flex flex-col items-center">

            <!-- Circle Logo -->
            @if ($agency->photo)
                <div class="flex h-24 w-24 items-center justify-center rounded-full text-3xl font-bold text-white">
                    <img src="{{ asset('storage/' . $agency->photo) }}" class="h-full w-full rounded-full object-cover">
                </div>
            @else
                <div class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-full bg-gradient-to-br from-red-700 to-red-900 text-sm font-bold text-white shadow-md">
                    {{ auth()->user()->agency->abbreviation }}
                </div>

            @endif

            <!-- Agency Name -->
            <h1 class="mt-6 text-4xl font-bold text-blue-950">
                {{ $agency->name }}
            </h1>

            <!-- Field Office -->
            <p class="mt-2 text-lg font-bold text-red-800">
                {{ $agency->fieldOffice->name }}
            </p>
            <div class="mt-5 flex flex-wrap items-center justify-center gap-16">

                <!-- Email -->
                <div class="text-center">
                    <p class="text-lg text-slate-400">
                        Head:
                    </p>

                    <p class="mt-1 text-lg font-bold text-blue-950">
                        {{ $agency->head }}
                    </p>
                </div>

            </div>

            <!-- Details -->
            <div class="mt-5 flex flex-wrap items-center justify-center gap-16">

                <!-- Email -->
                <div class="text-center">
                    <p class="text-lg text-slate-400">
                        Email:
                    </p>

                    <p class="mt-1 text-lg font-bold text-blue-950">
                        {{ $agency->email_address }}
                    </p>
                </div>


                <div class="text-center">
                    <p class="text-lg text-slate-400">
                        Agency HRMO:
                    </p>

                    <p class="mt-1 text-lg font-bold text-blue-950">
                        {{ $user->name }}
                    </p>
                </div>

            </div>
        </div>

        <!-- Buttons Container -->
        <div class="mt-10 flex flex-wrap items-center justify-center gap-4 rounded-[32px] bg-slate-50 p-6 ring-1 ring-slate-100">

            <!-- Edit -->
            
            <button type="button" onclick="openEditProfileModal()" class="rounded-2xl border border-slate-300 bg-white px-6 py-3 text-base font-bold text-blue-950 transition hover:bg-slate-100">
                Edit Info
            </button>

            <!-- Password -->
            <button class="rounded-2xl bg-blue-100 px-6 py-3 text-base font-bold text-blue-700 transition hover:bg-blue-200">
                Change Password
            </button>

            <!-- Archive -->
            <button class="rounded-2xl bg-red-100 px-6 py-3 text-base font-bold text-red-700 transition hover:bg-red-200">
                Request to Archive Account
            </button>

        </div>
        </div>
    </section>
</x-app-layout>

<script>
    function openEditProfileModal(){
        document.getElementById('editProfileModal').classList.remove('hidden');
        document.getElementById('editProfileModal').classList.add('flex');
    }
    function closeEditProfileModal(){
        document.getElementById('editProfileModal').classList.add('hidden');
        document.getElementById('editProfileModal').classList.add('flex');
    }
</script>