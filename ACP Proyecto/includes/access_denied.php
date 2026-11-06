<?php
$titulo_pagina='Acceso denegado';
require dirname(__DIR__).'/includes/header.php';
?>
<section class="notice-card"><span class="eyebrow">ACCESO RESTRINGIDO</span><h1>No tenés permiso para entrar</h1><p>Esta sección está reservada a usuarios con rol administrador.</p><a class="button" href="panel.php">Volver a mi panel</a></section>
<?php require dirname(__DIR__).'/includes/footer.php'; ?>
