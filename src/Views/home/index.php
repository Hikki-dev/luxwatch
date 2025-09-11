<?php
// src/Views/home/index.php
include __DIR__ . '/../layouts/header.php';
?>

<!-- Hero Section -->
<section class="relative h-screen bg-gradient-to-r from-luxury-charcoal to-gray-800 overflow-hidden">
    <div class="absolute inset-0">
        <img src="images/hero/hero-bg.jpg" alt="Luxury watches" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black opacity-40"></div>
    </div>

    <div class="relative z-10 flex items-center justify-center h-full">
        <div class="text-center text-white max-w-4xl px-4">
            <h1 class="font-luxury text-5xl md:text-7xl font-bold mb-6">
                Timeless Elegance
            </h1>
            <p class="text-xl md:text-2xl mb-8 opacity-90">
                Discover exquisite luxury timepieces crafted with precision
            </p>
            <a href="index.php?page=products" class="btn-luxury text-lg px-8 py-4 inline-block">
                Explore Collection
            </a>
        </div>
    </div>
    </div>
</section>

<!-- Featured Brands Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-luxury-heading mb-4">Premium Watch Brands</h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                Discover timepieces from the world's most prestigious manufacturers, each representing centuries of Swiss craftsmanship and innovation.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php while ($category = $categories->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="card-luxury p-6 text-center group">
                    <div class="w-full h-48 bg-gray-100 rounded-lg mb-4 flex items-center justify-center p-6">
                        <img src="images/brands/<?php echo strtolower(str_replace(' ', '-', $category['name'])); ?>-logo.jpg"
                            alt="<?php echo htmlspecialchars($category['name']); ?>"
                            class="max-w-full max-h-full object-contain">
                    </div>
                    <h3 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($category['name']); ?></h3>
                    <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($category['description']); ?></p>
                    <a href="index.php?page=products&brand=<?php echo urlencode($category['name']); ?>"
                        class="inline-flex items-center text-luxury-gold hover:text-luxury-darkGold transition-colors">
                        View Collection
                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-luxury-heading mb-4">Featured Watches</h2>
            <p class="text-gray-600 text-lg">Curated selection of exceptional timepieces</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php while ($product = $featured_products->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="card-luxury group max-w-sm">
                    <div class="aspect-square bg-gray-100 rounded-t-lg overflow-hidden">
                        <img src="images/products/<?php echo $product['slug']; ?>-1.jpg"
                            alt="<?php echo htmlspecialchars($product['name']); ?>"
                            class="w-full h-full object-cover">
                    </div>
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="inline-block bg-yellow-600 text-white text-xs px-2 py-1 rounded">
                                <?php echo ucfirst($product['condition_type']); ?>
                            </span>
                            <div class="flex text-yellow-400 text-sm">
                                <span class="mr-1">4.8</span>
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="font-semibold text-lg mb-1 truncate"><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p class="text-gray-600 text-sm mb-3"><?php echo htmlspecialchars($product['brand']); ?></p>
                        <div class="flex items-center justify-between">
                            <span class="text-xl font-bold text-yellow-600">$<?php echo number_format($product['price']); ?></span>
                            <a href="index.php?page=products&id=<?php echo $product['id']; ?>"
                                class="btn-luxury-outline text-xs px-3 py-2">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="text-center mt-8">
            <a href="index.php?page=products" class="btn-luxury-outline">View All Watches</a>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-luxury-heading mb-6">About Chronos</h2>
                <p class="text-gray-600 text-lg mb-6">
                    For over 50 years, Chronos has been the premier destination for luxury timepieces,
                    connecting discerning collectors with the world's finest watches.
                </p>
                <p class="text-gray-600 mb-8">
                    Founded in 1975 by master watchmaker Henri Dubois, our company has grown from a small
                    boutique in Geneva to a global leader in luxury watch retail. We pride ourselves on our
                    expertise, authenticity guarantee, and unparalleled customer service.
                </p>
                <div class="grid grid-cols-3 gap-8 mb-8">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-yellow-600 mb-2">50+</div>
                        <div class="text-sm text-gray-600">Years of Experience</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-yellow-600 mb-2">100k+</div>
                        <div class="text-sm text-gray-600">Happy Customers</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-yellow-600 mb-2">500+</div>
                        <div class="text-sm text-gray-600">Brands Represented</div>
                    </div>
                </div>
                <a href="index.php?page=about" class="btn-luxury-outline">Learn More</a>
            </div>
            <div class="relative">
                <img
                    src="images/hero/about-chronos.jpg"
                    alt="Chronos luxury watch workshop"
                    class="w-full h-96 object-cover rounded-lg shadow-lg"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

                <!-- Fallback if image doesn't exist -->
                <div class="bg-gray-100 rounded-lg h-96 items-center justify-center hidden">
                    <div class="text-center">
                        <div class="w-32 h-32 bg-gray-300 rounded-full mx-auto mb-4"></div>
                        <p class="text-gray-500">Image coming soon</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-16 bg-luxury-charcoal text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="font-luxury text-3xl font-bold mb-4">Our Services</h2>
            <p class="text-gray-300 text-lg">
                Beyond selling exceptional timepieces, we provide comprehensive services to ensure
                your watches maintain their beauty and precision for generations.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white bg-opacity-10 rounded-lg p-8">
                <div class="w-12 h-12 bg-yellow-600 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-4">Authentication Service</h3>
                <p class="text-gray-300 mb-4">
                    Our expert watchmakers authenticate every timepiece using advanced techniques and
                    decades of experience to guarantee authenticity.
                </p>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li>• Movement analysis</li>
                    <li>• Case and dial inspection</li>
                    <li>• Serial number verification</li>
                </ul>
            </div>

            <div class="bg-white bg-opacity-10 rounded-lg p-8">
                <div class="w-12 h-12 bg-yellow-600 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-4">Watch Servicing</h3>
                <p class="text-gray-300 mb-4">
                    Professional maintenance and repair services by certified technicians to keep your
                    timepiece in perfect condition.
                </p>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li>• Complete overhaul</li>
                    <li>• Water resistance testing</li>
                    <li>• Polishing and refinishing</li>
                </ul>
            </div>
        </div>

        <div class="text-center mt-8">
            <a href="index.php?page=services" class="btn-luxury">Learn More</a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>