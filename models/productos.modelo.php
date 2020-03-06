<?php
require_once "conexion.php";
class ModeloProductos{
	/*=============================================
	MOSTRAR PRODUCTOS
	=============================================*/
	static public function mdlMostrarProductos($tabla,$item,$valor,$entrada){
		$db = new Conexion();
		if($item != null){
			if($entrada == "modalProducto"){
				$sql = $db->consulta("SELECT * FROM $tabla WHERE $item = '$valor'");
				$datos = arrayMapUtf8Encode($db->recorrer($sql));
			}else if($entrada == "validarNombreRepetido"){
				$sql = $db->consulta("SELECT COUNT(dsc_producto) as contador FROM $tabla WHERE $item = '$valor'");
				$datos = $db->recorrer($sql);
			}else if($entrada == "capturarNombreProducto"){
				$sql = $db->consulta("SELECT dsc_producto FROM $tabla WHERE $item = '$valor'");
				$datos = arrayMapUtf8Encode($db->recorrer($sql));
			}			
		}else{
			if($entrada == 'detalleCotizacion' || $entrada == 'inputSelect'){
				$sql = $db->consulta("SELECT vtama_producto.cod_producto,vtama_producto.dsc_producto FROM $tabla");
			}else if($entrada == 'filtroCotizacion'){
				$sql = $db->consulta("SELECT vtama_producto.dsc_producto FROM $tabla");				
			}else if($entrada == 'vtnOrdenProduccion'){
				$sql = $db->consulta("SELECT cod_producto,dsc_producto FROM $tabla");
			}else{
				$sql = $db->consulta("SELECT vtama_producto.cod_producto,vtama_producto.dsc_producto,vtama_tipo_producto.dsc_tipo_producto,vtama_producto.dsc_detalle FROM $tabla LEFT JOIN vtama_tipo_producto ON vtama_tipo_producto.cod_tipo_producto = vtama_producto.cod_tipo_producto");
			}
			$datos = array();
		    while($key = $db->recorrer($sql)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		}//else
		$db->liberar($sql);
        $db->cerrar();
		return $datos;
	}//function mdlMostrarProductos
	/*=============================================
	CREAR PRODUCTO
	=============================================*/
	static public function mdlIngresarProducto($tabla,$datosProductos,$datosCotizacion){
		$db = new Conexion();
		if($datosProductos != null){
			$datosProductos =  arrayMapUtf8Decode($datosProductos);
			$sql = $db->consulta("INSERT INTO $tabla(cod_producto,cod_tipo_producto,dsc_producto,cod_usr_registro,fch_registro,dsc_detalle) VALUES('".$datosProductos['cod_producto']."',".$datosProductos['cod_tipo_producto'].",'".$datosProductos['dsc_producto']."','".$datosProductos['cod_usr_registro']."',CONVERT(datetime,'".$datosProductos["fch_registro"]."',21),'".$datosProductos["dsc_detalle"]."')");
			if($sql){
				return "ok";
			}else{
				return "error";
			}
		}else{
			$codigoArray = [];
			foreach ($datosCotizacion as $key => $value) {
				$codigo = maximoCodigoTabla('vtama_producto','cod_producto',date("Y").date("m"));
				$sql =  $db->consulta("INSERT INTO $tabla(cod_producto, cod_tipo_producto, dsc_producto, cod_usr_registro, fch_registro, dsc_detalle) VALUES('".$codigo."',".$value['cod_tipo_producto'].",'".$value['dsc_producto']."','".$value[0]."',CONVERT(datetime,'".$value[1]."',21),'".$value[3]."')");
				$codigoArray[$value["num_linea"]] = $codigo;
			}//foreach
			return $codigoArray;
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlIngresarProducto
	/*=============================================
	EDITAR PRODUCTO
	=============================================*/
	static public function mdlEditarProducto($tabla,$datos){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$sql = $db->consulta("UPDATE $tabla SET cod_tipo_producto = ".$datos["cod_tipo_producto"].", dsc_producto = '".$datos["dsc_producto"]."', cod_usr_modifica = '".$datos["cod_usr_modifica"]."', fch_modifica = CONVERT(datetime,'".$datos["fch_modifica"]."',21), dsc_detalle = '".$datos["dsc_detalle"]."' WHERE cod_producto = '".$datos["cod_producto"]."'");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEditarProducto
	/*=============================================
	ELIMINAR PRODUCTO
	=============================================*/
	static public function mdlEliminarProducto($tabla,$datos){
		$db = new Conexion();
		$sql = $db->consulta("DELETE FROM $tabla WHERE cod_producto = '".$datos."'");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEliminarProducto
}//class ModeloProducto