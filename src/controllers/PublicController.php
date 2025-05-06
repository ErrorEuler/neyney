<?php
class PublicController
{
    public function showHomepage()
    {
        require_once __DIR__ . '/../views/home.php';
    }

    public function searchSchedules()
    {
        // Placeholder for schedule search
        header('Content-Type: application/json');
        echo json_encode(['schedules' => []]);
        exit;
    }
    public function logout()
    {
        // Log the logout action
        error_log("User logged out: user_id " . ($_SESSION['user_id'] ?? 'unknown'));

        // Unset all session variables
        $_SESSION = [];

        // Destroy the session
        session_destroy();

        // Redirect to the login page with a success message
        header('Location: /login?success=You have been logged out successfully');
        exit;
    }
}
