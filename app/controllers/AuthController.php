<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {
  public function login() {
    header('Content-Type: application/json');

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
      echo json_encode(['status'=>'error','message'=>'Usuario y contraseña son obligatorios']); return;
    }

    $user = new User();
    if ($user->login($username, $password)) {
      echo json_encode(['status'=>'success']);
    } else {
      http_response_code(401);
      echo json_encode(['status'=>'error','message'=>'Credenciales inválidas']);
    }
  }

  public function me() {
    header('Content-Type: application/json');
    session_start();
    $resp = [
      'username' => $_SESSION['username'] ?? null,
      'role'     => $_SESSION['role']     ?? null,
      'name'     => $_SESSION['name']     ?? null,
    ];
    echo json_encode(['status'=>'success','user'=>$resp]);
  }

  public function logout() {
    header('Content-Type: application/json');
    session_start();
    session_destroy();
    echo json_encode(['status'=>'success']);
  }
}
