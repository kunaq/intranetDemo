<?php
class ControladorCotizacion{
	/*=============================================
	CREAR COTIZACION
	=============================================*/
	static public function ctrCrearCotizacion(){
		if(isset($_POST["accionCotizacion"]) && ($_POST["accionCotizacion"] == "crear" || $_POST["accionCotizacion"] == 'clonar')){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;
			$codCotizacion = maximoCodigoTabla('vtaca_cotizacion','cod_cotizacion','R');
			$codCotizacionImagen = str_replace("/", "", $codCotizacion);
			$rutaGlobal = realpath(dirname(__FILE__));
			$rutaGlobal = rutaGlobal($rutaGlobal);
			$tablaCotizacionAdjunto = "vtade_cotizacion_adjunto";
			$totalLineaClonar = 0;
			if($_POST["accionCotizacion"] == 'clonar'){
				$arrayDatoAdjuntoClonar = [];
				$numLineaAdjuntoClonar = [];
				$nombreAdjuntoClonar = [];
				$listaDatosAdjuntosClonar = json_decode($_POST["listaDatosAdjuntosClonarCotizacion"],true);
				if(count($listaDatosAdjuntosClonar) > 0){
					foreach ($listaDatosAdjuntosClonar as $key => $value) {
						$nuevoRutaClonar = $codCotizacionImagen."-".($key+1)."-".ms_escape_string(trim($value["dsc_archivo"]));
						$nuevoRutaClonar2 = $codCotizacionImagen."-".($key+1)."-".trim(utf8_decode($value["dsc_archivo"]));
						$rutaOriginal = $rutaGlobal."/archivos/cotizacion/".trim(utf8_decode($value["dsc_ruta_archivo"]));
						$rutaDestino = $rutaGlobal."/archivos/cotizacion/".$nuevoRutaClonar2;
						copy($rutaOriginal,$rutaDestino);
						array_push($arrayDatoAdjuntoClonar,$nuevoRutaClonar);
						array_push($numLineaAdjuntoClonar, $key+1);
						array_push($nombreAdjuntoClonar, ms_escape_string(trim($value["dsc_archivo"])));
						$totalLineaClonar++;
					}//foreach
					$respuestaAdjuntosClonar = ModeloCotizacion::mdlIngresarCotizacionAdjunto($tablaCotizacionAdjunto,$arrayDatoAdjuntoClonar,$numLineaAdjuntoClonar,$nombreAdjuntoClonar,$codCotizacion);
				}//if
			}//if clonar
			$arrayDatoAdjunto = [];
			$numLineaAdjunto = [];
			$nombreAdjunto = [];
			if($_FILES["adjuntoCotizacion"]["tmp_name"][0] != ''){
				for ($i=0; $i < count($_FILES["adjuntoCotizacion"]["tmp_name"]) ; $i++) {
					$fileCotizacion = $_FILES["adjuntoCotizacion"];
					$nombreDatoAdjunto = $codCotizacionImagen."-".($i+1+$totalLineaClonar)."-".ms_escape_string(trim($fileCotizacion["name"][$i]));
					$nombreDatoAdjunto2 = $codCotizacionImagen."-".($i+1+$totalLineaClonar)."-".trim(utf8_decode($fileCotizacion["name"][$i]));
					$ruta = $rutaGlobal."/archivos/cotizacion/".$nombreDatoAdjunto2;
					move_uploaded_file($fileCotizacion["tmp_name"][$i], $ruta);
					array_push($arrayDatoAdjunto,$nombreDatoAdjunto);
					array_push($numLineaAdjunto, $i+1+$totalLineaClonar);
					array_push($nombreAdjunto,ms_escape_string(trim($fileCotizacion["name"][$i])));
				}//for
				$respuestaAdjuntos = ModeloCotizacion::mdlIngresarCotizacionAdjunto($tablaCotizacionAdjunto,$arrayDatoAdjunto,$numLineaAdjunto,$nombreAdjunto,$codCotizacion);
			}//if
			$tablaCotizacionCab = "vtama_producto";
			$listaNuevosProductos = json_decode($_POST["listaNuevoProductoCotizacion"],true);
			if(count($listaNuevosProductos) > 0){
				foreach ($listaNuevosProductos as $key => $value) {
					$listaNuevosProductos[$key]["cod_tipo_producto"] = ($listaNuevosProductos[$key]["cod_tipo_producto"] == "") ? "NULL" : "'".$listaNuevosProductos[$key]["cod_tipo_producto"]."'";
					array_push($listaNuevosProductos[$key],$_SESSION["cod_trabajador"],$fechaActual,'','');
				}
				$desdeProductos = null;
				$respuestaProductos = ModeloProductos::mdlIngresarProducto($tablaCotizacionCab,$desdeProductos,$listaNuevosProductos);
			}//if
			$fchEmision = explode("-", $_POST["fechaEmisionCotizacion"]);
			if($_POST["valorCheckTotalDescuentoCotizacion"] == "NO"){
				$codTipoDescuento = "";
				$impDescuento = 0;
			}else{
				$codTipoDescuento = $_POST["selectDescuentoCotizacion"];
				$impDescuento = ($_POST["totalDescuentoCotizacion"] == "") ? 0 : $_POST["totalDescuentoCotizacion"];
			}
			$tabla = "vtaca_cotizacion";
			$datos = array("cod_cotizacion" => $codCotizacion,
						   "cod_estado_cotizacion" => $_POST["estadoCotizacion"],
						   "cod_cliente" => $_POST["clienteCotizacion"],
						   "cod_moneda" => $_POST["monedaCotizacion"],
						   "cod_forma_pago" => $_POST["formaPagoCotizacion"],
						   "dsc_contacto" => ms_escape_string(trim($_POST["contactoCotizacion"])),
						   "dsc_correo" => ms_escape_string(trim($_POST["correoCotizacion"])),
						   "dsc_cargo" => trim($_POST["cargoCotizacion"]),
						   "dsc_telefono" => ms_escape_string(trim($_POST["telefonoCotizacion"])),
						   "dsc_orden_compra" => ms_escape_string(trim($_POST["ordenCompraCotizacion"])),
						   "dsc_referencia" => ms_escape_string(trim($_POST["referenciaCotizacion"])),
						   "dsc_lugar_entrega" => ms_escape_string(trim($_POST["lugarEntregaCotizacion"])),
						   "dsc_tiempo_entrega" => ms_escape_string(trim($_POST["tiempoEntregaCotizacion"])),
						   "dsc_validez_oferta" => ms_escape_string(trim($_POST["validezOfertaCotizacion"])),
						   "dsc_garantia" => ms_escape_string(trim($_POST["garantiaCotizacion"])),
						   "fch_emision" => $fchEmision[2].'-'.$fchEmision[1].'-'.$fchEmision[0],
						   "cod_usr_registro" => $_SESSION["cod_trabajador"],
						   "fch_registro" => $fechaActual,
						   "imp_subtotal" => str_replace(",","",$_POST["subTotalCotizacion"]),
						   "imp_igv" => str_replace(",","",$_POST["igvCotizacion"]),
						   "imp_total" => str_replace(",","",$_POST["totalCotizacion"]),
						   "dsc_observacion" => ms_escape_string(trim($_POST["observacionGeneralCotizacion"])),
						   "cod_tipo_descuento" => $codTipoDescuento,
						   "imp_descuento" => $impDescuento,
						   "flg_descuento" => $_POST["valorCheckTotalDescuentoCotizacion"],
						   "cod_cotizacion_principal" => '',
						   "num_orden_produccion" => $_POST["nroOrdenProdCtzn"],
						   "fchEmision_orden_compra" => ordenarFechaDate($_POST["fchEmsOrdCmpCotizacion"])
						   );
			$respuesta = ModeloCotizacion::mdlIngresarCotizacion($tabla,$datos);
			if($respuesta == "ok"){
				$tabla2 = "vtade_cotizacion";
				$listaProductos = json_decode($_POST["listaProductosCotizacion"],true);
				foreach ($listaProductos as $key => $value) {
					$listaProductos[$key]["dsc_observacion"] = (trim($listaProductos[$key]["dsc_observacion"]));
					$listaProductos[$key]["num_dscto"] = ($value["num_dscto"] == '') ? 0 : $listaProductos[$key]["num_dscto"];
					$listaProductos[$key]["total_dscto"] = ($value["total_dscto"] == '') ? 0 : $listaProductos[$key]["total_dscto"];
					if($value["cod_producto"] == NULL){
						$listaProductos[$key]["cod_producto"] = $respuestaProductos[$value["num_linea"]];
					}
				}//foreach
				$respuesta2 = ModeloCotizacion::mdlIngresarCotizacionDetalle($tabla2,$codCotizacion,$listaProductos);
				return $respuesta2;
			}//if
		}//if
	}//function ctrCrearCotizacion
	/*=============================================
	EDITAR COTIZACION
	=============================================*/
	static public function ctrEditarCotizacion(){
		//if(isset($_POST["codigoCotizacion"])){
		if(isset($_POST["accionCotizacion"]) && $_POST["accionCotizacion"] == "editar"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;
			$entrada = $_POST["entradaCtz"];
			if($entrada == 'estadoAprobado'){
				$codCotizacionImagen = str_replace("/", "", $_POST["codigoCotizacionOriginal"]);
				$tablaCotizacionAdjunto = "vtade_cotizacion_adjunto";
				$rutaGlobal = realpath(dirname(__FILE__));
				$rutaGlobal = rutaGlobal($rutaGlobal);
				$tabla = "vtaca_cotizacion";
				$datos = array("cod_cotizacion" => $_POST["codigoCotizacionOriginal"],
							   "num_orden_produccion" => $_POST["nroOrdenProdCtzn"]
						);
				/*=============================================
				ELIMINAR DATOS ADJUNTOS
				=============================================*/
				$listaEliminarDatosAdjntos = json_decode($_POST["listaDatosAdjuntosCotizacion"],true);
				if(count($listaEliminarDatosAdjntos) > 0){
					ModeloCotizacion::mdlEliminarCotizacionDatosAdjuntos($tablaCotizacionAdjunto,$listaEliminarDatosAdjntos,$_POST["codigoCotizacionOriginal"]);
					foreach ($listaEliminarDatosAdjntos as $key => $value) {
						$rutaEliminarDatoAdjunto = $rutaGlobal."/archivos/cotizacion/".utf8_decode($value["dsc_ruta_archivo"]);
						unlink($rutaEliminarDatoAdjunto);
					}//foreach
				}//if
				/*=============================================
				INSERTAR DATOS ADJUNTOS
				=============================================*/
				$arrayDatoAdjunto = [];
				$numLineaAdjunto = [];
				$nombreAdjunto = [];
				if($_FILES["adjuntoCotizacion"]["tmp_name"][0] != ''){
					$maxNumLineaDatosAdjuntos = ModeloCotizacion::mdlMaxValorDatosAdjuntosCotizacion($tablaCotizacionAdjunto,$_POST["codigoCotizacionOriginal"]);
					for ($i=0; $i < count($_FILES["adjuntoCotizacion"]["tmp_name"]) ; $i++) {
						$fileCotizacion = $_FILES["adjuntoCotizacion"];
						$nombreDatoAdjunto = $codCotizacionImagen."-".($i+1+$maxNumLineaDatosAdjuntos["max_num_linea"])."-".ms_escape_string(trim($fileCotizacion["name"][$i]));
						$nombreDatoAdjunto2 = $codCotizacionImagen."-".($i+1+$maxNumLineaDatosAdjuntos["max_num_linea"])."-".trim(utf8_decode($fileCotizacion["name"][$i]));
						$ruta = $rutaGlobal."/archivos/cotizacion/".$nombreDatoAdjunto2;
						move_uploaded_file($fileCotizacion["tmp_name"][$i], $ruta);
						array_push($arrayDatoAdjunto,$nombreDatoAdjunto);
						array_push($numLineaAdjunto,$i+1+$maxNumLineaDatosAdjuntos["max_num_linea"]);
						array_push($nombreAdjunto,ms_escape_string(trim($fileCotizacion["name"][$i])));
					}//for
					$respuestaAdjuntos = ModeloCotizacion::mdlIngresarCotizacionAdjunto($tablaCotizacionAdjunto,$arrayDatoAdjunto,$numLineaAdjunto,$nombreAdjunto,$_POST["codigoCotizacionOriginal"]);
				}
				$respuesta = ModeloCotizacion::mdlEditarCotizacion($tabla,$datos,$entrada);
				return $respuesta;
			}else{
				$fchEmision = explode("-", $_POST["fechaEmisionCotizacion"]);
				if($_POST["valorCheckTotalDescuentoCotizacion"] == "NO"){
					$codTipoDescuento = "";
					$impDescuento = 0;
					}else{
						$codTipoDescuento = $_POST["selectDescuentoCotizacion"];
						$impDescuento = $_POST["totalDescuentoCotizacion"];
					}
				$tabla = "vtaca_cotizacion";
				$datos = array("cod_cotizacion" => $_POST["codigoCotizacionOriginal"],
							   "cod_estado_cotizacion" => $_POST["estadoCotizacion"],
							   "cod_cliente" => $_POST["clienteCotizacion"],
							   "cod_moneda" => $_POST["monedaCotizacion"],
							   "cod_forma_pago" => $_POST["formaPagoCotizacion"],
							   "dsc_contacto" => ms_escape_string(trim($_POST["contactoCotizacion"])),
							   "dsc_correo" => trim($_POST["correoCotizacion"]),
							   "dsc_cargo" => ms_escape_string(trim($_POST["cargoCotizacion"])),
							   "dsc_telefono" => ms_escape_string(trim($_POST["telefonoCotizacion"])),
							   "dsc_orden_compra" => ms_escape_string(trim($_POST["ordenCompraCotizacion"])),
							   "dsc_referencia" => ms_escape_string(trim($_POST["referenciaCotizacion"])),
							   "dsc_lugar_entrega" => ms_escape_string(trim($_POST["lugarEntregaCotizacion"])),
							   "dsc_tiempo_entrega" => ms_escape_string(trim($_POST["tiempoEntregaCotizacion"])),
							   "dsc_validez_oferta" => ms_escape_string(trim($_POST["validezOfertaCotizacion"])),
							   "dsc_garantia" => ms_escape_string(trim($_POST["garantiaCotizacion"])),
							   "fch_emision" => $fchEmision[2].'-'.$fchEmision[1].'-'.$fchEmision[0],
							   "cod_usr_modifica" => $_SESSION["cod_trabajador"],
							   "fch_modifica" => $fechaActual,				   
							   "imp_subtotal" => str_replace(",","",$_POST["subTotalCotizacion"]),
							   "imp_igv" => str_replace(",","",$_POST["igvCotizacion"]),
							   "imp_total" => str_replace(",","",$_POST["totalCotizacion"]),
							   "dsc_observacion" => ms_escape_string(trim($_POST["observacionGeneralCotizacion"])),
							   "cod_tipo_descuento" => $codTipoDescuento,
							   "imp_descuento" => $impDescuento,
							   "flg_descuento" => $_POST["valorCheckTotalDescuentoCotizacion"],
							   "cod_cotizacion_nuevo" => $_POST["codigoCotizacion"],
							   "num_orden_produccion" => $_POST["nroOrdenProdCtzn"],
							   "fchEmision_orden_compra" => ordenarFechaDate($_POST["fchEmsOrdCmpCotizacion"])
							   );
				$codCotizacionImagen = str_replace("/", "", $_POST["codigoCotizacion"]);
				$tablaCotizacionAdjunto = "vtade_cotizacion_adjunto";
				$rutaGlobal = realpath(dirname(__FILE__));
				$rutaGlobal = rutaGlobal($rutaGlobal);
				/*=============================================
				COMPROBAR SI EL CODIGO A MODIFICAR YA EXISTE
				=============================================*/
				$contCodCotizacion = ModeloCotizacion::mdlVerificarExisteCotizacion($tabla,$_POST["codigoCotizacion"]);
				if($contCodCotizacion["contadorCod"] > 0 && $_POST["codigoCotizacionOriginal"] != $_POST["codigoCotizacion"]){
					return "codigoRepetido";
				}else{
					if($_POST["accionEditar"] == "cambiarCabecera")	{
						/*=============================================
						ELIMINAR DATOS ADJUNTOS
						=============================================*/
						$listaEliminarDatosAdjntos = json_decode($_POST["listaDatosAdjuntosCotizacion"],true);
						if(count($listaEliminarDatosAdjntos) > 0){
							ModeloCotizacion::mdlEliminarCotizacionDatosAdjuntos($tablaCotizacionAdjunto,$listaEliminarDatosAdjntos,$_POST["codigoCotizacionOriginal"]);
							foreach ($listaEliminarDatosAdjntos as $key => $value) {
								$rutaEliminarDatoAdjunto = $rutaGlobal."/archivos/cotizacion/".utf8_decode($value["dsc_ruta_archivo"]);
								unlink($rutaEliminarDatoAdjunto);
							}//foreach
						}//if
						/*=============================================
						INSERTAR DATOS ADJUNTOS
						=============================================*/
						$arrayDatoAdjunto = [];
						$numLineaAdjunto = [];
						$nombreAdjunto = [];
						if($_FILES["adjuntoCotizacion"]["tmp_name"][0] != ''){
							$maxNumLineaDatosAdjuntos = ModeloCotizacion::mdlMaxValorDatosAdjuntosCotizacion($tablaCotizacionAdjunto,$_POST["codigoCotizacionOriginal"]);
							for ($i=0; $i < count($_FILES["adjuntoCotizacion"]["tmp_name"]) ; $i++) {
								$fileCotizacion = $_FILES["adjuntoCotizacion"];
								$nombreDatoAdjunto = $codCotizacionImagen."-".($i+1+$maxNumLineaDatosAdjuntos["max_num_linea"])."-".ms_escape_string(trim($fileCotizacion["name"][$i]));
								$nombreDatoAdjunto2 = $codCotizacionImagen."-".($i+1+$maxNumLineaDatosAdjuntos["max_num_linea"])."-".trim(utf8_decode($fileCotizacion["name"][$i]));
								$ruta = $rutaGlobal."/archivos/cotizacion/".$nombreDatoAdjunto2;
								move_uploaded_file($fileCotizacion["tmp_name"][$i], $ruta);
								array_push($arrayDatoAdjunto,$nombreDatoAdjunto);
								array_push($numLineaAdjunto,$i+1+$maxNumLineaDatosAdjuntos["max_num_linea"]);
								array_push($nombreAdjunto,ms_escape_string(trim($fileCotizacion["name"][$i])));
							}//for
							$respuestaAdjuntos = ModeloCotizacion::mdlIngresarCotizacionAdjunto($tablaCotizacionAdjunto,$arrayDatoAdjunto,$numLineaAdjunto,$nombreAdjunto,$_POST["codigoCotizacionOriginal"]);
						}//if
						$respuestaCotizacion = ModeloCotizacion::mdlEditarCotizacion($tabla,$datos,$entrada);
						return $respuestaCotizacion;
					}
					if($_POST["accionEditar"] == "cambiarDetalle"){
						/*=============================================
						ELIMINAR DATOS ADJUNTOS
						=============================================*/
						$listaEliminarDatosAdjntos = json_decode($_POST["listaDatosAdjuntosCotizacion"],true);
						if(count($listaEliminarDatosAdjntos) > 0){
							ModeloCotizacion::mdlEliminarCotizacionDatosAdjuntos($tablaCotizacionAdjunto,$listaEliminarDatosAdjntos,$_POST["codigoCotizacionOriginal"]);
							foreach ($listaEliminarDatosAdjntos as $key => $value) {
								$rutaEliminarDatoAdjunto = $rutaGlobal."/archivos/cotizacion/".utf8_decode($value["dsc_ruta_archivo"]);
								unlink($rutaEliminarDatoAdjunto);
							}//foreach
						}//if
						/*=============================================
						INSERTAR DATOS ADJUNTOS
						=============================================*/
						$arrayDatoAdjunto = [];
						$numLineaAdjunto = [];
						$nombreAdjunto = [];
						if($_FILES["adjuntoCotizacion"]["tmp_name"][0] != ''){
							$maxNumLineaDatosAdjuntos = ModeloCotizacion::mdlMaxValorDatosAdjuntosCotizacion($tablaCotizacionAdjunto,$_POST["codigoCotizacionOriginal"]);
							for ($i=0; $i < count($_FILES["adjuntoCotizacion"]["tmp_name"]) ; $i++) {
								$fileCotizacion = $_FILES["adjuntoCotizacion"];
								$nombreDatoAdjunto = $codCotizacionImagen."-".($i+1+$maxNumLineaDatosAdjuntos["max_num_linea"])."-".ms_escape_string(trim($fileCotizacion["name"][$i]));
								$nombreDatoAdjunto2 = $codCotizacionImagen."-".($i+1+$maxNumLineaDatosAdjuntos["max_num_linea"])."-".trim(utf8_decode($fileCotizacion["name"][$i]));
								$ruta = $rutaGlobal."/archivos/cotizacion/".$nombreDatoAdjunto2;
								move_uploaded_file($fileCotizacion["tmp_name"][$i], $ruta);
								array_push($arrayDatoAdjunto,$nombreDatoAdjunto);
								array_push($numLineaAdjunto,$i+1+$maxNumLineaDatosAdjuntos["max_num_linea"]);
								array_push($nombreAdjunto,ms_escape_string(trim($fileCotizacion["name"][$i])));
							}//for
							$respuestaAdjuntos = ModeloCotizacion::mdlIngresarCotizacionAdjunto($tablaCotizacionAdjunto,$arrayDatoAdjunto,$numLineaAdjunto,$nombreAdjunto,$_POST["codigoCotizacion"]);
						}//if
						$respuestaCotizacion = ModeloCotizacion::mdlEditarCotizacion($tabla,$datos,$entrada);
						//ELIMINA LOS DETALLES DE LA COTIZACION E INSERTO LOS NUEVOS DETALLES
						if($respuestaCotizacion == "ok"){
							//ELIMINA LOS DETALLES
							$tablaCotizacionDet = "vtade_cotizacion";
							ModeloCotizacion::mdlEliminarCotizacionDetalle($tablaCotizacionDet,$_POST["codigoCotizacionOriginal"]);
							//INSERTA SI EXISTEN NUEVOS PRODUCTOS
							$tablaProductos = "vtama_producto";
							$listaNuevosProductos = json_decode($_POST["listaNuevoProductoCotizacion"],true);
							if(count($listaNuevosProductos) > 0){
								foreach ($listaNuevosProductos as $key => $value) {
									$listaNuevosProductos[$key]["cod_tipo_producto"] = ($listaNuevosProductos[$key]["cod_tipo_producto"] == "") ? "NULL" : "'".$listaNuevosProductos[$key]["cod_tipo_producto"]."'";
									array_push($listaNuevosProductos[$key],$_SESSION["cod_trabajador"],$fechaActual,'','');
								}
								$desdeProductos = null;
								$respuestaProductos = ModeloProductos::mdlIngresarProducto($tablaProductos,$desdeProductos,$listaNuevosProductos);	
							}//if
							//INSERTA LOS DETALLES					
							$listaProductos = json_decode($_POST["listaProductosCotizacion"],true);
							foreach ($listaProductos as $key => $value) {
								$listaProductos[$key]["dsc_observacion"] = ms_escape_string(trim($listaProductos[$key]["dsc_observacion"]));
								if($value["cod_producto"] == NULL){
									$listaProductos[$key]["cod_producto"] = $respuestaProductos[$value["num_linea"]];
								}//if
								$listaProductos[$key]["total_dscto"] = valorVacioEntero($listaProductos[$key]["total_dscto"]);
								$listaProductos[$key]["num_dscto"] = valorVacioEntero($listaProductos[$key]["num_dscto"]);
							}//foreach
							$respuesta2 = ModeloCotizacion::mdlIngresarCotizacionDetalle($tablaCotizacionDet,$_POST["codigoCotizacion"],$listaProductos);
							//echo $respuesta2.'||';
							return $respuesta2;
						}//if
					}else if($_POST["accionEditar"] == "nuevaVersionDetalle"){
						$tablaCotizacionDet = "vtade_cotizacion";
						$codCotizacion = maximoCodigoTabla('vtaca_cotizacion','cod_cotizacion','R',$_POST["codigoCotizacion"]);
						$datos["cod_cotizacion"] = $codCotizacion;
						$datos["fch_registro"] = $fechaActual;
						$datos["cod_usr_registro"] = $_SESSION["cod_trabajador"];
						$datos["cod_cotizacion_principal"] = $_POST["codigoCotizacion"];
						$respuestaCotizacion = ModeloCotizacion::mdlIngresarCotizacion($tabla,$datos);
						if($respuestaCotizacion == "ok"){
							//INSERTA SI EXISTEN NUEVOS PRODUCTOS
							$tablaProductos = "vtama_producto";
							$listaNuevosProductos = json_decode($_POST["listaNuevoProductoCotizacion"],true);
							if(count($listaNuevosProductos) > 0){
								foreach ($listaNuevosProductos as $key => $value) {
									$listaNuevosProductos[$key]["cod_tipo_producto"] = ($listaNuevosProductos[$key]["cod_tipo_producto"] == "") ? "NULL" : "'".$listaNuevosProductos[$key]["cod_tipo_producto"]."'";
									array_push($listaNuevosProductos[$key],$_SESSION["cod_trabajador"],$fechaActual,'','');
								}
								$desdeProductos = null;
								$respuestaProductos = ModeloProductos::mdlIngresarProducto($tablaProductos,$desdeProductos,$listaNuevosProductos);	
							}//if
							//INSERTA LOS DETALLES					
							$listaProductos = json_decode($_POST["listaProductosCotizacion"],true);
							foreach ($listaProductos as $key => $value) {
								$listaProductos[$key]["dsc_observacion"] = ms_escape_string(trim($listaProductos[$key]["dsc_observacion"]));
								if($value["cod_producto"] == NULL){
									$listaProductos[$key]["cod_producto"] = $respuestaProductos[$value["num_linea"]];
								}
								$listaProductos[$key]["total_dscto"] = valorVacioEntero($listaProductos[$key]["total_dscto"]);
								$listaProductos[$key]["num_dscto"] = valorVacioEntero($listaProductos[$key]["num_dscto"]);
							}//foreach
							$respuesta2 = ModeloCotizacion::mdlIngresarCotizacionDetalle($tablaCotizacionDet,$codCotizacion,$listaProductos);
							//INSERTO LOS DATOS ADJUNTOS
							$codCotizacionImagen = str_replace("/", "", $codCotizacion);
							$tablaCotizacionAdjunto = "vtade_cotizacion_adjunto";
							$totalLineaClonar = 0;
							$arrayDatoAdjuntoClonar = [];
							$numLineaAdjuntoClonar = [];
							$nombreAdjuntoClonar = [];
							$listaDatosAdjuntosClonar = json_decode($_POST["listaDatosAdjuntosClonarCotizacion"],true);
							if(count($listaDatosAdjuntosClonar) > 0){
								foreach ($listaDatosAdjuntosClonar as $key => $value) {
									$nuevoRutaClonar = $codCotizacionImagen."-".($key+1)."-".ms_escape_string(trim($value["dsc_archivo"]));
									$nuevoRutaClonar2 = $codCotizacionImagen."-".($key+1)."-".trim(utf8_decode($value["dsc_archivo"]));
									$rutaOriginal = $rutaGlobal."/archivos/cotizacion/".trim(utf8_decode($value["dsc_ruta_archivo"]));
									$rutaDestino = $rutaGlobal."/archivos/cotizacion/".$nuevoRutaClonar2;
									copy($rutaOriginal,$rutaDestino);
									array_push($arrayDatoAdjuntoClonar,$nuevoRutaClonar);
									array_push($numLineaAdjuntoClonar, $key+1);
									array_push($nombreAdjuntoClonar, ms_escape_string(trim($value["dsc_archivo"])));
									$totalLineaClonar++;
								}//foreach
								$respuestaAdjuntosClonar = ModeloCotizacion::mdlIngresarCotizacionAdjunto($tablaCotizacionAdjunto,$arrayDatoAdjuntoClonar,$numLineaAdjuntoClonar,$nombreAdjuntoClonar,$codCotizacion);
							}//if
							$arrayDatoAdjunto = [];
							$numLineaAdjunto = [];
							$nombreAdjunto = [];
							if($_FILES["adjuntoCotizacion"]["tmp_name"][0] != ''){
								for ($i=0; $i < count($_FILES["adjuntoCotizacion"]["tmp_name"]) ; $i++) {
									$fileCotizacion = $_FILES["adjuntoCotizacion"];
									$nombreDatoAdjunto = $codCotizacionImagen."-".($i+1+$totalLineaClonar)."-".ms_escape_string(trim($fileCotizacion["name"][$i]));
									$nombreDatoAdjunto2 = $codCotizacionImagen."-".($i+1+$totalLineaClonar)."-".trim(utf8_decode($fileCotizacion["name"][$i]));
									$ruta = $rutaGlobal."/archivos/cotizacion/".$nombreDatoAdjunto2;
									move_uploaded_file($fileCotizacion["tmp_name"][$i], $ruta);
									array_push($arrayDatoAdjunto,$nombreDatoAdjunto);
									array_push($numLineaAdjunto, $i+1+$totalLineaClonar);
									array_push($nombreAdjunto,ms_escape_string(trim($fileCotizacion["name"][$i])));
								}//for
								$respuestaAdjuntos = ModeloCotizacion::mdlIngresarCotizacionAdjunto($tablaCotizacionAdjunto,$arrayDatoAdjunto,$numLineaAdjunto,$nombreAdjunto,$codCotizacion);
							}//if
						}//if
						return $respuestaCotizacion;
					}//if	
				}	
			}
		}//if
	}//function ctrEditarCotizacion
	//static public function ctrMostrarCotizacion($item,$valor,$entrada,$cliente,$producto,$fechaInicial,$fechaFinal){
	static public function ctrMostrarCotizacion($valor1,$valor2,$valor3,$valor4,$valor5,$entrada){
		$tabla1 = "vtaca_cotizacion";
		$respuesta = ModeloCotizacion::mdlMostrarCotizacion($tabla1,$valor1,$valor2,$valor3,$valor4,$valor5,$entrada);
		return $respuesta;
	}//function ctrMostrarCotizacion
	static public function ctrMostrarCotizacionDetalle($item,$valor,$entrada){
		$tabla = "vtade_cotizacion";
		$respuesta = ModeloCotizacion::mdlMostrarCotizacionDetalle($tabla, $item, $valor, $entrada);
		return $respuesta;
	}//function ctrMostrarCotizacionDetalle
	static public function ctrMostrarCotizacionDatosAdjuntos($item,$valor){
		$tabla = "vtade_cotizacion_adjunto";
		$respuesta = ModeloCotizacion::mdlMostrarCotizacionDatosAdjuntos($tabla, $item, $valor);
		return $respuesta;
	}//function ctrMostrarCotizacionDatosAdjuntos
	/*=============================================
	ELIMINAR COTIZACIÓN
	=============================================*/
	static public function ctrEliminarCotizacion(){
		if(isset($_POST["accionCotizacion"]) && $_POST["accionCotizacion"] == "eliminar"){
			$tabla ="vtaca_cotizacion";
			$datos = $_POST["codigoCotizacion"];
			$respuesta = ModeloCotizacion::mdlEliminarCotizacion($tabla, $datos);
			return $respuesta;
		}//if		
	}//function ctrEliminarCotizacion
	static public function ctrEnviarCorreoCotizacion(){
		$mail = new PHPMailer\PHPMailer\PHPMailer();
		$correoEnviar = $_POST['receptorCorreoCotizacion'];
		$mensaje = "<p>Hola se envio correo cotización</p>";
		$mail -> isSMTP();
		$mail->Host = 'smtp.office365.com';
		$mail->Port = 587;
		$mail->SMTPSecure = 'tls';
	  	$mail->SMTPAuth = true;
		$mail->Username = 'indelat_prueba@hotmail.com';
		$mail->Password = 'indelat123456';
		$mail->setFrom('indelat_prueba@hotmail.com', 'Soporte Indelat');
		$mail->addAddress($correoEnviar);
		$mail->Subject = 'Mesa de Ayuda Idenlat';
		$mail->Body    = $mensaje;
		$mail->IsHTML(true);
		$mail->CharSet = 'UTF-8';
		if($mail->send()){
			return "ok";
		}else{			
			return "Error mensaje: ".$mail->ErrorInfo;
		}
	}//function ctrEnviarCorreoCotizacion
}//ControladorCotizacion