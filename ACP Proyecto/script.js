/* ACP Proyecto - JS unificado. Seguridad y validación final: servidor PHP. */
(() => {
  'use strict';
  const $ = (s) => document.querySelector(s);
  const menuBtn=$('.nav-toggle');
  if (menuBtn) menuBtn.addEventListener('click',()=> {
    const open=$('#navlinks')?.classList.toggle('open'); menuBtn.setAttribute('aria-expanded',String(Boolean(open)));
  });
  document.querySelectorAll('form[data-confirm]').forEach(form=>{
    form.addEventListener('submit', event=>{
      if(!window.confirm(form.getAttribute('data-confirm')||'¿Confirmar?'))event.preventDefault();
    });
  });
  const reveal=new IntersectionObserver(entries=>{
    entries.forEach(entry=>{if(entry.isIntersecting){entry.target.classList.add('shown');reveal.unobserve(entry.target);}});
  },{threshold:0.08});
  document.querySelectorAll('.content-card,.quick-card,.home-hero,.page-heading,.auth-card').forEach(el=>{el.classList.add('reveal');reveal.observe(el);});
  // Galería heredada de la presentación original.
  const imagenes=['img/chicos robotica.png','img/chicos robotica 2.jpg','img/chico robotica 3.jpg','img/chicos robotica 4.png'];
  let indice=0;
  window.cambiarImagen=(d)=>{indice=(indice+d+imagenes.length)%imagenes.length;const im=$('#galeria-display');if(im)im.src=imagenes[indice];};
  window.abrirLightbox=()=>{const im=$('#galeria-display'),modal=$('#lightbox'),destino=$('#lightbox-img');if(!im||!modal||!destino)return;destino.src=im.src;modal.classList.add('show');};
  window.cerrarLightbox=()=>$('#lightbox')?.classList.remove('show');
  window.toggleMenu=()=>$('#navlinks')?.classList.toggle('open');
  document.addEventListener('keydown',e=>{if(e.key==='Escape')window.cerrarLightbox();});
  // Hora local del navegador, si se utiliza el elemento.
  const reloj=$('#fecha-hora');if(reloj){const actualizar=()=>{reloj.textContent=new Intl.DateTimeFormat('es-AR',{dateStyle:'medium',timeStyle:'medium',timeZone:'America/Argentina/Buenos_Aires'}).format(new Date())};actualizar();setInterval(actualizar,1000);}
})();
