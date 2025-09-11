<?php
// src/Views/brands/index.php  
include __DIR__ . '/../layouts/header.php';
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Premium Watch Brands</h1>
        <p class="text-gray-600 text-lg max-w-2xl mx-auto">
            Discover timepieces from the world's most prestigious manufacturers.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php if ($categories && $categories->rowCount() > 0): ?>
            <?php while ($category = $categories->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="card-luxury p-8 text-center">
                    <div class="w-full h-48 bg-gray-100 rounded-lg mb-6 flex items-center justify-center p-8">
                        <img src="images/brands/<?php echo strtolower(str_replace(' ', '-', $category['name'])); ?>-logo.jpg"
                            alt="<?php echo htmlspecialchars($category['name']); ?>"
                            class="max-w-full max-h-full object-contain">
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3"><?php echo htmlspecialchars($category['name']); ?></h3>
                    <p class="text-gray-600 mb-6"><?php echo htmlspecialchars($category['description']); ?></p>
                    <a href="index.php?page=products&brand=<?php echo urlencode($category['name']); ?>"
                        class="btn-luxury-outline">View Collection</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-span-full text-center py-16">
                <p class="text-gray-500 text-lg">No brands available.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>