<?php
require_once "conexion.php";
class ModeloCategoriaCliente{
	/*=============================================
	MOSTRAR CATEGORIAS DE CLIENTE
	=============================================*/
	static public function mdlMostrarCategoriaClientes($tabla,$item,$valor){
		$db = new Conexion();
		if($item != null){
			$sql = $db->consulta("SELECT cod_categoria_cliente,dsc_categoria_cliente FROM $tabla WHERE $item = '$valor'");
			$datos = arrayMapUtf8Encode($db->recorrer($sql));
		}else{
			$sql = $db->consulta("SELECT cod_categoria_cliente,dsc_categoria_cliente FROM $tabla");
			$datos = array();
		    while($key = $db->recorrer($sql)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		}
	    return $datos;
	}// function mdlMostrarCategoriaClientes
	/*=============================================
	CREAR CATEGORIA CLIENTE
	=============================================*/
	static public function mdlIngresarCategoriaCliente($tabla, $datos){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$sql = $db->consulta("INSERT INTO $tabla(cod_categoria_cliente,dsc_categoria_cliente, cod_usr_registro,fch_registro) VALUES('".$datos['cod_categoria_cliente']."','".$datos['dsc_categoria_cliente']."','".$datos['cod_usr_registro']."',CONVERT(datetime,'".$datos["fch_registro"]."',21))");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlIngresarCategoriaCliente	
	/*=============================================
	EDITAR CATEGORIA CLIENTE
	=============================================*/
	static public function mdlEditarCategoriaCliente($tabla, $datos){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$sql = $db->consulta("UPDATE $tabla SET dsc_categoria_cliente = '".$datos["dsc_categoria_cliente"]."', cod_usr_modifica = '".$datos["cod_usr_modifica"]."', fch_modifica = CONVERT(datetime,'".$datos["fch_modifica"]."',21) WHERE cod_categoria_cliente = '".$datos["cod_categoria_cliente"]."'");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEditarCategiraCliente
	/*=============================================
	ELIMINAR CATEGORIA CLIENTE
	=============================================*/
	static public function mdlEliminarCategoriaCliente($tabla, $datos){
		$db = new Conexion();
		$sql = $db->consulta("DELETE FROM $tabla WHERE cod_categoria_cliente = '".$datos."'");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEliminarCategoriaCliente
}//class ModeloCategoriaCliente