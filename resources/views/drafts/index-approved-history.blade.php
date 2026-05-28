<x-app-layout>
    
<section class="px-6">
    <x-back-button />
    
    <div class="rounded-[30px] bg-white p-6 shadow-gray-400 ring-1 ring-slate-100">
        
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                
                <thead class="text-left uppercase text-[#96A3BA] border-b border-slate-300">
                    <tr>
                        <th class="py-3 font-bold">File Name</th>
                        <th class="py-3 font-bold">Category</th>
                        <th class="py-3 font-bold">Status</th>
                        <th class="py-3 font-bold">Period</th>
                        <th class="py-3 font-bold">Action</th>
                    </tr>
                </thead>

                <tbody class="text-slate-700">

                    @forelse ($approved_drafts as $draft)

                        <tr class="h-14 border-b border-slate-200 hover:bg-slate-50">
                            
                            <td class="font-semibold">
                                {{ $draft->file_name }}
                            </td>

                            <td>
                                {{ $draft->mechanism->description }}
                            </td>
                            <td>
                                @if ($draft->status->id == 1)
                                <span class="rounded-full bg-yellow-200 px-3 py-1 text-[12px] font-bold text-yellow-900">
                                    To be Reviewed
                                </span>
                                @elseif ($draft->status->id == 2)
                                <span class="rounded-full bg-red-200 px-3 py-1 text-[12px] font-bold text-red-900 border-b border-slate-300">
                                    Needs Revision
                                </span>
                                @else
                                <span class="rounded-full bg-green-200 px-3 py-1 text-[12px] font-bold text-green-900 border-b border-slate-300">
                                    Approved
                                </span>
                                @endif
                            </td>

                            <td>
                                {{ $draft->period }}
                            </td>
                            <td>
                                <a class="text-blue-500  font-semibold hover:underline" href="{{ route('drafts.show', $draft->id) }}">View</a>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="3" class="py-10 text-center font-semibold text-slate-400">
                                No approved files found
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

    </div>
</section>
</x-app-layout>