<?php
// src/Controllers/HomeController.php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Category.php';

class HomeController
{
    private $db;
    private $product;
    private $category;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->product = new Product($this->db);
        $this->category = new Category($this->db);
    }

    public function products()
    {
        // Get search parameters
        $search = $_GET['search'] ?? null;
        $brand = $_GET['brand'] ?? null;
        $min_price = $_GET['min_price'] ?? null;
        $max_price = $_GET['max_price'] ?? null;
        $page_num = isset($_GET['pg']) ? (int)$_GET['pg'] : 1;
        $items_per_page = 12;
        $offset = ($page_num - 1) * $items_per_page;

        // Build the query with filters
        $query = "SELECT p.*, c.name as category_name, pi.image_url 
                  FROM products p 
                  LEFT JOIN categories c ON p.category_id = c.id 
                  LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
                  WHERE p.is_active = 1 AND p.status = 'approved'";

        $params = [];

        if ($search) {
            $query .= " AND (p.name LIKE :search OR p.description LIKE :search2 OR p.brand LIKE :search3)";
            $searchTerm = "%{$search}%";
            $params[':search'] = $searchTerm;
            $params[':search2'] = $searchTerm;
            $params[':search3'] = $searchTerm;
        }

        if ($brand) {
            $query .= " AND p.brand = :brand";
            $params[':brand'] = $brand;
        }

        if ($min_price) {
            $query .= " AND p.price >= :min_price";
            $params[':min_price'] = $min_price;
        }

        if ($max_price) {
            $query .= " AND p.price <= :max_price";
            $params[':max_price'] = $max_price;
        }

        // Get total count for pagination
        $count_query = "SELECT COUNT(*) as total FROM products p WHERE p.is_active = 1 AND p.status = 'approved'";

        // Add the same filters to count query
        if ($search) {
            $count_query .= " AND (p.name LIKE :search OR p.description LIKE :search2 OR p.brand LIKE :search3)";
        }
        if ($brand) {
            $count_query .= " AND p.brand = :brand";
        }
        if ($min_price) {
            $count_query .= " AND p.price >= :min_price";
        }
        if ($max_price) {
            $count_query .= " AND p.price <= :max_price";
        }

        $stmt = $this->db->prepare($count_query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        $total_products = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        $total_pages = ceil($total_products / $items_per_page);

        // Make sure page number is valid
        if ($page_num < 1) $page_num = 1;
        if ($page_num > $total_pages && $total_pages > 0) $page_num = $total_pages;

        // Recalculate offset with validated page number
        $offset = ($page_num - 1) * $items_per_page;

        // Add ordering and pagination
        $query .= " ORDER BY p.created_at DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $products = $stmt;

        // Get all categories for filter
        $categories = $this->category->readAll();

        // Pagination info
        $pagination = [
            'current_page' => $page_num,
            'total_pages' => $total_pages,
            'total_products' => $total_products,
            'items_per_page' => $items_per_page,
            'has_prev' => $page_num > 1,
            'has_next' => $page_num < $total_pages
        ];

        include __DIR__ . '/../Views/products/index.php';
    }

    public function brands()
    {
        $categories = $this->category->readAll();
        include __DIR__ . '/../Views/brands/index.php';
    }

    public function about()
    {
        include __DIR__ . '/../Views/about/index.php';
    }

    public function services()
    {
        include __DIR__ . '/../Views/services/index.php';
    }
}
