<div id="requestArchiveAccountModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
    <div class="w-full max-w-2xl rounded-4xl bg-white p-6 shadow-2xl">
        

        <form method="POST" action="{{ route('hrmo.self-archive') }}">
            @csrf
            @method('PATCH')


            <div class="px-8 py-4 text-center">
                <h2 class="text-2xl font-bold text-blue-950">
                    Archive your account
                </h2>

             
                    <p class="mt-4 leading-relaxed text-slate-600">
                        Are you sure you want to
                        <span class="font-bold text-red-800">
                            archive 
                        </span>
                        your account, {{ $user->name}}?
                    </p>
               
            </div>
            
            <div class="flex justify-between px-6 pb-2">
                <button 
                    type="button"
                    onclick="closeRequestArchiveAccountModal()"
                    class="rounded-2xl border border-slate-300 px-6 py-3 font-bold text-blue-950 transition hover:bg-slate-100"
                >
                    Cancel
                </button>
                <button 
                    type="submit"
                    class="rounded-2xl bg-red-800 px-6 py-3 font-bold text-white transition hover:bg-red-900"
                >
                    Archive Now
                </button>
            </div>
        </form>
        
    </div>
</div>

