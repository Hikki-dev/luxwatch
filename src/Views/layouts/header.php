<?php
// src/Views/layouts/header.php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chronos - Luxury Watch E-Commerce</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        luxury: {
                            gold: '#D4AF37',
                            darkGold: '#B8941F',
                            charcoal: '#2D3748'
                        }
                    },
                    fontFamily: {
                        'luxury': ['Playfair Display', 'serif']
                    }
                }
            }
        }
    </script>
    <style>
        .btn-luxury {
            background-color: #D4AF37;
            color: white;
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: inline-block;
            text-decoration: none;
        }

        .btn-luxury:hover {
            background-color: #B8941F;
            transform: scale(1.05);
        }

        .btn-luxury-outline {
            border: 2px solid #D4AF37;
            color: #D4AF37;
            background: transparent;
            font-weight: 600;
            padding: 10px 22px;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: inline-block;
            text-decoration: none;
        }

        .btn-luxury-outline:hover {
            background-color: #D4AF37;
            color: white;
        }

        .card-luxury {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
            transition: box-shadow 0.3s ease;
        }

        .card-luxury:hover {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.15);
        }

        .input-luxury {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .input-luxury:focus {
            outline: none;
            border-color: #D4AF37;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
        }

        .text-luxury-heading {
            font-size: 2.25rem;
            font-weight: 700;
            color: #1f2937;
            font-family: 'Playfair Display', serif;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="index.php" class="font-luxury text-2xl font-bold text-gray-800">
                        CHRONOS
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex space-x-8">
                    <a href="index.php" class="text-gray-700 hover:text-yellow-600 px-3 py-2">Home</a>
                    
                    <?php if (!isset($_SESSION['user_id']) || $_SESSION['role'] === 'customer'): ?>
                        <a href="index.php?page=brands" class="text-gray-700 hover:text-yellow-600 px-3 py-2">Brands</a>
                        <a href="index.php?page=products" class="text-gray-700 hover:text-yellow-600 px-3 py-2">Watches</a>
                        <a href="index.php?page=about" class="text-gray-700 hover:text-yellow-600 px-3 py-2">About</a>
                        <a href="index.php?page=services" class="text-gray-700 hover:text-yellow-600 px-3 py-2">Services</a>
                    <?php endif; ?>

                    <!-- Role-based navigation -->
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php if ($_SESSION['role'] === 'admin'): ?>
                            <a href="index.php?page=admin" class="text-gray-700 hover:text-yellow-600 px-3 py-2">Dashboard</a>
                            <a href="index.php?page=admin&action=users" class="text-gray-700 hover:text-yellow-600 px-3 py-2">Users</a>
                            <a href="index.php?page=admin&action=products" class="text-gray-700 hover:text-yellow-600 px-3 py-2">Products</a>
                        <?php elseif ($_SESSION['role'] === 'seller'): ?>
                            <a href="index.php?page=seller" class="text-gray-700 hover:text-yellow-600 px-3 py-2">Dashboard</a>
                            <a href="index.php?page=seller&action=products" class="text-gray-700 hover:text-yellow-600 px-3 py-2">My Products</a>
                            <a href="index.php?page=seller&action=profile" class="text-gray-700 hover:text-yellow-600 px-3 py-2">Profile</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <!-- Right side navigation -->
                <div class="flex items-center space-x-4">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php if ($_SESSION['role'] === 'customer'): ?>
                            <a href="index.php?page=cart" class="text-gray-700 hover:text-yellow-600 flex items-center">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m2.6 8L6 7m1 6v4a1 1 0 001 1h8a1 1 0 001-1v-4m-2 0L12 9l-3 4m0 0a2 2 0 102 2 2 0 00-2-2z"></path>
                                </svg>
                                Cart
                            </a>
                        <?php endif; ?>
                        
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600">Welcome, <?php echo htmlspecialchars($_SESSION['first_name']); ?></span>
                            <a href="index.php?page=auth&action=logout" class="btn-luxury-outline text-sm">Logout</a>
                        </div>
                    <?php else: ?>
                        <a href="index.php?page=auth&action=login" class="btn-luxury-outline text-sm">Sign In</a>
                        <a href="index.php?page=auth&action=register" class="btn-luxury text-sm">Register</a>
                    <?php endif; ?>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-700 hover:text-yellow-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div id="mobile-menu" class="hidden md:hidden">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t">
                    <a href="index.php" class="block px-3 py-2 text-gray-700">Home</a>
                    
                    <?php if (!isset($_SESSION['user_id']) || $_SESSION['role'] === 'customer'): ?>
                        <a href="index.php?page=brands" class="block px-3 py-2 text-gray-700">Brands</a>
                        <a href="index.php?page=products" class="block px-3 py-2 text-gray-700">Watches</a>
                        <a href="index.php?page=about" class="block px-3 py-2 text-gray-700">About</a>
                        <a href="index.php?page=services" class="block px-3 py-2 text-gray-700">Services</a>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php if ($_SESSION['role'] === 'admin'): ?>
                            <a href="index.php?page=admin" class="block px-3 py-2 text-gray-700">Dashboard</a>
                            <a href="index.php?page=admin&action=users" class="block px-3 py-2 text-gray-700">Users</a>
                            <a href="index.php?page=admin&action=products" class="block px-3 py-2 text-gray-700">Products</a>
                        <?php elseif ($_SESSION['role'] === 'seller'): ?>
                            <a href="index.php?page=seller" class="block px-3 py-2 text-gray-700">Dashboard</a>
                            <a href="index.php?page=seller&action=products" class="block px-3 py-2 text-gray-700">My Products</a>
                            <a href="index.php?page=seller&action=profile" class="block px-3 py-2 text-gray-700">Profile</a>
                        <?php elseif ($_SESSION['role'] === 'customer'): ?>
                            <a href="index.php?page=cart" class="block px-3 py-2 text-gray-700">Cart</a>
                        <?php endif; ?>
                        <a href="index.php?page=auth&action=logout" class="block px-3 py-2 text-gray-700">Logout</a>
                    <?php else: ?>
                        <a href="index.php?page=auth&action=login" class="block px-3 py-2 text-gray-700">Sign In</a>
                        <a href="index.php?page=auth&action=register" class="block px-3 py-2 text-gray-700">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Alert Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mx-4 mt-4 rounded relative">
            <span class="block sm:inline"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></span>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mx-4 mt-4 rounded relative">
            <span class="block sm:inline"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></span>
        </div>
    <?php endif; ?>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>