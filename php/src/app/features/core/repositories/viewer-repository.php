<?php
include_once dirname(__DIR__) . '/models.php';

class ViewerRepository {
    private string $IS_AUTH_KEY = 'is_auth';
    private string $ROLE_KEY = 'role';
    private string $ID_KEY = 'id';
    private string $LOGIN_KEY = 'login';

    function setIsAuth(bool $isAuth): void {
        $_SESSION[$this->IS_AUTH_KEY] = $isAuth;
    }

    function isAuth(): bool {
        return isset($_SESSION[$this->IS_AUTH_KEY]) && $_SESSION[$this->IS_AUTH_KEY];
    }

    function setId(int $id): void {
        $_SESSION[$this->ID_KEY] = $id;
    }

    function getId(): int | null {
        if (isset($_SESSION[$this->ID_KEY])) {
            return (int)$_SESSION[$this->ID_KEY];
        } else {
            return null;
        }
    }

    function setLogin(string $login): void {
        $_SESSION[$this->LOGIN_KEY] = $login;
    }

    function getLogin(): string | null {
        return isset($_SESSION[$this->LOGIN_KEY]) ? $_SESSION[$this->LOGIN_KEY] : null;
    }
}