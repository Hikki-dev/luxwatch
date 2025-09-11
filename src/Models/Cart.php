<?php
// src/Models/Cart.php
class Cart {
    private $conn;
    private $table_name = "cart";

    public $id;
    public $user_id;
    public $product_id;
    public $quantity;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Add to cart (CRUD - Create)
    public function addToCart() {
        // Check if item already exists
        $check_query = "SELECT id, quantity FROM " . $this->table_name . " 
                       WHERE user_id = :user_id AND product_id = :product_id";
        $check_stmt = $this->conn->prepare($check_query);
        $check_stmt->bindParam(':user_id', $this->user_id);
        $check_stmt->bindParam(':product_id', $this->product_id);
        $check_stmt->execute();

        if($row = $check_stmt->fetch(PDO::FETCH_ASSOC)) {
            // Update quantity if item exists
            $update_query = "UPDATE " . $this->table_name . " 
                           SET quantity = quantity + :quantity 
                           WHERE id = :id";
            $update_stmt = $this->conn->prepare($update_query);
            $update_stmt->bindParam(':quantity', $this->quantity);
            $update_stmt->bindParam(':id', $row['id']);
            return $update_stmt->execute();
        } else {
            // Insert new item
            $insert_query = "INSERT INTO " . $this->table_name . " 
                           SET user_id=:user_id, product_id=:product_id, quantity=:quantity";
            $insert_stmt = $this->conn->prepare($insert_query);
            $insert_stmt->bindParam(':user_id', $this->user_id);
            $insert_stmt->bindParam(':product_id', $this->product_id);
            $insert_stmt->bindParam(':quantity', $this->quantity);
            
            if($insert_stmt->execute()) {
                $this->id = $this->conn->lastInsertId();
                return true;
            }
        }
        return false;
    }

    // Get user cart items (CRUD - Read)
    public function getUserCart() {
        $query = "SELECT c.*, p.name, p.price, p.brand, p.model, pi.image_url 
                  FROM " . $this->table_name . " c 
                  JOIN products p ON c.product_id = p.id 
                  LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
                  WHERE c.user_id = :user_id 
                  ORDER BY c.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->execute();
        return $stmt;
    }

    // Update cart quantity (CRUD - Update)
    public function updateQuantity() {
        $query = "UPDATE " . $this->table_name . " 
                  SET quantity = :quantity, updated_at = CURRENT_TIMESTAMP 
                  WHERE id = :id AND user_id = :user_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':quantity', $this->quantity);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':user_id', $this->user_id);
        return $stmt->execute();
    }

    // Remove from cart (CRUD - Delete)
    public function removeFromCart() {
        $query = "DELETE FROM " . $this->table_name . " 
                  WHERE id = :id AND user_id = :user_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':user_id', $this->user_id);
        return $stmt->execute();
    }

    // Clear user cart
    public function clearCart() {
        $query = "DELETE FROM " . $this->table_name . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        return $stmt->execute();
    }

    // Get cart total
    public function getCartTotal() {
        $query = "SELECT SUM(c.quantity * p.price) as total 
                  FROM " . $this->table_name . " c 
                  JOIN products p ON c.product_id = p.id 
                  WHERE c.user_id = :user_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }

    // Get cart item count
    public function getCartCount() {
        $query = "SELECT SUM(quantity) as count FROM " . $this->table_name . " 
                  WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] ?? 0;
    }

    // Validate cart item ownership
    public function validateCartItem() {
        $query = "SELECT id FROM " . $this->table_name . " 
                  WHERE id = :id AND user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    // Check product availability
    public function checkProductAvailability() {
        $query = "SELECT stock_quantity, is_active, status FROM products 
                  WHERE id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $this->product_id);
        $stmt->execute();
        
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($product) {
            return $product['is_active'] && 
                   $product['status'] === 'approved' && 
                   $product['stock_quantity'] >= $this->quantity;
        }
        return false;
    }
}