<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Order.php';

class AdminController
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

    public function dashboard()
    {
        requireRole(ROLE_ADMIN);
        $stats = $this->getDashboardStats();
        include __DIR__ . '/../Views/admin/dashboard.php';
    }

    public function users()
    {
        requireRole(ROLE_ADMIN);
        $users = $this->user->readAll();
        include __DIR__ . '/../Views/admin/users/index.php';
    }

    public function products()
    {
        requireRole(ROLE_ADMIN);

        // Modified query to include primary image
        $query = "SELECT p.*, u.first_name, u.last_name, pi.image_url, pi.alt_text
              FROM products p 
              LEFT JOIN users u ON p.seller_id = u.id 
              LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
              ORDER BY p.created_at DESC 
              LIMIT 50";

        $products = $this->db->prepare($query);
        $products->execute();

        include __DIR__ . '/../Views/admin/products/index.php';
    }

    public function approveProduct($id)
    {
        requireRole(ROLE_ADMIN);

        $this->product->id = $id;
        if ($this->product->approve()) {
            $_SESSION['success'] = 'Product approved successfully';
        } else {
            $_SESSION['error'] = 'Failed to approve product';
        }

        redirect('admin&action=products');
    }

    // Delete product functionality
    public function deleteProduct($id)
    {
        requireRole(ROLE_ADMIN);

        $this->product->id = $id;
        if ($this->product->delete()) {
            $_SESSION['success'] = 'Product deleted successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete product';
        }

        redirect('admin&action=products');
    }

    public function rejectProduct($id)
    {
        requireRole(ROLE_ADMIN);

        $this->product->id = $id;
        if ($this->product->reject()) {
            $_SESSION['success'] = 'Product rejected successfully';
        } else {
            $_SESSION['error'] = 'Failed to reject product';
        }

        redirect('admin&action=products');
    }

    // Delete user functionality
    public function deleteUser($id)
    {
        requireRole(ROLE_ADMIN);

        // Check if trying to delete self
        if ($id == $_SESSION['user_id']) {
            $_SESSION['error'] = 'You cannot delete your own account';
            redirect('admin&action=users');
        }

        $this->user->id = $id;
        if ($this->user->delete()) {
            $_SESSION['success'] = 'User deleted successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete user';
        }

        redirect('admin&action=users');
    }

    // Orders management
    public function orders()
    {
        requireRole(ROLE_ADMIN);

        $query = "SELECT o.*, u.first_name, u.last_name, u.email 
                  FROM orders o 
                  JOIN users u ON o.user_id = u.id 
                  ORDER BY o.created_at DESC 
                  LIMIT 50";
        $orders = $this->db->prepare($query);
        $orders->execute();

        include __DIR__ . '/../Views/admin/orders/index.php';
    }

    // Analytics page
    public function analytics()
    {
        requireRole(ROLE_ADMIN);

        $analytics = $this->getAnalyticsData();
        include __DIR__ . '/../Views/admin/analytics/index.php';
    }

    private function getAnalyticsData()
    {
        $analytics = [];

        // Monthly revenue
        $query = "SELECT 
                    DATE_FORMAT(created_at, '%Y-%m') as month,
                    SUM(total_amount) as revenue,
                    COUNT(*) as order_count
                  FROM orders 
                  WHERE payment_status = 'paid' 
                  GROUP BY DATE_FORMAT(created_at, '%Y-%m')
                  ORDER BY month DESC 
                  LIMIT 12";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $analytics['monthly_revenue'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Top selling products
        $query = "SELECT p.name, p.brand, SUM(oi.quantity) as total_sold
                  FROM order_items oi
                  JOIN products p ON oi.product_id = p.id
                  JOIN orders o ON oi.order_id = o.id
                  WHERE o.status = 'delivered'
                  GROUP BY p.id
                  ORDER BY total_sold DESC
                  LIMIT 10";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $analytics['top_products'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $analytics;
    }

    // Toggle user status
    public function toggleUserStatus($id)
    {
        requireRole(ROLE_ADMIN);

        // Check if trying to deactivate self
        if ($id == $_SESSION['user_id']) {
            $_SESSION['error'] = 'You cannot deactivate your own account';
            redirect('admin&action=users');
        }

        $this->user->id = $id;
        if ($this->user->toggleStatus()) {
            $_SESSION['success'] = 'User status updated successfully';
        } else {
            $_SESSION['error'] = 'Failed to update user status';
        }

        redirect('admin&action=users');
    }

    private function getDashboardStats()
    {
        $stats = [];

        $query = "SELECT COUNT(*) as total FROM users";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $stats['total_users'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $query = "SELECT COUNT(*) as total FROM products";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $stats['total_products'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $query = "SELECT COUNT(*) as total FROM products WHERE status = 'pending'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $stats['pending_products'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $query = "SELECT COUNT(*) as total FROM orders";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $stats['total_orders'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Additional stats for better dashboard
        $query = "SELECT COUNT(*) as total FROM users WHERE role = 'seller'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $stats['total_sellers'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $query = "SELECT COUNT(*) as total FROM users WHERE role = 'customer'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $stats['total_customers'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $query = "SELECT SUM(total_amount) as revenue FROM orders WHERE payment_status = 'paid'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $stats['total_revenue'] = $stmt->fetch(PDO::FETCH_ASSOC)['revenue'] ?? 0;

        return $stats;
    }
}
