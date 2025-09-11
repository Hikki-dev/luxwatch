<?php
// src/Views/seller/dashboard.php
include __DIR__ . '/../layouts/header.php';
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-luxury-heading">Seller Dashboard</h1>
        <p class="text-gray-600">Welcome back, <?php echo $_SESSION['first_name']; ?>! Manage your luxury watch listings.</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="card-luxury p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-luxury-gold bg-opacity-20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-luxury-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Products</p>
                    <p class="text-2xl font-bold text-gray-900"><?php echo $stats['total_products']; ?></p>
                </div>
            </div>
        </div>

        <div class="card-luxury p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Approved</p>
                    <p class="text-2xl font-bold text-gray-900"><?php echo $stats['approved_products']; ?></p>
                </div>
            </div>
        </div>

        <div class="card-luxury p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending</p>
                    <p class="text-2xl font-bold text-gray-900"><?php echo $stats['pending_products']; ?></p>
                </div>
            </div>
        </div>

        <div class="card-luxury p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-900">$<?php echo number_format($stats['total_revenue']); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions and Recent Products -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Quick Actions -->
        <div class="card-luxury p-6">
            <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <a href="index.php?page=seller&action=products&sub=create" class="btn-luxury w-full block text-center">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add New Product
                </a>

                <a href="index.php?page=seller&action=products" class="btn-luxury-outline w-full block text-center">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Manage Products
                </a>

                <a href="index.php?page=seller&action=profile" class="btn-luxury-outline w-full block text-center">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Update Profile
                </a>
            </div>
        </div>

        <!-- Tips for Success -->
        <div class="card-luxury p-6">
            <h3 class="text-lg font-semibold mb-4">Tips for Success</h3>
            <div class="space-y-4">
                <div class="flex items-start space-x-3">
                    <div class="w-2 h-2 bg-luxury-gold rounded-full mt-2 flex-shrink-0"></div>
                    <div>
                        <h4 class="font-medium text-sm">High-Quality Photos</h4>
                        <p class="text-xs text-gray-600">Upload clear, well-lit images from multiple angles</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3">
                    <div class="w-2 h-2 bg-luxury-gold rounded-full mt-2 flex-shrink-0"></div>
                    <div>
                        <h4 class="font-medium text-sm">Detailed Descriptions</h4>
                        <p class="text-xs text-gray-600">Include condition, specifications, and history</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3">
                    <div class="w-2 h-2 bg-luxury-gold rounded-full mt-2 flex-shrink-0"></div>
                    <div>
                        <h4 class="font-medium text-sm">Competitive Pricing</h4>
                        <p class="text-xs text-gray-600">Research market values for similar timepieces</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3">
                    <div class="w-2 h-2 bg-luxury-gold rounded-full mt-2 flex-shrink-0"></div>
                    <div>
                        <h4 class="font-medium text-sm">Authentication Documents</h4>
                        <p class="text-xs text-gray-600">Provide certificates and warranty information</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>