<?php
// src/Views/seller/products/index.php
include __DIR__ . '/../../layouts/header.php';
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">My Products</h1>
            <p class="text-gray-600">Manage your luxury watch listings</p>
        </div>
        <a href="index.php?page=seller&action=products&sub=create" class="btn-luxury">Add New Product</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if ($products && $products->rowCount() > 0): ?>
            <?php while ($product = $products->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="card-luxury">
                    <div class="aspect-square bg-gray-100 rounded-t-lg flex items-center justify-center">
                        <div class="w-24 h-24 bg-gray-300 rounded-full"></div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-semibold text-lg"><?php echo htmlspecialchars($product['name']); ?></h3>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                            <?php echo $product['status'] === 'approved' ? 'bg-green-100 text-green-800' : ($product['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'); ?>">
                                <?php echo ucfirst($product['status']); ?>
                            </span>
                        </div>
                        <p class="text-gray-600 mb-2"><?php echo htmlspecialchars($product['brand']); ?></p>
                        <p class="text-2xl font-bold text-yellow-600 mb-4">$<?php echo number_format($product['price']); ?></p>

                        <div class="flex space-x-2">
                            <a href="index.php?page=seller&action=products&sub=edit&id=<?php echo $product['id']; ?>"
                                class="btn-luxury-outline flex-1 text-center text-sm">Edit</a>
                            <a href="index.php?page=seller&action=products&sub=delete&id=<?php echo $product['id']; ?>"
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm"
                                onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-span-full text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No products yet</h3>
                <p class="text-gray-500 mb-6">Start by adding your first luxury watch listing</p>
                <a href="index.php?page=seller&action=products&sub=create" class="btn-luxury">Add Your First Product</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>