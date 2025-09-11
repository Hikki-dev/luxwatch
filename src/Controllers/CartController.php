<?php
// src/Controllers/CartController.php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Cart.php';
require_once __DIR__ . '/../models/Product.php';

class CartController
{
    private $db;
    private $cart;
    private $product;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->cart = new Cart($this->db);
        $this->product = new Product($this->db);
    }

    // Show cart
    public function index()
    {
        requireAuth();

        $this->cart->user_id = $_SESSION['user_id'];
        $cart_items = $this->cart->getUserCart();
        $cart_total = $this->cart->getCartTotal();

        include __DIR__ . '/../Views/cart/index.php';
    }

    // Add to cart
    public function add()
    {
        requireAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'] ?? null;
            $quantity = $_POST['quantity'] ?? 1;

            if (!$product_id) {
                $_SESSION['error'] = 'Invalid product';
                redirect('products');
                return;
            }

            // Validate product exists and is available
            $query = "SELECT * FROM products WHERE id = :id AND is_active = 1 AND status = 'approved'";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $product_id);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$product) {
                $_SESSION['error'] = 'Product not found or unavailable';
                redirect('products');
                return;
            }

            // Check stock availability
            if ($product['stock_quantity'] < $quantity) {
                $_SESSION['error'] = 'Insufficient stock. Only ' . $product['stock_quantity'] . ' available';
                redirect('products');
                return;
            }

            // Set cart properties
            $this->cart->user_id = $_SESSION['user_id'];
            $this->cart->product_id = $product_id;
            $this->cart->quantity = $quantity;

            // Check if product already in cart
            $check_query = "SELECT id, quantity FROM cart WHERE user_id = :user_id AND product_id = :product_id";
            $check_stmt = $this->db->prepare($check_query);
            $check_stmt->bindParam(':user_id', $_SESSION['user_id']);
            $check_stmt->bindParam(':product_id', $product_id);
            $check_stmt->execute();
            $existing_item = $check_stmt->fetch(PDO::FETCH_ASSOC);

            if ($existing_item) {
                // Update quantity if already in cart
                $new_quantity = $existing_item['quantity'] + $quantity;

                // Check if new quantity exceeds stock
                if ($new_quantity > $product['stock_quantity']) {
                    $_SESSION['error'] = 'Cannot add more. Stock limit reached';
                    redirect($_POST['redirect_to'] ?? 'cart');
                    return;
                }

                $update_query = "UPDATE cart SET quantity = :quantity, updated_at = CURRENT_TIMESTAMP WHERE id = :id";
                $update_stmt = $this->db->prepare($update_query);
                $update_stmt->bindParam(':quantity', $new_quantity);
                $update_stmt->bindParam(':id', $existing_item['id']);

                if ($update_stmt->execute()) {
                    $_SESSION['success'] = 'Cart updated successfully';
                } else {
                    $_SESSION['error'] = 'Failed to update cart';
                }
            } else {
                // Add new item to cart
                $insert_query = "INSERT INTO cart (user_id, product_id, quantity, created_at, updated_at) 
                                VALUES (:user_id, :product_id, :quantity, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
                $insert_stmt = $this->db->prepare($insert_query);
                $insert_stmt->bindParam(':user_id', $_SESSION['user_id']);
                $insert_stmt->bindParam(':product_id', $product_id);
                $insert_stmt->bindParam(':quantity', $quantity);

                if ($insert_stmt->execute()) {
                    $_SESSION['success'] = 'Product added to cart successfully';
                } else {
                    $_SESSION['error'] = 'Failed to add product to cart';
                }
            }

            // Redirect back to where user came from
            $redirect_to = $_POST['redirect_to'] ?? 'cart';
            if ($redirect_to == 'products') {
                redirect('products');
            } elseif (strpos($redirect_to, 'product&id=') !== false) {
                redirect($redirect_to);
            } else {
                redirect('cart');
            }
        }
    }

    // Update cart quantity
    public function update()
    {
        requireAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cart_id = $_POST['cart_id'] ?? null;
            $quantity = $_POST['quantity'] ?? 1;

            if (!$cart_id || $quantity < 1) {
                $_SESSION['error'] = 'Invalid request';
                redirect('cart');
                return;
            }

            // Get cart item and product info
            $query = "SELECT c.*, p.stock_quantity 
                     FROM cart c 
                     JOIN products p ON c.product_id = p.id 
                     WHERE c.id = :cart_id AND c.user_id = :user_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':cart_id', $cart_id);
            $stmt->bindParam(':user_id', $_SESSION['user_id']);
            $stmt->execute();
            $cart_item = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$cart_item) {
                $_SESSION['error'] = 'Cart item not found';
                redirect('cart');
                return;
            }

            // Check stock
            if ($quantity > $cart_item['stock_quantity']) {
                $_SESSION['error'] = 'Quantity exceeds available stock';
                redirect('cart');
                return;
            }

            // Update quantity
            $update_query = "UPDATE cart SET quantity = :quantity, updated_at = CURRENT_TIMESTAMP 
                           WHERE id = :id AND user_id = :user_id";
            $update_stmt = $this->db->prepare($update_query);
            $update_stmt->bindParam(':quantity', $quantity);
            $update_stmt->bindParam(':id', $cart_id);
            $update_stmt->bindParam(':user_id', $_SESSION['user_id']);

            if ($update_stmt->execute()) {
                $_SESSION['success'] = 'Cart updated successfully';
            } else {
                $_SESSION['error'] = 'Failed to update cart';
            }
        }

        redirect('cart');
    }

    // Remove from cart
    public function remove($cart_id)
    {
        requireAuth();

        if (!$cart_id) {
            $_SESSION['error'] = 'Invalid request';
            redirect('cart');
            return;
        }

        $query = "DELETE FROM cart WHERE id = :id AND user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $cart_id);
        $stmt->bindParam(':user_id', $_SESSION['user_id']);

        if ($stmt->execute()) {
            $_SESSION['success'] = 'Product removed from cart';
        } else {
            $_SESSION['error'] = 'Failed to remove product from cart';
        }

        redirect('cart');
    }

    // Clear cart
    public function clear()
    {
        requireAuth();

        $query = "DELETE FROM cart WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $_SESSION['user_id']);

        if ($stmt->execute()) {
            $_SESSION['success'] = 'Cart cleared successfully';
        } else {
            $_SESSION['error'] = 'Failed to clear cart';
        }

        redirect('cart');
    }

    // Get cart count for header
    public function getCartCount()
    {
        if (!isLoggedIn()) {
            echo json_encode(['count' => 0]);
            return;
        }

        $query = "SELECT SUM(quantity) as count FROM cart WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode(['count' => $result['count'] ?? 0]);
    }
}
