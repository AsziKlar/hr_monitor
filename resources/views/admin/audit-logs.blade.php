<x-app-layout>
    

    
     <section class="px-6 mb-5">
        <x-back-button />
        
          <div class="flex items-center justify-between rounded-4xl bg-white p-6 shadow-gray-400 ring-1 ring-slate-100">
              <div class="text-blue-950">
                  <p class="text-2xl font-bold">
                      Audit Logs
                  </p>

              </div>
    
          </div>
    </section>
    
    <section class="px-6">
    
    <div class="rounded-[30px] bg-white p-6 shadow-gray-400 ring-1 ring-slate-100">
        
        <div class="overflow-x-auto overflow-y-auto max-h-[500px]">
            <table class="w-full border-collapse">
                
                <thead class="sticky top-0 bg-white text-left uppercase text-[#96A3BA] border-b border-slate-300">
                    <tr>
                        <th class="py-3 font-bold">Name</th>
                        <th class="py-3 font-bold">Action</th>
                        <th class="py-3 font-bold">Date</th>
                    </tr>
                </thead>

                <tbody class="text-slate-700">

                    @forelse ($auditLogs as $log)

                        <tr class="h-14 border-b border-slate-200 hover:bg-slate-50">
                            
                            <td class="font-semibold">
                                {{ $log->user->name}}
                            </td>

                            <td>
                                {{ $log->action}}
                            </td>
                            <td>
                                {{ $log->updated_at }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="3" class="py-10 text-center font-semibold text-slate-400">
                               No logs found
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

    </div>
</section>
</x-app-layout>