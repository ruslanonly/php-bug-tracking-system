<?php 
include_once dirname(__FILE__) . '/../../app/main.php';

if(!isset($_POST['login']) || !isset($_POST['password'])) {
  http_response_code(400);
  return;
}

$login = $_POST['login'];
$password = $_POST['password'];

try {
  $user = $authService->login($login, $password);

  if (is_null($user)) {
    http_response_code(401);
    return;
  }


  header('Content-Type: application/json');
  http_response_code(200);
  echo json_encode($user);
} catch(Exception $e) {
  http_response_code(500);
}