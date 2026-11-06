<?php
require_once __DIR__.'/includes/database.php';acp_require_login();$titulo_pagina='Mi panel';$registros=[];
try{$q=acp_db()->prepare('SELECT e.id,e.opinion_funcionamiento,e.created_at,er.nombre AS estado FROM evaluaciones e JOIN estados_revision er ON er.id=e.estado_id WHERE e.usuario_id=? ORDER BY e.created_at DESC LIMIT 30');$q->execute([acp_user()['id']]);$registros=$q->fetchAll();}catch(PDOException $e){error_log('ACP panel: '.$e->getMessage());acp_flash('error','No se pudieron cargar las evaluaciones.');}
require __DIR__.'/includes/header.php';?>
<main class="page-main"><section class="page-heading"><span class="eyebrow">MI ESPACIO · TP8</span><h1>Hola, <?=acp_e(acp_user()['nombre'])?></h1><p>Sesión iniciada con el rol <strong><?=acp_e(acp_user()['rol'])?></strong>. Tus registros quedan asociados a tu usuario.</p><div class="cta-row"><a class="button" href="Formulario.php">Nueva evaluación</a><?php if(acp_user()['rol']==='admin'):?><a class="button outline" href="admin/index.php">Administración</a><?php endif;?></div></section>
<section class="content-card"><h2>Mis últimas evaluaciones</h2><?php if(!$registros):?><p>Todavía no guardaste evaluaciones. <a href="Formulario.php">Crear la primera</a>.</p><?php else: ?>
<div class="responsive-table"><table><thead><tr><th>ID</th><th>Fecha</th><th>Estado</th><th>Observación</th></tr></thead><tbody>
<?php foreach($registros as $r):?><tr><td>#<?= (int)$r['id']?></td><td><?=acp_e($r['created_at'])?></td><td><span class="pill"><?=acp_e($r['estado'])?></span></td><td><?=acp_e(mb_strimwidth($r['opinion_funcionamiento'],0,150,'…'))?></td></tr><?php endforeach;?></tbody></table></div><?php endif;?></section></main>
<?php require __DIR__.'/includes/footer.php';?>
