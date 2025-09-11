<?php
// src/Views/about/index.php
include __DIR__ . '/../layouts/header.php';
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <!-- Content -->
        <div>
            <h1 class="text-4xl font-bold text-gray-900 mb-6">About Chronos</h1>
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
                    <div class="text-4xl font-bold text-yellow-600 mb-2">50+</div>
                    <div class="text-sm text-gray-600">Years of Experience</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-yellow-600 mb-2">100k+</div>
                    <div class="text-sm text-gray-600">Happy Customers</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-yellow-600 mb-2">500+</div>
                    <div class="text-sm text-gray-600">Brands Represented</div>
                </div>
            </div>

            <a href="index.php?page=products" class="btn-luxury">Browse Collection</a>
        </div>

        <!-- Image Placeholder -->
        <div class="bg-gray-100 rounded-lg h-96 overflow-hidden">
            <img src="images/hero/about-hero.jpg"
                alt="About Chronos - Luxury Watch Heritage"
                class="w-full h-full object-cover">
        </div>
    </div>

    <!-- Our Values Section -->
    <div class="mt-20">
        <h2 class="text-3xl font-bold text-center mb-12">Our Values</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Authenticity</h3>
                <p class="text-gray-600">Every timepiece is verified and comes with certification</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Security</h3>
                <p class="text-gray-600">Secure transactions with global delivery</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Excellence</h3>
                <p class="text-gray-600">Unparalleled expertise and customer service</p>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>