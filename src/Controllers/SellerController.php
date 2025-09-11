<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Order.php';

class SellerController
{
    private $db;
    private $user;
    private $product;
    private $order;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
        $this->product = new Product($this->db);
        $this->order = new Order($this->db);
    }

    // Seller dashboard
    public function dashboard()
    {
        requireRole(ROLE_SELLER);

        // Get seller statistics
        $stats = $this->getDashboardStats();

        include __DIR__ . '/../Views/seller/dashboard.php';
    }

    // Seller profile
    public function profile()
    {
        requireRole(ROLE_SELLER);

        $this->user->id = $_SESSION['user_id'];
        $this->user->readById();

        // Create user data array for the view
        $user_data = [
            'first_name' => $this->user->first_name,
            'last_name' => $this->user->last_name,
            'email' => $this->user->email,
            'phone' => $this->user->phone,
            'address' => $this->user->address,
            'city' => $this->user->city,
            'country' => $this->user->country,
            'postal_code' => $this->user->postal_code
        ];

        include __DIR__ . '/../Views/seller/profile.php';
    }

    // Update seller profile
    public function updateProfile()
    {
        requireRole(ROLE_SELLER);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->user->id = $_SESSION['user_id'];
            $this->user->first_name = $_POST['first_name'];
            $this->user->last_name = $_POST['last_name'];
            $this->user->phone = $_POST['phone'];
            $this->user->address = $_POST['address'];
            $this->user->city = $_POST['city'];
            $this->user->country = $_POST['country'];
            $this->user->postal_code = $_POST['postal_code'];

            if ($this->user->update()) {
                $_SESSION['success'] = 'Profile updated successfully';
                $_SESSION['first_name'] = $this->user->first_name;
                $_SESSION['last_name'] = $this->user->last_name;
            } else {
                $_SESSION['error'] = 'Failed to update profile';
            }
        }

        redirect('seller&action=profile');
    }

    // Get seller dashboard statistics
    private function getDashboardStats()
    {
        $stats = [];
        $seller_id = $_SESSION['user_id'];

        // Total products
        $query = "SELECT COUNT(*) as total FROM products WHERE seller_id = :seller_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':seller_id', $seller_id);
        $stmt->execute();
        $stats['total_products'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Approved products
        $query = "SELECT COUNT(*) as total FROM products WHERE seller_id = :seller_id AND status = 'approved'";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':seller_id', $seller_id);
        $stmt->execute();
        $stats['approved_products'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Pending products
        $query = "SELECT COUNT(*) as total FROM products WHERE seller_id = :seller_id AND status = 'pending'";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':seller_id', $seller_id);
        $stmt->execute();
        $stats['pending_products'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Total revenue
        $query = "SELECT SUM(oi.total_price) as revenue 
                  FROM order_items oi 
                  JOIN products p ON oi.product_id = p.id 
                  JOIN orders o ON oi.order_id = o.id
                  WHERE p.seller_id = :seller_id AND o.status = 'delivered'";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':seller_id', $seller_id);
        $stmt->execute();
        $stats['total_revenue'] = $stmt->fetch(PDO::FETCH_ASSOC)['revenue'] ?? 0;

        return $stats;
    }
}
