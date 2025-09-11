<?php
class Category {
    private $conn;
    private $table_name = "categories";

    public $id;
    public $name;
    public $slug;
    public $description;
    public $image_url;
    public $is_active;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create category (CRUD - Create)
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET name=:name, slug=:slug, description=:description, image_url=:image_url";

        $stmt = $this->conn->prepare($query);

        // Sanitize and prepare data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->slug = $this->generateSlug($this->name);
        $this->description = htmlspecialchars(strip_tags($this->description));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':slug', $this->slug);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':image_url', $this->image_url);

        if($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }

    // Read all categories (CRUD - Read)
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE is_active = 1 
                  ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Read category by ID
    public function readById() {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $this->name = $row['name'];
            $this->slug = $row['slug'];
            $this->description = $row['description'];
            $this->image_url = $row['image_url'];
            $this->is_active = $row['is_active'];
            $this->created_at = $row['created_at'];
            return true;
        }
        return false;
    }

    // Read category by slug
    public function readBySlug() {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE slug = :slug AND is_active = 1 LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':slug', $this->slug);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->description = $row['description'];
            $this->image_url = $row['image_url'];
            $this->is_active = $row['is_active'];
            $this->created_at = $row['created_at'];
            return true;
        }
        return false;
    }

    // Update category (CRUD - Update)
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET name=:name, slug=:slug, description=:description, image_url=:image_url 
                  WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->slug = $this->generateSlug($this->name);
        $this->description = htmlspecialchars(strip_tags($this->description));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':slug', $this->slug);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':image_url', $this->image_url);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    // Delete category (CRUD - Delete)
    public function delete() {
        // Check if category has products
        $check_query = "SELECT COUNT(*) as count FROM products WHERE category_id = :id";
        $check_stmt = $this->conn->prepare($check_query);
        $check_stmt->bindParam(':id', $this->id);
        $check_stmt->execute();
        $result = $check_stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result['count'] > 0) {
            return false; // Cannot delete category with products
        }

        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    // Toggle category status
    public function toggleStatus() {
        $query = "UPDATE " . $this->table_name . " 
                  SET is_active = NOT is_active 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    // Get category with product count
    public function getCategoriesWithProductCount() {
        $query = "SELECT c.*, COUNT(p.id) as product_count 
                  FROM " . $this->table_name . " c 
                  LEFT JOIN products p ON c.id = p.category_id AND p.is_active = 1 AND p.status = 'approved'
                  WHERE c.is_active = 1 
                  GROUP BY c.id 
                  ORDER BY c.name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Generate slug from name
    private function generateSlug($string) {
        // Convert to lowercase
        $slug = strtolower($string);
        // Replace spaces and special chars with hyphens
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        // Remove leading/trailing hyphens
        $slug = trim($slug, '-');
        
        // Check if slug exists and make unique if needed
        $original_slug = $slug;
        $counter = 1;
        while ($this->slugExists($slug)) {
            $slug = $original_slug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }

    // Check if slug exists
    private function slugExists($slug) {
        $query = "SELECT id FROM " . $this->table_name . " WHERE slug = :slug";
        if (isset($this->id)) {
            $query .= " AND id != :id";
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':slug', $slug);
        if (isset($this->id)) {
            $stmt->bindParam(':id', $this->id);
        }
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }
}