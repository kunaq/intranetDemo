<?php
require_once "conexion.php";
class ModeloTipoProducto{
	/*=============================================
	MOSTRAR TIPOS DE PRODUCTO
	=============================================*/
	static public function mdlMostrarTipoProductos($tabla,$item,$valor,$entrada){
		$db = new Conexion();
		if($item != null){
			$sql = $db->consulta("SELECT cod_tipo_producto,dsc_tipo_producto FROM $tabla WHERE $item = '$valor'");
			$datos = arrayMapUtf8Encode($db->recorrer($sql));
		}else{
			if($entrada == "detalleCotizacion" || $entrada == "tablaMaestra"){
				$sql = $db->consulta("SELECT cod_tipo_producto,dsc_tipo_producto FROM $tabla");
			}else{
				$sql = $db->consulta("SELECT * FROM $tabla");
			}
			$datos = array();
		    while($key = $db->recorrer($sql)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		}
	    return $datos;
	}// function mdlMostrarTipoProductos
	/*=============================================
	CREAR TIPO PRODUCTO
	=============================================*/
	static public function mdlIngresarTipoProducto($tabla, $datos){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$sql = $db->consulta("INSERT INTO $tabla(cod_tipo_producto, dsc_tipo_producto, cod_usr_registro, fch_registro) VALUES('".$datos['cod_tipo_producto']."','".$datos['dsc_tipo_producto']."','".$datos['cod_usr_registro']."',CONVERT(datetime,'".$datos["fch_registro"]."',21))");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlIngresarTipoProducto
	/*=============================================
	EDITAR TIPO PRODUCTO
	=============================================*/
	static public function mdlEditarTipoProducto($tabla, $datos){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$sql = $db->consulta("UPDATE $tabla SET dsc_tipo_producto = '".$datos["dsc_tipo_producto"]."',cod_usr_modifica = '".$datos["cod_usr_modifica"]."',fch_modifica = CONVERT(datetime,'".$datos["fch_modifica"]."',21) WHERE cod_tipo_producto = '".$datos["cod_tipo_producto"]."'");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEditarTipoProducto
	/*=============================================
	ELIMINAR TIPO PRODUCTO
	=============================================*/
	static public function mdlEliminarTipoProducto($tabla, $datos){
		$db = new Conexion();
		$sql = $db->consulta("DELETE FROM $tabla WHERE cod_tipo_producto = '".$datos."'");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEliminarTipoProducto
}//class ModeloTipoProducto