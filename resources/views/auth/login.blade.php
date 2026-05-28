<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/csc_logo.png') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
</head>

<body class="flex min-h-screen items-center justify-center bg-gradient-to-br from-blue-900 from-50% to-red-800">

<form method="POST" action="{{ route('login') }}">
    @csrf

    <section class="p-6">
        <div class="flex flex-col min-w-[480px] justify-center gap-4 items-center rounded-4xl bg-white p-6 ring-1 ring-slate-100 shadow-lg shadow-gray-950">

            <div class="h-16 w-16 rounded-2xl ring-2 ring-slate-200">
                <img    class="h-16 w-16 p-2" 
                        src="{{ asset('images/csc_logo.png') }}" 
                        alt="CSC Logo">
            </div>

            <div class="flex flex-col justify-center items-center">
                <h1 class="font-bold text-slate-700 text-2xl">LOG IN</h1>
                <span class="text-sm text-slate-500 p-3">Enter your Email and password.</span>
            </div>
            
           
            <div class="w-full">
                 @error('email')
                    <p class="mb-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <div class="flex w-full items-center rounded-2xl bg-slate-100 px-6 py-4 ring-1 ring-slate-200">
                    <input  id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="w-full bg-transparent outline-none"
                            placeholder="Enter ID"
                            required
                            autofocus
                            autocomplete="username"
                    >
                </div>

               
            </div>

            <div class="w-full">
                <div class="flex w-full items-center rounded-2xl bg-slate-100 px-6 py-4 ring-1 ring-slate-200">
                    <input  id="password"
                            type="password"
                            name="password"
                            class="w-full bg-transparent outline-none"
                            placeholder="Enter Password"
                            required
                            autocomplete="current-password"
                    >
                </div>

                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" 
                    class="flex w-full justify-center items-center rounded-2xl transition hover:scale-[1.05] hover:bg-red-700 bg-red-800 shadow-sm shadow-red-800">
                <span class="text-lg font-bold text-white p-3">LOG IN</span>
            </button>

            {{-- <div class="flex justify-center items-center gap-2">
                <p class="text-lg text-slate-500 p-3">Forgot Password?</p>

                @if (Route::has('password.request'))
                    <a  href="{{ route('password.request') }}" 
                        class="flex items-center text-red-800 rounded-2xl transition hover:text-red-700">
                        Click here
                    </a>
                @endif
            </div> --}}

        </div>
    </section>
</form>

</body>
</html>