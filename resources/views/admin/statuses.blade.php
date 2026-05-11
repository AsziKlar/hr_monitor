

<x-app-layout>
    <section class="p-6">

            
            <div class="flex flex-col gap-4 w-100">

                

                @foreach ($statuses as $status)
                    @php
                        $icon = '';
                        $color = '';
                        switch ($status->id) {
                            case 1:
                                $icon = 'file-search.svg';
                                $color = 'bg-amber-300';
                                break;
                            case 2:
                                $icon = 'repeat-2.svg';
                                $color = 'bg-red-300';
                                break;
                            default:
                                $icon = 'check-check.svg';
                                $color = 'bg-emerald-300';
                                break;
                        }

                    @endphp
            
                <a  class="block duration-300 ease-in-out hover:-translate-y-2 flex gap-4 items-center rounded-2xl {{ $color }} p-6 shadow-lg shadow-gray-200 hover:shadow-gray-500 ring-1 ring-slate-100" 
                    href="{{ route('admin.drafts.index', [$status, $mechanism]) }}">
                
                        <div class="flex-1 ">
                        <p class="text-2xl font-bold ">{{ $status->name }}</p>
                        <p class="text-1xl text-gray-400"></p>
                        </div>
                    <div class="{{ $color }} h-12 w-12 rounded-4xl flex items-center justify-center"><img src="{{ asset('images/' . $icon) }}"/></div>
                </a>

                @endforeach
           
            
            </div>
            
        </section>
</x-app-layout>