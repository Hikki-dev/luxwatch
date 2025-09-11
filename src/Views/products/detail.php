<?php
// src/Views/products/detail.php - COMPLETE VERSION
include __DIR__ . '/../layouts/header.php';
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="index.php" class="text-gray-700 hover:text-luxury-gold">Home</a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="index.php?page=products" class="ml-1 text-gray-700 hover:text-luxury-gold">Watches</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-gray-500"><?php echo htmlspecialchars($product['brand']); ?></span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Product Images Section - Left Side -->
        <div class="space-y-4">
            <!-- Main Large Image -->
            <div class="aspect-square bg-white rounded-lg overflow-hidden border border-gray-200">
                <?php if (!empty($images) && count($images) > 0): ?>
                    <img src="<?php echo htmlspecialchars($images[0]['image_url']); ?>"
                        alt="<?php echo htmlspecialchars($images[0]['alt_text'] ?? $product['name']); ?>"
                        class="w-full h-full object-contain p-8"
                        id="mainImage">
                <?php else: ?>
                    <!-- Placeholder if no image -->
                    <div class="w-full h-full flex items-center justify-center bg-gray-50">
                        <div class="text-center">
                            <svg class="w-32 h-32 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-gray-400">No image available</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Thumbnail Images -->
            <?php if (!empty($images) && count($images) > 1): ?>
                <div class="grid grid-cols-4 gap-4">
                    <?php foreach ($images as $index => $image): ?>
                        <button onclick="changeImage('<?php echo htmlspecialchars($image['image_url']); ?>')"
                            class="aspect-square bg-white rounded-lg overflow-hidden border-2 border-gray-200 hover:border-luxury-gold transition-colors">
                            <img src="<?php echo htmlspecialchars($image['image_url']); ?>"
                                alt="<?php echo htmlspecialchars($image['alt_text'] ?? 'Product thumbnail'); ?>"
                                class="w-full h-full object-contain p-2">
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Product Features -->
            <div class="bg-gray-50 rounded-lg p-6 mt-6">
                <h3 class="font-semibold text-lg mb-4">Key Features</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-luxury-gold mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm">Authentic Certified</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-luxury-gold mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm">Free Shipping</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-luxury-gold mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm">Secure Payment</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-luxury-gold mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm">14-Day Returns</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Information Section - Right Side -->
        <div>
            <!-- Status Badges -->
            <div class="flex items-center space-x-2 mb-4">
                <span class="inline-block bg-luxury-gold text-white text-xs px-3 py-1 rounded-full">
                    <?php echo ucfirst($product['condition_type']); ?>
                </span>
                <?php if ($product['is_featured']): ?>
                    <span class="inline-block bg-red-500 text-white text-xs px-3 py-1 rounded-full">Featured</span>
                <?php endif; ?>
                <?php if ($product['stock_quantity'] <= 1): ?>
                    <span class="inline-block bg-orange-500 text-white text-xs px-3 py-1 rounded-full">Limited Stock</span>
                <?php endif; ?>
            </div>

            <!-- Product Name and Brand -->
            <h1 class="text-3xl font-bold text-gray-900 mb-2"><?php echo htmlspecialchars($product['name']); ?></h1>
            <div class="flex items-center space-x-2 mb-4">
                <p class="text-xl text-gray-600"><?php echo htmlspecialchars($product['brand']); ?></p>
                <?php if (!empty($product['model'])): ?>
                    <span class="text-gray-400">•</span>
                    <p class="text-xl text-gray-600"><?php echo htmlspecialchars($product['model']); ?></p>
                <?php endif; ?>
                <?php if (!empty($product['reference_number'])): ?>
                    <span class="text-gray-400">•</span>
                    <p class="text-lg text-gray-500">Ref: <?php echo htmlspecialchars($product['reference_number']); ?></p>
                <?php endif; ?>
            </div>

            <!-- Rating -->
            <div class="flex items-center mb-6">
                <div class="flex text-yellow-400">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    <?php endfor; ?>
                </div>
                <span class="ml-2 text-gray-600">(4.8 out of 5 stars)</span>
            </div>

            <!-- Price Section -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <div class="flex items-baseline">
                    <span class="text-4xl font-bold text-luxury-gold">$<?php echo number_format($product['price'], 2); ?></span>
                    <?php if (!empty($product['original_price']) && $product['original_price'] > $product['price']): ?>
                        <span class="ml-3 text-xl text-gray-400 line-through">$<?php echo number_format($product['original_price'], 2); ?></span>
                        <span class="ml-2 bg-green-100 text-green-800 text-sm px-2 py-1 rounded">
                            Save <?php echo round((($product['original_price'] - $product['price']) / $product['original_price']) * 100); ?>%
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Description -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3">Description</h3>
                <p class="text-gray-600 leading-relaxed"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
            </div>

            <!-- Add to Cart Section -->
            <?php if (isLoggedIn() && $_SESSION['role'] === 'customer'): ?>
                <form method="POST" action="index.php?page=cart&action=add" class="mb-6">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <input type="hidden" name="redirect_to" value="product&id=<?php echo $product['id']; ?>">

                    <div class="flex items-center space-x-4 mb-6">
                        <label class="text-sm font-medium text-gray-700">Quantity:</label>
                        <div class="flex items-center border border-gray-300 rounded">
                            <button type="button" onclick="decrementQty()" class="px-3 py-2 hover:bg-gray-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                </svg>
                            </button>
                            <input type="number" name="quantity" id="quantity" value="1" min="1"
                                max="<?php echo $product['stock_quantity']; ?>"
                                class="w-16 text-center border-0 focus:ring-0">
                            <button type="button" onclick="incrementQty()" class="px-3 py-2 hover:bg-gray-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </button>
                        </div>
                        <span class="text-sm text-gray-500">
                            <?php echo $product['stock_quantity']; ?> available
                        </span>
                    </div>

                    <div class="flex space-x-4">
                        <button type="submit" class="btn-luxury flex-1">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Add to Cart
                        </button>
                        <button type="button" class="btn-luxury-outline px-6">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            <?php elseif (!isLoggedIn()): ?>
                <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-lg mb-6">
                    <p class="text-gray-700 mb-3">Please login to purchase this luxury timepiece</p>
                    <a href="index.php?page=auth&action=login" class="btn-luxury inline-block">Login to Purchase</a>
                </div>
            <?php endif; ?>

            <!-- Technical Specifications -->
            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold mb-4">Technical Specifications</h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <?php if (!empty($product['movement_type'])): ?>
                        <div class="bg-gray-50 p-3 rounded">
                            <dt class="text-sm text-gray-600 mb-1">Movement</dt>
                            <dd class="font-medium"><?php echo ucfirst($product['movement_type']); ?></dd>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($product['case_material'])): ?>
                        <div class="bg-gray-50 p-3 rounded">
                            <dt class="text-sm text-gray-600 mb-1">Case Material</dt>
                            <dd class="font-medium"><?php echo htmlspecialchars($product['case_material']); ?></dd>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($product['dial_color'])): ?>
                        <div class="bg-gray-50 p-3 rounded">
                            <dt class="text-sm text-gray-600 mb-1">Dial Color</dt>
                            <dd class="font-medium"><?php echo htmlspecialchars($product['dial_color']); ?></dd>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($product['strap_material'])): ?>
                        <div class="bg-gray-50 p-3 rounded">
                            <dt class="text-sm text-gray-600 mb-1">Strap/Bracelet</dt>
                            <dd class="font-medium"><?php echo htmlspecialchars($product['strap_material']); ?></dd>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($product['water_resistance'])): ?>
                        <div class="bg-gray-50 p-3 rounded">
                            <dt class="text-sm text-gray-600 mb-1">Water Resistance</dt>
                            <dd class="font-medium"><?php echo htmlspecialchars($product['water_resistance']); ?></dd>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($product['year_manufactured'])): ?>
                        <div class="bg-gray-50 p-3 rounded">
                            <dt class="text-sm text-gray-600 mb-1">Year</dt>
                            <dd class="font-medium"><?php echo htmlspecialchars($product['year_manufactured']); ?></dd>
                        </div>
                    <?php endif; ?>
                </dl>
            </div>

            <?php if (!empty($product['warranty_info'])): ?>
                <div class="border-t pt-6 mt-6">
                    <h3 class="text-lg font-semibold mb-4">Warranty Information</h3>
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($product['warranty_info'])); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Seller Information -->
            <div class="border-t pt-6 mt-6">
                <h3 class="text-lg font-semibold mb-4">Seller Information</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-luxury-gold rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-lg">
                                <?php echo strtoupper(substr($seller['first_name'], 0, 1) . substr($seller['last_name'], 0, 1)); ?>
                            </span>
                        </div>
                        <div>
                            <p class="font-medium"><?php echo htmlspecialchars($seller['first_name'] . ' ' . $seller['last_name']); ?></p>
                            <p class="text-sm text-gray-600">
                                <svg class="w-4 h-4 inline text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Verified Seller • Member since <?php echo date('Y', strtotime($seller['created_at'])); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products Section -->
    <?php if ($related_products && $related_products->rowCount() > 0): ?>
        <div class="mt-16">
            <h2 class="text-2xl font-bold mb-8">You May Also Like</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php while ($related = $related_products->fetch(PDO::FETCH_ASSOC)): ?>
                    <a href="index.php?page=product&id=<?php echo $related['id']; ?>" class="card-luxury group">
                        <div class="aspect-square bg-gray-100 rounded-t-lg overflow-hidden">
                            <?php if (!empty($related['image_url'])): ?>
                                <img src="<?php echo htmlspecialchars($related['image_url']); ?>"
                                    alt="<?php echo htmlspecialchars($related['name']); ?>"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center">
                                    <div class="w-20 h-20 bg-gray-300 rounded-full"></div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-lg mb-1 truncate"><?php echo htmlspecialchars($related['name']); ?></h3>
                            <p class="text-gray-600 text-sm mb-2"><?php echo htmlspecialchars($related['brand']); ?></p>
                            <div class="flex items-center justify-between">
                                <span class="text-xl font-bold text-luxury-gold">$<?php echo number_format($related['price']); ?></span>
                                <span class="text-sm text-luxury-gold hover:text-luxury-darkGold">View Details →</span>
                            </div>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    function changeImage(imageUrl) {
        document.getElementById('mainImage').src = imageUrl;
    }

    function incrementQty() {
        const qtyInput = document.getElementById('quantity');
        const max = parseInt(qtyInput.max);
        const current = parseInt(qtyInput.value);
        if (current < max) {
            qtyInput.value = current + 1;
        } else {
            alert('Maximum quantity available is ' + max);
        }
    }

    function decrementQty() {
        const qtyInput = document.getElementById('quantity');
        const current = parseInt(qtyInput.value);
        if (current > 1) {
            qtyInput.value = current - 1;
        }
    }

    // Allow manual input within limits
    document.getElementById('quantity').addEventListener('input', function(e) {
        const max = parseInt(this.max);
        const min = parseInt(this.min);
        let value = parseInt(this.value);

        if (isNaN(value) || value < min) {
            this.value = min;
        } else if (value > max) {
            this.value = max;
            alert('Maximum quantity available is ' + max);
        }
    });
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>