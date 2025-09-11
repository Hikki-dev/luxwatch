<?php
// src/Views/seller/profile.php
include __DIR__ . '/../layouts/header.php';
?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Seller Profile</h1>
        <p class="text-gray-600">Manage your account information</p>
    </div>

    <div class="card-luxury p-8">
        <form method="POST" action="index.php?page=seller&action=profile">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                    <input type="text" name="first_name" required class="input-luxury"
                        value="<?php echo htmlspecialchars($_SESSION['first_name'] ?? ''); ?>">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                    <input type="text" name="last_name" required class="input-luxury"
                        value="<?php echo htmlspecialchars($_SESSION['last_name'] ?? ''); ?>">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" class="input-luxury bg-gray-50"
                        value="<?php echo htmlspecialchars($_SESSION['email'] ?? ''); ?>" disabled>
                    <p class="text-sm text-gray-500 mt-1">Email cannot be changed</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                    <input type="tel" name="phone" class="input-luxury"
                        value="">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">City</label>
                    <input type="text" name="city" class="input-luxury"
                        value="">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                    <textarea name="address" rows="3" class="input-luxury"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                    <input type="text" name="country" class="input-luxury"
                        value="">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Postal Code</label>
                    <input type="text" name="postal_code" class="input-luxury"
                        value="">
                </div>
            </div>

            <div class="flex justify-between mt-8">
                <a href="index.php?page=seller" class="btn-luxury-outline">Cancel</a>
                <button type="submit" class="btn-luxury">Update Profile</button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>