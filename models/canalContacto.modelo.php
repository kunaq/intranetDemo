<?php
require_once "conexion.php";
class ModeloCanalContacto{
	/*=============================================
	MOSTRAR CANAL CONTACTO
	=============================================*/
	static public function mdlMostrarCanalContacto($tabla,$item,$valor){
		$db = new Conexion();
		if($item != null){
			$sql = $db->consulta("SELECT cod_canal_contacto,dsc_canal_contacto FROM $tabla WHERE $item = '$valor'");
			$datos = arrayMapUtf8Encode($db->recorrer($sql));
		}else{
			$sql = $db->consulta("SELECT cod_canal_contacto,dsc_canal_contacto FROM $tabla");
			$datos = array();
		    while($key = $db->recorrer($sql)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		}
	    return $datos;
	}// function mdlMostrarCanalContacto
	/*=============================================
	CREAR CANAL CONTACTO
	=============================================*/
	static public function mdlIngresarCanalContacto($tabla, $datos){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$sql = $db->consulta("INSERT INTO $tabla(cod_canal_contacto,dsc_canal_contacto, cod_usr_registro,fch_registro) VALUES('".$datos['cod_canal_contacto']."','".$datos['dsc_canal_contacto']."','".$datos['cod_usr_registro']."',CONVERT(datetime,'".$datos["fch_registro"]."',21))");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlIngresarCanalContacto	
	/*=============================================
	EDITAR CANAL CONTACTO
	=============================================*/
	static public function mdlEditarCanalContacto($tabla, $datos){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$sql = $db->consulta("UPDATE $tabla SET dsc_canal_contacto = '".$datos["dsc_canal_contacto"]."', cod_usr_modifica = '".$datos["cod_usr_modifica"]."', fch_modifica = CONVERT(datetime,'".$datos["fch_modifica"]."',21) WHERE cod_canal_contacto = '".$datos["cod_canal_contacto"]."'");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEditarCanalContacto
	/*=============================================
	ELIMINAR CANAL CONTACTO
	=============================================*/
	static public function mdlEliminarCanalContacto($tabla, $datos){
		$db = new Conexion();
		$sql = $db->consulta("DELETE FROM $tabla WHERE cod_canal_contacto = '".$datos."'");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEliminarCanalContacto
}//class ModeloCanalContacto