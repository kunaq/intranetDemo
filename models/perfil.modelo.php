<?php
require_once "conexion.php";
class ModeloPerfil{
	/*=============================================
	MOSTRAR ESTADO PERFIL
	=============================================*/
	static public function mdlMostrarPerfil($tabla,$item,$valor){
		$db = new Conexion();
		if($item != null){
			$sql = $db->consulta("SELECT cod_perfil,dsc_perfil,dsc_detalle FROM $tabla WHERE $item = '$valor'");
			$datos = arrayMapUtf8Encode($db->recorrer($sql));
		}else{
			$sql = $db->consulta("SELECT cod_perfil,dsc_perfil FROM $tabla");
			$datos = array();
		    while($key = $db->recorrer($sql)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		}
	    return $datos;
	}// function mdlMostrarPerfil
	/*=============================================
	EDITAR ESTADO PERFIL
	=============================================*/
	static public function mdlEditarPerfil($tabla, $datos){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$sql = $db->consulta("UPDATE $tabla SET dsc_perfil = '".$datos["dsc_perfil"]."',dsc_detalle = '".$datos["dsc_detalle"]."',cod_usr_modifica = '".$datos["cod_usr_modifica"]."', fch_modifica = CONVERT(datetime,'".$datos["fch_modifica"]."',21) WHERE cod_perfil = '".$datos["cod_perfil"]."'");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEditarPerfil
}//class ModeloPerfil