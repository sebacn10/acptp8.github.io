<?php
require __DIR__.'/_guard.php';$titulo_pagina='Gestión de evaluaciones';
$q=trim((string)($_GET['buscar']??''));$estado=($_GET['estado']??'');$records=[];$estados=[];
try{
 $db=acp_db();$estados=$db->query('SELECT id,nombre FROM estados_revision ORDER BY id')->fetchAll();
 $sql='SELECT e.id,e.nombre_apellido,e.correo,e.opinion_funcionamiento,e.created_at,er.nombre AS estado,u.nombre AS usuario FROM evaluaciones e JOIN usuarios u ON u.id=e.usuario_id JOIN estados_revision er ON er.id=e.estado_id WHERE 1=1';$params=[];
 if($q!==''){$sql.=' AND (e.nombre_apellido LIKE ? OR e.correo LIKE ? OR e.opinion_funcionamiento LIKE ?)';$needle='%'.str_replace(['%','_'],['\\%','\\_'],$q).'%';$params=array_merge($params,[$needle,$needle,$needle]);}
 if($estado!=='' && ctype_digit((string)$estado)){$sql.=' AND e.estado_id=?';$params[]=(int)$estado;}
 $sql.=' ORDER BY e.created_at DESC LIMIT 150';$s=$db->prepare($sql);$s->execute($params);$records=$s->fetchAll();
}catch(PDOException $e){error_log('ACP administrar registros: '.$e->getMessage());acp_flash('error','No se pudieron cargar los registros.');}
require dirname(__DIR__).'/includes/header.php';?>
<main class="page-main"><section class="page-heading"><span class="eyebrow">TP5 · GET / TP7 · CRUD</span><h1>Evaluaciones registradas</h1><p>Buscá por nombre, correo o comentario; revisá el estado y administrá cada registro.</p><a class="text-link" href="index.php">← Volver al administrador</a></section>
<section class="content-card"><form method="get" action="registros.php" class="filter-form"><label>Buscar <input type="search" name="buscar" value="<?=acp_e($q)?>" placeholder="Nombre, correo o texto"></label><label>Estado <select name="estado"><option value="">Todos</option><?php foreach($estados as $e):?><option value="<?=(int)$e['id']?>" <?=$estado==(string)$e['id']?'selected':''?>><?=acp_e($e['nombre'])?></option><?php endforeach;?></select></label><button class="button" type="submit">Filtrar</button><a class="button outline" href="registros.php">Limpiar</a></form>
<div class="responsive-table"><table><thead><tr><th>ID</th><th>Nombre</th><th>Observación</th><th>Estado</th><th>Fecha</th><th>Acciones</th></tr></thead><tbody>
<?php foreach($records as $r):?><tr><td>#<?=(int)$r['id']?></td><td><strong><?=acp_e($r['nombre_apellido'])?></strong><small class="subtext"><?=acp_e($r['usuario'])?></small></td><td><?=acp_e(mb_strimwidth($r['opinion_funcionamiento'],0,95,'…'))?></td><td><span class="pill"><?=acp_e($r['estado'])?></span></td><td><?=acp_e($r['created_at'])?></td><td><a class="small-button" href="editar.php?id=<?=(int)$r['id']?>">Editar</a></td></tr><?php endforeach;?>
<?php if(!$records):?><tr><td colspan="6">No se encontraron registros.</td></tr><?php endif;?></tbody></table></div></section></main>
<?php require dirname(__DIR__).'/includes/footer.php';?>
