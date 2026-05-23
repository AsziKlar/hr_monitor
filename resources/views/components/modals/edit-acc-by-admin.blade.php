<div id="editAccByAdminModal-{{ $account->id }}" class="fixed inset-0 z-[999999] hidden items-center justify-center bg-black/40 p-4">
    <div class="w-full max-w-xl overflow-hidden rounded-3xl bg-white shadow-2xl">

        
        <div class="p-8">
            <h2 class="text-3xl font-bold text-blue-950">
               Edit your account details
            </h2>
        </div>

        <form method="POST" action="{{ route('admin.accounts.update', $account) }}">
            @csrf
            @method('PATCH')
            <div class="border-y border-slate-200 bg-slate-100/20 p-8">
                <div>
                    <label class="font-bold text-blue-950">
                       Name
                    </label>

                    <input  type="text" 
                            name="name"
                            value="{{ $account->name }}"
                            placeholder="Enter Fullname"
                            class="mt-2 w-full rounded-2xl border border-slate-300 bg-white p-4 focus:border-blue-500 focus:ring-blue-500"
                            required>
                </div>

                <div class="mt-5 grid grid-cols-2 gap-4">
                    <div>
                        <label class="font-bold text-blue-950">
                            Email
                        </label>

                        <input 
                            type="email" 
                            name="email"
                            value="{{ $account->email }}"
                            class="mt-2 w-full rounded-2xl border border-slate-300 bg-white p-4 focus:border-blue-500 focus:ring-blue-500"
                            required
                        >
                    </div>
                    <div>
                        <label class="font-bold text-blue-950">
                            Password
                        </label>

                        <div class="relative mt-2">
                            <input
                                id="password-{{ $account->id }}"
                                type="password"
                                name="password"
                                placeholder="Leave blank if no change"
                                class="password-toggle-input w-full rounded-2xl border border-slate-300 bg-white p-4 pr-14 focus:border-blue-500 focus:ring-blue-500"
                            >

                            <button
                                type="button"
                                id="togglePassword-{{ $account->id }}"
                                class="absolute right-4 top-1/2 -translate-y-1/2 z-10 text-slate-500 hover:text-slate-700"
                            >
                                <img
                                    id="passwordIcon-{{ $account->id }}"
                                    src="{{ asset('images/eye-closed.svg') }}"
                                    class="h-5 w-5"
                                >
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            
            <div class="flex justify-end gap-4 p-6">

                <button 
                    type="button"
                    onclick="closeEditAccByAdminModal({{ $account->id}})"
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
<script>
(function () {
    const password = document.getElementById('password-{{ $account->id }}');
    const togglePassword = document.getElementById('togglePassword-{{ $account->id }}');
    const icon = document.getElementById('passwordIcon-{{ $account->id }}');

    if (password && togglePassword && icon) {
        togglePassword.addEventListener('click', function () {
            if (password.type === 'password') {
                password.type = 'text';
                icon.src = "{{ asset('images/eye1.svg') }}";
            } else {
                password.type = 'password';
                icon.src = "{{ asset('images/eye-closed.svg') }}";
            }
        });
    }
})();
</script>