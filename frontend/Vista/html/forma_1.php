4<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>Cuestionario</title>
	<meta charset="utf-8">
	<!-- <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/bootstrap.min.css"> -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/all.css">
	<link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/minisitio.css">
	<link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/sweetalert.v2.css">
	<link rel="icon" type="image/x-icon" href="<?php echo PUERTO."://".HOST;?>/imagenes/favicon.ico">
</head>
<body>
	<?php 

	$user_agent = $_SERVER['HTTP_USER_AGENT'];

	function getBrowser($user_agent){

		if(strpos($user_agent, 'MSIE') !== FALSE)
			return 'Internet explorer';
		elseif(strpos($user_agent, 'Edge') !== FALSE) //Microsoft Edge
			return 'Microsoft Edge';
		elseif(strpos($user_agent, 'Trident') !== FALSE) //IE 11
			return 'Internet explorer 11';
		elseif(strpos($user_agent, 'Opera Mini') !== FALSE)
			return "Opera Mini";
		elseif(strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR') !== FALSE)
			return "Opera";
		elseif(strpos($user_agent, 'Firefox') !== FALSE)
			return 'Mozilla Firefox';
		elseif(strpos($user_agent, 'Chrome') !== FALSE)
			return 'Google Chrome';
		elseif(strpos($user_agent, 'Safari') !== FALSE)
			return "Safari";
		else
			return 'No hemos podido detectar su navegador';
	}


	$navegador = getBrowser($user_agent);

	 ?>

<?php if(!isset($show_banner) && !isset($breadcrumbs)){ ?>
  <?php } ?>
    <!--mensajes de error y exito-->
    <?php if (isset($sess_err_msg) && !empty($sess_err_msg)){?>
      <div align="center" id="alerta" style="display:" class="alert alert-danger" role="alert">
        <strong><?php echo $sess_err_msg;?></strong>
      </div>  
    <?php }?>

    <?php if (isset($sess_suc_msg) && !empty($sess_suc_msg)){?>
      <div align="center" id="alerta" style="display:" class="alert alert-success" role="alert">
        <strong><?php echo $sess_suc_msg;?></strong>
      </div>  
    <?php } ?>
<div class="container">

	<div class="col-md-12">
		<div class="text-center">
			<br>
			<div class="con_encabezado">
				<span class="encabezado">Usted ha optado por el <b>MÉTODO DE DOBLE CLICK</b>. Ordene de 1 a 5 las oraciones en cada pregunta. En donde 1 es la oración con la que más se identifica y 5 con la que menos se identifica. El Test CANEA consta de 20 preguntas.</span><br><br><h3 class="metodoTexto"><b>Método seleccionado: </b>Doble click<img style="width: 3%;" src="<?php echo PUERTO.'://'.HOST.'/imagenes/metodoSel/1.png'; ?>"></h3></span>
			</div>
			<br>
		</div>
		<div class="">
			<div class="">
				<form action="<?php echo PUERTO."://".HOST;?>/registroresp/" method="post" id="forma_1">
					<div class="respuestas" id="respuestas" style="display: none;"></div>
					<input type="hidden" name="id_usuario" value="<?php echo $_SESSION['id_usuario']; ?>">
					<input type="hidden" name="tiempo" id="tiempo" value="<?php echo $tiempo; ?>">
					 <?php 
						$array_group = array();

						foreach ($data as $key => $value) {
						 $array_group[$value['id_pregunta']][$key] = $value;
						}
            
            switch($faceta){
            	case 1:
            	  $indice = 1;
            	break;
            	case 2:
            	  $indice = 5;
            	break;
            	case 3:
            	  $indice = 9;
            	break;
            	case 4:
            	  $indice = 13;
            	break;
            	case 5:
            	  $indice = 17;
            	break;
            }
            
						shuffle($array_group);
						foreach ($array_group as $key => $value) {
							
							$pregunta = "";
							$pregunta = current($value);
							$actual = $value;

							echo "<div class='card'>";
							echo "<div class='error_msg'></div>";
							echo "<div class='card-header'><h5>Pregunta ".$indice."</h5></div>";
							echo "<div class='card-body'>";

									echo "<div class='contenedor_p'>";
									echo "<div class='row'>";
									$columna = "";
									if($navegador == "Safari"){
										$columna = "offset-md-3 ";
									}
									echo "<div class='".$columna."col-md-6'>";
									foreach ($actual as $key => $value) {
										echo "<div class='text_origen' id='nido_".$value['id_opcion']."'>";
										echo "<input type='hidden' name='opcion[]' value='".$value['id_opcion']."'>";
										echo "<label>".utf8_encode($value['descripcion'])."</label>";
										echo "</div><br><br>";
									}
									echo "</div>";
									echo "<div class='".$columna."col-md-6'>";
									$l = 1;
									foreach ($actual as $key => $value) {
										echo "<span class='order_priority'>".($l)."</span>";
										echo "<div class='text_destino'><input type='hidden' name='orden[]' value='".($l++)."'></div><br><br>";
									}

									echo "</div>";
									echo "</div>";
									echo "</div>";




							echo "</div>";
							echo "</div>";
							echo "<br><br>";
							$indice++;
						}
					  ?>
					 <div class="row text-center">
					 	 <div class="col-md-12">
					     <input type="submit" name="" value="Guardar" class="btn-blue">
					   </div>
					 </div>
				</form>
			</div>
		</div>
	</div>
</div>
<input type="text" hidden id="puerto_host" value="<?php echo PUERTO."://".HOST ;?>">
<br><br>
<?php 
	if($faceta == 1){
?>
<div class="modal fade" tabindex="-1" id="modal_recomendaciones" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    	<div class="text-center">
      	<h1 class="qs-subt-1">RECOMENDACIONES</h1>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12" style="text-align: justify;">  
             <span class="contenido-modal-rec">Para obtener mayor efectividad en la búsqueda de empleo, le invitamos a completar el siguiente <b>TEST DE COMPETENCIAS</b>. ¡Recuerde! los test no son una pérdida de tiempo, mucho menos si el reclutador tiene claro cómo utilizar esta herramienta.</span><br><br>
            <ul>
            	<li class="contenido-modal-list">Prepárese. Mantenga una actitud tranquila.</li>
            	<li class="contenido-modal-list">Sea sincero, no pierda credibilidad</li>
            	<li class="contenido-modal-list">Lea las instrucciones.</li>
            	<li class="contenido-modal-list">Domine los nervios.</li>
            	<li class="contenido-modal-list">Sea usted mismo.</li>
            	<li class="contenido-modal-list">Solo se puede acceder una sola vez.</li>
            	<li class="contenido-modal-list">Después enviar el test no podrá realizar ningún tipo de corrección.</li>
            </ul>   
            <br>
            <br>    
            <center>
              <button type="button" class="btn-blue" data-dismiss="modal">Iniciar Test</button>
            </center> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
}
?>
<?php 
 
/*if($navegador == 'Internet explorer'){
	echo '<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.3.1/jquery.min.js"></script>
	<script src="'.PUERTO."://".HOST.'/js/jquery-ui-1.8.23.js"></script>
	<script src="'.PUERTO."://".HOST.'/js/modos_respuesta.js"></script>';
}else{*/
	echo '<script src="'.PUERTO."://".HOST.'/js/assets/js/vendor/jquery-3.0.0.js"></script>
	<script type="text/javascript" src="'.PUERTO."://".HOST.'/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="'.PUERTO."://".HOST.'/js/jquery-ui-1.12.1.js"></script>
	<script type="text/javascript" src="'.PUERTO."://".HOST.'/js/sweetalert.v2.js"></script>
	<script src="<?php echo PUERTO."://".HOST;?>/js/jquery.ui.touch-punch.min.js"></script>
	<script type="text/javascript" src="'.PUERTO."://".HOST.'/js/double-tap.js"></script>
	<script type="text/javascript" src="'.PUERTO."://".HOST.'/js/modos_respuesta.js"></script>';
//}
?>
</body>
</html>