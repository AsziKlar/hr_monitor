<x-app-layout>
    <!-- seacrhchd bar -->
    <section class="p-6">
        <div class="flex gap-4 items-center rounded-4xl bg-white p-6 shadow-gray-400 ring-1 ring-slate-100">
        <div class="flex-1 text-blue-950 gap-2 justify-between">
            <p class="text-2xl font-bold ">Agency Directory</p>
            <p class="text-1xl text-gray-400">Manage agency information, field offices, official emails, and agency heads.</p>
        </div>
        <div class="flex h-4 w-full max-w-[320px] items-center rounded-4xl bg-slate-100 p-6 shadow-gray-400 ring-1 ring-slate-200">
            <svg class="lucide lucide-search text-slate-400" viewBox="0 0 24 24" stroke="currentColor" xmlns="http://www.w3.org/2000/svg" height='24' width='24'/>
            <input class="w-full outline-none type='text' placeholder" placeholder='Search agency...'/>
        </div>
        <button class="flex items-center rounded-4xl transition hover:scale-[1.05] hover:bg-red-700 bg-red-800">
            <span class="text-1xl font-bold text-white p-3">+ Add New Agency</span>
        </button>
        </div>
    </section>


    <section class="p-6">
        <div class="grid grid-cols-1 gap-4">
            <a class="block duration-300 ease-in-out hover:-translate-y-2 flex gap-4 items-center rounded-2xl bg-white p-6 shadow-gray-400 ring-1 ring-slate-100" href="">
                <img class="h-16 w-16 rounded-2xl object-cover ring-2 ring-red-200" src="csc_logo.png">
                <div class="flex-1 ">
                <p class="text-2xl font-bold ">Agency 1</p>
                <p class="text-1xl font-bold text-red-800">Field Office: Misamis Oriental</p>
                <p class="text-1xl text-gray-600">Agency Head: <span class="text-1xl font-bold text-slate-800">Insert Name Here</span></p>
                </div>
                <div class="text-right">
                <p class="text-1xl text-gray-600">Email Address:
                </p>
                <span class="text-1xl font-bold text-slate-800">agency1@gmail.com</span>
                </div>
            </a>
        </div>
    </section>
</x-app-layout>