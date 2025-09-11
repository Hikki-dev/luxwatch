<?php
// src/Views/auth/login.php
include __DIR__ . '/../layouts/header.php';
?>

<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-luxury font-bold text-gray-900">
                Sign in to your account
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Or
                <a href="index.php?page=auth&action=register" class="font-medium text-yellow-600 hover:text-yellow-700 transition-colors">
                    create a new account
                </a>
            </p>
        </div>

        <form class="mt-8 space-y-6" action="index.php?page=auth&action=login" method="POST">
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="email-address" class="sr-only">Email address</label>
                    <input id="email-address" name="email" type="email" autocomplete="email" required
                        class="input-luxury rounded-t-md" placeholder="Email address">
                </div>
                <div>
                    <label for="password" class="sr-only">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                        class="input-luxury rounded-b-md" placeholder="Password">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember-me" name="remember-me" type="checkbox"
                        class="h-4 w-4 text-yellow-600 focus:ring-yellow-600 border-gray-300 rounded">
                    <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                        Remember me
                    </label>
                </div>

                <div class="text-sm">
                    <a href="#" class="font-medium text-yellow-600 hover:text-yellow-700 transition-colors">
                        Forgot your password?
                    </a>
                </div>
            </div>

            <div>
                <button type="submit" class="btn-luxury w-full">
                    Sign In
                </button>
            </div>

            <!-- Test Accounts Section -->
            <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                <h3 class="text-sm font-medium text-blue-900 mb-3">Test Accounts:</h3>
                <div class="space-y-2 text-xs text-blue-800">
                    <div class="flex justify-between">
                        <span>Admin:</span>
                        <span>admin@chronos.com / password123</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Seller 1:</span>
                        <span>seller1@example.com / password123</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Seller 2:</span>
                        <span>seller2@example.com / password123</span>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>