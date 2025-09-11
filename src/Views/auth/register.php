<?php
// src/Views/auth/register.php
include __DIR__ . '/../layouts/header.php';
?>

<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-luxury font-bold text-gray-900">
                Create your account
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Or
                <a href="index.php?page=auth&action=login" class="font-medium text-yellow-600 hover:text-yellow-700 transition-colors">
                    sign in to your existing account
                </a>
            </p>
        </div>
        <form class="mt-8 space-y-6" action="index.php?page=auth&action=register" method="POST">
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="first-name" class="block text-sm font-medium text-gray-700">First Name</label>
                        <input id="first-name" name="first_name" type="text" required
                            class="input-luxury mt-1" placeholder="First Name">
                    </div>
                    <div>
                        <label for="last-name" class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input id="last-name" name="last_name" type="text" required
                            class="input-luxury mt-1" placeholder="Last Name">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input id="email" name="email" type="email" autocomplete="email" required
                        class="input-luxury mt-1" placeholder="Email address">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" autocomplete="new-password" required
                        class="input-luxury mt-1" placeholder="Password">
                </div>

                <div>
                    <label for="confirm-password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input id="confirm-password" name="confirm_password" type="password" required
                        class="input-luxury mt-1" placeholder="Confirm Password">
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">Account Type</label>
                    <select id="role" name="role" required class="input-luxury mt-1">
                        <option value="">Select account type</option>
                        <option value="customer" <?php echo (isset($_GET['role']) && $_GET['role'] == 'customer') ? 'selected' : ''; ?>>Customer</option>
                        <option value="seller" <?php echo (isset($_GET['role']) && $_GET['role'] == 'seller') ? 'selected' : ''; ?>>Seller</option>
                    </select>
                </div>
            </div>

            <div>
                <button type="submit" class="btn-luxury w-full">
                    Create Account
                </button>
            </div>

            <div class="text-center">
                <p class="text-xs text-gray-500">
                    By creating an account, you agree to our
                    <a href="#" class="text-yellow-600 hover:text-yellow-700">Terms of Service</a>
                    and
                    <a href="#" class="text-yellow-600 hover:text-yellow-700">Privacy Policy</a>
                </p>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>