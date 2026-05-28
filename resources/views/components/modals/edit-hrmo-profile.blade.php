<div id="editHRMOModal" class="fixed inset-0 z-[999999] hidden items-center justify-center bg-black/40 p-4">
    <div class="w-full max-w-xl overflow-hidden rounded-3xl bg-white shadow-2xl">

        
        <div class="p-8">
            <h2 class="text-3xl font-bold text-blue-950">
               Edit HRMO Profile
            </h2>
        </div>

        <form method="POST" action="{{ route('hrmo.account.update') }}">
            @csrf
            @method('PATCH')
            <div class="border-y border-slate-200 bg-slate-100/20 p-8">
                <div>
                    <label class="font-bold text-blue-950">
                       Name
                    </label>

                    <input  type="text" 
                            name="name"
                            value="{{ old('name', $user->name) }}"
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
                            value="{{ old('email', $user->email) }}"
                            placeholder="juandelacruz@gmail.com"
                            class="mt-2 w-full rounded-2xl border border-slate-300 bg-white p-4 focus:border-blue-500 focus:ring-blue-500"
                            required
                        >
                    </div>
                    <div>
                        <label class="font-bold text-blue-950">
                            Password
                        </label>
                        <input id="password"
                            type="password"
                            placeholder="Leave blank if no change"
                            name="password"
                            class="mt-2 w-full rounded-2xl border border-slate-300 bg-white p-4 focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>

                </div>
            </div>

            
            <div class="flex justify-end gap-4 p-6">

                <button 
                    type="button"
                    onclick="closeEditHRMOModal()"
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

    const password = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');

    const icon = document.getElementById('passwordIcon');

    togglePassword.addEventListener('click', function(){
        if (password.type === 'password'){
            password.type = 'text';
            icon.src = "{{ asset('images/eye1.svg') }}";
            
        } else {
            password.type = 'password';
            icon.src = "{{ asset('images/eye-closed.svg') }}";
            
        }
    });

</script>