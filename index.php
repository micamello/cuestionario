<?php
require_once 'constantes.php';
require_once 'init.php';
//include 'multisitios.php';

dispatch();
$GLOBALS['db']->close();

function dispatch() {
    global $_SUBMIT;
    $pagina = Utils::getParam('mostrar', 'inicio');
    $controlador_nombre = obtieneControlador($pagina);
    $clase = 'Controlador_' . $controlador_nombre;
    if(class_exists($clase)){
      $controlador = new $clase();
    }else{
      //no existe controlador
    }
    return $controlador->construirPagina();
  }
  
function obtieneControlador($nombre){
  switch($nombre){   
    case 'cuestionariom2':
      return 'Cuestionariom2';
    break;
    default:
      return 'RegTest'; 
    break;
  }
  return ucfirst($nombre);
}
?>