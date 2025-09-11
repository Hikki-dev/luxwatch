<?php include '../src/Views/layouts/footer.php'; ?>

<?php
// src/Views/errors/404.php
include '../src/Views/layouts/header.php';
?>

<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full text-center">
        <div class="mb-8">
            <div class="text-6xl font-bold text-luxury-gold mb-4">404</div>
            <h1 class="text-2xl font-semibold text-gray-900 mb-4">Page Not Found</h1>
            <p class="text-gray-600 mb-8">
                The page you're looking for doesn't exist or has been moved.
            </p>
        </div>

        <div class="space-y-4">
            <a href="<?php echo BASE_URL; ?>" class="btn-luxury w-full">
                Return Home
            </a>
            <a href="<?php echo BASE_URL; ?>products" class="btn-luxury-outline w-full">
                Browse Watches
            </a>
        </div>
    </div>
</div>

<?php include '../src/Views/layouts/footer.php'; ?>