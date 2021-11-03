<?php 
  class Notification {

    private $conn;
    private $table = 'notifications';

    public $email;
    public $text;    
    public $created;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get requests
    public function read() {
      $query = 'SELECT *  FROM ' . $this->table;
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      return $stmt;
    }


    public function read_single() {
        
      // Create query
      $query = 'SELECT * FROM ' . $this->table . ' WHERE email = :email';
      $stmt = $this->conn->prepare($query);
      $this->email = htmlspecialchars(strip_tags($this->email));
      $stmt->bindParam(':email', $this->email);
      $stmt->execute();
      return $stmt;

    }
    
    public function create() {

        $query = 'INSERT INTO ' . $this->table . ' SET text = :text, email = :email, status = :status, created = :created';

        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->text = htmlspecialchars(strip_tags($this->text));
        $this->email = $this->email;
        $this->status = $this->status;
        $this->created = $this->created;

        // Bind data
        $stmt->bindParam(':text', $this->text);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':created', $this->created);

        try {

          $stmt->execute();
          return true;
          
        } catch(PDOException $e) {

          //echo $e->getMessage();
          return false;
        }

    }

    // Update User
    public function update() {
          // Create query
          $query = 'UPDATE ' . $this->table . '
                                SET password = :password, surpassword = :surpassword, birthday = :birthday, age = :age, gender = :gender, role = :role, profile_picture = :profile_picture
                                WHERE email = :email';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->password = htmlspecialchars(strip_tags($this->password));
          $this->email = htmlspecialchars(strip_tags($this->email));
          $this->surpassword = htmlspecialchars(strip_tags($this->surpassword));
          $this->birthday = $this->birthday;
          $this->age = $this->age;
          $this->gender = $this->gender;
          $this->role = htmlspecialchars(strip_tags($this->role));
          $this->profile_picture = htmlspecialchars(strip_tags($this->profile_picture));

          // Bind data
          $stmt->bindParam(':password', $this->password);
          $stmt->bindParam(':email', $this->email);
          $stmt->bindParam(':surpassword', $this->surpassword);
          $stmt->bindParam(':birthday', $this->birthday);
          $stmt->bindParam(':age', $this->age);
          $stmt->bindParam(':gender', $this->gender);
          $stmt->bindParam(':role', $this->role);
          $stmt->bindParam(':profile_picture', $this->profile_picture);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }

    // Delete User
    public function delete() {
          // Create query
          $query = 'DELETE FROM ' . $this->table . ' WHERE user_id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->id = htmlspecialchars(strip_tags($this->user_id));

          // Bind data
          $stmt->bindParam(':user_id', $this->user_id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }
    
  }