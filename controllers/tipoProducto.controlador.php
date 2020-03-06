<?php
class ControladorTipoProducto{
	/*=============================================
	CREAR PRODUCTOS
	=============================================*/
	static public function ctrCrearTipoProducto(){
		if(isset($_POST["accionTipoProducto"]) && $_POST["accionTipoProducto"] == "crear"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;
			$tabla = 'vtama_tipo_producto';
			$codTipoProducto = maximoCodigoTabla($tabla,'cod_tipo_producto','');
			$datos = array("cod_tipo_producto" => $codTipoProducto,
						   "dsc_tipo_producto" => ms_escape_string(trim($_POST["nombreTipoProducto"])),
						   "cod_usr_registro" => $_SESSION["cod_trabajador"],
						   "fch_registro" => $fechaActual);
			$respuesta = ModeloTipoProducto::mdlIngresarTipoProducto($tabla,$datos);
			return $respuesta;
		}//if
	}//function ctrCrearTipoProducto
	/*=============================================
	MOSTRAR PRODUCTOS
	=============================================*/
	static public function ctrMostrarTipoProducto($item,$valor,$entrada){
		$tabla = "vtama_tipo_producto";
		$respuesta = ModeloTipoProducto::mdlMostrarTipoProductos($tabla,$item,$valor,$entrada);
		return $respuesta;
	}//function ctrMostrarTipoProducto
	/*=============================================
	EDITAR PRODUCTOS
	=============================================*/
	static public function ctrEditarTipoProducto(){
		if(isset($_POST["accionTipoProducto"]) && $_POST["accionTipoProducto"] == "editar"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;
			$tabla = 'vtama_tipo_producto';
			$datos = array("cod_tipo_producto" => $_POST["codigoTipoProducto"],
						   "dsc_tipo_producto" => ms_escape_string(trim($_POST["nombreTipoProducto"])),
						   "cod_usr_modifica" => $_SESSION["cod_trabajador"],
						   "fch_modifica" => $fechaActual);
			$respuesta = ModeloTipoProducto::mdlEditarTipoProducto($tabla,$datos);
			return $respuesta;
		}//if
	}//function ctrEditarTipoProducto
	/*=============================================
	ELIMINAR TIPO PRODUCTO
	=============================================*/
	static public function ctrEliminarTipoProducto(){
		if(isset($_POST["accionTipoProducto"]) && $_POST["accionTipoProducto"] == "eliminar"){
			$tabla ="vtama_tipo_producto";
			$datos = $_POST["codigoTipoProducto"];
			$respuesta = ModeloTipoProducto::mdlEliminarTipoProducto($tabla, $datos);
			return $respuesta;
		}//if
	}//function ctrEliminarTipoProducto
}//class ControladorTipoProducto