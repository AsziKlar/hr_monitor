<div id="createUserModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
    <div class="w-full max-w-2xl overflow-hidden rounded-4xl bg-white shadow-2xl">

        
        <div class="p-8">
            <h2 class="text-3xl font-bold text-blue-950">
                Create Account
            </h2>
        </div>

        <form method="POST" action="{{ route('admin.account.store') }}">
            @csrf
            <div class="border-y border-slate-200 bg-slate-100/20 p-8">
                <div>
                    <label class="font-bold text-blue-950">
                       Name
                    </label>

                    <input  type="text" 
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Enter Fullname"
                            class="mt-2 w-full rounded-2xl border border-slate-300 bg-white p-4 focus:border-blue-500 focus:ring-blue-500"
                            required>
                </div>

                <div class="mt-5 grid grid-cols-2 gap-4">
                     <div>
                        <label class="font-bold text-blue-950">
                            Email Address
                        </label>

                        <input 
                            type="email" 
                            name="email"
                            value="{{ old('email_address') }}"
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
                    {{-- <div class="relative">
                        <label class="font-bold text-blue-950">
                            Password
                        </label>

                        <input id="password"
                            type="password" 
                            name="password"
                            placeholder="Enter Password"
                            class="mt-2 w-full rounded-2xl border border-slate-300 bg-white p-4 focus:border-blue-500 focus:ring-blue-500"
                            required
                        >

                        <button type="button" id="togglePassword" class="absolute right-4 top-[52px] text-slate-500 hover:text-slate-700"><img id="passwordIcon" src="{{ asset('images/eye-closed.svg') }}"></button>
                        @error('email_address')
                            <p class="mt-2 text-sm font-semibold text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div> --}}
                </div>

                <div class="mt-5 grid grid-cols-2 gap-4">
                    <div>
                        <label class="font-bold text-blue-950">
                            Role
                        </label>

                        <select id="roleSelect"
                            name="role"
                            class="mt-2 w-full rounded-2xl border border-slate-300 bg-white p-4 focus:border-blue-500 focus:ring-blue-500"
                            required
                        >
                            <option value="" disabled selected>Role</option>

                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">
                                    {{ $role->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                     <div>
                        <div id="agencyField" class="hidden">
                            <label class="font-bold text-blue-950">
                                Agency
                            </label>
                            <select
                                name="agency"
                                class="mt-2 w-full rounded-2xl border border-slate-300 bg-white p-4 focus:border-blue-500 focus:ring-blue-500"
    
                            >
                                <option value="" disabled selected>Agency</option>

                                @foreach ($agencies as $agency)
                                    <option value="{{ $agency->id }}">
                                        {{ $agency->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                        
                    </div>
                </div>



                   
                
            </div>

            
            <div class="flex justify-end gap-4 p-6">

                <button 
                    type="button"
                    onclick="closeCreateUserModal()"
                    class="rounded-2xl border border-slate-300 px-6 py-3 font-bold text-blue-950 hover:bg-slate-100"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="rounded-2xl bg-red-800 px-6 py-3 font-bold text-white hover:bg-red-900"
                >
                    Create
                </button>
            </div>
        </form>
    </div>
</div>

@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document
            .getElementById('createUserModal')
            .classList.remove('hidden');

        document
            .getElementById('createUserModal')
            .classList.add('flex');
    });
</script>
@endif

<script>
    const roleSelect = document.getElementById('roleSelect');
    const agencyField = document.getElementById('agencyField');

    roleSelect.addEventListener('change', function () {
        const selectedRole = roleSelect.options[roleSelect.selectedIndex].text;

        if (selectedRole === 'HRMO') {
            agencyField.classList.remove('hidden');

        }else {
            agencyField.classList.add('hidden');
        }
    });
</script>

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