<?php
// public/index.php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

// Get the page and action from URL parameters
$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

// Main routing
switch ($page) {
    case 'home':
    case '':
    default:
        showHomepage();
        break;

    case 'auth':
        handleAuth();
        break;

    case 'product':
        showProductDetail();
        break;

    case 'products':
        showProducts();
        break;

    case 'brands':
        showBrands();
        break;

    case 'about':
        showAbout();
        break;

    case 'services':
        showServices();
        break;

    case 'admin':
        showAdmin();
        break;

    case 'seller':
        showSeller();
        break;

    case 'cart':
        showCart();
        break;

    case 'checkout':
        showCheckout();
        break;

    case 'order-success':
        showOrderSuccess();
        break;
}

// Route functions
function showHomepage()
{
    $database = new Database();
    $db = $database->getConnection();

    // Limits to 4 featured products only
    $query = "SELECT p.*, c.name as category_name 
              FROM products p 
              LEFT JOIN categories c ON p.category_id = c.id 
              WHERE p.is_active = 1 AND p.status = 'approved' AND p.is_featured = 1
              ORDER BY p.created_at DESC 
              LIMIT 4";
    $featured_products = $db->prepare($query);
    $featured_products->execute();

    $query = "SELECT * FROM categories WHERE is_active = 1 ORDER BY name";
    $categories = $db->prepare($query);
    $categories->execute();

    include __DIR__ . '/../src/Views/home/index.php';
}

function showCart()
{
    // Check if user is logged in and is customer FIRST
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
        header('Location: index.php?page=auth&action=login');
        exit;
    }

    $database = new Database();
    $db = $database->getConnection();
    $action = $_GET['action'] ?? 'index';

    switch ($action) {
        case 'add':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $product_id = (int)$_POST['product_id'];
                $quantity = (int)$_POST['quantity'];
                $user_id = $_SESSION['user_id'];

                // Check if item exists in cart
                $check = $db->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
                $check->execute([$user_id, $product_id]);
                $existing = $check->fetch(PDO::FETCH_ASSOC);

                if ($existing) {
                    // Update quantity
                    $new_qty = $existing['quantity'] + $quantity;
                    $update = $db->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
                    $update->execute([$new_qty, $existing['id']]);
                } else {
                    // Add new item
                    $insert = $db->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
                    $insert->execute([$user_id, $product_id, $quantity]);
                }

                $redirect = $_POST['redirect_to'] ?? 'products';
                header("Location: index.php?page=$redirect&added=1");
                exit;
            }
            break;

        case 'update':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $cart_id = (int)$_POST['cart_id'];
                $quantity = (int)$_POST['quantity'];
                $user_id = $_SESSION['user_id'];

                if ($quantity > 0) {
                    $update = $db->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
                    $update->execute([$quantity, $cart_id, $user_id]);
                } else {
                    $delete = $db->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
                    $delete->execute([$cart_id, $user_id]);
                }

                header('Location: index.php?page=cart');
                exit;
            }
            break;

        case 'remove':
            $cart_id = (int)$_GET['id'];
            $user_id = $_SESSION['user_id'];

            $delete = $db->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
            $delete->execute([$cart_id, $user_id]);

            header('Location: index.php?page=cart');
            exit;

            // In your showCart() function default case, make sure you have:
        default:
            // Show cart
            $user_id = $_SESSION['user_id'];

            $cart_items = $db->prepare("
        SELECT 
            c.id,
            c.quantity,
            p.id as product_id,
            p.name,
            p.brand,
            p.model,
            p.price,
            pi.image_url
        FROM cart c
        JOIN products p ON c.product_id = p.id
        LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
        WHERE c.user_id = ?
        ORDER BY c.created_at DESC
    ");
            $cart_items->execute([$user_id]);

            // Calculate total
            $cart_total = 0;
            $items = [];
            while ($item = $cart_items->fetch(PDO::FETCH_ASSOC)) {
                $items[] = $item;
                $cart_total += $item['price'] * $item['quantity'];
            }

            // Re-execute the query for the view (since we consumed it above)
            $cart_items->execute([$user_id]);

            include __DIR__ . '/../src/Views/cart/index.php';
            break;
    }
}

