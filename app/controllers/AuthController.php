<?php
class AuthController
{
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if ($username === 'admin' && $password === 'admin123') {
                session_regenerate_id(true);
                $_SESSION['user'] = ['username' => $username];
                header('Location: /index.php?route=dashboard');
                exit;
            }

            $_SESSION['error'] = 'Identifiants invalides';
        }

        include __DIR__ . '/../views/login.php';
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
        header('Location: /index.php?route=login');
        exit;
    }
}
