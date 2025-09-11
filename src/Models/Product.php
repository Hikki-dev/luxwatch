<?php
class Product {
    private $conn;
    private $table_name = "products";

    public $id;
    public $seller_id;
    public $category_id;
    public $name;
    public $slug;
    public $description;
    public $brand;
    public $model;
    public $reference_number;
    public $price;
    public $original_price;
    public $condition_type;
    public $movement_type;
    public $case_material;
    public $dial_color;
    public $strap_material;
    public $water_resistance;
    public $year_manufactured;
    public $warranty_info;
    public $stock_quantity;
    public $is_featured;
    public $is_active;
    public $status;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create product (CRUD - Create)
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET seller_id=:seller_id, category_id=:category_id, name=:name, 
                      slug=:slug, description=:description, brand=:brand, model=:model,
                      reference_number=:reference_number, price=:price, original_price=:original_price,
                      condition_type=:condition_type, movement_type=:movement_type,
                      case_material=:case_material, dial_color=:dial_color,
                      strap_material=:strap_material, water_resistance=:water_resistance,
                      year_manufactured=:year_manufactured, warranty_info=:warranty_info,
                      stock_quantity=:stock_quantity";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->slug = $this->generateSlug($this->name);
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->brand = htmlspecialchars(strip_tags($this->brand));

        // Bind values
        $stmt->bindParam(":seller_id", $this->seller_id);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":slug", $this->slug);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":brand", $this->brand);
        $stmt->bindParam(":model", $this->model);
        $stmt->bindParam(":reference_number", $this->reference_number);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":original_price", $this->original_price);
        $stmt->bindParam(":condition_type", $this->condition_type);
        $stmt->bindParam(":movement_type", $this->movement_type);
        $stmt->bindParam(":case_material", $this->case_material);
        $stmt->bindParam(":dial_color", $this->dial_color);
        $stmt->bindParam(":strap_material", $this->strap_material);
        $stmt->bindParam(":water_resistance", $this->water_resistance);
        $stmt->bindParam(":year_manufactured", $this->year_manufactured);
        $stmt->bindParam(":warranty_info", $this->warranty_info);
        $stmt->bindParam(":stock_quantity", $this->stock_quantity);

        if($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }

    // Read all products (CRUD - Read)
    public function readAll($limit = 20, $offset = 0) {
        $query = "SELECT p.*, c.name as category_name, u.first_name, u.last_name 
                  FROM " . $this->table_name . " p 
                  LEFT JOIN categories c ON p.category_id = c.id 
                  LEFT JOIN users u ON p.seller_id = u.id 
                  WHERE p.is_active = 1 AND p.status = 'approved'
                  ORDER BY p.created_at DESC 
                  LIMIT :limit OFFSET :offset";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // Read product by ID
    public function readById() {
        $query = "SELECT p.*, c.name as category_name, u.first_name, u.last_name 
                  FROM " . $this->table_name . " p 
                  LEFT JOIN categories c ON p.category_id = c.id 
                  LEFT JOIN users u ON p.seller_id = u.id 
                  WHERE p.id = :id LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $this->name = $row['name'];
            $this->slug = $row['slug'];
            $this->description = $row['description'];
            $this->brand = $row['brand'];
            $this->model = $row['model'];
            $this->price = $row['price'];
            $this->condition_type = $row['condition_type'];
            $this->seller_id = $row['seller_id'];
            $this->category_id = $row['category_id'];
            return true;
        }
        return false;
    }

    // Update product (CRUD - Update)
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET name=:name, description=:description, brand=:brand, 
                      model=:model, price=:price, condition_type=:condition_type,
                      stock_quantity=:stock_quantity 
                  WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':brand', $this->brand);
        $stmt->bindParam(':model', $this->model);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':condition_type', $this->condition_type);
        $stmt->bindParam(':stock_quantity', $this->stock_quantity);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    // Delete product (CRUD - Delete)
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    // Get products by seller
    public function readBySeller($seller_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE seller_id = :seller_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':seller_id', $seller_id);
        $stmt->execute();
        return $stmt;
    }

    // Search products
    public function search($keyword, $brand = null, $min_price = null, $max_price = null) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE is_active = 1 AND status = 'approved'";
        
        if($keyword) {
            $query .= " AND (name LIKE :keyword OR description LIKE :keyword OR brand LIKE :keyword)";
        }
        if($brand) {
            $query .= " AND brand = :brand";
        }
        if($min_price) {
            $query .= " AND price >= :min_price";
        }
        if($max_price) {
            $query .= " AND price <= :max_price";
        }
        
        $query .= " ORDER BY created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        
        if($keyword) {
            $keyword = "%{$keyword}%";
            $stmt->bindParam(':keyword', $keyword);
        }
        if($brand) {
            $stmt->bindParam(':brand', $brand);
        }
        if($min_price) {
            $stmt->bindParam(':min_price', $min_price);
        }
        if($max_price) {
            $stmt->bindParam(':max_price', $max_price);
        }
        
        $stmt->execute();
        return $stmt;
    }

    // Generate slug from name
    private function generateSlug($string) {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    }

    // Approve product (Admin function)
    public function approve() {
        $query = "UPDATE " . $this->table_name . " SET status = 'approved' WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    // Reject product (Admin function)
    public function reject() {
        $query = "UPDATE " . $this->table_name . " SET status = 'rejected' WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }
}