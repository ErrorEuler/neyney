<?php
  ob_start();
  ?>

  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>PRMSU Scheduling System - Faculty</title>
      <link rel="stylesheet" href="/css/output.css">
      <script src="https://cdn.tailwindcss.com"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
      <script>
          tailwind.config = {
              theme: {
                  extend: {
                      colors: {
                          gold: {
                              50: '#FEF9E7',
                              100: '#FCF3CF',
                              200: '#F9E79F',
                              300: '#F7DC6F',
                              400: '#F5D33F',
                              500: '#D4AF37',
                              600: '#B8860B',
                              700: '#9A7209',
                              800: '#7C5E08',
                              900: '#5E4506',
                          },
                          gray: {
                              50: '#F9FAFB',
                              100: '#F3F4F6',
                              200: '#E5E7EB',
                              300: '#D1D5DB',
                              400: '#9CA3AF',
                              500: '#6B7280',
                              600: '#4B5563',
                              700: '#374151',
                              800: '#1F2937',
                              900: '#111827',
                          }
                      },
                      fontFamily: {
                          'sans': ['Roboto', 'sans-serif'],
                          'heading': ['Poppins', 'sans-serif'],
                      },
                      boxShadow: {
                          'custom': '0 4px 6px rgba(0, 0, 0, 0.1)',
                          'hover': '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
                          'card': '0 10px 20px rgba(0, 0, 0, 0.05), 0 6px 6px rgba(0, 0, 0, 0.03)',
                      }
                  },
              },
          }
      </script>
      <style>
          @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
          @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

          body {
              font-family: 'Roboto', sans-serif;
              scroll-behavior: smooth;
          }

          h1, h2, h3, h4, h5, h6 {
              font-family: 'Poppins', sans-serif;
          }

          @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
          .fade-in { animation: fadeIn 0.5s ease forwards; }
          .sidebar { background: linear-gradient(to bottom, #1F2937, #111827); }
          .min-h-screen .grid { padding-left: 64px; }
          @media (max-width: 768px) {
              .min-h-screen .grid { padding-left: 0; }
              .sidebar-hidden { transform: translateX(-100%); }
          }
          .min-h-screen > .bg-red-100, .min-h-screen > .bg-green-100 { margin-top: 1rem; }
      </style>
  </head>
  <body class="bg-gray-100">
      <?php
      // Use relative path based on folder structure
      $sidebarPath = __DIR__ . '/../partial/faculty/sidebar.php';
      error_log("Checking sidebar path: $sidebarPath");
      if (file_exists($sidebarPath)) {
          include $sidebarPath;
      } else {
          echo "<div class='bg-red-100 border-l-4 border-red-500 text-red-700 p-4 m-4 rounded' role='alert'>
                  <p class='font-bold'>Error</p>
                  <p>Sidebar file not found at: $sidebarPath</p>
                </div>";
      }
      ?>

      <div class="ml-0 md:ml-64 p-6 min-h-screen transition-all duration-300">
          <?php if (isset($error)): ?>
              <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
                  <p class='font-bold'>Error</p>
                  <p><?php echo htmlspecialchars($error); ?></p>
              </div>
          <?php endif; ?>
          <?php if (isset($success)): ?>
              <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
                  <p class='font-bold'>Success</p>
                  <p><?php echo htmlspecialchars($success); ?></p>
              </div>
          <?php endif; ?>

          <!-- Main content -->
          <?php if (isset($content)) echo $content; else echo "No content loaded, bro!"; ?>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <script>
          const toggleSidebar = document.getElementById('toggleSidebar');
          const sidebar = document.getElementById('sidebar');

          if (toggleSidebar && sidebar) {
              toggleSidebar.addEventListener('click', () => {
                  sidebar.classList.toggle('sidebar-hidden');
                  document.querySelector('.min-h-screen').classList.toggle('md:ml-64');
              });

              document.addEventListener('click', (event) => {
                  const isSmallScreen = window.innerWidth < 640;
                  const isSidebar = sidebar.contains(event.target);
                  const isToggleButton = toggleSidebar.contains(event.target);

                  if (isSmallScreen && !isSidebar && !isToggleButton && !sidebar.classList.contains('sidebar-hidden')) {
                      sidebar.classList.add('sidebar-hidden');
                      document.querySelector('.min-h-screen').classList.add('md:ml-64');
                  }
              });
          }

          const scheduleCtx = document.getElementById('scheduleChart');
          if (scheduleCtx) {
              const scheduleChart = new Chart(scheduleCtx.getContext('2d'), {
                  type: 'doughnut',
                  data: {
                      labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                      datasets: [{
                          data: <?php echo isset($scheduleDistJson) ? $scheduleDistJson : json_encode([0, 0, 0, 0, 0, 0]); ?>,
                          backgroundColor: [
                              '#D4AF37', '#FFD700', '#4B5563', '#6B7280', '#9CA3AF', '#D1D5DB'
                          ],
                          borderWidth: 1
                      }]
                  },
                  options: {
                      responsive: true,
                      maintainAspectRatio: false,
                      plugins: {
                          legend: {
                              position: 'right',
                              labels: {
                                  font: { size: 14, family: 'Inter, sans-serif' },
                                  color: '#4B5563'
                              }
                          }
                      }
                  }
              });
          } else {
              console.error('Chart canvas not found');
          }
      </script>
  </body>
  </html>

  <?php
  ob_end_flush();
  ?>