<?php
require __DIR__.'/_guard.php';$titulo_pagina='Administración';
try{$db=acp_db();$usuarios=(int)$db->query('SELECT COUNT(*) FROM usuarios')->fetchColumn();$evaluaciones=(int)$db->query('SELECT COUNT(*) FROM evaluaciones')->fetchColumn();$pendientes=(int)$db->query('SELECT COUNT(*) FROM evaluaciones WHERE estado_id=1')->fetchColumn();}catch(PDOException $e){$usuarios=$evaluaciones=$pendientes=0;error_log($e->getMessage());}
require dirname(__DIR__).'/includes/header.php';?>
<main class="page-main"><section class="page-heading"><span class="eyebrow">PANEL DE ADMINISTRACIÓN · TP7/8</span><h1>Gestión del proyecto</h1><p>Control de evaluaciones, usuarios y seguimiento técnico.</p></section>
<div class="metric-grid"><article><small>Usuarios</small><strong><?=$usuarios?></strong></article><article><small>Evaluaciones registradas</small><strong><?=$evaluaciones?></strong></article><article><small>Pendientes</small><strong><?=$pendientes?></strong></article></div>
<div class="quick-grid"><a class="quick-card" href="registros.php"><strong>Administrar evaluaciones</strong><span>Buscar, editar el estado y eliminar registros ↗</span></a><a class="quick-card" href="usuarios.php"><strong>Ver usuarios</strong><span>Consultar nombres y roles del sistema ↗</span></a><a class="quick-card" href="../Formulario.php"><strong>Nueva evaluación</strong><span>Ir al formulario de seguimiento ↗</span></a></div>
</main><?php require dirname(__DIR__).'/includes/footer.php';?>
