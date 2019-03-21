<!DOCTYPE html>
<html>
<head>
	<title>Cuestionario</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	<link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/minisitio.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>
<body class="window_body">
<?php 

$user_agent = $_SERVER['HTTP_USER_AGENT'];

function getBrowser($user_agent){

  if(strpos($user_agent, 'MSIE') !== FALSE)
    return 'MSIE';
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
		<br>
		<div class="text-center">
			<br>
			<div class="con_encabezado">
				<span class="encabezado">Por favor ordene de 1 a 5 las siguientes oraciones en cada pregunta. (1 es la oración con la que mas se identifica y 5 es con la que menos se identifica). Este cuestionario consta de 20 preguntas</span>
			</div>
		</div>
		<div class="">
			<div class="">
				<form action="<?php echo PUERTO."://".HOST;?>/registroresp/" method="post" id="forma_2">
					<div class="respuestas" id="respuestas" style="display: none;"></div>
					<input type="hidden" name="id_usuario" value="<?php echo $_SESSION['id_usuario']; ?>">
					<input type="hidden" name="tiempo" id="tiempo" value="<?php echo $tiempo; ?>">
					
					<?php 
						$columna = "";
						if($navegador == "Safari"){
							$columna = "offset-md-3 ";
						}
						
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
							echo "<div class='error_msg' id='error".$indice."'></div>";
							echo "<div class='card-header'><h5>Pregunta ".$indice."</h5></div>";
							echo "<div class='card-body'>";

								echo "<div class='contenedor_p_".$pregunta['id_pregunta']."''>";
								echo "<div class='row'>";
                echo "<div class='".$columna."col-md-6'>";
								foreach ($actual as $key => $value) {
									echo "<div class='contenedor_drag'>";
									echo "<div class='drag_origen' id='nido_".$value['id_opcion']."'>";
									echo "<input type='hidden' name='opcion[]' value='".$value['id_opcion']."'>";
									echo "<label>".utf8_encode($value['descripcion'])."</label>";
									echo "</div>";
									echo "</div><br><br>";
								}
								echo "</div>";

								echo "<div class='col-md-6'>";
								$l = 1;
								foreach ($actual as $key => $value) {
									echo "<span class='order_priority'>".($l)."</span>";
									echo "<div class='drop_destino'><input type='hidden' name='orden[]' value='".($l++)."'></div><br><br>";
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
					     <input type="submit" name="" value="Guardar" class="btn btn-success">
					   </div>
					 </div>
				</form>
			</div>
		</div>
	</div>
</div>
<br><br>

<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/vendor/jquery-3.0.0.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- <script src="<?php echo PUERTO."://".HOST;?>/js/minisitio.js"></script> -->
<script src="<?php echo PUERTO."://".HOST;?>/js/jquery.ui.touch-punch.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/modos_respuesta.js"></script>

</body>
</html>