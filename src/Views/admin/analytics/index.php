<?php
// src/Views/admin/analytics/index.php
include __DIR__ . '/../../layouts/header.php';
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Analytics</h1>
        <p class="text-gray-600">Business insights and performance metrics</p>
    </div>

    <!-- Key Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="card-luxury p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-900">
                        $<?php
                            $total_revenue = 0;
                            if (!empty($analytics['monthly_revenue'])) {
                                foreach ($analytics['monthly_revenue'] as $month) {
                                    $total_revenue += $month['revenue'];
                                }
                            }
                            echo number_format($total_revenue);
                            ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="card-luxury p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Orders</p>
                    <p class="text-2xl font-bold text-gray-900">
                        <?php
                        $total_orders = 0;
                        if (!empty($analytics['monthly_revenue'])) {
                            foreach ($analytics['monthly_revenue'] as $month) {
                                $total_orders += $month['order_count'];
                            }
                        }
                        echo number_format($total_orders);
                        ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="card-luxury p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Avg Order Value</p>
                    <p class="text-2xl font-bold text-gray-900">
                        $<?php
                            if ($total_orders > 0) {
                                echo number_format($total_revenue / $total_orders);
                            } else {
                                echo "0";
                            }
                            ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="card-luxury p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Growth Rate</p>
                    <p class="text-2xl font-bold text-gray-900">+15%</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Monthly Revenue Chart -->
        <div class="card-luxury p-6">
            <h3 class="text-lg font-semibold mb-4">Monthly Revenue</h3>
            <?php if (!empty($analytics['monthly_revenue'])): ?>
                <div class="space-y-4">
                    <?php foreach (array_slice($analytics['monthly_revenue'], 0, 6) as $month): ?>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600"><?php echo date('M Y', strtotime($month['month'] . '-01')); ?></span>
                            <div class="flex items-center">
                                <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                                    <div class="bg-yellow-600 h-2 rounded-full" style="width: <?php echo min(100, ($month['revenue'] / 50000) * 100); ?>%"></div>
                                </div>
                                <span class="text-sm font-medium">$<?php echo number_format($month['revenue']); ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-gray-500 text-center py-8">No revenue data available yet</p>
            <?php endif; ?>
        </div>

        <!-- Top Selling Products -->
        <div class="card-luxury p-6">
            <h3 class="text-lg font-semibold mb-4">Top Selling Products</h3>
            <?php if (!empty($analytics['top_products'])): ?>
                <div class="space-y-4">
                    <?php foreach (array_slice($analytics['top_products'], 0, 5) as $index => $product): ?>
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                <span class="text-sm font-medium text-yellow-600"><?php echo $index + 1; ?></span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    <?php echo htmlspecialchars($product['name']); ?>
                                </p>
                                <p class="text-sm text-gray-500">
                                    <?php echo htmlspecialchars($product['brand']); ?>
                                </p>
                            </div>
                            <div class="text-sm font-medium text-gray-900">
                                <?php echo $product['total_sold']; ?> sold
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-gray-500 text-center py-8">No product sales data available yet</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="card-luxury p-6 text-center">
            <div class="text-3xl font-bold text-blue-600 mb-2">
                <?php
                // Calculate conversion rate (dummy data for now)
                echo "2.4%";
                ?>
            </div>
            <div class="text-sm text-gray-600">Conversion Rate</div>
        </div>

        <div class="card-luxury p-6 text-center">
            <div class="text-3xl font-bold text-green-600 mb-2">
                <?php
                // Calculate customer lifetime value (dummy data for now)
                echo "$1,250";
                ?>
            </div>
            <div class="text-sm text-gray-600">Customer LTV</div>
        </div>

        <div class="card-luxury p-6 text-center">
            <div class="text-3xl font-bold text-purple-600 mb-2">
                <?php
                // Calculate return rate (dummy data for now)
                echo "8.7%";
                ?>
            </div>
            <div class="text-sm text-gray-600">Return Rate</div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>