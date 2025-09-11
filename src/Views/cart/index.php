<?php
// src/Views/cart/index.php - FIXED VERSION
include __DIR__ . '/../layouts/header.php';
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-luxury-heading">Shopping Cart</h1>
    </div>

    <?php if ($cart_items && $cart_items->rowCount() > 0): ?>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2 space-y-4">
                <?php
                $items = [];
                while ($item = $cart_items->fetch(PDO::FETCH_ASSOC)) {
                    $items[] = $item;
                }
                foreach ($items as $item):
                ?>
                    <div class="card-luxury p-6">
                        <div class="flex items-center space-x-4">
                            <!-- Product Image -->
                            <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <?php if (!empty($item['image_url'])): ?>
                                    <img src="<?php echo htmlspecialchars($item['image_url']); ?>"
                                        alt="<?php echo htmlspecialchars($item['name']); ?>"
                                        class="w-full h-full object-cover rounded-lg">
                                <?php else: ?>
                                    <div class="w-12 h-12 bg-gray-300 rounded-full"></div>
                                <?php endif; ?>
                            </div>

                            <!-- Product Details -->
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-lg"><?php echo htmlspecialchars($item['name']); ?></h3>
                                <p class="text-gray-600"><?php echo htmlspecialchars($item['brand']); ?>
                                    <?php if (!empty($item['model'])): ?>
                                        • <?php echo htmlspecialchars($item['model']); ?>
                                    <?php endif; ?>
                                </p>
                                <p class="text-sm text-gray-500">Certified Authentic • Free Shipping</p>
                            </div>

                            <!-- Price and Quantity -->
                            <div class="text-right">
                                <div class="text-2xl font-bold text-luxury-gold mb-2">
                                    $<?php echo number_format($item['price'], 2); ?>
                                </div>

                                <div class="flex items-center space-x-2">
                                    <form method="POST" action="index.php?page=cart&action=update" class="flex items-center">
                                        <input type="hidden" name="cart_id" value="<?php echo $item['id']; ?>">
                                        <button type="button" onclick="decrementQuantity(<?php echo $item['id']; ?>)"
                                            class="w-8 h-8 bg-gray-200 rounded-l flex items-center justify-center hover:bg-gray-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                            </svg>
                                        </button>
                                        <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>"
                                            min="1" max="10" id="quantity-<?php echo $item['id']; ?>"
                                            class="w-16 h-8 text-center border-t border-b border-gray-200 focus:outline-none">
                                        <button type="button" onclick="incrementQuantity(<?php echo $item['id']; ?>)"
                                            class="w-8 h-8 bg-gray-200 rounded-r flex items-center justify-center hover:bg-gray-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>

                                <a href="index.php?page=cart&action=remove&id=<?php echo $item['id']; ?>"
                                    class="text-red-500 hover:text-red-700 text-sm mt-2 inline-block"
                                    onclick="return confirm('Remove this item from cart?')">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Remove
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="card-luxury p-6 sticky top-24">
                    <h2 class="text-xl font-semibold mb-6">Order Summary</h2>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span class="font-semibold">$<?php echo number_format($cart_total, 2); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span>Shipping</span>
                            <span class="text-green-600 font-semibold">Free</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Tax (8%)</span>
                            <span class="font-semibold">$<?php echo number_format($cart_total * 0.08, 2); ?></span>
                        </div>
                        <div class="border-t pt-3">
                            <div class="flex justify-between text-lg font-bold">
                                <span>Total</span>
                                <span class="text-luxury-gold">$<?php echo number_format($cart_total * 1.08, 2); ?></span>
                            </div>
                        </div>
                    </div>

                    <a href="index.php?page=checkout" class="btn-luxury w-full mb-3 text-center block">
                        Proceed to Checkout
                    </a>

                    <a href="index.php?page=products" class="block text-center text-luxury-gold hover:text-luxury-darkGold">
                        Continue Shopping
                    </a>

                    <div class="mt-6 pt-6 border-t">
                        <p class="text-sm text-gray-600 flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.065-6.064A7.065 7.065 0 1119.065 5.2"></path>
                            </svg>
                            Secure checkout powered by SSL encryption
                        </p>

                        <div class="flex justify-center space-x-2 mt-3">
                            <div class="w-8 h-6 bg-gray-200 rounded flex items-center justify-center text-xs">💳</div>
                            <div class="w-8 h-6 bg-gray-200 rounded flex items-center justify-center text-xs">💳</div>
                            <div class="w-8 h-6 bg-gray-200 rounded flex items-center justify-center text-xs">💳</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <!-- Empty Cart -->
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-gray-100 rounded-full mx-auto mb-6 flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Your cart is empty</h2>
            <p class="text-gray-600 mb-8">Discover our collection of luxury timepieces and add some to your cart.</p>
            <a href="index.php?page=products" class="btn-luxury">
                Start Shopping
            </a>
        </div>
    <?php endif; ?>
</div>

<script>
    function incrementQuantity(cartId) {
        const input = document.getElementById('quantity-' + cartId);
        const currentValue = parseInt(input.value);
        if (currentValue < 10) {
            input.value = currentValue + 1;
            updateCartQuantity(cartId, input.value);
        }
    }

    function decrementQuantity(cartId) {
        const input = document.getElementById('quantity-' + cartId);
        const currentValue = parseInt(input.value);
        if (currentValue > 1) {
            input.value = currentValue - 1;
            updateCartQuantity(cartId, input.value);
        }
    }

    function updateCartQuantity(cartId, quantity) {
        const formData = new FormData();
        formData.append('cart_id', cartId);
        formData.append('quantity', quantity);

        fetch('index.php?page=cart&action=update', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                // Reload page to update totals
                window.location.reload();
            })
            .catch(error => {
                console.error('Error updating cart:', error);
            });
    }
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>