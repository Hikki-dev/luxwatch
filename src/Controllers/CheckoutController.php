<?php
// src/Controllers/CheckoutController.php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Cart.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/User.php';

class CheckoutController
{
    private $db;
    private $cart;
    private $order;
    private $product;
    private $user;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->cart = new Cart($this->db);
        $this->order = new Order($this->db);
        $this->product = new Product($this->db);
        $this->user = new User($this->db);
    }

    // Show checkout page
    public function index()
    {
        requireAuth();
        
        // Only customers can checkout
        if ($_SESSION['role'] !== 'customer') {
            $_SESSION['error'] = 'Only customers can place orders';
            redirect('');
        }

        // Get cart items
        $this->cart->user_id = $_SESSION['user_id'];
        $cart_items = $this->cart->getUserCart();
        $cart_total = $this->cart->getCartTotal();

        // Check if cart is empty
        if ($cart_items->rowCount() == 0) {
            $_SESSION['error'] = 'Your cart is empty';
            redirect('cart');
        }

        // Get user information for pre-filling
        $this->user->id = $_SESSION['user_id'];
        $this->user->readById();

        // Calculate order totals
        $subtotal = $cart_total;
        $tax_rate = 0.08; // 8% tax
        $tax_amount = $subtotal * $tax_rate;
        $shipping_amount = 0; // Free shipping
        $total_amount = $subtotal + $tax_amount + $shipping_amount;

        include __DIR__ . '/../Views/checkout/index.php';
    }

    // Process checkout
    public function process()
    {
        requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('checkout');
        }

        // Validate form data
        $required_fields = [
            'billing_first_name', 'billing_last_name', 'billing_email',
            'billing_address', 'billing_city', 'billing_country', 'billing_postal',
            'shipping_first_name', 'shipping_last_name', 
            'shipping_address', 'shipping_city', 'shipping_country', 'shipping_postal',
            'payment_method'
        ];

        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                $_SESSION['error'] = 'Please fill in all required fields';
                redirect('checkout');
            }
        }

        // Start transaction
        $this->db->beginTransaction();

        try {
            // Get cart items
            $this->cart->user_id = $_SESSION['user_id'];
            $cart_items = $this->cart->getUserCart();
            $cart_total = $this->cart->getCartTotal();

            if ($cart_items->rowCount() == 0) {
                throw new Exception('Cart is empty');
            }

            // Calculate totals
            $subtotal = $cart_total;
            $tax_amount = $subtotal * 0.08;
            $shipping_amount = 0;
            $total_amount = $subtotal + $tax_amount + $shipping_amount;

            // Create billing address JSON
            $billing_address = json_encode([
                'first_name' => $_POST['billing_first_name'],
                'last_name' => $_POST['billing_last_name'],
                'email' => $_POST['billing_email'],
                'phone' => $_POST['billing_phone'] ?? '',
                'address' => $_POST['billing_address'],
                'city' => $_POST['billing_city'],
                'state' => $_POST['billing_state'] ?? '',
                'country' => $_POST['billing_country'],
                'postal_code' => $_POST['billing_postal']
            ]);

            // Create shipping address JSON
            if (isset($_POST['same_as_billing']) && $_POST['same_as_billing'] == '1') {
                $shipping_address = $billing_address;
            } else {
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

            // Create order
            $this->order->user_id = $_SESSION['user_id'];
            $this->order->subtotal = $subtotal;
            $this->order->tax_amount = $tax_amount;
            $this->order->shipping_amount = $shipping_amount;
            $this->order->total_amount = $total_amount;
            $this->order->billing_address = $billing_address;
            $this->order->shipping_address = $shipping_address;
            $this->order->payment_method = $_POST['payment_method'];
            $this->order->notes = $_POST['order_notes'] ?? '';

            if (!$this->order->create()) {
                throw new Exception('Failed to create order');
            }

            $order_id = $this->order->id;

            // Add order items
            $cart_items->execute(); // Re-execute to get fresh results
            while ($item = $cart_items->fetch(PDO::FETCH_ASSOC)) {
                // Check product availability
                $query = "SELECT stock_quantity FROM products WHERE id = :id";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':id', $item['product_id']);
                $stmt->execute();
                $product = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($product['stock_quantity'] < $item['quantity']) {
                    throw new Exception("Insufficient stock for " . $item['name']);
                }

                // Add order item
                if (!$this->order->addOrderItem($item['product_id'], $item['quantity'], $item['price'])) {
                    throw new Exception('Failed to add order item');
                }

                // Update product stock
                $new_stock = $product['stock_quantity'] - $item['quantity'];
                $update_query = "UPDATE products SET stock_quantity = :stock WHERE id = :id";
                $update_stmt = $this->db->prepare($update_query);
                $update_stmt->bindParam(':stock', $new_stock);
                $update_stmt->bindParam(':id', $item['product_id']);
                
                if (!$update_stmt->execute()) {
                    throw new Exception('Failed to update product stock');
                }
            }

            // Process payment (simulated)
            if ($_POST['payment_method'] === 'credit_card') {
                // Simulate payment processing
                // In real application, integrate with payment gateway
                $payment_successful = $this->processPayment($_POST, $total_amount);
                
                if ($payment_successful) {
                    $this->order->id = $order_id;
                    $this->order->payment_status = 'paid';
                    $this->order->status = 'confirmed';
                    $this->order->updatePaymentStatus();
                    $this->order->updateStatus();
                } else {
                    throw new Exception('Payment failed');
                }
            }

            // Clear cart
            if (!$this->cart->clearCart()) {
                throw new Exception('Failed to clear cart');
            }

            // Commit transaction
            $this->db->commit();

            // Store order number in session for success page
            $_SESSION['order_number'] = $this->order->order_number;
            $_SESSION['order_total'] = $total_amount;

            // Redirect to success page
            redirect('checkout&action=success');

        } catch (Exception $e) {
            // Rollback transaction
            $this->db->rollback();
            $_SESSION['error'] = 'Order processing failed: ' . $e->getMessage();
            redirect('checkout');
        }
    }

    // Order success page
    public function success()
    {
        requireAuth();

        if (!isset($_SESSION['order_number'])) {
            redirect('');
        }

        $order_number = $_SESSION['order_number'];
        $order_total = $_SESSION['order_total'] ?? 0;

        // Clear session variables
        unset($_SESSION['order_number']);
        unset($_SESSION['order_total']);

        include __DIR__ . '/../Views/checkout/success.php';
    }

    // Simulate payment processing
    private function processPayment($payment_data, $amount)
    {
        // Validate credit card (basic validation)
        if (empty($payment_data['card_number']) || 
            empty($payment_data['card_name']) || 
            empty($payment_data['card_expiry']) || 
            empty($payment_data['card_cvv'])) {
            return false;
        }

        // Remove spaces and validate card number length
        $card_number = str_replace(' ', '', $payment_data['card_number']);
        if (strlen($card_number) < 13 || strlen($card_number) > 19) {
            return false;
        }

        // Validate CVV
        if (strlen($payment_data['card_cvv']) < 3 || strlen($payment_data['card_cvv']) > 4) {
            return false;
        }

        return rand(1, 100) <= 95;
    }

    // Get order details for customer
    public function orderDetails($order_id)
    {
        requireAuth();

        $this->order->id = $order_id;
        if ($this->order->readById()) {
            // Check if user owns this order
            if ($this->order->user_id != $_SESSION['user_id']) {
                $_SESSION['error'] = 'Unauthorized access';
                redirect('');
            }

            $order_items = $this->order->getOrderItems();
            include __DIR__ . '/../Views/checkout/order-details.php';
        } else {
            $_SESSION['error'] = 'Order not found';
            redirect('');
        }
    }
}