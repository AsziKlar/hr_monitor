@if (auth()->check() && auth()->user()->must_change_password)
    <div class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50">
        <div class="w-full max-w-md rounded-3xl bg-white p-8 shadow-lg">
            <h2 class="text-2xl font-bold text-slate-800 mb-4">
                Change Temporary Password
            </h2>

            <p class="mt-2 text-base text-slate-600">
                Please change your password before continuing.
                Password must contain <strong>uppercase, lowercase, number,</strong> and <strong>special character</strong>
            </p>

            <form method="POST" action="{{ route('force.password.change') }}" class="mt-6">
                @csrf

                <div>
                    <label class="text-sm font-semibold text-slate-700">
                        New Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        required
                        class="mt-2 w-full rounded-xl border border-slate-300 p-3"
                    >

                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label class="text-sm font-semibold text-slate-700">
                        Confirm Password
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        required
                        class="mt-2 w-full rounded-xl border border-slate-300 p-3"
                    >
                </div>

                <div class="mt-4">
                    <button
                        type="submit"
                        class="flex w-full justify-center items-center rounded-2xl transition hover:scale-[1.05] hover:bg-red-700 bg-red-800 shadow-sm shadow-red-800">
                        <span class="p-3 text-lg font-bold text-white">
                            Change Password
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endif