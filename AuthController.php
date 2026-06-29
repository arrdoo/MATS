<?php
class AuthController
{
    public function login(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            $isValid = false;
            if ($username !== '' && $password !== '') {
                $normalizedUsername = strtolower($username);
                $normalizedPassword = strtolower($password);

                $isValid = ($normalizedUsername === 'admin' && $normalizedPassword === 'admin123')
                    || ($normalizedUsername === 'admin' && $password === 'admin123');
            }

            if ($isValid) {
                session_regenerate_id(true);
                $_SESSION['user'] = ['username' => 'admin', 'role' => 'admin'];
                header('Location: /index.php?action=dashboard');
                exit;
            }

            $_SESSION['error'] = 'Identifiants invalides';
        }

        require __DIR__ . '/../views/login.php';
    }

    public function logout(): void
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: /index.php?action=login');
        exit;
    }

    public function requireAuth(): void
    {
        session_start();
        if (empty($_SESSION['user'])) {
            header('Location: /index.php?action=login');
            exit;
        }
    }
}
