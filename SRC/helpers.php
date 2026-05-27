<?php
declare(strict_types= 1);

// ingen hacker kan skicka in skadlig kod i våra formulär,
function e(mixed $value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

// skydda mot CSRF-attacker: skapa en hemlig token, för att verifiera formulär
function csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// skydda mot CSRF-attacker: säkerställ att formuläret skickades från vår egen sida.
function csrf_verify(): void { 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die('Invalid CSRF token');
        }
    }
}  

// skyddar inloggningssidan så att bara inloggade användare kan komma in.
function require_login(): void {
    if (empty($_SESSION['user_id'])) {
        header('Location: /login');
        exit;
    }               
}

// skyddar admin-panelen så att bara admin kan komma in.
function require_role(string $role): void {
    if (($_SESSION['role'] ?? '') !== $role) {
        http_response_code(403);
        die("403- Forbidden: You don't have permission to access this page.");
    }
}

?>