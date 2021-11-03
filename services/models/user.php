<?php 
  class User {

    private $conn;
    private $table = 'users';

    public $user_id;
    public $email;
    public $name;
    public $surname;
    
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
      $query = 'SELECT * FROM users INNER JOIN passwords ON users.email = passwords.email WHERE users.email = :email AND passwords.password = :password';
      $stmt = $this->conn->prepare($query);
      $this->email = htmlspecialchars(strip_tags($this->email));
      $this->password = htmlspecialchars(strip_tags($this->password));
      $stmt->bindParam(':email', $this->email);
      $stmt->bindParam(':password', $this->password);
      $stmt->execute();
      return $stmt;

    }
    

    public function create() {

      // $query = 'INSERT INTO ' . $this->table . ' SET name = :name, email = :email, surname = :surname, created = :created
      //   ON DUPLICATE KEY UPDATE name = :name, email = :email, surname = :surname';

        $query = 'INSERT INTO ' . $this->table . ' SET name = :name, email = :email, surname = :surname, created = :created';

        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->surname = htmlspecialchars(strip_tags($this->surname));
        $this->created = $this->created;

        // Bind data
        //Create tables for: passwords, birthdays, gender, roles, active, blocked, deleted, ppicture, phonenumbers
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':surname', $this->surname);
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
                                SET name = :name, surname = :surname, birthday = :birthday, age = :age, gender = :gender, role = :role, profile_picture = :profile_picture
                                WHERE email = :email';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->name = htmlspecialchars(strip_tags($this->name));
          $this->email = htmlspecialchars(strip_tags($this->email));
          $this->surname = htmlspecialchars(strip_tags($this->surname));
          $this->birthday = $this->birthday;
          $this->age = $this->age;
          $this->gender = $this->gender;
          $this->role = htmlspecialchars(strip_tags($this->role));
          $this->profile_picture = htmlspecialchars(strip_tags($this->profile_picture));

          // Bind data
          $stmt->bindParam(':name', $this->name);
          $stmt->bindParam(':email', $this->email);
          $stmt->bindParam(':surname', $this->surname);
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