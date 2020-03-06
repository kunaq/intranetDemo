<?php
class ControladorClientes{
	/*=============================================
	CREAR CLIENTE
	=============================================*/
	static public function ctrCrearCliente(){
		if(isset($_POST["accionCliente"]) && $_POST["accionCliente"] == "crear"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;
			$codCliente = maximoCodigoTabla('vtama_cliente','cod_cliente','CL');
			$item = "flg_ruc";
			$valor = "SI";
			$tipoDocumento = ControladorTipoDocumento::ctrMostrarTipoDocumento($item,$valor);
			$nuevoDepartamento = isset($_POST["departamentoCliente"]) ? $_POST["departamentoCliente"] : '';
			$nuevaProvincia = isset($_POST["provinciaCliente"]) ? $_POST["provinciaCliente"] : '';
			$nuevoDistrito = isset($_POST["distritoCliente"]) ? $_POST["distritoCliente"] : '';
			$tabla = "vtama_cliente";
			/*=============================================
			VALIDAR DOCUMENTO REPETIDO
			=============================================*/			
			$itemDocumento = "dsc_documento";
			$valorDocumento = ms_escape_string(trim($_POST["documentoCliente"]));
			$entradaDocumento = "validarDocumentoRepetido";
			$documentoRepetido = ModeloClientes::mdlMostrarClientes($tabla,$itemDocumento,$valorDocumento,$entradaDocumento);
			if($documentoRepetido['contador'] == 0){
				$datos = array("cod_cliente" => $codCliente,
							   "dsc_razon_social" => ms_escape_string(trim($_POST["nombreCliente"])),
							   "cod_tipo_documento" => $tipoDocumento["cod_tipo_documento"],
							   "dsc_documento" => ms_escape_string(trim($_POST["documentoCliente"])),
							   "cod_categoria_cliente" => $_POST["categoriaCliente"],
							   "cod_forma_pago" => $_POST["formaPagoCliente"],
							   "cod_pais" => $_POST["paisCliente"],
							   "cod_departamento" => $nuevoDepartamento,
							   "cod_provincia" => $nuevaProvincia,
							   "cod_distrito" => $nuevoDistrito,
							   "dsc_direccion" => ms_escape_string(trim($_POST["direccionCliente"])),
							   "cod_usr_registro" => $_SESSION["cod_trabajador"],
							   "fch_registro" => $fechaActual);
				$respuesta = ModeloClientes::mdlIngresarCliente($tabla,$datos);
				$respuestaArray = ["respuesta" => $respuesta,
								   "codigo" => $codCliente,
								   "nombre" => ms_escape_string(trim($_POST["nombreCliente"]))
								  ];
			}else{
				$respuestaArray = ["respuesta" => "documentoRepetido"];
			}
			return $respuestaArray;
		}//if
	}//function ctrCrearCliente
	/*=============================================
	MOSTRAR CLIENTES
	=============================================*/
	static public function ctrMostrarClientes($item,$valor,$entrada){
		$tabla = "vtama_cliente";
		$respuesta = ModeloClientes::mdlMostrarClientes($tabla,$item,$valor,$entrada);
		return $respuesta;
	}//function ctrMostrarClientes
	/*=============================================
	EDITAR CLIENTE
	=============================================*/
	static public function ctrEditarCliente(){
		if(isset($_POST["accionCliente"]) && $_POST["accionCliente"] == "editar"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;
			$editarDepartamento = isset($_POST["departamentoCliente"]) ? $_POST["departamentoCliente"] : '';
			$editarProvincia = isset($_POST["provinciaCliente"]) ? $_POST["provinciaCliente"] : '';
			$editarDistrito = isset($_POST["distritoCliente"]) ? $_POST["distritoCliente"] : '';
			$tabla = "vtama_cliente";
			/*=============================================
			VALIDAR DOCUMENTO REPETIDO
			=============================================*/			
			$itemDocumento = "dsc_documento";
			$valorDocumento = ms_escape_string(trim($_POST["documentoCliente"]));
			$entradaDocumento = "validarDocumentoRepetido";
			$documentoRepetido = ModeloClientes::mdlMostrarClientes($tabla,$itemDocumento,$valorDocumento,$entradaDocumento);
			$itemDocumento2 = "cod_cliente";
			$valorDocumento2 = $_POST["codigoCliente"];
			$entradaDocumento2 = "capturarDocumentoCliente";
			$nombreDocumento2 = ModeloClientes::mdlMostrarClientes($tabla,$itemDocumento2,$valorDocumento2,$entradaDocumento2);
			if($documentoRepetido['contador'] == 0 || trim($_POST["documentoCliente"]) == $nombreDocumento2["dsc_documento"]){
				$datos = array("cod_cliente" => $_POST["codigoCliente"],
							   "dsc_razon_social" => ms_escape_string(trim($_POST["nombreCliente"])),
							   "dsc_documento" => ms_escape_string(trim($_POST["documentoCliente"])),
							   "cod_categoria_cliente" => $_POST["categoriaCliente"],
							   "cod_forma_pago" => $_POST["formaPagoCliente"],
							   "cod_pais" => $_POST["paisCliente"],
							   "cod_departamento" => $editarDepartamento,
							   "cod_provincia" => $editarProvincia,
							   "cod_distrito" => $editarDistrito,
							   "dsc_direccion" => ms_escape_string(trim($_POST["direccionCliente"])),
							   "cod_usr_modifica" => $_SESSION["cod_trabajador"],
							   "fch_modifica" => $fechaActual);
				$respuesta = ModeloClientes::mdlEditarCliente($tabla,$datos);
				$respuestaArray = ["respuesta" => $respuesta];
			}else{
				$respuestaArray = ["respuesta" => "documentoRepetido"];
			}
			return $respuestaArray;
		}//if
	}//function ctrEditarCliente
	/*=============================================
	ELIMINAR CLIENTE
	=============================================*/
	static public function ctrEliminarCliente(){
		if(isset($_POST["accionCliente"]) && $_POST["accionCliente"] == "eliminar"){
			$tabla ="vtama_cliente";
			$datos = $_POST["codigoCliente"];
			$respuesta = ModeloClientes::mdlEliminarCliente($tabla,$datos);
			return $respuesta;
		}//if
	}//function ctrEliminarCliente
	/*=============================================
	DESCARGAR EXCEL
	=============================================*/
	public function ctrDescargarReporte(){
		if(isset($_GET["reporte"])){
			$tabla = "vtama_cliente";
			$item = null;
			$valor = null;
			$entrada = null;
			$clientes = ModeloClientes::mdlMostrarClientes($tabla,$item,$valor,$entrada);
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
					<td style='font-weight:bold; border:1px solid #eee;text-align:center;'>RUC</td> 
					<td style='font-weight:bold; border:1px solid #eee;text-align:center;'>RAZON SOCIAL</td>
					<td style='font-weight:bold; border:1px solid #eee;text-align:center;'>CATEGORIA</td>
					<td style='font-weight:bold; border:1px solid #eee;text-align:center;'>DIRECCION</td>
					<td style='font-weight:bold; border:1px solid #eee;text-align:center;'>PAIS</td>
					<td style='font-weight:bold; border:1px solid #eee;text-align:center;'>DEPARTAMENTO</td>
					<td style='font-weight:bold; border:1px solid #eee;text-align:center;'>PROVINCIA</td>
					<td style='font-weight:bold; border:1px solid #eee;text-align:center;'>DISTRITO</td>
					</tr>");
			foreach ($clientes as $row => $item) {				
				echo Utf8Decode("<tr>
						<td style='border:1px solid #eee;'>".$item["dsc_documento"]."</td>
						<td style='border:1px solid #eee;'>".$item["dsc_razon_social"]."</td>
						<td style='border:1px solid #eee;'>".$item["dsc_categoria_cliente"]."</td>
						<td style='border:1px solid #eee;'>".$item["dsc_direccion"]."</td>
						<td style='border:1px solid #eee;'>".$item["dsc_pais"]."</td>
						<td style='border:1px solid #eee;'>".$item["dsc_departamento"]."</td>
						<td style='border:1px solid #eee;'>".$item["dsc_provincia"]."</td>
						<td style='border:1px solid #eee;'>".$item["dsc_distrito"]."</td>
					</tr>");
			}//foreach
			echo "</table>";
		}//if
	}//function ctrDescargarReporte
}//class ControladorCliente