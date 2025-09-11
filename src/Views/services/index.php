<?php
// src/Views/services/index.php
include __DIR__ . '/../layouts/header.php';
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-16">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Our Services</h1>
        <p class="text-gray-600 text-lg max-w-3xl mx-auto">
            Beyond selling exceptional timepieces, we provide comprehensive services to ensure
            your watches maintain their beauty and precision for generations.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
        <!-- Authentication Service -->
        <div class="card-luxury p-8">
            <div class="w-16 h-16 bg-yellow-100 rounded-lg flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Authentication Service</h3>
            <p class="text-gray-600 mb-6">
                Our expert watchmakers authenticate every timepiece using advanced techniques and
                decades of experience to guarantee authenticity.
            </p>
            <ul class="space-y-3 text-gray-600 mb-6">
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Movement analysis
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Case and dial inspection
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Serial number verification
                </li>
            </ul>
            <button class="btn-luxury-outline">Learn More</button>
        </div>

        <!-- Watch Servicing -->
        <div class="card-luxury p-8">
            <div class="w-16 h-16 bg-yellow-100 rounded-lg flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Watch Servicing</h3>
            <p class="text-gray-600 mb-6">
                Professional maintenance and repair services by certified technicians to keep your
                timepiece in perfect condition.
            </p>
            <ul class="space-y-3 text-gray-600 mb-6">
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Complete overhaul
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Water resistance testing
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Polishing and refinishing
                </li>
            </ul>
            <button class="btn-luxury-outline">Learn More</button>
        </div>
    </div>

    <!-- Additional Services -->
    <div class="bg-gray-50 rounded-2xl p-8">
        <h2 class="text-3xl font-bold text-center mb-8">Additional Services</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-12 h-12 bg-yellow-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Watch Appraisal</h3>
                <p class="text-gray-600 text-sm">Professional valuation for insurance and resale</p>
            </div>
            <div class="text-center">
                <div class="w-12 h-12 bg-yellow-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Secure Storage</h3>
                <p class="text-gray-600 text-sm">Climate-controlled storage solutions</p>
            </div>
            <div class="text-center">
                <div class="w-12 h-12 bg-yellow-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Concierge Service</h3>
                <p class="text-gray-600 text-sm">Personal consultation and delivery</p>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="text-center mt-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Ready to Get Started?</h2>
        <p class="text-gray-600 text-lg mb-8">Contact us to discuss your timepiece needs</p>
        <div class="space-y-4 sm:space-y-0 sm:space-x-4 sm:flex sm:justify-center">
            <button class="btn-luxury">Schedule Consultation</button>
            <button class="btn-luxury-outline">Request Quote</button>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>