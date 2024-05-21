<?php 
include_once dirname(__DIR__) . '/core/repositories/viewer-repository.php';
class AuthGuard {
  function __construct(private ViewerRepository $viewerRepository) {}
  function canActivate() {
    $isAuth = $this->viewerRepository->isAuth();
    if ($isAuth === true) {
      return;
    }
    header('Location: /login.php');
    die();
  }
}