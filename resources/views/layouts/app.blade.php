<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        #page-loader {
            position: fixed;
            inset: 0;
            z-index: 999999;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .loader {
            width: 50px;
            height: 50px;
            border: 5px solid #e2e8f0;
            border-top-color: #2563eb;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>

    <link rel="icon" type="image/svg+xml" href="/csc_logo.png" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HR Mechanism Tracker</title>


</head>






<body class="flex h-screen overflow-hidden">

    <div id="page-loader">
        <div class="loader"></div>
    </div>

    <x-sidebar />

    <div id="overlay" class="hidden fixed inset-0 bg-black/40 z-40"></div>

    <x-alert />

    <div class="flex-1 flex flex-col overflow-hidden w-full main-content lg:ml-64 transition-all duration-300 ease-in-out">
        <x-topbar />

        <main class="bg-slate-100 flex-1 min-h-0 overflow-y-auto">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts

    <script>
        window.addEventListener('load', function () {
            document.getElementById('page-loader').style.display = 'none';
        });

        const hamburger = document.getElementById('hamburger');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const mainContent = document.querySelector('.main-content');

        function initSidebar() {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                mainContent.classList.add('lg:ml-64');
            } else {
                sidebar.classList.add('-translate-x-full');
                mainContent.classList.remove('lg:ml-64');
            }
        }

        initSidebar();

        setTimeout(() => {
            sidebar.classList.remove('transition-none');
            mainContent.classList.remove('transition-none');
        }, 100);

        hamburger.addEventListener('click', () => {
            if (window.innerWidth >= 1024) {
                sidebar.classList.toggle('-translate-x-full');
                mainContent.classList.toggle('lg:ml-64');
            } else {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            }
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        window.addEventListener('resize', initSidebar);
    </script>

  </body>



</html>