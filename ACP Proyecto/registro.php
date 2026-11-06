<?php
require_once __DIR__.'/includes/database.php';
if (acp_user()) acp_redirect('panel.php');
$titulo_pagina='Crear cuenta'; $errors=[];
$nombre=trim((string)($_POST['nombre']??'')); $email=trim((string)($_POST['email']??''));
if ($_SERVER['REQUEST_METHOD']==='POST') {
    acp_verify_csrf(); $pass=(string)($_POST['password']??''); $confirm=(string)($_POST['confirm_password']??'');
    if (mb_strlen($nombre)<2 || mb_strlen($nombre)>100) $errors[]='Ingresá un nombre de 2 a 100 caracteres.';
    if (!filter_var($email,FILTER_VALIDATE_EMAIL) || mb_strlen($email)>190) $errors[]='Ingresá un correo válido.';
    if (strlen($pass)<8) $errors[]='La contraseña debe tener al menos 8 caracteres.';
    if ($pass!==$confirm) $errors[]='Las contraseñas no coinciden.';
    if (!$errors) {
        try {
            $db=acp_db();
            $check=$db->prepare('SELECT id FROM usuarios WHERE email = ? LIMIT 1');$check->execute([$email]);
            if ($check->fetch()) $errors[]='El correo ya está registrado.';
            else {
                $stmt=$db->prepare('INSERT INTO usuarios (nombre,email,password,rol) VALUES (?,?,?,?)');
                $stmt->execute([$nombre,$email,password_hash($pass,PASSWORD_DEFAULT),'usuario']);
                acp_flash('success','Cuenta creada. Ya podés iniciar sesión.');acp_redirect('login.php');
            }
        } catch(PDOException $e) {error_log('ACP registro: '.$e->getMessage());$errors[]='No se pudo registrar. Comprobá la conexión con la base de datos.';}
    }
}
require __DIR__.'/includes/header.php'; ?>
<main class="auth-layout"><section class="auth-side"><span class="eyebrow">TP8 · CUENTAS Y SESIONES</span><h1>Participá del seguimiento del proyecto.</h1><p>Creá una cuenta para registrar evaluaciones del prototipo y consultar tus aportes.</p><img src="img/imagen arduino 2.png" alt="Arduino y electrónica"></section>
<section class="auth-card"><h2>Crear cuenta</h2><p>Todos los campos son obligatorios.</p>
<?php foreach($errors as $error): ?><div class="flash error" role="alert"><?=acp_e($error)?></div><?php endforeach; ?>
<form method="post" action="registro.php" autocomplete="on" class="stack-form"><?=acp_csrf_input()?>
<label for="nombre">Nombre completo</label><input id="nombre" name="nombre" required minlength="2" maxlength="100" autocomplete="name" value="<?=acp_e($nombre)?>">
<label for="email">Correo electrónico</label><input id="email" name="email" type="email" required maxlength="190" autocomplete="email" value="<?=acp_e($email)?>">
<label for="password">Contraseña</label><input id="password" type="password" name="password" required minlength="8" autocomplete="new-password"><small>Como mínimo, 8 caracteres.</small>
<label for="confirm_password">Repetir contraseña</label><input id="confirm_password" name="confirm_password" type="password" required minlength="8" autocomplete="new-password">
<button class="button" type="submit">Crear mi cuenta</button></form><p>¿Ya tenés cuenta? <a href="login.php">Iniciá sesión</a></p></section></main>
<?php require __DIR__.'/includes/footer.php'; ?>