function showCheckout()
{
    // Check if user is logged in and is customer
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
        header('Location: index.php?page=auth&action=login');
        exit;
    }

    $database = new Database();
    $db = $database->getConnection();
    $user_id = $_SESSION['user_id'];
    $action = $_GET['action'] ?? 'index';

    // Handle order processing
    if ($action === 'process' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get cart items
        $cart_stmt = $db->prepare("
            SELECT c.*, p.name, p.price, p.stock_quantity
            FROM cart c
            JOIN products p ON c.product_id = p.id
            WHERE c.user_id = ?
        ");
        $cart_stmt->execute([$user_id]);
        $cart_items = $cart_stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($cart_items)) {
            header('Location: index.php?page=cart');
            exit;
        }

        // Calculate totals
        $subtotal = 0;
        foreach ($cart_items as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $tax_amount = $subtotal * 0.08;
        $shipping_amount = 0; // Free shipping
        $total_amount = $subtotal + $tax_amount + $shipping_amount;

        // Generate order number
        $order_number = 'ORD-' . date('Ymd') . '-' . strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6));

        // Prepare addresses
        $billing_address = json_encode([
            'first_name' => $_POST['billing_first_name'],
            'last_name' => $_POST['billing_last_name'],
            'email' => $_POST['billing_email'],
            'phone' => $_POST['billing_phone'],
            'address' => $_POST['billing_address'],
            'city' => $_POST['billing_city'],
            'state' => $_POST['billing_state'] ?? '',
            'country' => $_POST['billing_country'],
            'postal_code' => $_POST['billing_postal']
        ]);

        $shipping_address = $billing_address; // Same as billing for now
        if (!isset($_POST['same_as_billing'])) {
            $shipping_address = json_encode([
                'first_name' => $_POST['shipping_first_name'],
                'last_name' => $_POST['shipping_last_name'],
                'address' => $_POST['shipping_address'],
                'city' => $_POST['shipping_city'],
                'state' => $_POST['shipping_state'] ?? '',
                'country' => $_POST['shipping_country'],
                'postal_code' => $_POST['shipping_postal']
            ]);
        }

        try {
            $db->beginTransaction();

            // Create order
            $order_stmt = $db->prepare("
                INSERT INTO orders (user_id, order_number, status, subtotal, tax_amount, shipping_amount, total_amount, 
                                  shipping_address, billing_address, payment_method, payment_status, notes) 
                VALUES (?, ?, 'confirmed', ?, ?, ?, ?, ?, ?, ?, 'paid', ?)
            ");
            $order_stmt->execute([
                $user_id,
                $order_number,
                $subtotal,
                $tax_amount,
                $shipping_amount,
                $total_amount,
                $shipping_address,
                $billing_address,
                $_POST['payment_method'],
                $_POST['order_notes'] ?? ''
            ]);

            $order_id = $db->lastInsertId();

            // Create order items
            $order_item_stmt = $db->prepare("
                INSERT INTO order_items (order_id, product_id, quantity, unit_price, total_price) 
                VALUES (?, ?, ?, ?, ?)
            ");

            foreach ($cart_items as $item) {
                $total_price = $item['price'] * $item['quantity'];
                $order_item_stmt->execute([
                    $order_id,
                    $item['product_id'],
                    $item['quantity'],
                    $item['price'],
                    $total_price
                ]);

                // Update product stock
                $stock_stmt = $db->prepare("
                    UPDATE products SET stock_quantity = stock_quantity - ? WHERE id = ?
                ");
                $stock_stmt->execute([$item['quantity'], $item['product_id']]);
            }

            // Clear cart
            $clear_cart = $db->prepare("DELETE FROM cart WHERE user_id = ?");
            $clear_cart->execute([$user_id]);

            $db->commit();

            // Redirect to success page
            header("Location: index.php?page=order-success&order_number=$order_number");
            exit;
        } catch (Exception $e) {
            $db->rollback();
            $error = "Order processing failed. Please try again.";
        }
    }

    // Show checkout form (default action)
    // Get cart items for checkout
    $cart_items_result = $db->prepare("
        SELECT 
            c.id,
            c.quantity,
            p.id as product_id,
            p.name,
            p.brand,
            p.price,
            pi.image_url
        FROM cart c
        JOIN products p ON c.product_id = p.id
        LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
        WHERE c.user_id = ?
    ");
    $cart_items_result->execute([$user_id]);

    // Check if cart is empty
    if ($cart_items_result->rowCount() === 0) {
        header('Location: index.php?page=cart');
        exit;
    }

    // Calculate totals
    $cart_total = 0;
    $items = [];
    while ($item = $cart_items_result->fetch(PDO::FETCH_ASSOC)) {
        $items[] = $item;
        $cart_total += $item['price'] * $item['quantity'];
    }

    include __DIR__ . '/../src/Views/checkout/index.php';
}

function showOrderSuccess()
{
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
        header('Location: index.php?page=auth&action=login');
        exit;
    }

    $order_number = $_GET['order_number'] ?? null;
    if (!$order_number) {
        header('Location: index.php?page=products');
        exit;
    }

    $database = new Database();
    $db = $database->getConnection();

    // Get order details
    $order_stmt = $db->prepare("
        SELECT * FROM orders 
        WHERE order_number = ? AND user_id = ?
    ");
    $order_stmt->execute([$order_number, $_SESSION['user_id']]);
    $order = $order_stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        header('Location: index.php?page=products');
        exit;
    }

    // Fixed path - removed duplicate directory structure and corrected filename
    include __DIR__ . '/../src/Views/checkout/success.php';
}


function handleAuth()
{
    require_once __DIR__ . '/../src/Controllers/AuthController.php';
    $authController = new AuthController();

    $action = $_GET['action'] ?? 'login';

    switch ($action) {
        case 'login':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $authController->login();
            } else {
                $authController->showLogin();
            }
            break;
        case 'register':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $authController->register();
            } else {
                $authController->showRegister();
            }
            break;
        case 'logout':
            $authController->logout();
            break;
    }
}

