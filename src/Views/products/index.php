<?php
// src/Views/products/index.php - FIXED VERSION WITH CORRECT LINKS
include __DIR__ . '/../layouts/header.php';
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-luxury-heading mb-2">Luxury Watches</h1>
        <p class="text-gray-600">
            Showing <?php echo isset($pagination) ? $pagination['total_products'] : '0'; ?> premium timepieces
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Filters Sidebar -->
        <div class="lg:col-span-1">
            <div class="card-luxury p-6 sticky top-24">
                <h3 class="font-semibold text-lg mb-4">Filters</h3>

                <!-- Search -->
                <div class="mb-6">
                    <form method="GET" action="index.php">
                        <input type="hidden" name="page" value="products">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                        <div class="flex">
                            <input type="text" name="search"
                                value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>"
                                class="input-luxury flex-1 rounded-r-none"
                                placeholder="Search watches...">
                            <button type="submit" class="btn-luxury rounded-l-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Price Range -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
                    <form method="GET" action="index.php" class="space-y-2">
                        <input type="hidden" name="page" value="products">
                        <input type="hidden" name="search" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                        <input type="hidden" name="brand" value="<?php echo htmlspecialchars($_GET['brand'] ?? ''); ?>">

                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" name="min_price" placeholder="Min"
                                value="<?php echo htmlspecialchars($_GET['min_price'] ?? ''); ?>"
                                class="input-luxury text-sm">
                            <input type="number" name="max_price" placeholder="Max"
                                value="<?php echo htmlspecialchars($_GET['max_price'] ?? ''); ?>"
                                class="input-luxury text-sm">
                        </div>
                        <button type="submit" class="btn-luxury-outline w-full text-sm">Apply</button>
                    </form>

                    <!-- Quick price filters -->
                    <div class="mt-3 space-y-1">
                        <div class="text-sm text-gray-600 mb-2">Quick filters:</div>
                        <a href="?page=products&min_price=0&max_price=5000"
                            class="block text-sm hover:text-luxury-gold <?php echo (isset($_GET['max_price']) && $_GET['max_price'] == '5000') ? 'text-luxury-gold font-semibold' : ''; ?>">
                            Under $5,000
                        </a>
                        <a href="?page=products&min_price=5000&max_price=15000"
                            class="block text-sm hover:text-luxury-gold">
                            $5,000 - $15,000
                        </a>
                        <a href="?page=products&min_price=15000&max_price=50000"
                            class="block text-sm hover:text-luxury-gold">
                            $15,000 - $50,000
                        </a>
                        <a href="?page=products&min_price=50000"
                            class="block text-sm hover:text-luxury-gold">
                            Over $50,000
                        </a>
                    </div>
                </div>

                <!-- Brand Filter -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Brand</label>
                    <div class="space-y-2">
                        <a href="?page=products"
                            class="block text-sm hover:text-luxury-gold <?php echo !isset($_GET['brand']) ? 'text-luxury-gold font-semibold' : ''; ?>">
                            All Brands
                        </a>
                        <?php
                        if (isset($categories)) {
                            $categories->execute(); // Re-execute the query
                            while ($category = $categories->fetch(PDO::FETCH_ASSOC)):
                        ?>
                                <a href="?page=products&brand=<?php echo urlencode($category['name']); ?>"
                                    class="block text-sm hover:text-luxury-gold <?php echo (isset($_GET['brand']) && $_GET['brand'] == $category['name']) ? 'text-luxury-gold font-semibold' : ''; ?>">
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </a>
                        <?php
                            endwhile;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="lg:col-span-3">
            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php if ($products && $products->rowCount() > 0): ?>
                    <?php while ($product = $products->fetch(PDO::FETCH_ASSOC)): ?>
                        <div class="card-luxury group">
                            <!-- FIXED: Make entire card clickable to product detail page -->
                            <a href="index.php?page=product&id=<?php echo $product['id']; ?>" class="block">
                                <div class="aspect-square bg-gray-100 rounded-t-lg overflow-hidden relative">
                                    <?php if (!empty($product['image_url'])): ?>
                                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>"
                                            alt="<?php echo htmlspecialchars($product['name']); ?>"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    <?php else: ?>
                                        <!-- Use slug-based image as fallback -->
                                        <img src="images/products/<?php echo htmlspecialchars($product['slug']); ?>-1.jpg"
                                            alt="<?php echo htmlspecialchars($product['name']); ?>"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                            onerror="this.onerror=null; this.src='images/placeholder.jpg';">
                                    <?php endif; ?>

                                    <!-- Badges -->
                                    <div class="absolute top-3 left-3 space-y-2">
                                        <span class="inline-block bg-luxury-gold text-white text-xs px-2 py-1 rounded">
                                            <?php echo ucfirst($product['condition_type']); ?>
                                        </span>
                                    </div>
                                </div>

                                <div class="p-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex text-yellow-400">
                                            <?php for ($i = 0; $i < 5; $i++): ?>
                                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            <?php endfor; ?>
                                            <span class="text-sm ml-1 text-gray-600">(4.8)</span>
                                        </div>
                                    </div>

                                    <h3 class="font-semibold text-lg mb-1 line-clamp-1"><?php echo htmlspecialchars($product['name']); ?></h3>
                                    <p class="text-gray-600 text-sm mb-3"><?php echo htmlspecialchars($product['brand']); ?></p>

                                    <div class="flex items-center justify-between">
                                        <span class="text-2xl font-bold text-luxury-gold">$<?php echo number_format($product['price']); ?></span>

                                        <!-- FIXED: Change button behavior -->
                                        <span class="btn-luxury text-sm px-4 py-2">
                                            View Details
                                        </span>
                                    </div>
                                </div>
                            </a>

                            <!-- Add to Cart as separate form (optional - can be removed if you want only view details) -->
                            <?php if (isLoggedIn() && $_SESSION['role'] === 'customer'): ?>
                                <div class="px-4 pb-4">
                                    <form method="POST" action="index.php?page=cart&action=add">
                                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <input type="hidden" name="redirect_to" value="products">
                                        <button type="submit" class="btn-luxury-outline w-full text-sm">
                                            Quick Add to Cart
                                        </button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-span-full text-center py-16">
                        <div class="w-24 h-24 bg-gray-100 rounded-full mx-auto mb-6 flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
                        <p class="text-gray-500 mb-6">Try adjusting your filters or search criteria</p>
                        <a href="index.php?page=products" class="btn-luxury">View All Products</a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <?php if (isset($pagination) && $pagination['total_pages'] > 1): ?>
                <div class="flex items-center justify-center mt-12 space-x-2">
                    <?php if ($pagination['current_page'] > 1): ?>
                        <a href="?page=products&pg=<?php echo $pagination['current_page'] - 1; ?>"
                            class="px-3 py-2 text-gray-600 hover:text-gray-900">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                    <?php endif; ?>

                    <?php
                    $start = max(1, $pagination['current_page'] - 2);
                    $end = min($pagination['total_pages'], $pagination['current_page'] + 2);

                    for ($i = $start; $i <= $end; $i++):
                    ?>
                        <a href="?page=products&pg=<?php echo $i; ?>"
                            class="px-4 py-2 <?php echo $i == $pagination['current_page'] ? 'bg-luxury-gold text-white' : 'text-gray-600 hover:bg-gray-100'; ?> rounded-md">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                        <a href="?page=products&pg=<?php echo $pagination['current_page'] + 1; ?>"
                            class="px-3 py-2 text-gray-600 hover:text-gray-900">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>