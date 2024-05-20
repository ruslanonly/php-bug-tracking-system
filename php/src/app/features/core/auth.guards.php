<?php 
include_once dirname(__FILE__) . '/../../core/domain/repositories.php';
class ApplicantGuard {
  function __construct(private ViewerRepository $viewerRepository) {}
  function canActivate() {
    $role = $this->viewerRepository->getRole();
    $isAuth = $this->viewerRepository->isAuth();
    if ($isAuth === true && $role === Role::Applicant) {
      return;
    }
    header('Location: /login.php');
    die();
  }
}

class EmployerGuard {
  function __construct(private ViewerRepository $viewerRepository) {}
  function canActivate() {
    $role = $this->viewerRepository->getRole();
    $isAuth = $this->viewerRepository->isAuth();
    if ($isAuth === true && $role === Role::Employer) {
      return;
    }
    header('Location: /login.php');
    die();
  }
}