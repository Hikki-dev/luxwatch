<?php
// src/Models/User.php
class User
{
    private $conn;
    private $table_name = "users";

    public $id;
    public $email;
    public $password;
    public $first_name;
    public $last_name;
    public $role;
    public $phone;
    public $address;
    public $city;
    public $country;
    public $postal_code;
    public $is_active;
    public $created_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Create user (CRUD - Create)
    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET email=:email, password=:password, first_name=:first_name, 
                      last_name=:last_name, role=:role, phone=:phone, 
                      address=:address, city=:city, country=:country, postal_code=:postal_code";

        $stmt = $this->conn->prepare($query);

        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->role = htmlspecialchars(strip_tags($this->role));

        // Bind values
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":role", $this->role);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":city", $this->city);
        $stmt->bindParam(":country", $this->country);
        $stmt->bindParam(":postal_code", $this->postal_code);

        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }

    // Read user by email
    public function readByEmail()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->id = $row['id'];
            $this->email = $row['email'];
            $this->password = $row['password']; // Keep hashed password for verification
            $this->first_name = $row['first_name'];
            $this->last_name = $row['last_name'];
            $this->role = $row['role'];
            $this->phone = $row['phone'];
            $this->address = $row['address'];
            $this->city = $row['city'];
            $this->country = $row['country'];
            $this->postal_code = $row['postal_code'];
            $this->is_active = $row['is_active'];
            $this->created_at = $row['created_at'];
            return true;
        }
        return false;
    }

    // Read user by ID (CRUD - Read)
    public function readById()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->email = $row['email'];
            $this->first_name = $row['first_name'];
            $this->last_name = $row['last_name'];
            $this->role = $row['role'];
            $this->phone = $row['phone'];
            $this->address = $row['address'];
            $this->city = $row['city'];
            $this->country = $row['country'];
            $this->postal_code = $row['postal_code'];
            $this->is_active = $row['is_active'];
            return true;
        }
        return false;
    }

    // Update user (CRUD - Update)
    public function update()
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET first_name=:first_name, last_name=:last_name, 
                      phone=:phone, address=:address, city=:city, 
                      country=:country, postal_code=:postal_code 
                  WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));

        $stmt->bindParam(':first_name', $this->first_name);
        $stmt->bindParam(':last_name', $this->last_name);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':city', $this->city);
        $stmt->bindParam(':country', $this->country);
        $stmt->bindParam(':postal_code', $this->postal_code);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    // Delete user (CRUD - Delete)
    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    // Get all users (for admin)
    public function readAll()
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Verify password - FIXED VERSION
    public function verifyPassword($password)
    {
        if (empty($this->password)) {
            return false;
        }
        return password_verify($password, $this->password);
    }

    // Check if email exists
    public function emailExists()
    {
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = :email LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    // Update password
    public function updatePassword($new_password)
    {
        $query = "UPDATE " . $this->table_name . " SET password = :password WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    // Toggle user status (for admin)
    public function toggleStatus()
    {
        $query = "UPDATE " . $this->table_name . " SET is_active = NOT is_active WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }
}
