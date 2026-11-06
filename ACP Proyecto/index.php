<?php $titulo_pagina='Techo Automatizado con Arduino | Proyecto EET N°3100'; require __DIR__.'/includes/header.php'; ?>
<main class="page-main">
<section class="home-hero"><div><span class="eyebrow">PROYECTO DE AUTOMATIZACIÓN · EET N.º 3100</span><h1>Un techo inteligente que responde a la lluvia.</h1><p>Diseño y desarrollo de un techo corredizo automatizado con Arduino, sensores y un sistema motorizado para proteger la ropa ante cambios del clima.</p><div class="cta-row"><a class="button" href="Proyecto.php">Conocer el proyecto</a><a class="button outline" href="Formulario.php">Registrar evaluación</a></div></div><img src="img/imagen arduino.jpg" alt="Proyecto técnico con placa Arduino"></section>
<section class="content-card"><h2>Galería del proyecto</h2><p>Imágenes del proceso de aprendizaje y construcción.</p><div class="gallery-wrapper">
<h2>Galería del Proyecto de Robótica</h2>
<div class="galeria-container">
<button class="galeria-btn" onclick="cambiarImagen(-1)">❮ Anterior</button>
<img alt="Estudiantes trabajando en proyectos de robótica en la escuela técnica" class="galeria-img" id="galeria-display" onclick="abrirLightbox()" src="img/chicos robotica.png"/>
<button class="galeria-btn" onclick="cambiarImagen(1)">Siguiente ❯</button>
</div>
</div>
<div class="main-presentation">
<h1>PRESENTACION</h1>
<p> Este proyecto consiste en un techo corredizo automatizado diseñado para proteger la ropa colgada de la lluvia. Utilizando un sensor de agua, el sistema al detectar la presencia de humedad activa el mecanismo para desplegar el techo, asegurando que la ropa se mantenga seca. </p>
<div class="details-block">
<h2>Funcionamiento Técnico del Techo Inteligente</h2>
<p>La problemática planteada surge del imprevisto cambio climático cotidiano. Con frecuencia, las precipitaciones sorpresivas mojan las prendas colgadas al aire libre. La automatización mediante la plataforma Arduino ofrece una alternativa práctica, económica y sumamente eficiente.</p>
<p>El circuito utiliza un módulo detector de gotas de lluvia configurado con umbrales de sensibilidad precisos. Tan pronto como las primeras gotas tocan la superficie del sensor, la placa procesa la señal analógica y envía la orden correspondiente a la etapa de potencia de los motores, logrando el despliegue del cobertor protector de forma inmediata.</p>
</div>
</div></section><section class="quick-grid"><a class="quick-card" href="Recursos.php"><strong>Componentes</strong><span>Conocé los sensores y materiales utilizados ↗</span></a><a class="quick-card" href="Curso.php"><strong>Aprendé Arduino</strong><span>Introducción a la electrónica y la programación ↗</span></a><a class="quick-card" href="panel.php"><strong>Seguimiento</strong><span>Consultá tus evaluaciones y registros ↗</span></a></section>
</main>
<?php require __DIR__.'/includes/footer.php'; ?>
