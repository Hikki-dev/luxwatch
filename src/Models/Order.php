<?php
class Order {
    private $conn;
    private $table_name = "orders";

    public $id;
    public $user_id;
    public $order_number;
    public $status;
    public $subtotal;
    public $tax_amount;
    public $shipping_amount;
    public $total_amount;
    public $shipping_address;
    public $billing_address;
    public $payment_method;
    public $payment_status;
    public $notes;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create order (CRUD - Create)
    public function create() {
        $this->order_number = $this->generateOrderNumber();
        
        $query = "INSERT INTO " . $this->table_name . " 
                  SET user_id=:user_id, order_number=:order_number, 
                      subtotal=:subtotal, tax_amount=:tax_amount, 
                      shipping_amount=:shipping_amount, total_amount=:total_amount,
                      shipping_address=:shipping_address, billing_address=:billing_address,
                      payment_method=:payment_method, notes=:notes";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':order_number', $this->order_number);
        $stmt->bindParam(':subtotal', $this->subtotal);
        $stmt->bindParam(':tax_amount', $this->tax_amount);
        $stmt->bindParam(':shipping_amount', $this->shipping_amount);
        $stmt->bindParam(':total_amount', $this->total_amount);
        $stmt->bindParam(':shipping_address', $this->shipping_address);
        $stmt->bindParam(':billing_address', $this->billing_address);
        $stmt->bindParam(':payment_method', $this->payment_method);
        $stmt->bindParam(':notes', $this->notes);

        if($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }

    // Read order by ID (CRUD - Read)
    public function readById() {
        $query = "SELECT o.*, u.first_name, u.last_name, u.email 
                  FROM " . $this->table_name . " o 
                  JOIN users u ON o.user_id = u.id 
                  WHERE o.id = :id LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $this->user_id = $row['user_id'];
            $this->order_number = $row['order_number'];
            $this->status = $row['status'];
            $this->subtotal = $row['subtotal'];
            $this->tax_amount = $row['tax_amount'];
            $this->shipping_amount = $row['shipping_amount'];
            $this->total_amount = $row['total_amount'];
            $this->shipping_address = $row['shipping_address'];
            $this->billing_address = $row['billing_address'];
            $this->payment_method = $row['payment_method'];
            $this->payment_status = $row['payment_status'];
            $this->notes = $row['notes'];
            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];
            return true;
        }
        return false;
    }

    // Read order by order number
    public function readByOrderNumber() {
        $query = "SELECT o.*, u.first_name, u.last_name, u.email 
                  FROM " . $this->table_name . " o 
                  JOIN users u ON o.user_id = u.id 
                  WHERE o.order_number = :order_number LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_number', $this->order_number);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $this->id = $row['id'];
            $this->user_id = $row['user_id'];
            $this->status = $row['status'];
            $this->subtotal = $row['subtotal'];
            $this->tax_amount = $row['tax_amount'];
            $this->shipping_amount = $row['shipping_amount'];
            $this->total_amount = $row['total_amount'];
            $this->shipping_address = $row['shipping_address'];
            $this->billing_address = $row['billing_address'];
            $this->payment_method = $row['payment_method'];
            $this->payment_status = $row['payment_status'];
            $this->notes = $row['notes'];
            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];
            return true;
        }
        return false;
    }

    // Update order status (CRUD - Update)
    public function updateStatus() {
        $query = "UPDATE " . $this->table_name . " 
                  SET status = :status, updated_at = CURRENT_TIMESTAMP 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    // Update payment status
    public function updatePaymentStatus() {
        $query = "UPDATE " . $this->table_name . " 
                  SET payment_status = :payment_status, updated_at = CURRENT_TIMESTAMP 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':payment_status', $this->payment_status);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    // Get user orders (CRUD - Read)
    public function getUserOrders() {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE user_id = :user_id 
                  ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->execute();
        return $stmt;
    }

    // Get all orders (Admin) (CRUD - Read)
    public function readAll($limit = 50, $offset = 0) {
        $query = "SELECT o.*, u.first_name, u.last_name, u.email 
                  FROM " . $this->table_name . " o 
                  JOIN users u ON o.user_id = u.id 
                  ORDER BY o.created_at DESC 
                  LIMIT :limit OFFSET :offset";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // Get orders by status
    public function getOrdersByStatus($status) {
        $query = "SELECT o.*, u.first_name, u.last_name, u.email 
                  FROM " . $this->table_name . " o 
                  JOIN users u ON o.user_id = u.id 
                  WHERE o.status = :status 
                  ORDER BY o.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt;
    }

    // Get order items
    public function getOrderItems() {
        $query = "SELECT oi.*, p.name, p.brand, p.model 
                  FROM order_items oi 
                  JOIN products p ON oi.product_id = p.id 
                  WHERE oi.order_id = :order_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $this->id);
        $stmt->execute();
        return $stmt;
    }

    // Add order item
    public function addOrderItem($product_id, $quantity, $unit_price) {
        $total_price = $quantity * $unit_price;
        
        $query = "INSERT INTO order_items 
                  SET order_id=:order_id, product_id=:product_id, 
                      quantity=:quantity, unit_price=:unit_price, total_price=:total_price";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $this->id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':unit_price', $unit_price);
        $stmt->bindParam(':total_price', $total_price);

        return $stmt->execute();
    }

    // Cancel order
    public function cancel() {
        if ($this->status === 'pending' || $this->status === 'confirmed') {
            $this->status = 'cancelled';
            return $this->updateStatus();
        }
        return false;
    }

    // Generate unique order number
    private function generateOrderNumber() {
        do {
            $order_number = 'LW' . date('Y') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        } while ($this->orderNumberExists($order_number));
        
        return $order_number;
    }

    // Check if order number exists
    private function orderNumberExists($order_number) {
        $query = "SELECT id FROM " . $this->table_name . " WHERE order_number = :order_number";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_number', $order_number);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    // Get order statistics
    public function getOrderStats() {
        $stats = [];
        
        // Total orders
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $stats['total'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Pending orders
        $query = "SELECT COUNT(*) as pending FROM " . $this->table_name . " WHERE status = 'pending'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $stats['pending'] = $stmt->fetch(PDO::FETCH_ASSOC)['pending'];
        
        // Total revenue
        $query = "SELECT SUM(total_amount) as revenue FROM " . $this->table_name . " WHERE payment_status = 'paid'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $stats['revenue'] = $stmt->fetch(PDO::FETCH_ASSOC)['revenue'] ?? 0;
        
        return $stats;
    }
}
?>