<?php
require_once __DIR__.'/bootstrap.php';
$titulo_pagina = $titulo_pagina ?? 'Proyecto Techo Automatizado';
$current = basename((string)($_SERVER['SCRIPT_NAME'] ?? 'index.php'));
$prefix = str_contains(str_replace('\\','/',(string)($_SERVER['SCRIPT_NAME'] ?? '')), '/admin/') ? '../' : '';
$user = acp_user();
$links = ['index.php'=>'Inicio','Proyecto.php'=>'Proyecto','Recursos.php'=>'Recursos','Profesores.php'=>'Profesores','Colegio.php'=>'Colegio','Alumnos.php'=>'Alumnos','Opinion.php'=>'Opinión','Formulario.php'=>'Evaluar'];
?><!doctype html>
<html lang="es"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Portal del proyecto escolar de techo corredizo automático con Arduino - EET N°3100.">
<title><?=acp_e($titulo_pagina)?> | ACP Proyecto</title>
<link rel="stylesheet" href="<?=acp_e($prefix)?>estilos.css?v=2026-11-acp8">
<script src="<?=acp_e($prefix)?>script.js?v=2026-11-acp8" defer></script>
</head>
<body>
<header class="site-header">
  <div class="nav-shell">
    <a class="brand" href="<?=acp_e($prefix)?>index.php"><span class="brand-logo">A</span><span><strong>ACP Proyecto</strong><small>EET N.º 3100 · Automatización</small></span></a>
    <button class="nav-toggle" type="button" aria-controls="navlinks" aria-expanded="false">☰ Menú</button>
    <nav class="navlinks" id="navlinks" aria-label="Navegación principal">
    <?php foreach($links as $path=>$label): ?>
      <a class="<?=$current===$path?'active':''?>" href="<?=acp_e($prefix.$path)?>" <?=$current===$path?'aria-current="page"':''?>><?=acp_e($label)?></a>
    <?php endforeach; ?>
    </nav>
    <div class="user-actions">
    <?php if ($user): ?>
      <a class="small-button" href="<?=acp_e($prefix)?>panel.php">Mi panel</a>
      <?php if ($user['rol'] === 'admin'): ?><a class="small-button" href="<?=acp_e($prefix)?>admin/index.php">Admin</a><?php endif; ?>
      <form method="post" action="<?=acp_e($prefix)?>logout.php" class="inline-form"><?=acp_csrf_input()?><button type="submit" class="quiet-button">Salir</button></form>
    <?php else: ?>
      <a class="small-button" href="<?=acp_e($prefix)?>login.php">Ingresar</a><a class="small-button primary" href="<?=acp_e($prefix)?>registro.php">Registrarse</a>
    <?php endif; ?>
    </div>
  </div>
</header>
<div class="site-container">
<?php foreach(($_SESSION['flash']??[]) as $notice): ?>
  <div class="flash <?=acp_e($notice['type'])?>" role="status"><?=acp_e($notice['message'])?></div>
<?php endforeach; unset($_SESSION['flash']); ?>
