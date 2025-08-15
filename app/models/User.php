<?php
require_once __DIR__ . '/../config/db.php';

class User {
  private $db;
  public function __construct() { $this->db = Database::connect(); }

  public function login($username, $password) {
    $st = $this->db->prepare("SELECT id, username, name, password, role FROM users WHERE username=? LIMIT 1");
    $st->bind_param('s', $username);
    $st->execute();
    $u = $st->get_result()->fetch_assoc();

    if ($u && password_verify($password, $u['password'])) {
      session_start();
      $_SESSION['username'] = $u['username'];
      $_SESSION['role']     = $u['role'];
      $_SESSION['name']     = $u['name'];
      return true;
    }
    return false;
  }
}
