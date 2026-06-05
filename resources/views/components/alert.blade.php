@if (session('success'))
    <div 
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 5000)"
        x-show="show"
        x-transition
        class="fixed top-6 left-0 right-0 lg:left-64 z-[99999] flex justify-center px-4"
    >
        <div class="rounded-2xl bg-green-100 px-5 py-4 font-semibold text-green-800 shadow-2xl">
            {{ session('success') }}
        </div>
    </div>
@endif

@if (session('error'))
    <div 
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 5000)"
        x-show="show"
        x-transition
        class="fixed top-6 left-0 right-0 lg:left-64 z-[99999] flex justify-center px-4"
    >
        <div class="rounded-2xl bg-red-100 px-5 py-4 font-semibold text-red-800 shadow-2xl">
            {{ session('error') }}
        </div>
    </div>
@endif

@if ($errors->any())
    <div 
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 5000)"
        x-show="show"
        x-transition
        class="fixed top-6 left-0 right-0 lg:left-64 z-[99999] flex justify-center px-4"
    >
        <div class="rounded-2xl bg-red-100 px-5 py-4 font-semibold text-red-800 shadow-2xl">
            <p class="font-bold">Please check the form.</p>

            <ul class="mt-2 list-disc pl-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif