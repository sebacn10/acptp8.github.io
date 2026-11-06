<?php
function acp_user(): ?array {
    if (empty($_SESSION['usuario_id'])) return null;
    return ['id'=>(int)$_SESSION['usuario_id'], 'nombre'=>(string)($_SESSION['usuario_nombre']??'Usuario'),
            'rol'=>(string)($_SESSION['rol']??'usuario')];
}
function acp_require_login(): void {
    if (!acp_user()) {
        $prefix = str_contains((string)($_SERVER['SCRIPT_NAME'] ?? ''), '/admin/') ? '../' : '';
        acp_redirect($prefix . 'login.php?error=acceso_denegado');
    }
}
function acp_require_admin(): void {
    acp_require_login();
    // Verificar el rol actual en la base, no confiar solamente en la sesión antigua.
    try {
        if (!function_exists('acp_db')) require_once __DIR__.'/database.php';
        $q=acp_db()->prepare('SELECT rol FROM usuarios WHERE id=? LIMIT 1');
        $q->execute([(int)$_SESSION['usuario_id']]);
        $rol=$q->fetchColumn();
        if ($rol===false) {$_SESSION=[];acp_redirect('../login.php?error=acceso_denegado');}
        $_SESSION['rol']=(string)$rol;
    } catch (PDOException $e) {
        error_log('ACP rol administrador: '.$e->getMessage());
        http_response_code(503); exit('No se pudo verificar el acceso al administrador. Revisá MySQL.');
    }
    if (($_SESSION['rol']??'usuario') !== 'admin') {
        http_response_code(403);
        require dirname(__DIR__).'/includes/access_denied.php';
        exit;
    }
}
