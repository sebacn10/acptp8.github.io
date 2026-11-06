<?php
require_once __DIR__.'/includes/database.php';
if (acp_user()) acp_redirect('panel.php');
$titulo_pagina='Iniciar sesión';$errors=[];$email=trim((string)($_POST['email']??''));
if ($_SERVER['REQUEST_METHOD']==='POST') {
    acp_verify_csrf();
    try {
        $s=acp_db()->prepare('SELECT id,nombre,email,password,rol FROM usuarios WHERE email=? LIMIT 1');$s->execute([$email]);$u=$s->fetch();
        if (!$u || !password_verify((string)($_POST['password']??''),$u['password'])) {
            $errors[]='Correo o contraseña incorrectos.';
        } else {
            session_regenerate_id(true);
            $_SESSION['usuario_id']=(int)$u['id'];
            $_SESSION['usuario_nombre']=$u['nombre'];
            $_SESSION['rol']=$u['rol'];
            $_SESSION['login_at']=time();
            acp_redirect('panel.php');
        }
    } catch(PDOException $e) {error_log('ACP login: '.$e->getMessage());$errors[]='No se pudo iniciar sesión. Revisá la conexión de MySQL.';}
}
require __DIR__.'/includes/header.php'; ?>
<main class="auth-layout"><section class="auth-side"><span class="eyebrow">AUTENTICACIÓN SEGURA · TP8</span><h1>Bienvenido de nuevo.</h1><p>Ingresá para consultar el estado de tus registros y acceder a las herramientas del proyecto.</p><img src="img/chicos robotica 2.jpg" alt="Estudiantes de robótica"></section>
<section class="auth-card"><h2>Iniciar sesión</h2><?php if(isset($_GET['error']) && $_GET['error']==='acceso_denegado'): ?><div class="flash error">Primero necesitás iniciar sesión para acceder a esa página.</div><?php endif; ?>
<?php foreach($errors as $error): ?><div class="flash error" role="alert"><?=acp_e($error)?></div><?php endforeach; ?>
<form method="post" action="login.php" class="stack-form"><?=acp_csrf_input()?>
<label for="email">Correo electrónico</label><input id="email" name="email" type="email" required autocomplete="username" value="<?=acp_e($email)?>">
<label for="password">Contraseña</label><input id="password" name="password" type="password" required autocomplete="current-password">
<button class="button" type="submit">Ingresar</button></form><p>¿No tenés cuenta? <a href="registro.php">Registrate</a></p></section></main>
<?php require __DIR__.'/includes/footer.php'; ?>
