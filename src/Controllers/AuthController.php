<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/User.php';      

class AuthController
{
    private $db;
    private $user;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    public function showLogin()
    {
        if (isLoggedIn()) {
            redirect('index.php');
        }
        include __DIR__ . '/../Views/auth/login.php';
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            if (empty($email) || empty($password)) {
                $_SESSION['error'] = 'Email and password are required';
                header('Location: index.php?page=auth&action=login');
                exit();
            }

            $this->user->email = $email;
            if ($this->user->readByEmail()) {
                if ($this->user->verifyPassword($password)) {
                    if ($this->user->is_active) {
                        $_SESSION['user_id'] = $this->user->id;
                        $_SESSION['email'] = $this->user->email;
                        $_SESSION['first_name'] = $this->user->first_name;
                        $_SESSION['last_name'] = $this->user->last_name;
                        $_SESSION['role'] = $this->user->role;

                        switch ($this->user->role) {
                            case ROLE_ADMIN:
                                header('Location: index.php?page=admin');
                                break;
                            case ROLE_SELLER:
                                header('Location: index.php?page=seller');
                                break;
                            default:
                                header('Location: index.php');
                        }
                        exit();
                    } else {
                        $_SESSION['error'] = 'Account is inactive';
                    }
                } else {
                    $_SESSION['error'] = 'Invalid credentials';
                }
            } else {
                $_SESSION['error'] = 'Invalid credentials';
            }
            header('Location: index.php?page=auth&action=login');
            exit();
        }
    }

    public function showRegister()
    {
        if (isLoggedIn()) {
            redirect('index.php');
        }
        include __DIR__ . '/../Views/auth/register.php';
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            $first_name = trim($_POST['first_name']);
            $last_name = trim($_POST['last_name']);
            $role = $_POST['role'] ?? 'customer';

            // Basic validation
            if (empty($email) || empty($password) || empty($first_name) || empty($last_name)) {
                $_SESSION['error'] = 'All fields are required';
                header('Location: index.php?page=auth&action=register');
                exit();
            }

            if ($password !== $confirm_password) {
                $_SESSION['error'] = 'Passwords do not match';
                header('Location: index.php?page=auth&action=register');
                exit();
            }

            // Check if email exists
            $this->user->email = $email;
            if ($this->user->emailExists()) {
                $_SESSION['error'] = 'Email already exists';
                header('Location: index.php?page=auth&action=register');
                exit();
            }

            // Create user
            $this->user->email = $email;
            $this->user->password = $password;
            $this->user->first_name = $first_name;
            $this->user->last_name = $last_name;
            $this->user->role = $role;

            if ($this->user->create()) {
                $_SESSION['success'] = 'Registration successful! Please login.';
                header('Location: index.php?page=auth&action=login');
            } else {
                $_SESSION['error'] = 'Registration failed. Please try again.';
                header('Location: index.php?page=auth&action=register');
            }
            exit();
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: index.php');
        exit();
    }
}
