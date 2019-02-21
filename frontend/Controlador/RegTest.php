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
    //if(isset($_SESSION['metodo_seleccionado_vista'])){
    //  unset($_SESSION['metodo_seleccionado_vista']);
    //}

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
        $this->gracias();
      break;
      default:
        
      	$pais = Modelo_Pais::obtieneListado();
      	$provincia = Modelo_Provincia::obtieneListado();
        $escolaridad = Modelo_Escolaridad::obtieneListado();
        $profesion = Modelo_ProfesionTest::obtenerListado();
        $ocupacion = Modelo_Ocupacion::obtenerListado();
        $empresas = Modelo_Usuario::obtieneListadoEmpresas();
        $result = '';
        if(isset($_SESSION['id_usuario']) && $_SESSION['id_usuario'] != 0){
          $accion = 'Editar';
          $result = Modelo_Usuario::buscaDatosUsuario($_SESSION['id_usuario']);
        }else{
          $accion = 'Guardar';
        }

        Vista::render('registrotest',array('pais'=>$pais, 'provincia'=>$provincia, 'escolaridad'=>$escolaridad, 'profesion'=>$profesion, 'ocupacion'=>$ocupacion,'accion'=>$accion, 'result'=>$result, 'empresas'=>$empresas), '', '');
      break;
    }    
  }

  public function guardarDatosTest($tipo,$idUsuario){
    $url = "";    
    if ( Utils::getParam('form_register') == 1 ){
      try{
        $campos = array('nombres'=>1, 'apellidos'=>1, 'fecha_nacimiento'=>1, 'pais'=>1, 'provincia'=>0, 'genero'=>1, 'estado_civil'=>1, 'nivel_instruccion'=>1, 'terminos_condiciones'=>1, 'correo'=>1,'provincia_res'=>1, 'profesion'=>1, 'ocupacion'=>1,'documentacion'=>1,'dni'=>1,'empresa'=>1);        

        $metodo_resp = Utils::getParam('metodo_resp', '', $this->data);
        $data = $this->camposRequeridos($campos);        

        $validaFechaNac = Modelo_Usuario::validarFechaNac($data['fecha_nacimiento']);
        if (empty($validaFechaNac)) {
          throw new Exception("Debe ser Mayor de edad");
        }

        self::validarTipoDato($data);

        if(!Modelo_Usuario::guardarUsuario($data,$tipo,$idUsuario)){
          throw new Exception("Ha ocurrido un error, intente nuevamente");
        }

        if($tipo == 1){
          $_SESSION['id_usuario'] = $GLOBALS['db']->insert_id();
          $_SESSION['mensaje_exito'] = "Te has registrado correctamente.";
        }else{
          $_SESSION['mensaje_exito'] = "Has editado correctamente.";
        }
                 
        if(!empty($metodo_resp)){
          $url = 'test';
        }else{
          $url = "metodo_seleccion";
        }
      }
      catch( Exception $e ){
        $GLOBALS['db']->rollback();
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
    if(Utils::validatFormatoFecha($data['fecha_nacimiento']) == false){
      throw new Exception("La fecha ingresada es incorrecta");
    }
    // valida correo
    if(Utils::es_correo_valido($data['correo']) == false){
      throw new Exception("La correo ingresado no es válido");
    }
    // valida formato dinero
   /* if(Utils::formatoDinero($data['aspiracion_salarial']) == false){
      throw new Exception("La formato de dinero ingresado no es válido");
    }*/
  }

  /*public function guardarDatosUsuarioTest($data){    
    if(!Modelo_Usuario::guardarUsuario($data)){
      throw new Exception("Ha ocurrido un error, intente nuevamente");
    }
  }*/

  public function gracias(){
    unset($_SESSION['id_usuario']);
    unset($_SESSION['mostrar_exito']);
    Vista::render('gracias',array(), '', '');
  }
}  
?>