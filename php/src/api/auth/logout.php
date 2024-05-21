<?php 
include_once dirname(__FILE__) . '/../../app/main.php';

$authService->logout();
http_response_code(200);