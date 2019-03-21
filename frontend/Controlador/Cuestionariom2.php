<?php
class Controlador_Cuestionariom2 extends Controlador_Base{
  
  public function construirPagina(){
    $opcion = Utils::getParam('opcion', '', $this->data);
    switch ($opcion) {
      case 'guardarresp':
        
      try{ 
          if(!isset($_POST['array_orden']) && !isset($_POST['array_opcion'])){
            throw new Exception("Error al guardar las opciones de la pregunta");
          }
            $orden = $_POST['array_orden'];
            $opcion = $_POST['array_opcion'];
            $tiempo = $_POST['tiempo'];
            $id_usuario = $_POST['id_usuario'];
            $data = array('id_usuario'=>$id_usuario, 'opcion'=>$opcion, 'orden'=>$orden, 'tiempo'=>$tiempo);
            self::guardarRespuestas($data);
            $_SESSION['id_faceta'] = Modelo_Respuesta::facetaSiguiente($id_usuario);
        }
        catch( Exception $e ){      
          //echo $e->getMessage();
          $_SESSION['mostrar_error'] = $e->getMessage();  
        }
        Utils::doRedirect(PUERTO.'://'.HOST.'/test');
      break;
      case 'metodo_resp':
        Vista::render('metodo_seleccion', METODO_SELECCION, '', '');
      break;
      case 'reg_var':
      //$_SESSION['id_usuario'] = ;
        if(!isset($_SESSION['id_faceta'])){
          $_SESSION['id_faceta'] = 1;
        }
        else{
          $_SESSION['id_faceta'] = Modelo_Respuesta::facetaSiguiente($_SESSION['id_usuario']);
        }
        //if(!isset($_SESSION['metodo_seleccionado_vista'])){
          $_SESSION['metodo_seleccionado_vista'] = "forma_".$_POST['seleccion'];
        //}
        Modelo_Usuario::actualizarMetodo($_POST['seleccion'],$_SESSION['id_usuario']);
        Utils::doRedirect(PUERTO.'://'.HOST.'/test');
      break;
      default:           
      $_SESSION['id_faceta'] = Modelo_Respuesta::facetaSiguiente($_SESSION['id_usuario']);
        // $data = Modelo_Opcion::obtieneOpciones(1);
      self::renderscreen($_SESSION['id_faceta'], $_SESSION['metodo_seleccionado_vista']);

      break;
    }         
  }

  public function guardarRespuestas($data){
      $usuario = $data['id_usuario'];
      $orden = $data['orden'];
      $tiempo = $data['tiempo'];
      $opcion = $data['opcion'];

      if (empty($usuario) || (empty($orden) && !is_array($orden)) || empty($tiempo) || (empty($opcion) && !is_array($opcion))){
        throw new Exception("Error al guardar las opciones de la pregunta");
      }

      // for ($i=0; $i < count($opcion); $i++) { 
      //   $result = Modelo_Respuesta::validarRespuesta($usuario,$orden[$i],$opcion[$i]);
      //   if($result == $pregunta){
      //     $_SESSION['id_pregunta'] = $result;
      //     throw new Exception("Respuesta ingresada ya esta repetida"); 
      //   }
      // }

      // if(!self::validarValoresRepetidos($orden)){
      //   throw new Exception("Por favor, verificar que no haya ingresado valores repetidos"); 
      // }

      for ($i=0; $i < count($orden); $i++) { 
        if(!Utils::validarNumeros($orden[$i])){
          throw new Exception("El campo solo acepta números");
          
        }
      }

      $fecha1 = new DateTime($tiempo);
      $fecha2 = new DateTime("now");
      $diferencia = $fecha1->diff($fecha2);
      $tiempo = $diferencia->format('%H:%i:%s');

      if (!Modelo_Usuario::buscaUsuario($usuario)){
        throw new Exception("Error el usuario no existe");
      }

      $all_selected = 0;
        for ($i=0; $i < count($opcion); $i++) { 
          if($opcion[$i] != 0 && $opcion[$i] != null && $opcion[$i] != ""){
            $all_selected++;
          }
        }

      if((count($orden) != count($opcion)) || count($opcion) != $all_selected){
        throw new Exception("Por favor, ordene todas las preguntas del lado izquierdo hacia el lado derecho de acuerdo a su prioridad.");
        
      }

      if (!Modelo_Respuesta::guardarValores($orden,$tiempo,$usuario,$opcion)){
        throw new Exception("Error al guardar las opciones de la pregunta");  
      }
  }


  public function renderscreen($faceta, $vista){
    $rs = Modelo_Respuesta::facetaSiguiente($_SESSION['id_usuario']);
    if (empty($rs)){
       Utils::doRedirect(PUERTO.'://'.HOST.'/gracias/');
    }
    else{
      $data = Modelo_Opcion::obtieneOpciones($faceta);
      Vista::render($vista,array('data'=>$data, 'tiempo'=>date("Y-m-d H:i:s"), 'faceta'=>$rs), '', '');  
    }
    //funcion que obtiene las opciones de una pregunta especifica    
    
  }

  public function validarValoresRepetidos($orden){
    for ($i=0; $i < count($orden); $i++) {       
      for ($j=0; $j < count($orden); $j++) { 
        if($i != $j){
          if($orden[$i] == $orden[$j]){
             return false;
          }
        }
      }
    }
    return true;
  }
}
?>