function showProducts()
{
    require_once __DIR__ . '/../src/Controllers/HomeController.php';
    $homeController = new HomeController();
    $homeController->products();
}

function showProductDetail()
{
    $id = $_GET['id'] ?? null;

    if (!$id) {
        header('Location: index.php?page=products');
        exit;
    }

    $database = new Database();
    $db = $database->getConnection();

    // Handle review submissions
    $action = $_GET['action'] ?? 'view';
    if ($action === 'add-review') {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
            header('Location: index.php?page=auth&action=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = (int)$_POST['product_id'];
            $user_id = $_SESSION['user_id'];
            $rating = (int)$_POST['rating'];
            $title = trim($_POST['title'] ?? '');
            $comment = trim($_POST['comment'] ?? '');

            // Insert review
            $insert = $db->prepare("
                INSERT INTO reviews (user_id, product_id, rating, title, comment, is_approved) 
                VALUES (?, ?, ?, ?, ?, 1)
            ");
            $insert->execute([$user_id, $product_id, $rating, $title, $comment]);

            header("Location: index.php?page=product&id=$product_id&review_added=1");
            exit;
        }
    }

    // Get product details
    $product_stmt = $db->prepare("
        SELECT 
            p.*,
            u.first_name as seller_first_name,
            u.last_name as seller_last_name
        FROM products p
        LEFT JOIN users u ON p.seller_id = u.id
        WHERE p.id = ? AND p.is_active = 1 AND p.status = 'approved'
    ");
    $product_stmt->execute([$id]);
    $product = $product_stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        header('Location: index.php?page=products');
        exit;
    }

    // Get seller information (separate array for the view)
    $seller_stmt = $db->prepare("
        SELECT first_name, last_name, created_at 
        FROM users 
        WHERE id = ?
    ");
    $seller_stmt->execute([$product['seller_id']]);
    $seller = $seller_stmt->fetch(PDO::FETCH_ASSOC);

    // Get product images (renamed to match view expectation)
    $images_stmt = $db->prepare("
        SELECT * FROM product_images 
        WHERE product_id = ? 
        ORDER BY sort_order ASC
    ");
    $images_stmt->execute([$id]);
    $images = [];
    while ($img = $images_stmt->fetch(PDO::FETCH_ASSOC)) {
        $images[] = $img;
    }

    // Get related products (same category, different products)
    $related_products = $db->prepare("
        SELECT 
            p.id, p.name, p.brand, p.price,
            pi.image_url
        FROM products p
        LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
        WHERE p.category_id = ? AND p.id != ? AND p.is_active = 1 AND p.status = 'approved'
        ORDER BY RAND()
        LIMIT 4
    ");
    $related_products->execute([$product['category_id'], $id]);

    // Get reviews
    $reviews = $db->prepare("
        SELECT 
            r.*,
            u.first_name,
            u.last_name
        FROM reviews r
        JOIN users u ON r.user_id = u.id
        WHERE r.product_id = ? AND r.is_approved = 1
        ORDER BY r.created_at DESC
    ");
    $reviews->execute([$id]);

    include __DIR__ . '/../src/Views/products/detail.php';
}

function showBrands()
{
    require_once __DIR__ . '/../src/Controllers/HomeController.php';
    $homeController = new HomeController();
    $homeController->brands();
}

function showAbout()
{
    require_once __DIR__ . '/../src/Controllers/HomeController.php';
    $homeController = new HomeController();
    $homeController->about();
}

function showServices()
{
    require_once __DIR__ . '/../src/Controllers/HomeController.php';
    $homeController = new HomeController();
    $homeController->services();
}

function showAdmin()
{
    require_once __DIR__ . '/../src/Controllers/AdminController.php';
    $adminController = new AdminController();

    $action = $_GET['action'] ?? 'dashboard';
    $id = $_GET['id'] ?? null;

    switch ($action) {
        case 'dashboard':
        default:
            $adminController->dashboard();
            break;
        case 'users':
            $adminController->users();
            break;
        case 'products':
            $adminController->products();
            break;
        case 'approve-product':
            $adminController->approveProduct($id);
            break;
        case 'reject-product':
            $adminController->rejectProduct($id);
            break;
        case 'delete-user':
            $adminController->deleteUser($id);
            break;
        case 'orders':
            $adminController->orders();
            break;
        case 'analytics':
            $adminController->analytics();
            break;
    }
}

function showSeller()
{
    require_once __DIR__ . '/../src/Controllers/SellerController.php';
    $sellerController = new SellerController();

    $action = $_GET['action'] ?? 'dashboard';
    $sub = $_GET['sub'] ?? null;
    $id = $_GET['id'] ?? null;

    switch ($action) {
        case 'dashboard':
        default:
            $sellerController->dashboard();
            break;
        case 'profile':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $sellerController->updateProfile();
            } else {
                $sellerController->profile();
            }
            break;
        case 'products':
            require_once __DIR__ . '/../src/Controllers/ProductController.php';
            $productController = new ProductController();

            switch ($sub) {
                case 'create':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $productController->store();
                    } else {
                        $productController->create();
                    }
                    break;
                case 'edit':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $productController->update($id);
                    } else {
                        $productController->edit($id);
                    }
                    break;
                case 'delete':
                    $productController->delete($id);
                    break;
                default:
                    $productController->index();
                    break;
            }
            break;
    }
}
