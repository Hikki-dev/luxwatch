<?php
// src/Views/admin/products/index.php
include __DIR__ . '/../../layouts/header.php';
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Manage Products</h1>
        <p class="text-gray-600">Review and approve seller product listings</p>
    </div>

    <div class="card-luxury overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seller</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if ($products && $products->rowCount() > 0): ?>
                    <?php while ($product = $products->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gray-100 rounded mr-3 overflow-hidden">
                                        <?php if (!empty($product['image_url'])): ?>
                                            <img src="<?php echo htmlspecialchars($product['image_url']); ?>"
                                                alt="<?php echo htmlspecialchars($product['alt_text'] ?? 'Product image'); ?>"
                                                class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <div class="w-full h-full bg-gray-300 rounded flex items-center justify-center">
                                                <span class="text-xs text-gray-500">No Image</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">
                                            <?php echo htmlspecialchars($product['name']); ?>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            <?php echo htmlspecialchars($product['brand']); ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo htmlspecialchars($product['first_name'] . ' ' . $product['last_name']); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                $<?php echo number_format($product['price']); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                <?php echo $product['status'] === 'approved' ? 'bg-green-100 text-green-800' : ($product['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'); ?>">
                                    <?php echo ucfirst($product['status']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <?php if ($product['status'] === 'pending'): ?>
                                    <a href="index.php?page=admin&action=approve-product&id=<?php echo $product['id']; ?>"
                                        class="text-green-600 hover:text-green-900"
                                        onclick="return confirm('Approve this product?')">Approve</a>
                                    <a href="index.php?page=admin&action=reject-product&id=<?php echo $product['id']; ?>"
                                        class="text-red-600 hover:text-red-900"
                                        onclick="return confirm('Reject this product?')">Reject</a>
                                <?php endif; ?>

                                <!-- DELETE BUTTON FOR ALL PRODUCTS -->
                                <a href="index.php?page=admin&action=delete-product&id=<?php echo $product['id']; ?>"
                                    class="text-red-600 hover:text-red-900"
                                    onclick="return confirm('Are you sure you want to permanently delete this product? This action cannot be undone.')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No products found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>