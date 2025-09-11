<?php
// src/Controllers/ProductController.php - COMPLETE VERSION
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/User.php';

class ProductController
{
    private $db;
    private $product;
    private $category;
    private $user;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->product = new Product($this->db);
        $this->category = new Category($this->db);
        $this->user = new User($this->db);
    }

    // Show single product detail (PUBLIC METHOD)
    public function show($id)
    {
        if (!$id) {
            header('Location: index.php?page=products');
            exit();
        }

        // Get product details with category and seller info
        $query = "SELECT p.*, c.name as category_name, u.first_name as seller_first_name, 
                         u.last_name as seller_last_name, u.created_at as seller_joined
                  FROM products p 
                  LEFT JOIN categories c ON p.category_id = c.id 
                  LEFT JOIN users u ON p.seller_id = u.id 
                  WHERE p.id = :id AND p.is_active = 1 AND p.status = 'approved'
                  LIMIT 1";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            $_SESSION['error'] = 'Product not found';
            header('Location: index.php?page=products');
            exit();
        }

        // Get product images
        $query = "SELECT * FROM product_images WHERE product_id = :product_id ORDER BY sort_order, is_primary DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':product_id', $id);
        $stmt->execute();
        $images = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Get seller information
        $seller = [
            'first_name' => $product['seller_first_name'],
            'last_name' => $product['seller_last_name'],
            'created_at' => $product['seller_joined']
        ];

        // Get related products (same brand or category)
        $query = "SELECT p.*, pi.image_url 
                  FROM products p 
                  LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
                  WHERE p.id != :id 
                  AND p.is_active = 1 
                  AND p.status = 'approved'
                  AND (p.brand = :brand OR p.category_id = :category_id)
                  ORDER BY RAND() 
                  LIMIT 4";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':brand', $product['brand']);
        $stmt->bindParam(':category_id', $product['category_id']);
        $stmt->execute();
        $related_products = $stmt;

        include __DIR__ . '/../Views/products/detail.php';
    }

    // Show seller's products
    public function index()
    {
        requireRole(ROLE_SELLER);

        $products = $this->product->readBySeller($_SESSION['user_id']);
        include __DIR__ . '/../Views/seller/products/index.php';
    }

    // Show add product form
    public function create()
    {
        requireRole(ROLE_SELLER);

        $categories = $this->category->readAll();
        include __DIR__ . '/../Views/seller/products/create.php';
    }

    // Handle product creation (CRUD - Create)
    public function store()
    {
        requireRole(ROLE_SELLER);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validation
            $required_fields = ['name', 'description', 'brand', 'price', 'category_id'];
            foreach ($required_fields as $field) {
                if (empty($_POST[$field])) {
                    $_SESSION['error'] = ucfirst($field) . ' is required';
                    redirect('seller&action=products&sub=create');
                }
            }

            // Set product properties
            $this->product->seller_id = $_SESSION['user_id'];
            $this->product->category_id = $_POST['category_id'];
            $this->product->name = $_POST['name'];
            $this->product->description = $_POST['description'];
            $this->product->brand = $_POST['brand'];
            $this->product->model = $_POST['model'] ?? null;
            $this->product->reference_number = $_POST['reference_number'] ?? null;
            $this->product->price = $_POST['price'];
            $this->product->original_price = $_POST['original_price'] ?? null;
            $this->product->condition_type = $_POST['condition_type'];
            $this->product->movement_type = $_POST['movement_type'] ?? null;
            $this->product->case_material = $_POST['case_material'] ?? null;
            $this->product->dial_color = $_POST['dial_color'] ?? null;
            $this->product->strap_material = $_POST['strap_material'] ?? null;
            $this->product->water_resistance = $_POST['water_resistance'] ?? null;
            $this->product->year_manufactured = $_POST['year_manufactured'] ?? null;
            $this->product->warranty_info = $_POST['warranty_info'] ?? null;
            $this->product->stock_quantity = $_POST['stock_quantity'] ?? 1;

            if ($this->product->create()) {
                $_SESSION['success'] = 'Product added successfully and is pending approval';
                redirect('seller&action=products');
            } else {
                $_SESSION['error'] = 'Failed to add product';
                redirect('seller&action=products&sub=create');
            }
        }
    }

    // Show edit product form
    public function edit($id)
    {
        requireRole(ROLE_SELLER);

        $this->product->id = $id;
        if ($this->product->readById()) {
            // Check if seller owns this product
            if ($this->product->seller_id != $_SESSION['user_id']) {
                $_SESSION['error'] = 'Unauthorized access';
                redirect('seller&action=products');
            }

            $categories = $this->category->readAll();
            include __DIR__ . '/../Views/seller/products/edit.php';
        } else {
            $_SESSION['error'] = 'Product not found';
            redirect('seller&action=products');
        }
    }

    // Handle product update (CRUD - Update)
    public function update($id)
    {
        requireRole(ROLE_SELLER);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->product->id = $id;
            if ($this->product->readById()) {
                // Check if seller owns this product
                if ($this->product->seller_id != $_SESSION['user_id']) {
                    $_SESSION['error'] = 'Unauthorized access';
                    redirect('seller&action=products');
                }

                // Update product properties
                $this->product->name = $_POST['name'];
                $this->product->description = $_POST['description'];
                $this->product->brand = $_POST['brand'];
                $this->product->model = $_POST['model'];
                $this->product->price = $_POST['price'];
                $this->product->condition_type = $_POST['condition_type'];
                $this->product->stock_quantity = $_POST['stock_quantity'];

                if ($this->product->update()) {
                    $_SESSION['success'] = 'Product updated successfully';
                    redirect('seller&action=products');
                } else {
                    $_SESSION['error'] = 'Failed to update product';
                    redirect('seller&action=products&sub=edit&id=' . $id);
                }
            } else {
                $_SESSION['error'] = 'Product not found';
                redirect('seller&action=products');
            }
        }
    }

    // Handle product deletion (CRUD - Delete)
    public function delete($id)
    {
        requireRole(ROLE_SELLER);

        $this->product->id = $id;
        if ($this->product->readById()) {
            // Check if seller owns this product
            if ($this->product->seller_id != $_SESSION['user_id']) {
                $_SESSION['error'] = 'Unauthorized access';
                redirect('seller&action=products');
            }

            if ($this->product->delete()) {
                $_SESSION['success'] = 'Product deleted successfully';
            } else {
                $_SESSION['error'] = 'Failed to delete product';
            }
        } else {
            $_SESSION['error'] = 'Product not found';
        }

        redirect('seller&action=products');
    }
}
