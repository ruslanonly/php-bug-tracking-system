<?php
include_once dirname(__FILE__) . '/../../app/main.php';

if(!isset($_POST['login']) || !isset($_POST['password'])) {
  http_response_code(400);
  return;
}

$login = $_POST['login'];
$password = $_POST['password'];

try {
  $user = $authService->register($login, $password);

  header('Content-Type: application/json');
  http_response_code(200);
  echo json_encode($user);
} catch(Exception $error) {
  http_response_code(500);
}