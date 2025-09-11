<?php
// src/Views/order/success.php
include __DIR__ . '/../layouts/header.php';
?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="text-center">
        <!-- Success Icon -->
        <div class="w-20 h-20 bg-green-100 rounded-full mx-auto mb-6 flex items-center justify-center">
            <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        <h1 class="text-3xl font-bold text-gray-900 mb-4">Order Confirmed!</h1>
        <p class="text-lg text-gray-600 mb-8">Thank you for your purchase. Your order has been successfully placed.</p>

        <!-- Order Details -->
        <div class="card-luxury p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Order Details</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
                <div>
                    <span class="text-gray-600">Order Number:</span>
                    <span class="font-medium ml-2"><?php echo htmlspecialchars($order['order_number']); ?></span>
                </div>
                <div>
                    <span class="text-gray-600">Total Amount:</span>
                    <span class="font-medium ml-2 text-luxury-gold">$<?php echo number_format($order['total_amount'], 2); ?></span>
                </div>
                <div>
                    <span class="text-gray-600">Payment Status:</span>
                    <span class="font-medium ml-2 text-green-600">Paid</span>
                </div>
                <div>
                    <span class="text-gray-600">Order Status:</span>
                    <span class="font-medium ml-2">Confirmed</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="space-x-4">
            <a href="index.php?page=products" class="btn-luxury">Continue Shopping</a>
            <a href="index.php" class="btn-luxury-outline">Back to Home</a>
        </div>

        <!-- What's Next -->
        <div class="mt-12 bg-gray-50 rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">What happens next?</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div class="text-center">
                    <div class="w-12 h-12 bg-luxury-gold bg-opacity-20 rounded-full mx-auto mb-2 flex items-center justify-center">
                        <span class="text-luxury-gold font-bold">1</span>
                    </div>
                    <p class="font-medium">Order Processing</p>
                    <p class="text-gray-600">We'll prepare your luxury timepiece</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-luxury-gold bg-opacity-20 rounded-full mx-auto mb-2 flex items-center justify-center">
                        <span class="text-luxury-gold font-bold">2</span>
                    </div>
                    <p class="font-medium">Quality Check</p>
                    <p class="text-gray-600">Authentication and inspection</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-luxury-gold bg-opacity-20 rounded-full mx-auto mb-2 flex items-center justify-center">
                        <span class="text-luxury-gold font-bold">3</span>
                    </div>
                    <p class="font-medium">Secure Shipping</p>
                    <p class="text-gray-600">Insured delivery to your address</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>