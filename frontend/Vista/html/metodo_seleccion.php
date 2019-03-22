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
<!DOCTYPE html>
<html>
<head>
	<title>Selección de método</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/all.css">
	  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/minisitio.css">
</head>
<body>
<?php if($navegador == 'MSIE'){ ?>
<div align="center" id="mensaje" style="height: 150px;background: #c36262;"><br>
<h3>Usted esta usando internet explorer 8 o inferior</h3>
<p>Esta es una versi&oacute;n antigua del navegador, y puede afectar negativamente a su seguridad y su experiencia de navegaci&oacute;n.</p><p>Por favor, actualice a la version actual de IE o cambie de navegador ahora.</p>
<p><b><a href="https://www.microsoft.com/es-es/download/internet-explorer.aspx">Actualizar IE</a></b></p>
</div>
<?php } ?>
<form id="form_seleccion" action="<?php echo PUERTO."://".HOST;?>/test_reg_var/" method="post">
	<div class="">
		<div class="col-md-12">
			<br><br>
			<div id="error_msg"></div>
			<br><br><br>
			<div class="card">
				<div class="card-body">
					<div class="text-center">
						<span style="font-size: 14px; font-weight: bold;">En esta página se presentan dos opciones de respuestas, para responder el cuestionario. Seleccione la opción con la que más se sienta cómodo.</span>
						<span style="font-size: 14px; font-weight: bold;">En la parte inferior podrá visualizar dos ejemplos didácticos. </span>
					</div><br><br>
					<div>
						<div class="row">
						<?php 
							$columna = "";
							if($navegador == "Safari"){
								$columna = "offset-md-3 ";
							}
						foreach (METODO_SELECCION as $key=>$value) {
							?>
								<div class="<?php echo $columna; ?>col-md-6 text-center">
									<div class="form-group">
										<label class="form-check-label">
										  <input type="radio" class="form-check-input" name="seleccion" value="<?php echo $key; ?>">
										  	<span style="font-size: 12px;"><?php echo utf8_encode($value[0]); ?></span>
										</label>
									</div>
									<br>
									<div class="text-center">
										<img class="eder" src="<?php echo PUERTO."://".HOST."/imagenes/".$key.".gif";?>" style="width: 100%;" id="<?php echo "gif_".$key; ?>">
									</div>
									<!-- <div class="card">
										<div class="card-body">
											<h5><?php echo utf8_encode($value[1]); ?></h5>	
										</div>
									</div> -->
								</div>
							<?php 
						}

						 ?>
						</div>
					</div>
				</div>
				<?php if($navegador != 'MSIE'){ ?>
				<div class="card-footer text-center">
					<input type="submit" name="" value="Seleccionar" class="btn btn-success">
				</div>
			<?php } ?>
			</div>
		</div>
	</div>
</form>


<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/vendor/jquery-3.0.0.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/bootstrap.min.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/jquery-ui.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/minisitio.js"></script>
</body>
</html>