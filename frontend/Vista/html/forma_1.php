<!DOCTYPE html>
<html>
<head>
	<title>Cuestionario</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	<link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/minisitio.css">
</head>
<body>

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
			<h4 style="text-align:justify;">Por favor ordene de 1 a 5 las siguientes oraciones en cada pregunta (1 es la oración con la que mas se identifica y 5 es con la que menos se identifica)</h4>
		</div>
		<div class="">
			<div class="">
				<form action="<?php echo PUERTO."://".HOST;?>/registroresp/" method="post" id="forma_1">
					<div class="respuestas" id="respuestas" style="display: none;"></div>
					<input type="hidden" name="id_usuario" value="<?php echo $_SESSION['id_usuario']; ?>">
					<input type="hidden" name="tiempo" id="tiempo" value="<?php echo $tiempo; ?>">
					<?php
					$i = 1;
					$j = 1;
					$preg_ant = 0;
					foreach ($data as $cuestionario){
						if($preg_ant != $cuestionario['id_pregunta']){
							$j = 1;
							echo "</div>";
							echo "</div>";
							echo "<div class='card-header'>";
							echo "<div class='error_msg'></div>";
							echo "<label>Pregunta&nbsp;".$cuestionario['id_pregunta']."</label>";
							echo "</div>";
							echo "<div class='card-body'>";
							echo "<div class='contenedor_p'>";
							$preg_ant = $cuestionario['id_pregunta'];
						}
						?>
							<div class="row text-justify">
								<div class="col-md-6">
									<div class="text_origen">
										<input type="hidden" name="opcion[]" value="<?php echo $cuestionario['id_opcion']; ?>">
										<label><?php echo utf8_encode($cuestionario['descripcion']); ?></label>
									</div><br>
								</div>
								<div class="col-md-6">
									<span class="order_priority"><?php echo $j; ?></span>
									
									<div class="text_destino">
										<input type="hidden" name="orden[]" value="<?php echo $j; ?>">
									</div><br>
								</div>
							</div>
						<?php
							$i++;
							$j++;
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

<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/vendor/jquery-3.0.0.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- <script src="<?php echo PUERTO."://".HOST;?>/js/minisitio.js"></script> -->
<script src="<?php echo PUERTO."://".HOST;?>/js/modos_respuesta.js"></script>
</body>
</html>