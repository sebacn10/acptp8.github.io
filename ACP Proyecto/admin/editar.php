<?php
require __DIR__.'/_guard.php';$titulo_pagina='Editar evaluación';$id=(int)($_GET['id']??$_POST['id']??0);if($id<1){http_response_code(404);exit('Registro inválido.');}
$db=acp_db();$st=$db->prepare('SELECT * FROM evaluaciones WHERE id=?');$st->execute([$id]);$record=$st->fetch();if(!$record){http_response_code(404);exit('No se encontró la evaluación.');}
$estados=$db->query('SELECT id,nombre FROM estados_revision ORDER BY id')->fetchAll();$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
 acp_verify_csrf();$texto=trim((string)($_POST['opinion_funcionamiento']??''));$estado=(int)($_POST['estado_id']??0);
 if(mb_strlen($texto)<10||mb_strlen($texto)>3000)$errors[]='El comentario debe tener entre 10 y 3000 caracteres.';
 if(!in_array($estado,array_column($estados,'id'),false))$errors[]='Seleccioná un estado válido.';
 if(!$errors){try{$s=$db->prepare('UPDATE evaluaciones SET opinion_funcionamiento=?,estado_id=? WHERE id=?');$s->execute([$texto,$estado,$id]);acp_flash('success','Evaluación actualizada correctamente.');acp_redirect('registros.php');}catch(PDOException $e){error_log($e->getMessage());$errors[]='No se pudo actualizar.';}}
 $record['opinion_funcionamiento']=$texto;$record['estado_id']=$estado;
}
require dirname(__DIR__).'/includes/header.php';?>
<main class="page-main"><section class="page-heading"><span class="eyebrow">TP7 · UPDATE</span><h1>Editar evaluación #<?=$id?></h1><a href="registros.php">← Volver al listado</a></section><section class="content-card form-page"><p><strong>Registrado por:</strong> <?=acp_e($record['nombre_apellido'])?> · <?=acp_e($record['correo'])?></p><?php foreach($errors as $e):?><div class="flash error"><?=acp_e($e)?></div><?php endforeach;?><form method="post" class="stack-form"><?=acp_csrf_input()?><input type="hidden" name="id" value="<?=$id?>"><label for="estado_id">Estado</label><select name="estado_id" id="estado_id"><?php foreach($estados as $e):?><option value="<?=(int)$e['id']?>" <?=(int)$record['estado_id']===(int)$e['id']?'selected':''?>><?=acp_e($e['nombre'])?></option><?php endforeach;?></select><label for="opinion">Observación</label><textarea id="opinion" name="opinion_funcionamiento" required minlength="10" maxlength="3000" rows="7"><?=acp_e($record['opinion_funcionamiento'])?></textarea><button class="button" type="submit">Guardar cambios</button></form><hr><form method="post" action="eliminar.php" class="inline-form" data-confirm="¿Eliminar definitivamente esta evaluación?"><?=acp_csrf_input()?><input type="hidden" name="id" value="<?=$id?>"><button class="button danger" type="submit">Eliminar evaluación</button></form></section></main>
<?php require dirname(__DIR__).'/includes/footer.php';?>
