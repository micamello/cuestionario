<?php
class Controlador_RegTest extends Controlador_Base {
  
  public function construirPagina(){   
    
    if((isset($_SESSION['mensaje_exito']) && $_SESSION['mensaje_exito'] == '') || !isset($_SESSION['mensaje_exito'])){
      unset($_SESSION['id_usuario']);
    }
    if(isset($_SESSION['id_pregunta'])){
      unset($_SESSION['id_pregunta']);
    }
    if(isset($_SESSION['questions'])){
      unset($_SESSION['questions']);
    }

  	$opcion = Utils::getParam('opcion','',$this->data);
  	switch($opcion){
      case 'buscaProvincia':
        $id_pais = Utils::getParam('id_pais', '', $this->data);
        $provincias = Modelo_Provincia::obtieneListadoAsociativo($id_pais);
        Vista::renderJSON($provincias);
      break;
      case 'buscaCiudad':
        $id_provincia = Utils::getParam('id_provincia', '', $this->data);
        $arrciudad    = Modelo_Ciudad::obtieneCiudadxProvincia($id_provincia);
        Vista::renderJSON($arrciudad);
      break;
      case 'buscaParroquia':
        $id_canton = Utils::getParam('id_canton', '', $this->data);        
        $parroquia = Modelo_Parroquia::obtieneParroquiaxCanton($id_canton);
        Vista::renderJSON($parroquia);
      break;
      case 'buscaDni':
        $dni = Utils::getParam('dni', '', $this->data);
        $datodni = Modelo_Usuario::existeDni($dni);

        if($datodni['id_usuario'] != ''){
          $_SESSION['id_usuario'] = $datodni['id_usuario'];
          $_SESSION['mensaje_exito'] = 'puede editar';
          if(!empty($datodni['metodo_resp'])){
            $_SESSION['metodo_seleccionado_vista'] = 'forma_'.$datodni['metodo_resp'];
          }
        }else{
          unset( $_SESSION['id_usuario']);
          unset($_SESSION['mensaje_exito'] );
        }

        Vista::renderJSON(array("result"=>$datodni));
      break;
      case 'guardardatostest':

        if(isset($_SESSION['id_usuario']) && $_SESSION['id_usuario'] != 0){
          $tipo = 2;
          $idUsuario = $_SESSION['id_usuario'];
        }else{
          $tipo = 1;
          $idUsuario = '';
        }
        $this->guardarDatosTest($tipo,$idUsuario);
        
        
      break;
      case 'gracias':
        if(isset($_SESSION['id_usuario'])){
          $rs1 = Modelo_Respuesta::facetaSiguiente($_SESSION['id_usuario']);
          if($rs1 != 1 && $rs1 != false){
            Utils::doRedirect(PUERTO.'://'.HOST.'/test/');
          }
          elseif($rs1 == 1){
            Utils::doRedirect(PUERTO.'://'.HOST.'/metodo_seleccion/');         
          }
          elseif($rs1 == false){
            $this->gracias();
          }
        }
        else{
          Utils::doRedirect(PUERTO.'://'.HOST);
        }
      break;
      default:
        $this->mostrarDefault();
      break;
    }  



  }

  public function guardarDatosTest($tipo,$idUsuario){
    $url = "";   unset($_SESSION['datospost']); 
    if ( Utils::getParam('form_register') == 1 ){
      try{
        $campos = array('nombres'=>1, 'apellidos'=>1, 'fecha_nacimiento'=>1, 'pais'=>1, 'provincia'=>0, 'genero'=>1, 'estado_civil'=>1, 'nivel_instruccion'=>1, 'terminos_condiciones'=>1, 'correo'=>1,'provincia_res'=>1, 'profesion'=>1, 'ocupacion'=>1,'documentacion'=>1,'dni'=>1,'empresa'=>1);        

        $metodo_resp = Utils::getParam('metodo_resp', '', $this->data); 
        $data = $this->camposRequeridos($campos);  
        $validaFechaNac = Modelo_Usuario::validarFechaNac($data['fecha_nacimiento']);
        if (empty($validaFechaNac)) {
          throw new Exception("La fecha es incorrecta");
        }

        self::validarTipoDato($data);

        if (SUCURSAL_PAISID == $data['pais'] && empty($data['provincia'])){
          throw new Exception("Debe ingresar una provincia de nacimiento");
        }  

        if(!Modelo_Usuario::guardarUsuario($data,$tipo,$idUsuario)){
          throw new Exception("Ha ocurrido un error, intente nuevamente");
        }
        
        if($tipo == 1){
          $_SESSION['id_usuario'] = $GLOBALS['db']->insert_id();
          $_SESSION['mensaje_exito'] = "Te has registrado correctamente.";
        }else{
          $_SESSION['mensaje_exito'] = "Has editado correctamente.";
        }
                 
        $faceta = Modelo_Respuesta::facetaSiguiente($idUsuario);
        if($faceta > 1){          
          $_SESSION['metodo_seleccionado_vista'] = 'forma_'.$metodo_resp;
          $url = 'test/';
        }else{
          $url = "metodo_seleccion/";
        }
        
      }
      catch( Exception $e ){
        $GLOBALS['db']->rollback();
        $_SESSION['datospost'] = $_POST;        
        $_SESSION['mostrar_error'] = $e->getMessage();        
      }
      Utils::doRedirect(PUERTO.'://'.HOST.'/'.$url);
    }
  }

