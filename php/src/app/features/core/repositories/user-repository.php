<?php
include_once dirname(__DIR__) . '/models.php';

class UsersRepository {
  function __construct(
    private mysqli $db,
  ) {}

  function addUser(string $login, string $password): User | null {
    $query = "INSERT INTO users(login, password) VALUES (?, ?)";
    $stmt = $this->db->prepare($query);
    $stmt->bind_param("ss", $login, $password);
    $stmt->execute();
    $stmt->close();
    
    $id = $this->db->insert_id;

    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    
    $row = $result->fetch_assoc();
    if(is_null($row)) {
        return null;
    }

    return new User(
      $row['id'], 
      $row['login'], 
      $row['password'], 
    );
  }

  function getUser(string $login, string $password): User | null {
    $query = "SELECT * FROM users WHERE login = ? AND password = ? LIMIT 1";
    $stmt = $this->db->prepare($query);
    $stmt->bind_param("ss", $login, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    
    if(is_null($row)) {
        return null;
    }
    
    return new User(
      $row['id'], 
      $row['login'], 
      $row['password'], 
    );
  }
}