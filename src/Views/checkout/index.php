<?php
// src/Views/checkout/index.php
include __DIR__ . '/../layouts/header.php';
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>

    <form method="POST" action="index.php?page=checkout&action=process" id="checkoutForm">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Billing & Shipping -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Billing Information -->
                <div class="card-luxury p-6">
                    <h2 class="text-xl font-semibold mb-4">Billing Information</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                            <input type="text" name="billing_first_name" required
                                value="<?php echo isset($_SESSION['first_name']) ? htmlspecialchars($_SESSION['first_name']) : ''; ?>"
                                class="input-luxury">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                            <input type="text" name="billing_last_name" required
                                value="<?php echo isset($_SESSION['last_name']) ? htmlspecialchars($_SESSION['last_name']) : ''; ?>"
                                class="input-luxury">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" name="billing_email" required
                                value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>"
                                class="input-luxury">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone *</label>
                            <input type="tel" name="billing_phone" required class="input-luxury">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                            <input type="text" name="billing_address" required class="input-luxury">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                            <input type="text" name="billing_city" required class="input-luxury">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">State/Province</label>
                            <input type="text" name="billing_state" class="input-luxury">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Country *</label>
                            <select name="billing_country" required class="input-luxury">
                                <option value="">Select Country</option>
                                <option value="US">United States</option>
                                <option value="CA">Canada</option>
                                <option value="GB">United Kingdom</option>
                                <option value="AU">Australia</option>
                                <option value="DE">Germany</option>
                                <option value="FR">France</option>
                                <option value="JP">Japan</option>
                                <option value="SG">Singapore</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Postal Code *</label>
                            <input type="text" name="billing_postal" required class="input-luxury">
                        </div>
                    </div>
                </div>

                <!-- Shipping Information -->
                <div class="card-luxury p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold">Shipping Information</h2>
                        <label class="flex items-center">
                            <input type="checkbox" name="same_as_billing" value="1"
                                id="sameAsBilling" checked
                                class="mr-2 text-luxury-gold focus:ring-luxury-gold">
                            <span class="text-sm">Same as billing</span>
                        </label>
                    </div>

                    <div id="shippingFields" class="hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                                <input type="text" name="shipping_first_name" class="input-luxury shipping-field">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                                <input type="text" name="shipping_last_name" class="input-luxury shipping-field">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                                <input type="text" name="shipping_address" class="input-luxury shipping-field">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                                <input type="text" name="shipping_city" class="input-luxury shipping-field">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">State/Province</label>
                                <input type="text" name="shipping_state" class="input-luxury">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Country *</label>
                                <select name="shipping_country" class="input-luxury shipping-field">
                                    <option value="">Select Country</option>
                                    <option value="US">United States</option>
                                    <option value="CA">Canada</option>
                                    <option value="GB">United Kingdom</option>
                                    <option value="AU">Australia</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Postal Code *</label>
                                <input type="text" name="shipping_postal" class="input-luxury shipping-field">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="card-luxury p-6">
                    <h2 class="text-xl font-semibold mb-4">Payment Method</h2>
                    <div class="space-y-3 mb-4">
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="payment_method" value="credit_card" checked
                                class="mr-3 text-luxury-gold focus:ring-luxury-gold">
                            <span>Credit/Debit Card</span>
                        </label>
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="payment_method" value="bank_transfer"
                                class="mr-3 text-luxury-gold focus:ring-luxury-gold">
                            <span>Cash On Delivery</span>
                        </label>
                    </div>

                    <!-- Credit Card Fields -->
                    <div id="creditCardFields" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Card Number *</label>
                            <input type="text" name="card_number" placeholder="1234 5678 9012 3456"
                                maxlength="19" class="input-luxury">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Name on Card *</label>
                            <input type="text" name="card_name" class="input-luxury">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Expiry Date *</label>
                                <input type="text" name="card_expiry" placeholder="MM/YY"
                                    maxlength="5" class="input-luxury">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">CVV *</label>
                                <input type="text" name="card_cvv" placeholder="123"
                                    maxlength="4" class="input-luxury">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Notes -->
                <div class="card-luxury p-6">
                    <h2 class="text-xl font-semibold mb-4">Order Notes (Optional)</h2>
                    <textarea name="order_notes" rows="3"
                        placeholder="Add any special instructions for your order..."
                        class="input-luxury"></textarea>
                </div>
            </div>

            <!-- Right Column - Order Summary -->
            <div class="lg:col-span-1">
                <div class="card-luxury p-6 sticky top-24">
                    <h2 class="text-xl font-semibold mb-4">Order Summary</h2>

                    <!-- Cart Items -->
                    <div class="space-y-3 mb-6">
                        <?php foreach ($items as $item): ?>
                            <div class="flex items-center space-x-3">
                                <div class="w-16 h-16 bg-gray-100 rounded flex-shrink-0">
                                    <?php if (!empty($item['image_url'])): ?>
                                        <img src="<?php echo htmlspecialchars($item['image_url']); ?>"
                                            alt="<?php echo htmlspecialchars($item['name']); ?>"
                                            class="w-full h-full object-cover rounded">
                                    <?php else: ?>
                                        <div class="w-full h-full bg-gray-300 rounded"></div>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium truncate">
                                        <?php echo htmlspecialchars($item['name']); ?>
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        Qty: <?php echo $item['quantity']; ?> × $<?php echo number_format($item['price']); ?>
                                    </p>
                                </div>
                                <div class="text-sm font-medium">
                                    $<?php echo number_format($item['price'] * $item['quantity']); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="border-t pt-4 space-y-2">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span class="font-medium">$<?php echo number_format($cart_total, 2); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span>Tax (8%)</span>
                            <span class="font-medium">$<?php echo number_format($cart_total * 0.08, 2); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span>Shipping</span>
                            <span class="font-medium text-green-600">FREE</span>
                        </div>
                        <div class="border-t pt-2">
                            <div class="flex justify-between text-lg font-bold">
                                <span>Total</span>
                                <span class="text-luxury-gold">$<?php echo number_format($cart_total * 1.08, 2); ?></span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-luxury w-full mt-6">
                        Place Order
                    </button>

                    <p class="text-xs text-gray-500 text-center mt-4">
                        By placing this order, you agree to our Terms of Service and Privacy Policy
                    </p>

                    <!-- Security badges -->
                    <div class="mt-4 pt-4 border-t">
                        <p class="text-sm text-gray-600 flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Secure Checkout
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Toggle shipping fields
    document.getElementById('sameAsBilling').addEventListener('change', function() {
        const shippingFields = document.getElementById('shippingFields');
        const shippingInputs = document.querySelectorAll('.shipping-field');

        if (this.checked) {
            shippingFields.classList.add('hidden');
            shippingInputs.forEach(input => input.removeAttribute('required'));
        } else {
            shippingFields.classList.remove('hidden');
            shippingInputs.forEach(input => input.setAttribute('required', 'required'));
        }
    });

    // Toggle payment fields
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const creditCardFields = document.getElementById('creditCardFields');
            const cardInputs = creditCardFields.querySelectorAll('input');

            if (this.value === 'credit_card') {
                creditCardFields.classList.remove('hidden');
                cardInputs.forEach(input => input.setAttribute('required', 'required'));
            } else {
                creditCardFields.classList.add('hidden');
                cardInputs.forEach(input => input.removeAttribute('required'));
            }
        });
    });

    // Format card number
    document.querySelector('input[name="card_number"]').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\s/g, '');
        let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
        e.target.value = formattedValue;
    });

    // Format expiry date
    document.querySelector('input[name="card_expiry"]').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.slice(0, 2) + '/' + value.slice(2, 4);
        }
        e.target.value = value;
    });

    // Only allow numbers for CVV
    document.querySelector('input[name="card_cvv"]').addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/\D/g, '');
    });
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>