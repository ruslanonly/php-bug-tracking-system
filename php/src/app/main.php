<?php
session_start();
include_once(dirname(__DIR__).'/app/shared/lib/db/connect_database.php');

// domain
include_once dirname(__DIR__) . '/app/features/core/models.php';

// repositories
include_once dirname(__DIR__) . '/app/features/core/repositories/user-repository.php';
include_once dirname(__DIR__) . '/app/features/core/repositories/viewer-repository.php';

// feature/auth
include_once dirname(__DIR__) . '/app/features/core/auth-service.php';
include_once dirname(__DIR__) . '/app/features/core/auth.guards.php';

$_DB = connectBTSDatabase();

$usersRepository = new UsersRepository($_DB->mysqli);

$viewerRepository = new ViewerRepository();

$authService = new AuthService($usersRepository, $viewerRepository);

$authGuard = new AuthGuard($viewerRepository);