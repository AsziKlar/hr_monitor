<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>tailwind-beginner</title>
  </head>
  


  <body class="flex h-screen">

    {{-- sidebar content --}}
    <x-sidebar />

    <div id="overlay" class="hidden fixed inset-0 bg-black/40 z-40"></div>

    <!-- main content with topbar at the TOP! hihi -->
    

    <div class="flex-1 flex flex-col overflow-hidden w-full main-content lg:ml-64 transition-all duration-300 ease-in-out transition-none">
        <x-topbar />
        <x-alert />

        <main class=" bg-slate-100 flex-1 overflow-y-auto">
            
            {{ $slot }}

        </main>
    </div>

    @livewireScripts

    <script> 
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

      // so no transition when page loads only in toggle icon for sidebar
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

      // Handle window resize
      window.addEventListener('resize', initSidebar);
    </script>
    
    
    
   

  </body>


</html>