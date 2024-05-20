<?php
include_once dirname(__FILE__) . '/../domain/models.php';
include_once dirname(__FILE__) . '/../domain/repositories.php';
class UserRepository {
  function __construct(
    private mysqli $bd,
  ) {}

  function addUser(string $login, string $password, int $role): User | null {
    $query = "INSERT INTO users(login, password, role) VALUES (?, ?, ?)";
    $stmt = $this->bd->prepare($query);
    $stmt->bind_param("ssi", $login, $password, $role);
    $stmt->execute();
    $stmt->close();
    
    $id = $this->bd->insert_id;

    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $this->bd->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    
    $row = $result->fetch_assoc();
    if(is_null($row)) {
        return null;
    }

    $roleEmun = Role::from($row['role']);
    
    return new User(
      $row['id'], 
      $row['login'], 
      $row['password'], 
      $roleEmun
    );
  }
}