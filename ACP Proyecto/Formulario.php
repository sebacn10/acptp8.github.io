<?php
require_once __DIR__.'/includes/database.php';
acp_require_login();
$titulo_pagina='Evaluar el prototipo';$errors=[];
$nombre=trim((string)($_POST['nombre_apellido']??acp_user()['nombre']));
$correo=trim((string)($_POST['correo']??''));
$opinion=trim((string)($_POST['opinion_funcionamiento']??''));
if ($_SERVER['REQUEST_METHOD']==='POST') {
    acp_verify_csrf();
    if(mb_strlen($nombre)<2 || mb_strlen($nombre)>120)$errors[]='Escribí tu nombre y apellido.';
    if(!filter_var($correo,FILTER_VALIDATE_EMAIL) || mb_strlen($correo)>190)$errors[]='Ingresá un correo válido.';
    if(mb_strlen($opinion)<10 || mb_strlen($opinion)>3000)$errors[]='La evaluación debe tener entre 10 y 3000 caracteres.';
    if(!$errors)try {
        $s=acp_db()->prepare('INSERT INTO evaluaciones (usuario_id,nombre_apellido,correo,opinion_funcionamiento,estado_id) VALUES (?,?,?,?,1)');
        $s->execute([acp_user()['id'],$nombre,$correo,$opinion]);
        acp_flash('success','Evaluación registrada correctamente en MySQL.');acp_redirect('panel.php');
    }catch(PDOException $e){error_log('ACP formulario: '.$e->getMessage());$errors[]='No pudimos guardar el registro. Revisá MySQL.';}
}
require __DIR__.'/includes/header.php';?>
<main class="page-main"><section class="page-heading"><span class="eyebrow">TP5 · FORMULARIO POST</span><h1>Registro de funcionamiento</h1><p>Evaluá el comportamiento del techo automatizado. Tus observaciones se guardarán de forma segura en MySQL.</p></section>
<section class="content-card form-page"><h2>Contanos cómo funcionó el prototipo</h2>
<?php foreach($errors as $error):?><div class="flash error" role="alert"><?=acp_e($error)?></div><?php endforeach;?>
<form method="post" action="Formulario.php" class="stack-form"><?=acp_csrf_input()?>
<label for="nombre-apellido">Nombre y apellido</label><input id="nombre-apellido" name="nombre_apellido" required minlength="2" maxlength="120" value="<?=acp_e($nombre)?>">
<label for="correo">Correo electrónico</label><input id="correo" type="email" name="correo" required maxlength="190" value="<?=acp_e($correo)?>">
<label for="opinion-funcionamiento">¿Qué tal funcionó el programa y el techo?</label><textarea id="opinion-funcionamiento" name="opinion_funcionamiento" required minlength="10" maxlength="3000" rows="6" placeholder="Describí la respuesta del sensor, el movimiento del motor y qué mejorarías."><?=acp_e($opinion)?></textarea>
<button class="button" type="submit">Guardar evaluación</button></form></section></main>
<?php require __DIR__.'/includes/footer.php';?>