  public function validarTipoDato($data){
    if (!preg_match('/^[\p{L} ]+$/u', html_entity_decode($data['nombres']))){
      throw new Exception("El campo solo acepta letras, tildes y espacios");
      
    }
    if (!preg_match('/^[\p{L} ]+$/u', html_entity_decode($data['apellidos']))){
      throw new Exception("El campo solo acepta letras, tildes y espacios");
    }
    // validar fecha
    /*if(Utils::validatFormatoFecha($data['fecha_nacimiento']) == false){
      throw new Exception("La fecha ingresada es incorrecta");
    }*/
    // valida correo
    if(Utils::es_correo_valido($data['correo']) == false){
      throw new Exception("La correo ingresado no es válido");
    }
  }

  public function gracias(){
    unset($_SESSION['id_usuario']);
    unset($_SESSION['mostrar_exito']);
    unset($_SESSION['metodo_seleccionado_vista']);
    unset($_SESSION['id_faceta']);
    Vista::render('gracias',array(), '', '');
  }

  public function mostrarDefault(){
    $pais = Modelo_Pais::obtieneListado();
    $provincia = Modelo_Provincia::obtieneListado();
    $escolaridad = Modelo_Escolaridad::obtieneListado();
    $profesion = Modelo_ProfesionTest::obtenerListado();
    $ocupacion = Modelo_Ocupacion::obtenerListado();
    $empresas = Modelo_Usuario::obtieneListadoEmpresas();
    $result = array(); 
    if(isset($_SESSION['id_usuario']) && $_SESSION['id_usuario'] != 0){
      $accion = 'Editar';
      $result = Modelo_Usuario::buscaDatosUsuario($_SESSION['id_usuario']);
      //$_SESSION['metodo_seleccionado_vista'] = 'forma_'.$result['metodo_resp'];
    }
    else{  
      if (isset($_SESSION['datospost']['documentacion']) && !empty($_SESSION['datospost']['documentacion'])) {
        $result['tipodoc'] = $_SESSION['datospost']['documentacion'];
      }   
      if (isset($_SESSION['datospost']['dni']) && !empty($_SESSION['datospost']['dni'])) {
        $result['dni'] = $_SESSION['datospost']['dni'];
      } 
      if (isset($_SESSION['datospost']['nombres']) && !empty($_SESSION['datospost']['nombres'])) {
        $result['nombres'] = $_SESSION['datospost']['nombres'];
      }
      if (isset($_SESSION['datospost']['apellidos']) && !empty($_SESSION['datospost']['apellidos'])) {
        $result['apellidos'] = $_SESSION['datospost']['apellidos'];
      }
      if (isset($_SESSION['datospost']['fecha_nacimiento']) && !empty($_SESSION['datospost']['fecha_nacimiento'])) {
        $result['fecha_nacimiento'] = $_SESSION['datospost']['fecha_nacimiento'];
      }
      // print_r($result['fecha_nacimiento']);
      // print_r($_SESSION['datospost']['fecha_nacimiento']);
      // exit();
      if (isset($_SESSION['datospost']['genero']) && !empty($_SESSION['datospost']['genero'])) {
        $result['genero'] = $_SESSION['datospost']['genero'];
      }
      if (isset($_SESSION['datospost']['estado_civil']) && !empty($_SESSION['datospost']['estado_civil'])) {
        $result['estado_civil'] = $_SESSION['datospost']['estado_civil'];
      }
      if (isset($_SESSION['datospost']['nivel_instruccion']) && !empty($_SESSION['datospost']['nivel_instruccion'])) {
        $result['id_escolaridad'] = $_SESSION['datospost']['nivel_instruccion'];
      }
      if (isset($_SESSION['datospost']['profesion']) && !empty($_SESSION['datospost']['profesion'])) {
        $result['id_profesion'] = $_SESSION['datospost']['profesion'];
      }
      if (isset($_SESSION['datospost']['ocupacion']) && !empty($_SESSION['datospost']['ocupacion'])) {
        $result['id_ocupacion'] = $_SESSION['datospost']['ocupacion'];
      }
      if (isset($_SESSION['datospost']['provincia_res']) && !empty($_SESSION['datospost']['provincia_res'])) {
        $result['id_provincia_res'] = $_SESSION['datospost']['provincia_res'];
      }
      if (isset($_SESSION['datospost']['correo']) && !empty($_SESSION['datospost']['correo'])) {
        $result['correo'] = $_SESSION['datospost']['correo'];
      }
      if (isset($_SESSION['datospost']['pais']) && !empty($_SESSION['datospost']['pais'])) {
        $result['id_nacionalidad'] = $_SESSION['datospost']['pais'];
      }
      if (isset($_SESSION['datospost']['provincia']) && !empty($_SESSION['datospost']['provincia'])) {
        $result['id_provincia'] = $_SESSION['datospost']['provincia'];
      }
      if (isset($_SESSION['datospost']['empresa']) && !empty($_SESSION['datospost']['empresa'])) {
        $result['id_empresa'] = $_SESSION['datospost']['empresa'];
      }
      if (isset($_SESSION['datospost']['terminos_condiciones']) && !empty($_SESSION['datospost']['terminos_condiciones'])) {
        $result['term_cond'] = 1;
      }
      $accion = 'Guardar';
    }

    Vista::render('registrotest',array('pais'=>$pais, 'provincia'=>$provincia, 'escolaridad'=>$escolaridad, 'profesion'=>$profesion, 'ocupacion'=>$ocupacion,'accion'=>$accion, 'result'=>$result, 'empresas'=>$empresas), '', '');

    //Vista::render('pagina_enconstruccion',array(),'','');
  }


}  
?>