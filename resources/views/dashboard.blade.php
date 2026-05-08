<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>tailwind-beginner</title>
  </head>


  <body class="flex h-screen">

    <aside id="sidebar" class="fixed w-64 h-screen text-white top-0 left-0 bg-blue-950/95 px-5 py-5 rounded-r-2xl overflow-hidden transition-all duration-300 ease-in-out transition-none z-50">
      <div class="min-w-[14rem] flex h-full flex-col">
        <!-- logo and staff details  -->
        <!--<div class="mb-8 flex items-center gap-1 px-1">
          <img class="h-12 w-12 object-contain rounded-xl bg-white/5 p-1" src="csc_logo.png" alt="logo">
          
          <div>
            <h2 class="text-xl font-bold leading-tight">CSC REGION X</h2>
            <p class="text-sm text-gray-400 leading-tight">HR Mechanism Tracker</p>
          </div>
        </div>-->
        <!-- staff details  -->
        <div class="rounded-3xl bg-white/10 mt-4 px-4 py-3 shawdow-inner ring-1 ring-white/10">
          <div class="flex items-center gap-3">
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-radial-[at_25%_25%] from-red-800 to-red-900 to-75% text-sm font-bold text-white shadow-lg">
              LC
            </div>
            <div>
              <p class="text-base font-bold leading-tight">Lucian Cagata</p>
              <p class="text-xs text-white/70">CSC Admin</p>
            </div>
          </div>
        </div>

        <nav class="space-y-2 text-sm">
            <p class="text-[11px] text-white/50 mt-6">NAVIGATION</p>
            <a class="flex items-center gap-3 p-3 rounded-2xl bg-radial-[at_25%_25%] from-red-800 to-red-900 to-75% font-bold text-white shadow-lg shadow-red-900/20" href="">
              Dashboard
            </a>

            <a class="flex items-center gap-3 p-3 rounded-2xl font-bold transition hover:bg-white/10 " href="mechanisms.html">
              Mechanisms
            </a>

            <a class="flex items-center gap-3 p-3 rounded-2xl font-bold transition hover:bg-white/10 " href="agencies.html">
              Agencies Directory
            </a>

            <p class="text-[11px] text-white/50 mt-6">ADMINISTRATIVE TOOLS</p>

            <a class="flex items-center gap-3 p-3 rounded-2xl font-bold transition hover:bg-white/10 " href="accmng.html">
              Manage Account
            </a>

            <a class="flex items-center gap-3 p-3 rounded-2xl font-bold transition hover:bg-white/10 " href="announcement.html">
              Make Announcement
            </a>
        </nav>
        <div class="mt-auto pt-6">
          <a class="flex items-center gap-3 p-3 rounded-2xl text-sm font-bold transition hover:bg-white/10 " href="login.html">
            
            <form method="POST" action="{{ route('logout') }}">
              @csrf

              <button type="submit"
                  class="flex w-full items-center gap-3 rounded-2xl p-3 text-sm font-bold transition hover:bg-white/10">
                  <span>Logout</span>
              </button>
          </form>
          </a>
        </div>
      </div>
    </aside>

    <div id="overlay" class="hidden fixed inset-0 bg-black/40 z-40"></div>

    <!-- topbar and content -->
    <div class="flex-1 flex flex-col overflow-hidden w-full main-content lg:ml-64 transition-all duration-300 ease-in-out transition-none">

      <header class="sticky top-0 left-0 w-full flex items-center justify-between px-4 py-3 border-b border-slate-200/80 bg-white z-30">
          <div class="flex items-center gap-4">
            <div id='hamburger' class="flex h-9 w-9 items-center justify-center rounded-xl transition hover:bg-fuchsia-400/20 ">
              <img class="h-7 w-7 object-contain rounded-xl bg-white/5" src="images/hamburger.svg" alt="hamburger">
            </div>
              <div class="mb-0 flex items-center gap-1 px-0">
                <img class="h-12 w-12 object-contain rounded-xl bg-white/5 p-1" src="images/csc_logo.png" alt="logo">
                
                <div>
                  <h2 class="text-xl font-bold leading-tight">CSC REGION X</h2>
                  <p class="text-sm text-gray-500 leading-tight">HR Mechanism Tracker</p>
                </div>
              </div>
          </div>
          <button class="flex h-9 w-9 items-center justify-center rounded-full shadow-sm transition hover:scale-105 hover:bg-amber-400">
            <img class="h-5 w-5 object-contain rounded-xl bg-white/5" src="images/notification_bell.svg" alt="hamburger">

          </button>
      </header>

      <main class=" bg-slate-100 flex-1 overflow-y-auto">
        
        <!-- page content -->
        <section class="p-6">
          <!-- mechanism to be reviewed card -->
          <div class="text-blue-950 flex flex-row gap-2 justify-between">
            
            <div class="flex-1 rounded-4xl bg-blue-200/40 p-6 shadow-sm ring-1 ring-blue-200">
              <p class="text-2xl font-bold text-blue-600 uppercase tracking-wider">MSP</p>
              <div class="mt-2">
                <div>
                  <p class="text-4xl font-bold">10</p>
                </div>
                <div class="mt-2">
                  <p class="mt-2 inline-block rounded-full bg-yellow-200 p-2 text-xs font-bold text-yellow-700">To be Reviewed</p>
                </div>
              </div>
            </div>

            <div class="flex-1 rounded-4xl bg-fuchsia-200/40 p-6 shadow-sm ring-1 ring-fuchsia-200">
              <p class="text-2xl font-bold text-fuchsia-600 uppercase tracking-wider">SPMS</p>
              <div class="mt-2">
                <div>
                  <p class="text-4xl font-bold">10</p>
                </div>
                <div class="mt-2">
                  <p class="mt-2 inline-block rounded-full bg-yellow-200 p-2 text-xs font-bold text-yellow-700">To be Reviewed</p>
                </div>
              </div>
            </div>

            <div class="flex-1 rounded-4xl bg-amber-200/20 p-6 shadow-sm ring-1 ring-amber-200">
              <p class="text-2xl font-bold text-amber-600 uppercase tracking-wider">PRAISE</p>
              <div class="mt-2">
                <div>
                  <p class="text-4xl font-bold">10</p>
                </div>
                <div class="mt-2">
                  <p class="mt-2 inline-block rounded-full bg-yellow-200 p-2 text-xs font-bold text-yellow-700">To be Reviewed</p>
                </div>
              </div>
            </div>

            <div class="flex-1 rounded-4xl bg-purple-200/20 p-6 shadow-sm ring-1 ring-purple-200">
              <p class="text-2xl font-bold text-purple-600 uppercase tracking-wider">MSP</p>
              <div class="mt-2">
                <div>
                  <p class="text-4xl font-bold">10</p>
                </div>
                <div class="mt-2">
                  <p class="mt-2 inline-block rounded-full bg-yellow-200 p-2 text-xs font-bold text-yellow-700">To be Reviewed</p>
                </div>
              </div>
            </div>

            <div class="flex-1 rounded-4xl bg-emerald-200/20 p-6 shadow-sm ring-1 ring-emerald-200">
              <p class="text-2xl font-bold text-emerald-600 uppercase tracking-wider">GM</p>
              <div class="mt-2">
                <div>
                  <p class="text-4xl font-bold">10</p>
                </div>
                <div class="mt-2">
                  <p class="mt-2 inline-block rounded-full bg-yellow-200 p-2 text-xs font-bold text-yellow-700">To be Reviewed</p>
                </div>
              </div>
            </div>

          </div>
          <!-- statistics -->
          <div class="mt-6 grid grid-cols-2 gap-4 justify-between">
            <!-- barchart -->
            <div class="rounded-4xl bg-white p-6 shadow-gray-400 ring-1 ring-slate-100">
              <div>
                <div class="mb-4">
                  <h2 class="text-xl font-bold">Field Office Compliance</h2>
                  <p class="text-sm">Overview of mechanisms completed</p>
                </div>

                <div class="h-75">
                  <canvas id='mechanismBarChart' style="display: block; box-sizing: border-box; height: 300px; width: 481px;" width="601" height="375">
                  </canvas>
                </div>

              </div>
            </div>

            <!-- piecharts -->
            <div class="rounded-4xl grid grid-cols-3 gap-4 text-sm bg-white p-6 shadow-gray-400 ring-1 ring-slate-100">
              <div class="col-span-3">
                <h2 class="font-bold text-xl">Summary of Approved Mechanisms</h2>
                <p class="text-sm">blah blah blah idk wat cha say by jason derulo</p>
              </div>

              <div class="col-span-1">
                <div class="h-auto">
                  <canvas id='mechanismApprovedChart' style="display: block; box-sizing: border-box; height: auto; width: auto;" width="100%" height="auto">
                  </canvas>
                </div>
                <h2 class="font-bold text-center mt-4">MSP</h2>
              </div>

              <div class="col-span-1">
                <div class="mb-4">
                  <h2 class="text-xl font-bold">Approved Mechanisms</h2>
                  <p class="text-sm">Overview of mechanisms completed</p>
                </div>

                <div class="h-75">
                  <canvas id='mechanismApprovedChart' style="display: block; box-sizing: border-box; height: 300px; width: 481px;" width="601" height="375">
                  </canvas>
                </div>
              </div>

              <div class="col-span-1">
                <div class="mb-4">
                  <h2 class="text-xl font-bold">Approved Mechanisms</h2>
                  <p class="text-sm">Overview of mechanisms completed</p>
                </div>

                <div class="h-75">
                  <canvas id='mechanismApprovedChart' style="display: block; box-sizing: border-box; height: 300px; width: 481px;" width="601" height="375">
                  </canvas>
                </div>
              </div>

              <div class="col-span-1">
                <div class="mb-4">
                  <h2 class="text-xl font-bold">Approved Mechanisms</h2>
                  <p class="text-sm">Overview of mechanisms completed</p>
                </div>

                <div class="h-75">
                  <canvas id='mechanismApprovedChart' style="display: block; box-sizing: border-box; height: 300px; width: 481px;" width="601" height="375">
                  </canvas>
                </div>
              </div>
              
              <div class="col-span-1">
                <div class="mb-4">
                  <h2 class="text-xl font-bold">Approved Mechanisms</h2>
                  <p class="text-sm">Overview of mechanisms completed</p>
                </div>

                <div class="h-75">
                  <canvas id='mechanismApprovedChart' style="display: block; box-sizing: border-box; height: 300px; width: 481px;" width="601" height="375">
                  </canvas>
                </div>
              </div>
                

            </div>
          </div>


        </section>
      </main>
    </div>

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
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- charts -->
    <script>
      // bar chart
      const mechanismBarCtx = document.getElementById('mechanismBarChart').getContext('2d');
      const mechanismBarChart = new Chart(mechanismBarCtx, {
          type: 'bar',
          data: {
              labels: ['Field Office 1', 'Field Office 2', 'Field Office 3', 'Field Office 4'],
              datasets: [{
                  label: '',
                  data: [12, 19, 3, 5],
                  backgroundColor: [
                    '#3B5BDB',
                    '#E6C84F',
                    '#8B5CF6',
                    '#34B28A',
                  ], 
                  borderColor: [
                    '#3B5BDB',
                    '#E6C84F',
                    '#8B5CF6',
                    '#34B28A',
                  ],
                  borderWidth: 1,
                  borderRadius: 15
              }]
          },
          options: {
              responsive: true,
              maintainAspectRatio: false,
              plugins: {
                legend: {
                  display: false
                }
              }
          } 
      });

      const mechanismApprovedCtx = document.getElementById('mechanismApprovedChart').getContext('2d');
      const mechanismApprovedChart = new Chart(mechanismApprovedCtx, {
          type: 'doughnut',
          data: {
              labels: ['Green', 'Red'],
              datasets: [{
                  label: 'uhm idk yet',
                  data: [30,70],
                  backgroundColor: [
                    '#24bf99',
                    '#b01c1c',
                  ], 
                  borderColor: [
                    '#24bf99',
                    '#b01c1c',
                  ],
                  borderWidth: 1,
              }]
          },
          options: {
              responsive: true,
              maintainAspectRatio: false
          } 
      });

    </script>
    

    <script type="module" src="/src/main.ts"></script>


  </body>


</html>