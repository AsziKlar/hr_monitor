@if (session('success'))
    <div 
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 5000)"
        x-show="show"
        x-transition
        class="fixed top-6 right-6 z-[9999] rounded-2xl bg-green-100 px-5 py-4 font-semibold text-green-800 shadow-2xl"
    >
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div 
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 5000)"
        x-show="show"
        x-transition
        class="fixed top-6 right-6 z-[9999] rounded-2xl bg-red-100 px-5 py-4 font-semibold text-red-800 shadow-2xl"
    >
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div 
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 5000)"
        x-show="show"
        x-transition
        class="fixed top-6 right-6 z-[9999] rounded-2xl bg-red-100 px-5 py-4 font-semibold text-red-800 shadow-2xl"
    >
        <p class="font-bold">Please check the form.</p>

        <ul class="mt-2 list-disc pl-5 text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif