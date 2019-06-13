<!DOCTYPE html>
<html>
<head>
	<title>Cuestionario</title>
	<meta charset="utf-8">
	<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> -->
	<!-- <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/bootstrap.min.css"> -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/all.css">
	<link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/minisitio.css">
	<link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/sweetalert.v2.css">
	<link rel="icon" type="image/x-icon" href="<?php echo PUERTO."://".HOST;?>/imagenes/favicon.ico">
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
				<span class="encabezado">Por favor ordene de 1 a 5 las siguientes oraciones en cada pregunta. (1 es la oración con la que mas se identifica y 5 es con la que menos se identifica). Este test consta de 20 preguntas<br><br><h3 class="metodoTexto"><b>Método seleccionado: </b>Seleccionar y arrastrar<img style="width: 3%;" src="<?php echo PUERTO.'://'.HOST.'/imagenes/metodoSel/2.png'; ?>"></h3></span>
			</div>
			<br>
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
					     <input type="submit" name="" value="Guardar" class="btn-blue">
					   </div>
					 </div>
				</form>
			</div>
		</div>
	</div>
</div>
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
             <span class="contenido-modal-rec">Para obtener mayor efectividad en su búsqueda de empleo, le invitamos a llenar el siguiente <b>Test de Personalidad</b>. Por favor, tome en cuenta las siguientes recomendaciones:<br></span>
            <ul>
            	<li class="contenido-modal-rec">Para obtener mejores resultados debe completar el Test CANEA en el menor tiempo posible, sin embargo no tiene límite fijado. </li>
            	<li class="contenido-modal-list">Busque un lugar tranquilo para que pueda completar el test.</li>
            	<li class="contenido-modal-list">Apague celulares o aparatos que puedan distraerlo.</li>
            	<li class="contenido-modal-list">Conteste de forma honesta y precisa. <b>Solo puede acceder una vez.</b></li>
            	<li class="contenido-modal-list">Al enviar no podrá realizar ningún tipo de corrección.</li>
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
<input type="text" hidden id="puerto_host" value="<?php echo PUERTO."://".HOST ;?>">
<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/vendor/jquery-3.0.0.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/sweetalert.v2.js"></script>
<!-- <script src="<?php echo PUERTO."://".HOST;?>/js/minisitio.js"></script> -->
<script src="<?php echo PUERTO."://".HOST;?>/js/jquery.ui.touch-punch.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/modos_respuesta.js"></script>

</body>
</html>