<?php
require __DIR__.'/_guard.php';
if($_SERVER['REQUEST_METHOD']!=='POST'){http_response_code(405);exit('Acción no permitida.');}
acp_verify_csrf();$id=(int)($_POST['id']??0);
if($id>0)try{$s=acp_db()->prepare('DELETE FROM evaluaciones WHERE id=?');$s->execute([$id]);acp_flash('success','Evaluación eliminada.');}catch(PDOException $e){error_log($e->getMessage());acp_flash('error','No fue posible eliminar.');}
acp_redirect('registros.php');
