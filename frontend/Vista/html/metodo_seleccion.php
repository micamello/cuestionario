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
	<!-- <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/bootstrap.min.css"> -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/all.css">
	  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/minisitio.css">
	  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/sweetalert.v2.css">
	  <link rel="icon" type="image/x-icon" href="<?php echo PUERTO."://".HOST;?>/imagenes/favicon.ico">



</head>
<body style="background-color: white;">
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
			<br>
			<div class="text-center">
			  <h2 class="titulo1">Desarrollo de Tests</h2>
			</div>
			<div id="error_msg"></div>
			<!-- <br><br><br> -->
			<div class="col-md-12">
				<div class="container">
					<!-- <div class="text-center">
						<span style="font-size: 14px; font-weight: bold;">En esta página se presentan dos opciones de respuestas, para responder el cuestionario. Seleccione la opción con la que más se sienta cómodo.</span>
						<span style="font-size: 14px; font-weight: bold;">En la parte inferior podrá visualizar dos ejemplos didácticos. </span>
					</div><br><br> -->
					<div class="col-md-12">
			          <p class="qs-text">A continuación se le presentaran dos opciones de respuestas, escoja con la que se sienta más cómodo.</p>
			        </div>
					<div>
						<div class="row">
						<?php 
							$columna = "";
							if($navegador == "Safari"){
								$columna = "offset-md-3 ";
							}
							$i = 1;
						foreach (METODO_SELECCION as $key=>$value) {

							?>
								<div class="<?php echo $columna; ?>col-md-6 text-center">
									<div class="form-group">
										<label class="form-check-label">
										  <!-- <input type="radio" class="form-check-input" name="seleccion" value="<?php echo $key; ?>"> -->
										  	<span class="tit-test"><?php echo utf8_encode($value[0]); ?></span>
										</label>
									</div>
									<br>
									<?php 
									if($i == 1){
										?>
										<!-- <br> -->
										<div class="visible-lg">
											<br><br>
										</div>
										<?php
									} 

									?>
									<div class="text-center">
										<img id="img-test" src="<?php echo PUERTO."://".HOST."/imagenes/metodoSel/".$key.".png";?>">
									</div>
									<div class="col-md-12 text-center">
						              <div class="form-group check_box">
						                <label class="btn-blue margin-40">
						                  <input type="radio" name="seleccion" value="<?php echo $key; ?>">&nbsp; Escoger esta opción
						                </label>
						              </div> 
						            </div>

									<!-- <div class="card">
										<div class="card-body">
											<h5><?php echo utf8_encode($value[1]); ?></h5>	
										</div>
									</div> -->
								</div>
							<?php 
							$i++;
						}

						 ?>
							 <div class="col-md-12" align="center">
					            <input type="submit" name="" value="Ir a los tests" class="btn-blue">
					            <!-- <br><br> -->
					        </div>
						</div>
					</div>
				</div>
				<!-- <?php if($navegador != 'MSIE'){ ?>
				<div class="card-footer text-center">
					<input type="submit" name="" value="Seleccionar" class="btn btn-success">
				</div>
			<?php } ?> -->
			</div>
		</div>
	</div>
</form>
<div class="modal fade" tabindex="-1" id="msg_canea" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="">
        <div class="">
        	<div class="text-center">
	          	<br>
	         	<h2 class="titulo1">¿Qué es CANEA?</h2>
	        </div>
        <div class="col-md-12">
	    	<p class="qs-text">Canea es un test basado en la teoria de los <b>"5 GRANDES RASGOS DE PERSONALIDAD"</b> y ha sido muy utilizada en diversas investigaciones para el &aacute;rea organizacional a nivel mundial.</p>
	    	<div class="row">
	    		<div class="col-md-2 offset-md-1 col-xs-2 offset-xs-1 col-sm-2 offset-sm-1 minscreen">
	    			<div class="canea-text-modal">C</div>
					<div><h4 class="d-none d-lg-block texto-canea">Hacer</h4></div>
	    		</div>
	    		<div class="col-md-2 col-xs-2 col-sm-2 minscreen">
	    			<div class="canea-text-modal">A</div>
					<div align="center"><h4 class="d-none d-lg-block texto-canea">Relaciones Interpersonales</h4></div>
	    		</div>
	    		<div class="col-md-2 col-xs-2 col-sm-2 minscreen">
	    			<div class="canea-text-modal">N</div>
					<div><h4 class="d-none d-lg-block texto-canea">Inteligencia Emocional</h4></div>
	    		</div>
	    		<div class="col-md-2 col-xs-2 col-sm-2 minscreen">
	    			<div class="canea-text-modal">E</div>
					<div><h4 class="d-none d-lg-block texto-canea">Asertividad/<br>Comunicación</h4></div>
	    		</div>
	    		<div class="col-md-2 col-xs-2 col-sm-2 minscreen">
	    			<div class="canea-text-modal">A</div>
					<div id="prueba-e"><h4 class="d-none d-lg-block texto-canea">Pensar</h4></div>
	    		</div>
	    	</div>
	    	<div class="text-center">
          <button type="button" class="btn-blue" data-dismiss="modal">Aceptar</button>
        </div>
	     </div>
        </div>
      </div>
    </div>
  </div>
</div>

<input type="text" hidden id="puerto_host" value="<?php echo PUERTO."://".HOST ;?>">
<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/vendor/jquery-3.0.0.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/bootstrap.min.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/jquery-ui.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/sweetalert.v2.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/minisitio.js"></script>
</body>
</html>