<?php
class ControladorContacto{
	public $archivo;
	/*=============================================
	MOSTRAR CONTACTO
	=============================================*/
	static public function ctrMostrarContacto($item1,$valor1,$entrada){
		$tabla1 = 'vtaca_contacto';
		$tabla2 = 'vtama_cliente';
		$respuesta = ModeloContacto::mdlMostrarContacto($item1,$valor1,$entrada,$tabla1,$tabla2);
		return trimForeach($respuesta);
	}//function ctrMostrarContacto
	/*=============================================
	CREAR CONTACTO
	=============================================*/
	public function ctrCrearContacto(){
		if(isset($_POST["accionContacto"]) && ($_POST["accionContacto"] == "crear")){			
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;
			$fchRegistroContacto = explode("-", $_POST["fechaRegistroContacto"]);
			$fchAtencion = explode("-", $_POST["fechaAtencionContacto"]);
			$tabla1 = "vtaca_contacto";
			$tabla2 = "vtade_contacto_informe";
			$codContacto = maximoCodigoTabla($tabla1,'cod_contacto','CON');
			$tipoContacto = explode("|", $_POST["tipoContacto"]);
			$rutaGlobal = realpath(dirname(__FILE__));
			$rutaGlobal = rutaGlobal($rutaGlobal);
			$datos = array("cod_contacto" => $codContacto,
						   "cod_cliente" => $_POST["clienteContacto"],
						   "cod_canal" => $_POST["canalContacto"],
						   "cod_tipo" => $tipoContacto[0],
						   "cod_estado" => $_POST["estadoContacto"],
						   "dsc_nombre_contacto" => ms_escape_string(trim($_POST["nombreContacto"])),
						   "dsc_correo_contacto" => ms_escape_string(trim($_POST["correoContacto"])),
						   "dsc_telefono_contacto" => ms_escape_string(trim($_POST["telefonoContacto"])),
						   "fch_registro_contacto" => $fchRegistroContacto[2].'-'.$fchRegistroContacto[1].'-'.$fchRegistroContacto[0],
						   "dsc_detalle_contacto" => ms_escape_string(trim($_POST["detalleContacto"])),
						   "cod_trabajador_atencion" => $_POST["trabajadorAtencionContacto"],
						   "dsc_detalle_atencion" => ms_escape_string(trim($_POST["detalleAtencionContacto"])),
						   "fch_atencion" => $fchAtencion[2].'-'.$fchAtencion[1].'-'.$fchAtencion[0],
						   "cod_usr_registro" => $_SESSION["cod_trabajador"],
						   "fch_registro" => $fechaActual
						);
			$listaInformeContacto = json_decode($_POST["listaInformeContacto"],true);
			if(count($listaInformeContacto) > 0){
				foreach ($listaInformeContacto as $key => $value) {
					$listaInformeContacto[$key]["dsc_actividad"] = Utf8Decode(ms_escape_string(trim($listaInformeContacto[$key]["dsc_actividad"])));
					$listaInformeContacto[$key]["dsc_lugar"] = Utf8Decode(ms_escape_string(trim($listaInformeContacto[$key]["dsc_lugar"])));
					$listaInformeContacto[$key]["dsc_participantes_cliente"] = Utf8Decode(ms_escape_string(trim($listaInformeContacto[$key]["dsc_participantes_cliente"])));
					$listaInformeContacto[$key]["dsc_participantes_indelat"] = Utf8Decode(ms_escape_string(trim($listaInformeContacto[$key]["dsc_participantes_indelat"])));
					$listaInformeContacto[$key]["dsc_acuerdo"] = Utf8Decode(ms_escape_string(trim($listaInformeContacto[$key]["dsc_acuerdo"])));
					$listaInformeContacto[$key]["dsc_objetivo"] = Utf8Decode(ms_escape_string(trim($listaInformeContacto[$key]["dsc_objetivo"])));
				}//foreach
			}//if	
		}//else
		$respuesta = ModeloContacto::mdlIngresarContacto($tabla1,$tabla2,$codContacto,$datos,$listaInformeContacto,$tipoContacto[1]);
		if($respuesta == "ok"){
			$contListaOriginalInformeContacto = $_POST["contadorListaOriginalInformeContacto"];
			$numLineaArchivo = 1;
			for ($i=1; $i <= $contListaOriginalInformeContacto; $i++) {
				if(isset($_FILES["archivoInformeContacto".$i]["name"])){
					$nombreImagen = $codContacto."-".$numLineaArchivo."-".trim(utf8_decode($_FILES["archivoInformeContacto".$i]["name"]));
					$ruta = $rutaGlobal."/archivos/contacto/informe/".$nombreImagen;
					move_uploaded_file($_FILES["archivoInformeContacto".$i]["tmp_name"], $ruta);
					//$respuesta .= $_FILES["archivoInformeContacto".$i]["name"].'&'.$numLineaArchivo.'||';
					$numLineaArchivo++;
				}
				
			}
		}			
		return $respuesta;
	}//function ctrCrearCotizacion
	/*=============================================
	EDITAR CONTACTO
	=============================================*/
	static public function ctrEditarContacto(){
		if(isset($_POST["accionContacto"]) && ($_POST["accionContacto"] == "editar")){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;
			$fchRegistroContacto = explode("-", $_POST["fechaRegistroContacto"]);
			$fchAtencion = explode("-", $_POST["fechaAtencionContacto"]);
			$tabla1 = "vtaca_contacto";
			$tabla2 = "vtade_contacto_informe";
			$codContacto = $_POST["codigoContacto"];
			$tipoContacto = explode("|", $_POST["tipoContacto"]);
			$rutaGlobal = realpath(dirname(__FILE__));
			$rutaGlobal = rutaGlobal($rutaGlobal);
			$datos = array("cod_contacto" => $codContacto,
						   "cod_cliente" => $_POST["clienteContacto"],
						   "cod_canal" => $_POST["canalContacto"],
						   "cod_tipo" => $tipoContacto[0],
						   "cod_estado" => $_POST["estadoContacto"],
						   "dsc_nombre_contacto" => ms_escape_string(trim($_POST["nombreContacto"])),
						   "dsc_correo_contacto" => ms_escape_string(trim($_POST["correoContacto"])),
						   "dsc_telefono_contacto" => ms_escape_string(trim($_POST["telefonoContacto"])),
						   "fch_registro_contacto" => $fchRegistroContacto[2].'-'.$fchRegistroContacto[1].'-'.$fchRegistroContacto[0],
						   "dsc_detalle_contacto" => ms_escape_string(trim($_POST["detalleContacto"])),
						   "cod_trabajador_atencion" => $_POST["trabajadorAtencionContacto"],
						   "dsc_detalle_atencion" => ms_escape_string(trim($_POST["detalleAtencionContacto"])),
						   "fch_atencion" => $fchAtencion[2].'-'.$fchAtencion[1].'-'.$fchAtencion[0],
						   "cod_usr_modifica" => $_SESSION["cod_trabajador"],
						   "fch_modifica" => $fechaActual
						);
			$listaInformeContacto = json_decode($_POST["listaInformeContacto"],true);
			if(count($listaInformeContacto) > 0){
				foreach ($listaInformeContacto as $key => $value) {
					$listaInformeContacto[$key]["dsc_actividad"] = Utf8Decode(ms_escape_string(trim($listaInformeContacto[$key]["dsc_actividad"])));
					$listaInformeContacto[$key]["dsc_lugar"] = Utf8Decode(ms_escape_string(trim($listaInformeContacto[$key]["dsc_lugar"])));
					$listaInformeContacto[$key]["dsc_participantes_cliente"] = Utf8Decode(ms_escape_string(trim($listaInformeContacto[$key]["dsc_participantes_cliente"])));
					$listaInformeContacto[$key]["dsc_participantes_indelat"] = Utf8Decode(ms_escape_string(trim($listaInformeContacto[$key]["dsc_participantes_indelat"])));
					$listaInformeContacto[$key]["dsc_acuerdo"] = Utf8Decode(ms_escape_string(trim($listaInformeContacto[$key]["dsc_acuerdo"])));
					$listaInformeContacto[$key]["dsc_objetivo"] = Utf8Decode(ms_escape_string(trim($listaInformeContacto[$key]["dsc_objetivo"])));
				}//foreach
			}//if
			$respuesta = ModeloContacto::mdlEditarContacto($tabla1,$tabla2,$codContacto,$datos,$listaInformeContacto,$tipoContacto[1],$rutaGlobal);
			if($respuesta == "ok"){
				$contListaOriginalInformeContacto = $_POST["contadorListaOriginalInformeContacto"];
				$numLineaArchivo = 1;
				for ($i=1; $i <= $contListaOriginalInformeContacto; $i++) {
					if(isset($_FILES["archivoInformeContacto".$i]["name"])){
						$nombreImagen = $codContacto."-".$i."-".trim(utf8_decode($_FILES["archivoInformeContacto".$i]["name"]));
						$ruta = $rutaGlobal."/archivos/contacto/informe/".$nombreImagen;
						move_uploaded_file($_FILES["archivoInformeContacto".$i]["tmp_name"], $ruta);
						$numLineaArchivo++;
					}//if					
				}//for
			}//if
			return $respuesta;			
		}//if
	}//function ctrEditarContacto
	/*=============================================
	ELIMINAR CONTACTO
	=============================================*/
	static public function ctrEliminarContacto(){
		if(isset($_POST["accionContacto"]) && ($_POST["accionContacto"] == "eliminar")){
			$tabla1 = 'vtaca_contacto';
			$tabla2 = 'vtade_contacto_informe';
			$rutaGlobal = realpath(dirname(__FILE__));
			$rutaGlobal = rutaGlobal($rutaGlobal);
			$codContacto = $_POST["codigoContacto"];
			$respuesta = ModeloContacto::mdlEliminarContacto($tabla1,$tabla2,$codContacto,$rutaGlobal);
			return $respuesta;
		}//if
	}//function ctrEditarContacto
	/*=============================================
	MOSTRAR INFORME CONTACTO
	=============================================*/
	static public function ctrMostrarInformeContacto($item,$valor,$item2,$valor2){
		$tabla = "vtade_contacto_informe";
		$respuesta = ModeloContacto::mdlMostrarInformeContacto($tabla,$item,$valor,$item2,$valor2);
		return $respuesta;
	}//function ctrMostrarInformeContacto
	/*=============================================
	SUBIR ARCHIVO INFORME CONTACTO
	=============================================*/
	static public function ctrSubirArchivoInformeContacto($rey){
		return $rey;
		/*if(isset($_FILES["archivoInformeContacto"]["tmp_name"]) && $_FILES["archivoInformeContacto"]["tmp_name"] != ''){
			$reyn = $_FILES["archivoInformeContacto"]["tmp_name"];
			return $reyn;
		}*/
		//return "llego";
	}//function ctrSubirArchivoInformeContacto
	/*=============================================
	ELIMINAR INFORME CONTACTO
	=============================================*/
	static public function ctrEliminarInformeContacto(){
		if(isset($_POST["accionInformeContacto"]) && ($_POST["accionInformeContacto"] == "eliminar")){
			$tabla = 'vtade_contacto_informe';
			$codContacto = $_POST["codigoContacto"];
			$numLinea = $_POST["numLinea"];
			$respuesta = ModeloContacto::mdlEliminarInformeContacto($tabla,$codContacto,$numLinea);
			return $respuesta;
		}//if
	}//function ctrEliminarInformeContacto
	/*=============================================
	CANCELAR INFORME CONTACTO
	=============================================*/
	static public function ctrCancelarInformeContacto(){
		if(isset($_POST["accionInformeContacto"]) && ($_POST["accionInformeContacto"] == "cancelar")){
			$tabla = 'vtade_contacto_informe';
			$codContacto = $_POST["codigoContacto"];
			$respuesta = ModeloContacto::mdlCancelarInformeContacto($tabla,$codContacto);
			return $respuesta;
		}//if
	}//function ctrCancelarInformeContacto
	/*=============================================
	CANCELAR INFORME CONTACTO
	=============================================*/
	/*static public function ctrCancelarInformeContacto(){
		if(isset($_POST["accionInformeContacto"]) && ($_POST["accionInformeContacto"] == "cancelar")){
			$tabla = 'vtade_contacto_informe';
			$codContacto = $_POST["codigoContacto"];
			$respuesta = ModeloContacto::mdlCancelarInformeContacto($tabla,$codContacto);
			return $respuesta;
		}//if
	}*///function ctrCancelarInformeContacto
}//ControladorCotizacion