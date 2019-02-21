<?php
class Modelo_Opcion{

	public static function listadoxPregunta($pregunta){
		if (empty($pregunta)){ return false; }
		$sql = "SELECT o.*,r.orden 
						FROM mfo_opcion o INNER JOIN mfo_opcion_respuesta r
						ON o.id_opcion = r.id_opcion
						WHERE r.id_pre = ? 
						ORDER BY r.orden";
		return $GLOBALS['db']->auto_array($sql,array($pregunta),true);
	}
	
	/*******MINISITIO******/
	public static function obtieneOpciones($faceta){
		if (empty($faceta)){ return false; }
		$sql = "SELECT o.id_opcion, o.descripcion, o.valor, p.id_pregunta 
						FROM mfo_opcionm2 o
						INNER JOIN mfo_preguntam2 p ON p.id_pregunta = o.id_pregunta
						INNER JOIN mfo_competenciam2 c ON p.id_competencia = c.id_competencia
						WHERE c.id_faceta = ?
						ORDER BY p.orden, RAND()";
    return $GLOBALS['db']->auto_array($sql,array($faceta),true);
	}
}  
?>