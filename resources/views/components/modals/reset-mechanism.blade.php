<div id="resetMechanismModal-{{ $agency->id }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
    <div class="w-full max-w-2xl rounded-4xl bg-white p-6 shadow-2xl">
        

        <form method="POST" action="{{ route('admin.settings.period_increment', [$mechanism, $agency]) }}">
            @csrf
            <div class="text-center flex-1 px-6">
                <h2 class="text-2xl font-bold text-blue-950">
                    Reset Mechanism
                </h2>

                <p class="mt-2 text-slate-600">
                    Do you want to reset the drafts for {{ $mechanism->name }} for agency 
                    <span class="font-bold text-red-800">
                        {{ $agency->name }}
                    </span>?
                </p>
            </div>
            <div class="flex justify-between">
                <button 
                    type="button"
                    onclick="closeResetMechanismModal({{ $agency->id }})"
                    class="rounded-2xl border border-slate-300 px-6 py-3 font-bold text-blue-950 transition hover:bg-slate-100"
                >
                    Cancel
                </button>
                <button 
                    type="submit"
                    class="rounded-2xl bg-red-800 px-6 py-3 font-bold text-white transition hover:bg-red-900"
                >
                    Reset
                </button>
            </div>
        </form>
        
    </div>
</div>

