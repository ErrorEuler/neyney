<?php
// Ensure session is started (should already be started in index.php, but just in case)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get user's first and last names from session, with fallback values
$firstName = isset($_SESSION['first_name']) ? htmlspecialchars($_SESSION['first_name']) : 'User';
$lastName = isset($_SESSION['last_name']) ? htmlspecialchars($_SESSION['last_name']) : '';
$fullName = trim("$firstName $lastName");

// Get user's initials (first letter of first name + first letter of last name)
$initials = strtoupper(substr($firstName, 0, 1) . (isset($_SESSION['last_name']) ? substr($lastName, 0, 1) : ''));
?>

<div id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-gray-900 text-white transition-all duration-300 ease-in-out z-50 sidebar">
    <div class="p-6">
        <div class="flex items-center mb-6">
            <img src="/images/PRMSU-logo.png" alt="PRMSU Logo" class="w-12 h-12 mr-2" onerror="this.style.display='none';">
            <div>
                <h2 class="text-xl font-bold">PRMSU Scheduling System - ACSS</h2>
                <p class="text-sm text-gray-400">Faculty Portal</p>
            </div>
        </div>
        <div class="mb-6">
            <p class="text-sm font-medium"><?php echo $initials; ?></p>
            <p class="text-sm text-gray-300"><?php echo $fullName; ?> <span class="text-green-400">Faculty</span></p>
        </div>
        <nav>
            <a href="/faculty/dashboard" class="block py-2 px-4 text-gray-300 hover:bg-gray-700 rounded <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'bg-gray-700' : ''; ?>">
                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
            </a>
            <a href="/faculty/schedule" class="block py-2 px-4 text-gray-300 hover:bg-gray-700 rounded">
                <i class="fas fa-calendar-alt mr-2"></i> Schedule
            </a>
            <a href="/faculty/profile" class="block py-2 px-4 text-gray-300 hover:bg-gray-700 rounded">
                <i class="fas fa-user mr-2"></i> Profile
            </a>
            <a href="/logout" class="block py-2 px-4 text-gray-300 hover:bg-gray-700 rounded">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </a>
        </nav>
    </div>
</div>