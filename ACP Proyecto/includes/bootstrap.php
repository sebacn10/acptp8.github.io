<?php
// Configuración compartida - TP4/TP7/TP8
if (!defined('ACP_BOOTSTRAP')) {
    define('ACP_BOOTSTRAP', true);
    $envFile = dirname(__DIR__) . '/.env';
    $env = [];
    if (is_file($envFile)) {
        foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
            $line = trim($line);
            if ($line === '' || $line[0] === '#' || strpos($line, '=') === false) continue;
            [$key, $value] = explode('=', $line, 2);
            $env[trim($key)] = trim(trim($value), "\"'");
        }
    }
    function acp_env(string $key, string $default = ''): string {
        global $env;
        $v = getenv($key);
        return $v !== false ? (string)$v : (string)($env[$key] ?? $default);
    }
    function acp_e($value): string {
        return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
    function acp_url(string $to = 'index.php'): string { return $to; }
    function acp_redirect(string $url): void { header('Location: ' . $url, true, 303); exit; }
    function acp_flash(string $type, string $message): void { $_SESSION['flash'][] = ['type'=>$type, 'message'=>$message]; }
    function acp_csrf_token(): string {
        if (!isset($_SESSION['csrf']) || !is_string($_SESSION['csrf'])) $_SESSION['csrf']=bin2hex(random_bytes(32));
        return $_SESSION['csrf'];
    }
    function acp_csrf_input(): string { return '<input type="hidden" name="csrf" value="'.acp_e(acp_csrf_token()).'">'; }
    function acp_verify_csrf(): void {
        if (!hash_equals(acp_csrf_token(), (string)($_POST['csrf'] ?? ''))) {
            http_response_code(403); exit('Solicitud rechazada: token de seguridad inválido. Volvé a la página y actualizá.');
        }
    }
    if (session_status() !== PHP_SESSION_ACTIVE) {
        ini_set('session.use_strict_mode', '1');
        ini_set('session.use_only_cookies', '1');
        session_name('ACPSESSID');
        session_set_cookie_params([
            'lifetime'=>0, 'path'=>'/', 'secure'=>!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
            'httponly'=>true, 'samesite'=>'Lax'
        ]);
        session_start();
    }
    require_once __DIR__ . '/auth.php';
}
