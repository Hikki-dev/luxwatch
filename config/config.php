<?php
session_start();

// Define base URL
define('BASE_URL', 'http://localhost:8888/luxwatch/public/');

// User roles
define('ROLE_ADMIN', 'admin');
define('ROLE_SELLER', 'seller');
define('ROLE_CUSTOMER', 'customer');

// Helper functions
function redirect($path)
{
    header("Location: " . BASE_URL . $path);
    exit();
}

function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function hasRole($role)
{
    return isset($_SESSION['role']) && $_SESSION['role'] === $role;
}

function requireAuth()
{
    if (!isLoggedIn()) {
        redirect('auth/login');
    }
}

function requireRole($role)
{
    requireAuth();
    if (!hasRole($role)) {
        redirect('');
    }
}
