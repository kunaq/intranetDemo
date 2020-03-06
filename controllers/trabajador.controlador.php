<?php
class ControladorTrabajador{
	/*=============================================
	MOSTRAR TRABAJADORES
	=============================================*/
	static public function ctrMostrarTrabajador($item1,$valor1,$item2,$valor2,$item3,$valor3,$entrada){
		$tabla1 = 'rhuma_trabajador';
		$tabla2 = 'feivi_orden_produccion_documento_usuario';
		$respuesta = ModeloTrabajador::mdlMostrarTrabajador($item1,$valor1,$item2,$valor2,$item3,$valor3,$entrada,$tabla1,$tabla2);
		return $respuesta;
	}//function ctrMostrarTrabajador
	/*=============================================
	INGRESO TRABAJADOR
	=============================================*/
	static public function ctrIngresoTrabajador(){
		if(isset($_POST["accionTrabajador"]) && $_POST["accionTrabajador"] == "ingreso"){
			$encriptar = crypt($_POST["ingPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
			$tabla1 = "rhuma_trabajador";
			$item1 = "dsc_usuario";
			$valor1 = $_POST["ingTrabajador"];
			$item2 = $valor2 = $item3 = $valor3 = null;
			$tabla2 = null;
			$entrada = "login";
			$respuesta = ModeloTrabajador::mdlMostrarTrabajador($item1,$valor1,$item2,$valor2,$item3,$valor3,$entrada,$tabla1,$tabla2);
			if(count($respuesta) > 0){
				if($respuesta["dsc_usuario"] == $_POST["ingTrabajador"] && $respuesta["dsc_clave"] == $encriptar){
					$tablaPermiso = 'vtaca_permiso_ventana';
					$itemPermiso = 'cod_usuario';
					$valorPermiso = $respuesta["cod_trabajador"];
					$respuesta2 = ModeloTrabajador::mdlMostrarPermisos($tablaPermiso,$itemPermiso,$valorPermiso);
					$flgEmpresa = $flgEmpresaEditar = $flgCotizacion = $flgCotizacionCrear = $flgCotizacionEditar = $flgCotizacionClonar = $flgCotizacionEliminar = $flgCotizacionEnviarCorreo = $flgCotizacionImpresionNormal = $flgCotizacionImpresionReducida = $flgCotizacionEstadistica = $flgAreaPedidoOrdProd = $flgAreaPedidoOrdProdEditar = $flgAreaCompraOrdProd = $flgAreaCompraOrdProdEditar = $flgAreaDiseñoOrdProd = $flgAreaDiseñoOrdProdEditar = $flgAreaFabricacionOrdProd = $flgAreaFabricacionOrdProdEditar = $flgAreaRevMoldOrdProd = $flgAreaRevMoldOrdProdEditar = $flgAreaPinturaOrdProd = $flgAreaPinturaOrdProdEditar = $flgAreaCtrCalidadOrdProd = $flgAreaCtrCalidadOrdProdEditar = $flgAreaDespachoOrdProd = $flgAreaDespachoOrdProdEditar = $flgAreaFacturacionOrdProd = $flgAreaFacturacionOrdProdEditar = 'NO';
					//$flgCotizacion = 'NO';
					foreach ($respuesta2 as $key => $value) {
						if($value["flg_empresa"] == 'SI'){
							$flgEmpresa = $value["flg_empresa"];
							$flgEmpresaEditar = $value["flg_editar"];
						}
						if($value["flg_cotizacion"] == 'SI'){
							$flgCotizacion = $value["flg_cotizacion"];
							$flgCotizacionCrear = $value["flg_crear"];
							$flgCotizacionEditar = $value["flg_editar"];
							$flgCotizacionClonar = $value["flg_clonar"];
							$flgCotizacionEliminar = $value["flg_eliminar"];
							$flgCotizacionEnviarCorreo = $value["flg_enviar_correo"];
							$flgCotizacionImpresionNormal = $value["flg_impresion_normal"];
							$flgCotizacionImpresionReducida = $value["flg_impresion_reducida"];
							$flgCotizacionEstadistica = $value["flg_estadistica"];
						}
						if($value["flg_area_pedido_ordProduccion"] == 'SI'){
							$flgAreaPedidoOrdProd = $value["flg_area_pedido_ordProduccion"];
							$flgAreaPedidoOrdProdEditar = $value["flg_editar"];
						}
						if($value["flg_area_compra_ordProduccion"] == 'SI'){
							$flgAreaCompraOrdProd = $value["flg_area_compra_ordProduccion"];
							$flgAreaCompraOrdProdEditar = $value["flg_editar"];
						}
						if($value["flg_area_diseño_ordProduccion"] == 'SI'){
							$flgAreaDiseñoOrdProd = $value["flg_area_diseño_ordProduccion"];
							$flgAreaDiseñoOrdProdEditar = $value["flg_editar"];
						}
						if($value["flg_area_fabricacion_ordProduccion"] == 'SI'){
							$flgAreaFabricacionOrdProd = $value["flg_area_fabricacion_ordProduccion"];
							$flgAreaFabricacionOrdProdEditar = $value["flg_editar"];
						}
						if($value["flg_area_rev_mold_ordProduccion"] == 'SI'){
							$flgAreaRevMoldOrdProd = $value["flg_area_rev_mold_ordProduccion"];
							$flgAreaRevMoldOrdProdEditar = $value["flg_editar"];
						}
						if($value["flg_area_pintura_ordProduccion"] == 'SI'){
							$flgAreaPinturaOrdProd = $value["flg_area_pintura_ordProduccion"];
							$flgAreaPinturaOrdProdEditar = $value["flg_editar"];
						}
						if($value["flg_area_control_calidad_ordProduccion"] == 'SI'){
							$flgAreaCtrCalidadOrdProd = $value["flg_area_control_calidad_ordProduccion"];
							$flgAreaCtrCalidadOrdProdEditar = $value["flg_editar"];
						}
						if($value["flg_area_despacho_ordProduccion"] == 'SI'){
							$flgAreaDespachoOrdProd = $value["flg_area_despacho_ordProduccion"];
							$flgAreaDespachoOrdProdEditar = $value["flg_editar"];
						}
						if($value["flg_area_facturacion_ordProduccion"] == 'SI'){
							$flgAreaFacturacionOrdProd = $value["flg_area_facturacion_ordProduccion"];
							$flgAreaFacturacionOrdProdEditar = $value["flg_editar"];
						}
					}//foreach
					//echo $flgEmpresaEditar.'||'.$flgCotizacionCrear.'||'.$flgCotizacionClonar.'||'.$flgCotizacionImpresionReducida;
					$_SESSION["iniciarSesionIntranet"] = "ok";
					$_SESSION["cod_trabajador"] = $respuesta["cod_trabajador"];
					$_SESSION["nombres"] = $respuesta["dsc_nombres"];
					$_SESSION["apellido_paterno"] = $respuesta["dsc_apellido_paterno"];
					$_SESSION["apellido_materno"] = $respuesta["dsc_apellido_materno"];
					$_SESSION["cargo"] = $respuesta["dsc_cargo"];
					$_SESSION["perfilAdministrador"] = $respuesta["flg_administrador"];
					$_SESSION["perfilEspecial"] = $respuesta["flg_especial"];
					$_SESSION["perfilUsuario"] = $respuesta["flg_usuario"];
					$_SESSION["imagen"] = trim($respuesta["imagen"]);
					$_SESSION["flgEmpresa"] = $flgEmpresa;
					$_SESSION["flgCotizacion"] = $flgCotizacion;
					$_SESSION["flgCotizacionCrear"] = $flgCotizacionCrear;
					$_SESSION["flgCotizacionEditar"] = $flgCotizacionEditar;
					$_SESSION["flgCotizacionClonar"] = $flgCotizacionClonar;
					$_SESSION["flgCotizacionEliminar"] = $flgCotizacionEliminar;
					$_SESSION["flgCotizacionEnviarCorreo"] = $flgCotizacionEnviarCorreo;
					$_SESSION["flgCotizacionImpresionNormal"] = $flgCotizacionImpresionNormal;
					$_SESSION["flgCotizacionImpresionReducida"] = $flgCotizacionImpresionReducida;
					$_SESSION["flgCotizacionEstadistica"] = $flgCotizacionEstadistica;
					$_SESSION["flgAreaPedidoOrdProd"] = $flgAreaPedidoOrdProd;
					$_SESSION["flgAreaPedidoOrdProdEditar"] = $flgAreaPedidoOrdProdEditar;
					$_SESSION["flgAreaCompraOrdProd"] = $flgAreaCompraOrdProd;
					$_SESSION["flgAreaCompraOrdProdEditar"] = $flgAreaCompraOrdProdEditar;
					$_SESSION["flgAreaDiseñoOrdProd"] = $flgAreaDiseñoOrdProd;
					$_SESSION["flgAreaDiseñoOrdProdEditar"] = $flgAreaDiseñoOrdProdEditar;
					$_SESSION["flgAreaFabricacionOrdProd"] = $flgAreaFabricacionOrdProd;
					$_SESSION["flgAreaFabricacionOrdProdEditar"] = $flgAreaFabricacionOrdProdEditar;
					$_SESSION["flgAreaRevMoldOrdProd"] = $flgAreaRevMoldOrdProd;
					$_SESSION["flgAreaRevMoldOrdProdEditar"] = $flgAreaRevMoldOrdProdEditar;
					$_SESSION["flgAreaPinturaOrdProd"] = $flgAreaPinturaOrdProd;
					$_SESSION["flgAreaPinturaOrdProdEditar"] = $flgAreaPinturaOrdProdEditar;
					$_SESSION["flgAreaCtrCalidadOrdProd"] = $flgAreaCtrCalidadOrdProd;
					$_SESSION["flgAreaCtrCalidadOrdProdEditar"] = $flgAreaCtrCalidadOrdProdEditar;
					$_SESSION["flgAreaDespachoOrdProd"] = $flgAreaDespachoOrdProd;
					$_SESSION["flgAreaDespachoOrdProdEditar"] = $flgAreaDespachoOrdProdEditar;
					$_SESSION["flgAreaFacturacionOrdProd"] = $flgAreaFacturacionOrdProd;
					$_SESSION["flgAreaFacturacionOrdProdEditar"] = $flgAreaFacturacionOrdProdEditar;
					return "ok";
				}else{
					return "error";
				}
			}else{
				return "error";
			}
		}
	}//function ctrIngresoTrabajdor
	/*=============================================
	EDITAR TRABAJADOR
	=============================================*/
	static public function ctrEditarTrabajador(){
		if(isset($_POST["accionTrabajador"]) && $_POST["accionTrabajador"] == "editar"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;
			$tabla = "rhuma_trabajador";
			$datos = array("cod_trabajador" => $_POST["codigoTrabajador"],
						   "dsc_anexo" => ms_escape_string(trim($_POST["anexoTrabajador"])),
						   "dsc_grupo_sanguineo" => ms_escape_string(trim($_POST["grupoSanguineoTrabajador"])),
						   "dsc_contacto" => ms_escape_string(trim($_POST["nombreContactoTrabajador"])),
						   "dsc_telefono_contacto_1" => ms_escape_string(trim($_POST["telefonoContactoTrabajador"])),
						   "cod_usr_modifica" => $_SESSION["cod_trabajador"],
						   "fch_modifica" => $fechaActual
						  );
			/*$password = crypt(trim($_POST["passwordContactoTrabajador"]), '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
			$datos = array("cod_trabajador" => $_POST["codigoTrabajador"],
						   "dsc_anexo" => ms_escape_string(trim($_POST["anexoTrabajador"])),
						   "dsc_grupo_sanguineo" => ms_escape_string(trim($_POST["grupoSanguineoTrabajador"])),
						   "dsc_contacto" => ms_escape_string(trim($_POST["nombreContactoTrabajador"])),
						   "dsc_telefono_contacto_1" => ms_escape_string(trim($_POST["telefonoContactoTrabajador"])),
						   "dsc_usuario" => $_POST["usuarioContactoTrabajador"],
						   "dsc_clave" => $password,
						   "cod_usr_modifica" => $_SESSION["cod_trabajador"],
						   "fch_modifica" => $fechaActual
						  );*/
			$respuesta = ModeloTrabajador::mdlEditarTrabajador($tabla, $datos);
			return $respuesta;
		}
	}//function ctrEditarTrabajador
}//class ControladorTrabajador