<?php
// src/Views/checkout/success.php
include __DIR__ . '/../layouts/header.php';
?>

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center">
        <!-- Success Icon -->
        <div class="w-24 h-24 bg-green-100 rounded-full mx-auto mb-6 flex items-center justify-center">
            <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        <!-- Success Message -->
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Order Placed Successfully!</h1>

        <p class="text-gray-600 text-lg mb-8">
            Thank you for your purchase. Your order has been received and is being processed.
        </p>

        <!-- Order Details -->
        <div class="card-luxury p-8 mb-8 text-left max-w-md mx-auto">
            <h2 class="text-lg font-semibold mb-4">Order Details</h2>

            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Order Number:</span>
                    <span class="font-medium"><?php echo htmlspecialchars($order_number); ?></span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Total Amount:</span>
                    <span class="font-medium text-luxury-gold">$<?= number_format($order['total_amount'] ?? 0, 2) ?></span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Status:</span>
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                        Confirmed
                    </span>
                </div>
            </div>
        </div>

        <!-- What's Next -->
        <div class="bg-blue-50 rounded-lg p-6 mb-8 text-left max-w-md mx-auto">
            <h3 class="font-semibold mb-3">What happens next?</h3>
            <ul class="space-y-2 text-sm text-gray-600">
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    You will receive an order confirmation email shortly
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    We'll notify you when your order ships
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Estimated delivery: 3-5 business days
                </li>
            </ul>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-3 sm:space-y-0 sm:space-x-4 sm:flex sm:justify-center">
            <a href="index.php" class="btn-luxury inline-block">
                Continue Shopping
            </a>
            <a href="index.php?page=account&action=orders" class="btn-luxury-outline inline-block">
                View My Orders
            </a>
        </div>

        <!-- Customer Support -->
        <div class="mt-12 pt-8 border-t">
            <p class="text-gray-600 mb-4">
                Need help with your order? Contact our customer support
            </p>
            <div class="flex justify-center space-x-6 text-sm">
                <a href="mailto:support@chronos.com" class="text-luxury-gold hover:text-luxury-darkGold">
                    <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    support@chronos.com
                </a>
                <a href="tel:+1234567890" class="text-luxury-gold hover:text-luxury-darkGold">
                    <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    +1 (234) 567-890
                </a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>