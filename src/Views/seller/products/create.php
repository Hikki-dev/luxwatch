<?php
// src/Views/seller/products/create.php
include __DIR__ . '/../../layouts/header.php';
?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Add New Product</h1>
        <p class="text-gray-600">List your luxury watch for sale</p>
    </div>

    <div class="card-luxury p-8">
        <form method="POST" action="index.php?page=seller&action=products&sub=store">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold mb-4">Basic Information</h3>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                    <input type="text" name="name" required class="input-luxury"
                        placeholder="e.g., Rolex Submariner Date">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Brand *</label>
                    <input type="text" name="brand" required class="input-luxury"
                        placeholder="e.g., Rolex">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Model</label>
                    <input type="text" name="model" class="input-luxury"
                        placeholder="e.g., 126610LN">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Reference Number</label>
                    <input type="text" name="reference_number" class="input-luxury"
                        placeholder="e.g., 126610LN">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                    <select name="category_id" required class="input-luxury">
                        <option value="">Select a category</option>
                        <?php if ($categories && $categories->rowCount() > 0): ?>
                            <?php while ($category = $categories->fetch(PDO::FETCH_ASSOC)): ?>
                                <option value="<?php echo $category['id']; ?>">
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </option>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Condition *</label>
                    <select name="condition_type" required class="input-luxury">
                        <option value="">Select condition</option>
                        <option value="new">New</option>
                        <option value="pre-owned">Pre-owned</option>
                        <option value="vintage">Vintage</option>
                    </select>
                </div>

                <!-- Pricing -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold mb-4 mt-6">Pricing</h3>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Selling Price *</label>
                    <input type="number" name="price" required min="0" step="0.01" class="input-luxury"
                        placeholder="0.00">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Original Price</label>
                    <input type="number" name="original_price" min="0" step="0.01" class="input-luxury"
                        placeholder="0.00">
                </div>

                <!-- Technical Details -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold mb-4 mt-6">Technical Details</h3>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Movement Type</label>
                    <select name="movement_type" class="input-luxury">
                        <option value="">Select movement</option>
                        <option value="automatic">Automatic</option>
                        <option value="manual">Manual</option>
                        <option value="quartz">Quartz</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Case Material</label>
                    <input type="text" name="case_material" class="input-luxury"
                        placeholder="e.g., Stainless Steel">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Dial Color</label>
                    <input type="text" name="dial_color" class="input-luxury"
                        placeholder="e.g., Black">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Year Manufactured</label>
                    <input type="number" name="year_manufactured" min="1900" max="2025" class="input-luxury"
                        placeholder="2023">
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                    <textarea name="description" required rows="4" class="input-luxury"
                        placeholder="Provide detailed description of the watch condition, history, and any notable features..."></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Warranty Information</label>
                    <textarea name="warranty_info" rows="2" class="input-luxury"
                        placeholder="Details about warranty, papers, box, etc."></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Stock Quantity</label>
                    <input type="number" name="stock_quantity" min="1" value="1" class="input-luxury">
                </div>
            </div>

            <div class="flex justify-between mt-8">
                <a href="index.php?page=seller&action=products" class="btn-luxury-outline">Cancel</a>
                <button type="submit" class="btn-luxury">Add Product</button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>