<?php
require_once "conexion.php";
class ModeloEmpresaValores{
	/*=============================================
	MOSTRAR EMPRESA VALORES
	=============================================*/
	static public function mdlMostrarEmpresaValores($tabla){
		$db = new Conexion();
		$sql = $db->consulta("SELECT cod_valor,dsc_valor,imagen FROM $tabla");		
		$datos = array();
	    while($key = $db->recorrer($sql)){
	    	$datos[] = arrayMapUtf8Encode($key);
		}
		return $datos;
	}//function mdlMostrarEmpresaValores
}//class ModeloEmpresaValores