<?php
class ControladorProductos{
	/*=============================================
	CREAR PRODUCTOS
	=============================================*/
	static public function ctrCrearProducto(){
		if(isset($_POST["accionProducto"]) && $_POST["accionProducto"] == "crear"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;
			$tabla = "vtama_producto";
			$codTipoProducto = ($_POST["tipoProducto"] == "") ? "NULL" : "'".$_POST["tipoProducto"]."'";
			$codProducto = maximoCodigoTabla($tabla,'cod_producto',date("Y").date("m"));
			$item = "dsc_producto";
			$valor = ms_escape_string(trim($_POST["nombreProducto"]));
			$entrada = "validarNombreRepetido";
			$nombre = ModeloProductos::mdlMostrarProductos($tabla,$item,$valor,$entrada);
			if($nombre['contador'] == 0){
				$datos = array("cod_producto" => $codProducto,
							   "cod_tipo_producto" => $codTipoProducto,
							   "dsc_producto" => ms_escape_string(trim($_POST["nombreProducto"])),
							   "cod_usr_registro" => $_SESSION["cod_trabajador"],
							   "fch_registro" => $fechaActual,
							   "dsc_detalle" => ms_escape_string(trim($_POST["observacionProducto"]))
							);
				$desdeCotizacion = null;
				$respuesta = ModeloProductos::mdlIngresarProducto($tabla,$datos,$desdeCotizacion);
			}else{
				$respuesta = "nombreRepetido";
			}
			return $respuesta;		
		}//if
	}//function ctrCrearProducto
	/*=============================================
	MOSTRAR PRODUCTOS
	=============================================*/
	static public function ctrMostrarProductos($item,$valor,$entrada){
		$tabla = "vtama_producto";
		$respuesta = ModeloProductos::mdlMostrarProductos($tabla,$item,$valor,$entrada);
		return $respuesta;
	}//function ctrMostrarProductos
	/*=============================================
	EDITAR PRODUCTO
	=============================================*/
	static public function ctrEditarProducto(){
		if(isset($_POST["accionProducto"]) && $_POST["accionProducto"] == "editar"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;
			$tabla = "vtama_producto";
			$codTipoProducto = ($_POST["tipoProducto"] == "") ? "NULL" : "'".$_POST["tipoProducto"]."'";
			$item = "dsc_producto";
			$valor = ms_escape_string(trim($_POST["nombreProducto"]));
			$entrada = "validarNombreRepetido";
			$nombre = ModeloProductos::mdlMostrarProductos($tabla,$item,$valor,$entrada);
			$item2 = "cod_producto";
			$valor2 = $_POST["codigoProducto"];
			$entrada2 = "capturarNombreProducto";
			$nombre2 = ModeloProductos::mdlMostrarProductos($tabla,$item2,$valor2,$entrada2);
			if($nombre['contador'] == 0 || trim($_POST["nombreProducto"]) == $nombre2["dsc_producto"]){
				$datos = array("cod_producto" => $_POST["codigoProducto"],
							   "cod_tipo_producto" => $codTipoProducto,
							   "dsc_producto" => ms_escape_string(trim($_POST["nombreProducto"])),
							   "cod_usr_modifica" => $_SESSION["cod_trabajador"],
							   "fch_modifica" => $fechaActual,
							   "dsc_detalle" => ms_escape_string(trim($_POST["observacionProducto"]))
							);
				$respuesta = ModeloProductos::mdlEditarProducto($tabla,$datos);
			}else{
				$respuesta = "nombreRepetido";
			}
			return $respuesta;
		}//if
	}//function ctrEditarProducto
	/*=============================================
	ELIMINAR PRODUCTO
	=============================================*/
	static public function ctrEliminarProducto(){
		if(isset($_POST["accionProducto"]) && $_POST["accionProducto"] == "eliminar"){
			$tabla ="vtama_producto";
			$datos = $_POST["codigoProducto"];
			$respuesta = ModeloProductos::mdlEliminarProducto($tabla, $datos);
			return $respuesta;
		}//if
	}//function ctrEliminarProducto
	/*=============================================
	DESCARGAR EXCEL
	=============================================*/
	public function ctrDescargarReporte(){
		if(isset($_GET["reporte"])){
			$tabla = "vtama_producto";
			$item = null;
			$valor = null;
			$entrada = null;
			$productos = ModeloProductos::mdlMostrarProductos($tabla,$item,$valor,$entrada);
			/*=============================================
			CREAMOS EL ARCHIVO DE EXCEL
			=============================================*/
			$name = $_GET["reporte"].'.xls';
			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate"); 
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public"); 
			header('Content-Disposition:; filename="'.$name.'"');
			header("Content-Transfer-Encoding: binary");
			echo Utf8Decode("<table border='0'>
					<tr> 
					<td style='font-weight:bold; border:1px solid #eee; text-align:center;'>CODIGO</td> 
					<td style='font-weight:bold; border:1px solid #eee; text-align:center;'>DESCRIPCION</td>
					<td style='font-weight:bold; border:1px solid #eee; text-align:center;'>TIPO</td>
					<td style='font-weight:bold; border:1px solid #eee; text-align:center;'>OBSERVACIONES</td>
					</tr>");
			foreach ($productos as $row => $item) {				
				echo Utf8Decode("<tr>
						<td style='border:1px solid #eee;'>".$item["cod_producto"]."</td>
						<td style='border:1px solid #eee;'>".$item["dsc_producto"]."</td>
						<td style='border:1px solid #eee;'>".$item["dsc_tipo_producto"]."</td>
						<td style='border:1px solid #eee;'>".$item["dsc_detalle"]."</td>
					</tr>");
			}//foreach
			echo "</table>";
		}//if
	}//function ctrDescargarReporte
}//class ControladorProductos