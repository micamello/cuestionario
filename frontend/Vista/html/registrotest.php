<?php 
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT"); 
header("Last-Modified: " . gmdate("D, d MYH:i:s") . " GMT"); 
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); 
header("Cache-Control: post-check=0, pre-check=0", false); 
header("Pragma: no-cache");
clearstatcache();

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

if($navegador == 'Safari'){
  $columna = '12';
}else{
  $columna = '6';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
  <title>Registro de Datos</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/all.css">
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/bootstrap-select.min.css">
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/minisitio.css">
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/DateTimePicker.css">
  <!-- <link rel="stylesheet" type="text/css" href="../src/DateTimePicker.css" /> -->
  <!-- <script type="text/javascript" src="jquery-1.11.0.min.js"></script> -->
  <!-- <script type="text/javascript" src="../src/DateTimePicker.js"></script> -->
</head>
<body class="window_class">
  <?php if($navegador == 'MSIE'){ ?>
  <div align="center" id="mensaje" style="height: 150px;background: #c36262;"><br>
    <h3>Usted esta usando internet explorer 8 o inferior</h3>
    <p>Esta es una versi&oacute;n antigua del navegador, y puede afectar negativamente a su seguridad y su experiencia de navegaci&oacute;n.</p><p>Por favor, actualice a la version actual de IE o cambie de navegador ahora.</p>
    <p><b><a href="https://www.microsoft.com/es-es/download/internet-explorer.aspx">Actualizar IE</a></b></p>
  </div>
  <?php } ?>
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
  
  <div class="col-md-12" style="text-align: center;"><img src="<?php echo PUERTO;?>://<?php echo HOST;?>/imagenes/logo.png" height="100"></div>
  <!--<div class="container">-->
  <div class="col-md-8 offset-md-2">
    <div class="card shadow-lg rounded text-center">
      <form action="<?php echo PUERTO."://".HOST;?>/registrodatostest/" method="POST" id="form_registrotest">
        <div class="card-header bg-info text-white">
          Registro de datos 
        </div>
        <div class="card-body">
          <input type="hidden" name="form_register" id="form_register" value="1">
          <div class="row">
            <div class="col-md-<?php echo $columna; ?>">
              <div class="form-group" id="seleccione_group">
                <label for="tipo_dni">Tipo de documento</label><i class="asterisk_red">*</i>
                <select autocomplete="on" class="form-control" id="documentacion" name="documentacion">
                  <option selected="" disabled value="">Seleccione una opci&oacute;n</option>
                  <?php
                    $option = '';
                    foreach(DOCUMENTACION as $key => $doc){
                      $option .= "<option value='".$key."'";
                      if (isset($result['tipodoc']) && $result['tipodoc'] == $key)
                      { 
                        $option .= " selected='selected'";
                      }
                      $option .= ">".$doc."</option>";
                    }
                    echo utf8_encode($option);
                   ?>
                </select>
                <div></div>
              </div>
            </div>  

            <div class="col-md-<?php echo $columna; ?>">
              <div class="form-group" id="seccion_dni">
                  <label for="dni" id="nombre_dni">C&eacute;dula</label><i class="asterisk_red">*</i>
                  <input class="form-control" type="text" id="dni" name="dni" value="<?php if (isset($result['dni'])){ echo $result['dni']; } ?>"/>
                  <div></div>
              </div>
            </div>    

            <div class="col-md-<?php echo $columna; ?>">
              <div class="form-group">
               <label for="nombres">Nombres</label><i class="asterisk_red">*</i>
               <input autocomplete="on" type="text" id="nombres" class="form-control" id="nombres" name="nombres" value="<?php if (isset($result['nombres'])){ echo $result['nombres']; } ?>">
               <div></div>
             </div>
            </div>
            <!--<input type="hidden" name="registro_datos" id="registro_datos" value="1">-->
            <div class="col-md-<?php echo $columna; ?>">
             <div class="form-group">
              <label for="apellidos">Apellidos</label><i class="asterisk_red">*</i>
              <input autocomplete="on" type="text" class="form-control" id="apellidos" name="apellidos" value="<?php if (isset($result['apellidos'])){ echo $result['apellidos']; } ?>">
              <div></div>
             </div>
            </div>

            <div class="col-md-<?php echo $columna; ?>">
              <div class="form-group">
                <label for="fecha">Fecha de nacimiento</label><i class="asterisk_red">*</i>
                <input type="text" data-field="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="aaaa-mm-dd" value="<?php if (isset($result['fecha_nacimiento'])){ echo str_replace(' 00:00:00', '', $result['fecha_nacimiento']); } ?>" autocomplete="off">
                <div id="fecha_error"></div>
                <div id="fecha"></div>
              </div>
            </div>

            <div class="col-md-<?php echo $columna; ?>">
              <div class="form-group">
                <label for="genero">Género</label><i class="asterisk_red">*</i>
                <select autocomplete="on" name="genero" class="form-control" id="genero">
                  <option value="1" selected="selected" disabled="disabled">Seleccione una opción</option>
                  <?php 
                     $option = '';
                    foreach (GENERO as $key => $value) {

                      $option .= "<option value='".$key."'";
                      if (isset($result['genero']) && $result['genero'] == $key)
                      { 
                        $option .= " selected='selected'";
                      }
                      $option .= ">".$value."</option>";
                    }
                    echo $option;
                  ?>
                </select>
                <div></div>
              </div>
            </div>

            <div class="col-md-<?php echo $columna; ?>">
              <div class="form-group">
                <label for="estado_civil">Estado civil</label><i class="asterisk_red">*</i>
                <select autocomplete="on" class="form-control" name="estado_civil" id="estado_civil">
                  <option value="0" selected="" disabled="">Seleccione una opción</option>
                  <?php 
                    $option = '';
                    foreach (ESTADO_CIVIL as $key => $value) {
                      $option .= "<option value='".$key."'";
                      if (isset($result['estado_civil']) && $result['estado_civil'] == $key)
                      { 
                        $option .= " selected='selected'";
                      }
                      $option .= ">".utf8_encode($value)."</option>";
                    }
                    echo $option;
                   ?>
                </select>
                <div></div>
              </div>
            </div>

            <div class="col-md-<?php echo $columna; ?>">
              <div class="form-group">
                <label for="nivel_instruccion">Nivel de instrucción</label><i class="asterisk_red" disabled>*</i>
                  <select autocomplete="on" class="form-control" name="nivel_instruccion" id="nivel_instruccion">
                    <option value="0" selected="" disabled="">Seleccione una opción</option>
                    <?php 
                      $option = '';
                      foreach ($escolaridad as $esc) {
                        $option .= "<option value='".$esc['id_escolaridad']."'";
                        if (isset($result['id_escolaridad']) && $result['id_escolaridad'] == $esc['id_escolaridad'])
                        { 
                          $option .= " selected='selected'";
                        }
                        $option .= ">".utf8_encode($esc['descripcion'])."</option>";
                      }
                      echo $option;
                     ?>
                  </select>
                  <div></div>
              </div>
            </div>

            <div class="col-md-<?php echo $columna; ?>">
              <div class="form-group">
                <label for="profesion">Profesión</label><i class="asterisk_red">*</i>
                  <select autocomplete="on" class="form-control" name="profesion" id="profesion" data-live-search="true">
                    <option value="0" selected="" disabled="">Seleccione una opción</option>
                    <?php 
                       $option = '';
                      foreach ($profesion as $pro) {
                        $option .= "<option value='".$pro['id_profesion']."'";
                        if (isset($result['id_profesion']) && $result['id_profesion'] == $pro['id_profesion'])
                        { 
                          $option .= " selected='selected'";
                        }
                        $option .= ">".utf8_encode($pro['descripcion'])."</option>";
                      }
                      echo $option;
                     ?>
                  </select>
                  <div id="err_profesion"></div>
              </div>
            </div>

            <div class="col-md-<?php echo $columna; ?>">
              <div class="form-group">
                <label for="ocupacion">Ocupación</label><i class="asterisk_red">*</i>
                <select autocomplete="on" class="form-control" name="ocupacion" id="ocupacion" data-live-search="true">
                  <option value="0" selected="" disabled="">Seleccione una opción</option>
                  <?php 
                    $option = '';
                    foreach ($ocupacion as $ocu) {
                      $option .= "<option value='".$ocu['id_ocupacion']."'";
                      if (isset($result['id_ocupacion']) && $result['id_ocupacion'] == $ocu['id_ocupacion'])
                      { 
                        $option .= " selected='selected'";
                      }
                      $option .= ">".utf8_encode($ocu['descripcion'])."</option>";
                    }
                    echo $option;
                   ?>
                </select>
                <div id="err_ocupacion"></div>
              </div>
            </div>                                

            <div class="col-md-<?php echo $columna; ?>">
              <div class="form-group">
                <label>Provincia de Residencia</label><i class="asterisk_red">*</i>
                <select autocomplete="on" class="form-control" name="provincia_res" id="provincia_res" >
                  <option value="0" selected="" disabled="">Seleccione una opción</option>
                  <?php 
                    $option = '';
                    foreach ($provincia as $provincia_listado) {
                      $option .= "<option value='".$provincia_listado['id_provincia']."'";
                      if (isset($result['id_provincia_res']) && $result['id_provincia_res'] == $provincia_listado['id_provincia'])
                      { 
                        $option .= " selected='selected'";
                      }
                      $option .= ">".utf8_encode($provincia_listado['nombre'])."</option>";
                    }
                    echo $option;
                   ?>
                </select>
                <div></div>
              </div>
            </div>                      

            <div class="col-md-<?php echo $columna; ?>">
              <div class="form-group">
                <label for="correo">Correo</label><i class="asterisk_red">*</i>
                <input autocomplete="on" type="text" class="form-control" name="correo" id="correo" value="<?php if (isset($result['correo'])){ echo $result['correo']; } ?>" >
                <div></div>
              </div>
            </div>

            <div class="col-md-12" id="pais_content">
              <div class="form-group">
                <label>Pa&iacute;s de Nacimiento</label><i class="asterisk_red">*</i>
                <select autocomplete="on" class="form-control" name="pais" id="pais" >
                  <option value="0" selected="" disabled="">Seleccione una opción</option>
                  <?php 
                    $option = '';
                    foreach ($pais as $pais_listado) {
                      $option .= "<option value='".$pais_listado['id_pais']."'";
                      if (isset($result['id_nacionalidad']) && $result['id_nacionalidad'] == $pais_listado['id_pais'])
                      { 
                        $option .= " selected='selected'";
                      }
                      $option .= ">".utf8_encode($pais_listado['nombre_abr'])."</option>";
                    }
                   echo $option;
                  ?>
                </select>
                <div></div>
              </div>
            </div>
         

            <?php if((isset($result['id_provincia']) && !empty($result['id_provincia'])) || (isset($result['id_nacionalidad']) && $result['id_nacionalidad'] == SUCURSAL_PAISID)){ ?>
            <div class="col-md-12" id="nuevo_div">
            <div class="col-md-12" id="provincia_content">
              <div class="form-group">
                <label>Provincia de Nacimiento</label><i class="asterisk_red">*</i>
                <select autocomplete="on" class="form-control" name="provincia" id="provincia">
                  <option value="0" selected="" disabled="">Seleccione una opción</option>
                  <?php  
                      $option = '';
                      foreach ($provincia as $provincia_listado) {
                        $option .= "<option value='".$provincia_listado['id_provincia']."'";
                        if ($result['id_provincia'] == $provincia_listado['id_provincia'])
                        { 
                          $option .= " selected='selected'";
                        }
                        $option .= ">".utf8_encode($provincia_listado['nombre'])."</option>";
                      }
                      echo $option;                    
                   ?>
                </select>
                <div></div>
              </div>
            </div>  
          </div>
            <?php } else{ ?>
                <div class="col-md-12" id="nuevo_div">
                  <input type="hidden" name="provincia" id="provincia" value="">
                </div>
              <?php }  ?>
            
            <div class="col-md-12" id="empr">
              <div class="form-group">
                <label>Relaci&oacute;n de Dependencia (Empresa)</label><i class="asterisk_red">*</i>
                <select autocomplete="on" class="form-control" name="empresa" id="empresa" >
                  <option value="-1" selected="" disabled="">Seleccione una opción</option>
                  <?php 
                    if (empty($result['id_empresa'])){
                      $option = "<option value='0' selected='selected'>Ninguna</option>";  
                    }
                    else{
                      $option = "<option value='0'>Ninguna</option>";  
                    }                    
                    foreach ($empresas as $empresas_listado) {
                      $option .= "<option value='".$empresas_listado['id_empresa']."'";
                      if (isset($result['id_empresa']) && $result['id_empresa'] == $empresas_listado['id_empresa'])
                      { 
                        $option .= " selected='selected'";
                      }
                      $option .= ">".utf8_encode($empresas_listado['nombre'])."</option>";
                    }
                   echo $option;
                  ?>
                </select>
                <div></div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-check">
                <input autocomplete="on" type="checkbox" class="form-check-input" name="terminos_condiciones" id="terminos_condiciones" <?php if (isset($result['term_cond'])){ echo 'checked'; } ?> >
                <label class="form-check-label" for="terminos_condiciones">Aceptar <a href="<?php echo PUERTO."://".HOST."/documentos/politicas.pdf";?>" target="_blank">políticas</a> para presentar y publicar el TEST</label><i class="asterisk_red">*</i>
                <div></div>
              </div>
            </div>
          </div>
          <input type="text" hidden id="puerto_host" value="<?php echo PUERTO."://".HOST ;?>">
          <input type="text" hidden name="metodo_resp" id="metodo_resp" value="<?php if(isset($result['metodo_resp'])){ echo $result['metodo_resp']; } ?>">
          <div class="alert alert-danger" style="display: none" id="errors_form" role="alert">
            
          </div>

        </div>
        <?php if($navegador != 'MSIE'){ ?>
          <div class="card-footer bg-transparent text-muted">
            <input type="submit" name="registro" id="registro" class="btn btn-success" value="<?php echo $accion; ?>">
          </div>
        <?php } ?>
      </form>
    </div>
  <!--</div>-->
</div>
<br>

<?php 

 
if($navegador == 'MSIE'){
  echo '<script type="text/javascript" src="'.PUERTO."://".HOST.'/js/jquery.min-1.3.1.js"></script>
  <script type="text/javascript" src="'.PUERTO."://".HOST.'/js/minisitio.js"></script>';
}else{
  echo '<script type="text/javascript" src="'.PUERTO."://".HOST.'/js/jquery-3.0.0.js"></script>
  <script type="text/javascript" src="'.PUERTO."://".HOST.'/js/popper.min.js"></script>
  <script type="text/javascript" src="'.PUERTO."://".HOST.'/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="'.PUERTO."://".HOST.'/js/bootstrap-select.min.js"></script>
  <script type="text/javascript" src="'.PUERTO."://".HOST.'/js/DateTimePicker.js"></script>
  <script type="text/javascript" src="'.PUERTO."://".HOST.'/js/minisitio_nomovil.js"></script>';
}
?>

<script>
$( document ).ready(function() {

  function navegador(){
      var agente = window.navigator.userAgent;
      var navegadores = ["Chrome", "Firefox", "Safari", "Opera", "MSIE", "Trident", "Edge"];
      for(var i in navegadores){
          if(agente.indexOf( navegadores[i]) != -1 ){
              return navegadores[i];
          }
      }
  }
//console.log(window.navigator.userAgent);
  if(navegador() != 'MSIE'){
    $('#profesion').selectpicker();
    $('#ocupacion').selectpicker();   
    $('#fecha').DateTimePicker({
      dateFormat: "yyyy-MM-dd",
      shortDayNames: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
      shortMonthNames: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
      fullMonthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Deciembre"],
      titleContentDate: "Configurar fecha",
      titleContentTime: "Configurar tiempo",
      titleContentDateTime: "Configurar Fecha & Tiempo",
      setButtonContent: "Listo",
      clearButtonContent: "Limpiar"
    });
  }

});
</script>

</body>
</html>