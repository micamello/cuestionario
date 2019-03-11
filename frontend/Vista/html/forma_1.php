<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>Cuestionario</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/all.css">
	<link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/minisitio.css">
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
			<h4 style="text-align:justify;">Por favor ordene de 1 a 5 las siguientes oraciones en cada pregunta. (1 es la oración con la que mas se identifica y 5 es con la que menos se identifica). Este cuestionario consta de 20 preguntas</h4>
		</div>
		<div class="">
			<div class="">
				<form action="<?php echo PUERTO."://".HOST;?>/registroresp/" method="post" id="forma_1">
					<div class="respuestas" id="respuestas" style="display: none;"></div>
					<input type="hidden" name="id_usuario" value="<?php echo $_SESSION['id_usuario']; ?>">
					<input type="hidden" name="tiempo" id="tiempo" value="<?php echo $tiempo; ?>">
					 <?php 
						$pregunta_inicial = array_values($data)[0]['id_pregunta'];
						$array_group = array();

						foreach ($data as $key => $value) {
						 $array_group[$value['id_pregunta']][$key] = $value;
						}

						$k = $pregunta_inicial;
						$e = 0;

						for ($i=0; $i < count($array_group); $i++) {
							echo "<div class='card'>";
							echo "<div class='error_msg'></div>";
							echo "<div class='card-header'><h5>Pregunta ".$k."</h5></div>";
							echo "<div class='card-body'>";

									echo "<div class='contenedor_p'>";
									echo "<div class='row'>";
									$columna = "";
									if($navegador == "Safari"){
										$columna = "offset-md-3 ";
									}
									echo "<div class='".$columna."col-md-6'>";
										for ($j= 0; $j < count($array_group[$k]) ; $j++) { 
											echo "<div class='text_origen' id='nido_".$array_group[$k][$e]['id_opcion']."'>";
											echo "<input type='hidden' name='opcion[]' value='".$array_group[$k][$e]['id_opcion']."'>";
											echo "<label>".utf8_encode($array_group[$k][$e]['descripcion'])."</label>";
											echo "</div><br><br>";
											$e++;




										}
									echo "</div>";
									echo "<div class='".$columna."col-md-6'>";
										for ($l= 0; $l < count($array_group[$k]) ; $l++) { 
											echo "<span class='order_priority'>".($l+1)."</span>";
											// echo "cajas<br>";
											echo "<div class='text_destino'><input type='hidden' name='orden[]' value='".($l+1)."'></div><br><br>";
										}
									$k++;
									echo "</div>";
									echo "</div>";
									echo "</div>";




							echo "</div>";
							echo "</div>";
							echo "<br><br>";
						}
					  ?>
					 <div class="row text-center">
					 	 <div class="col-md-12">
					     <input type="submit" name="" value="Guardar" class="btn btn-success">
					   </div>
					 </div>
				</form>
			</div>
		</div>
	</div>
</div>

<br><br>
<?php 
 
if($navegador == 'Internet explorer'){
	echo '<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.3.1/jquery.min.js"></script>
	<script src="'.PUERTO."://".HOST.'/js/jquery-ui-1.8.23.js"></script>
	<script type="text/javascript" src="https://www.micamello.com.ec/ruleta/js/modos_respuesta.js"></script>';
}else{
	echo '<script type="text/javascript" src="https://www.micamello.com.ec/ruleta/js/jquery-3.0.0.js"></script>
	<script type="text/javascript" src="'.PUERTO."://".HOST.'/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="'.PUERTO."://".HOST.'/js/jquery-ui-1.12.1.js"></script>
	<script type="text/javascript" src="'.PUERTO."://".HOST.'/js/double-tap.js"></script>
	<script type="text/javascript" src="'.PUERTO."://".HOST.'/js/modos_respuesta_nomovil.js"></script>';
}
?>
</body>
</html>