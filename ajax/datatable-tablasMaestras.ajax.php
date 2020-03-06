<?php
class TablasMaestras{
	/*=============================================
	MOSTRAR TABLAS MAESTRAS
	=============================================*/
	public function mostrarTablasMaestras(){
		if($_GET["bd"] == "vtama_tipo_producto"){
			require_once "../core.php";
			require_once "../funciones.php";
			require_once "../controllers/tipoProducto.controlador.php";
			require_once "../models/tipoProducto.modelo.php";
			$item = null;
			$valor = null;
			$entrada = "tablaMaestra";
			$tipoProductos = ControladorTipoProducto::ctrMostrarTipoProducto($item,$valor,$entrada);
			if(count($tipoProductos) > 0){
				$datosJson = '{
					"data": [';
						for ($i=0; $i < count($tipoProductos); $i++) {
							$botones = "<div class='btn-group'><button class='btn btn-sm btn-warning btnEditarTipoProducto' codTipoProducto='".$tipoProductos[$i]["cod_tipo_producto"]."' data-toggle='modal' data-target='#modalTipoProducto' title='Editar'><i class='fa fa-pencil'></i></button><button class='btn btn-sm btn-danger btnEliminarTipoProducto' codTipoProducto='".$tipoProductos[$i]["cod_tipo_producto"]."' title='Eliminar'><i class='fa fa-trash'></i></button></div>";
							$datosJson .= '[ 
								"'.($i+1).'",
								"'.escapeComillasJson($tipoProductos[$i]["dsc_tipo_producto"]).'",
								"'.$botones.'"
							],';						
						}
						$datosJson = substr($datosJson, 0, -1);
					$datosJson .= ']
				}';
			}else{
				$datosJson = '{
					"data": []
				}';
			}
		}else if($_GET["bd"] == "vtama_tipo_documento"){
			require_once "../core.php";
			require_once "../funciones.php";
			require_once "../controllers/tipoDocumento.controlador.php";
			require_once "../models/tipoDocumento.modelo.php";
			$item = null;
			$valor = null;
			$tipoDocumentos = ControladorTipoDocumento::ctrMostrarTipoDocumento($item,$valor);
			if(count($tipoDocumentos) > 0){
				$datosJson = '{
					"data": [';
						for ($i=0; $i < count($tipoDocumentos); $i++) {
							$botones = "<div class='btn-group'><button class='btn btn-sm btn-warning btnEditarTipoDocumento' codTipoDocumento='".$tipoDocumentos[$i]["cod_tipo_documento"]."' data-toggle='modal' data-target='#modalTipoDocumento' title='Editar'><i class='fa fa-pencil'></i></button><button class='btn btn-sm btn-danger btnEliminarTipoDocumento' codTipoDocumento='".$tipoDocumentos[$i]["cod_tipo_documento"]."' title='Eliminar'><i class='fa fa-trash'></i></button></div>";
							$datosJson .= '[ 
								"'.($i+1).'",
								"'.escapeComillasJson($tipoDocumentos[$i]["dsc_tipo_documento"]).'",
								"'.$botones.'"
							],';						
						}
						$datosJson = substr($datosJson, 0, -1);
					$datosJson .= ']
				}';
			}else{
				$datosJson = '{
					"data": []
				}';
			}
		}else if($_GET["bd"] == "vtama_categoria_cliente"){
			require_once "../core.php";
			require_once "../funciones.php";
			require_once "../controllers/categoriaCliente.controlador.php";
			require_once "../models/categoriaCliente.modelo.php";
			$item = null;
			$valor = null;
			$categoriaClientes = ControladorCategoriaCliente::ctrMostrarCategoriaClientes($item,$valor);
			if(count($categoriaClientes) > 0){
				$datosJson = '{
					"data": [';
						for ($i=0; $i < count($categoriaClientes); $i++) {
							$botones = "<div class='btn-group'><button class='btn btn-sm btn-warning btnEditarCategoriaCliente' codCategoriaCliente='".$categoriaClientes[$i]["cod_categoria_cliente"]."' data-toggle='modal' data-target='#modalCategoriaCliente' title='Editar'><i class='fa fa-pencil'></i></button><button class='btn btn-sm btn-danger btnEliminarCategoriaCliente' codCategoriaCliente='".$categoriaClientes[$i]["cod_categoria_cliente"]."' title='Eliminar'><i class='fa fa-trash'></i></button></div>";
							$datosJson .= '[ 
								"'.($i+1).'",
								"'.escapeComillasJson($categoriaClientes[$i]["dsc_categoria_cliente"]).'",
								"'.$botones.'"
							],';						
						}
						$datosJson = substr($datosJson, 0, -1);
					$datosJson .= ']
				}';
			}else{
				$datosJson = '{
					"data": []
				}';
			}
		}else if($_GET["bd"] == "vtama_pais"){
			require_once "../core.php";
			require_once "../funciones.php";
			require_once "../controllers/pais.controlador.php";
			require_once "../models/pais.modelo.php";
			$item = null;
			$valor = null;
			$paises = ControladorPais::ctrMostrarPaises($item,$valor);
			if(count($paises) > 0){
				$datosJson = '{
					"data": [';
						for ($i=0; $i < count($paises); $i++) {
							$botones = "<div class='btn-group'><button class='btn btn-sm btn-warning btnEditarPais' codPais='".$paises[$i]["cod_pais"]."' data-toggle='modal' data-target='#modalPais' title='Editar'><i class='fa fa-pencil'></i></button><button class='btn btn-sm btn-danger btnEliminarPais' codPais='".$paises[$i]["cod_pais"]."' title='Eliminar'><i class='fa fa-trash'></i></button></div>";
							$datosJson .= '[
								"'.($i+1).'",
								"'.escapeComillasJson($paises[$i]["dsc_pais"]).'",
								"'.$botones.'"
							],';						
						}
						$datosJson = substr($datosJson, 0, -1);
					$datosJson .= ']
				}';
			}else{
				$datosJson = '{
					"data": []
				}';
			}
		}else if($_GET["bd"] == "vtama_estado_cotizacion"){
			require_once "../core.php";
			require_once "../funciones.php";
			require_once "../controllers/estadoCotizacion.controlador.php";
			require_once "../models/estadoCotizacion.modelo.php";
			$item = $valor = $entrada = null;
			$estadoCotizacion = ControladorEstadoCotizacion::ctrMostrarEstadoCotizacion($item,$valor,$entrada);
			if(count($estadoCotizacion) > 0){
				$datosJson = '{
					"data": [';
						for ($i=0; $i < count($estadoCotizacion); $i++) {
							$botones = "<div class='btn-group'><button class='btn btn-sm btn-warning btnEditarEstadoCotizacion' codEstadoCotizacion='".$estadoCotizacion[$i]["cod_estado_cotizacion"]."' data-toggle='modal' data-target='#modalEstadoCotizacion' title='Editar'><i class='fa fa-pencil'></i></button></div>";
							$datosJson .= '[
								"'.($i+1).'",
								"'.escapeComillasJson($estadoCotizacion[$i]["dsc_estado_cotizacion"]).'",
								"'.$botones.'"
							],';						
						}
						$datosJson = substr($datosJson, 0, -1);
					$datosJson .= '] 
				}';
			}else{
				$datosJson = '{
					"data": []
				}';
			}
		}else if($_GET["bd"] == "vtama_perfil"){
			require_once "../core.php";
			require_once "../funciones.php";
			require_once "../controllers/perfil.controlador.php";
			require_once "../models/perfil.modelo.php";
			$item = null;
			$valor = null;
			$perfil = ControladorPerfil::ctrMostrarPerfil($item,$valor);
			if(count($perfil) > 0){
				$datosJson = '{
					"data": [';
						for ($i=0; $i < count($perfil); $i++) {
							$botones = "<div class='btn-group'><button class='btn btn-sm btn-warning btnEditarPerfil' codPerfil='".$perfil[$i]["cod_perfil"]."' data-toggle='modal' data-target='#modalPerfil' title='Editar'><i class='fa fa-pencil'></i></button></div>";
							$datosJson .= '[
								"'.($i+1).'",
								"'.escapeComillasJson($perfil[$i]["dsc_perfil"]).'",
								"'.$botones.'"
							],';						
						}
						$datosJson = substr($datosJson, 0, -1);
					$datosJson .= ']
				}';
			}else{
				$datosJson = '{
					"data": []
				}';
			}
		}else if($_GET["bd"] == "vtama_moneda"){
			require_once "../core.php";
			require_once "../funciones.php";
			require_once "../controllers/moneda.controlador.php";
			require_once "../models/moneda.modelo.php";
			$item = null;
			$valor = null;
			$moneda = ControladorMoneda::ctrMostrarMoneda($item,$valor);
			if(count($moneda) > 0){
				$datosJson = '{
					"data": [';
						for ($i=0; $i < count($moneda); $i++) {
							$botones = "<div class='btn-group'><button class='btn btn-sm btn-warning btnEditarMoneda' codMoneda='".$moneda[$i]["cod_moneda"]."' data-toggle='modal' data-target='#modalMoneda' title='Editar'><i class='fa fa-pencil'></i></button><button class='btn btn-sm btn-danger btnEliminarMoneda' codMoneda='".$moneda[$i]["cod_moneda"]."' title='Eliminar'><i class='fa fa-trash'></i></button></div>";
							$datosJson .= '[
								"'.($i+1).'",
								"'.escapeComillasJson($moneda[$i]["dsc_moneda"]).'",
								"'.$botones.'"
							],';						
						}
						$datosJson = substr($datosJson, 0, -1);
					$datosJson .= ']
				}';
			}else{
				$datosJson = '{
					"data": []
				}';
			}
		}else if($_GET["bd"] == "vtama_forma_pago"){
			require_once "../core.php";
			require_once "../funciones.php";
			require_once "../controllers/formaPago.controlador.php";
			require_once "../models/formaPago.modelo.php";
			$item = null;
			$valor = null;
			$formaPago = ControladorFormaPago::ctrMostrarFormaPago($item,$valor);
			if(count($formaPago) > 0){
				$datosJson = '{
					"data": [';
						for ($i=0; $i < count($formaPago); $i++) {
							$botones = "<div class='btn-group'><button class='btn btn-sm btn-warning btnEditarFormaPago' codFormaPago='".$formaPago[$i]["cod_forma_pago"]."' data-toggle='modal' data-target='#modalFormaPago' title='Editar'><i class='fa fa-pencil'></i></button><button class='btn btn-sm btn-danger btnEliminarFormaPago' codFormaPago='".$formaPago[$i]["cod_forma_pago"]."' title='Eliminar'><i class='fa fa-trash'></i></button></div>";
							$datosJson .= '[
								"'.($i+1).'",
								"'.escapeComillasJson($formaPago[$i]["dsc_forma_pago"]).'",
								"'.$botones.'"
							],';						
						}
						$datosJson = substr($datosJson, 0, -1);
					$datosJson .= ']
				}';
			}else{
				$datosJson = '{
					"data": []
				}';
			}
		}else if($_GET["bd"] == "vtama_canal_contacto"){
			require_once "../core.php";
			require_once "../funciones.php";
			require_once "../controllers/canalContacto.controlador.php";
			require_once "../models/canalContacto.modelo.php";
			$item = null;
			$valor = null;
			$canalContacto = ControladorCanalContacto::ctrMostrarCanalContacto($item,$valor);
			if(count($canalContacto) > 0){
				$datosJson = '{
					"data": [';
						for ($i=0; $i < count($canalContacto); $i++) {
							$botones = "<div class='btn-group'><button class='btn btn-sm btn-warning btnEditarCanalContacto' codCanalContacto='".$canalContacto[$i]["cod_canal_contacto"]."' data-toggle='modal' data-target='#modalCanalContacto' title='Editar'><i class='fa fa-pencil'></i></button><button class='btn btn-sm btn-danger btnEliminarCanalContacto' codCanalContacto='".$canalContacto[$i]["cod_canal_contacto"]."' title='Eliminar'><i class='fa fa-trash'></i></button></div></div>";
							$datosJson .= '[
								"'.($i+1).'",
								"'.escapeComillasJson($canalContacto[$i]["dsc_canal_contacto"]).'",
								"'.$botones.'"
							],';						
						}
						$datosJson = substr($datosJson, 0, -1);
					$datosJson .= ']
				}';
			}else{
				$datosJson = '{
					"data": []
				}';
			}
		}else if($_GET["bd"] == "vtama_estado_contacto"){
			require_once "../core.php";
			require_once "../funciones.php";
			require_once "../controllers/estadoContacto.controlador.php";
			require_once "../models/estadoContacto.modelo.php";
			$item = null;
			$valor = null;
			$estadoContacto = ControladorEstadoContacto::ctrMostrarEstadoContacto($item,$valor);
			if(count($estadoContacto) > 0){
				$datosJson = '{
					"data": [';
						for ($i=0; $i < count($estadoContacto); $i++) {
							$botones = "<div class='btn-group'><button class='btn btn-sm btn-warning btnEditarEstadoContacto' codEstadoContacto='".$estadoContacto[$i]["cod_estado_contacto"]."' data-toggle='modal' data-target='#modalEstadoContacto' title='Editar'><i class='fa fa-pencil'></i></button><button class='btn btn-sm btn-danger btnEliminarEstadoContacto' codEstadoContacto='".$estadoContacto[$i]["cod_estado_contacto"]."' title='Eliminar'><i class='fa fa-trash'></i></button></div></div>";
							$datosJson .= '[
								"'.($i+1).'",
								"'.escapeComillasJson($estadoContacto[$i]["dsc_estado_contacto"]).'",
								"'.$botones.'"
							],';						
						}
						$datosJson = substr($datosJson, 0, -1);
					$datosJson .= ']
				}';
			}else{
				$datosJson = '{
					"data": []
				}';
			}
		}else if($_GET["bd"] == "vtama_tipo_contacto"){
			require_once "../core.php";
			require_once "../funciones.php";
			require_once "../controllers/tipoContacto.controlador.php";
			require_once "../models/tipoContacto.modelo.php";
			$item = null;
			$valor = null;
			$tipoContacto = ControladorTipoContacto::ctrMostrarTipoContacto($item,$valor);
			if(count($tipoContacto) > 0){
				$datosJson = '{
					"data": [';
						for ($i=0; $i < count($tipoContacto); $i++) {
							$botones = "<div class='btn-group'><button class='btn btn-sm btn-warning btnEditarTipoContacto' codTipoContacto='".$tipoContacto[$i]["cod_tipo_contacto"]."' data-toggle='modal' data-target='#modalTipoContacto' title='Editar'><i class='fa fa-pencil'></i></button><button class='btn btn-sm btn-danger btnEliminarTipoContacto' codTipoContacto='".$tipoContacto[$i]["cod_tipo_contacto"]."' title='Eliminar'><i class='fa fa-trash'></i></button></div></div>";
							$datosJson .= '[
								"'.($i+1).'",
								"'.escapeComillasJson($tipoContacto[$i]["dsc_tipo_contacto"]).'",
								"'.$botones.'"
							],';						
						}
						$datosJson = substr($datosJson, 0, -1);
					$datosJson .= ']
				}';
			}else{
				$datosJson = '{
					"data": []
				}';
			}
		}
		echo $datosJson;
	}//function mostrarTablasMaestras
}//class TablasMaestras
/*=============================================
ACTIVAR TABLAS MAESTRAS
=============================================*/
$activarTablasMaestras = new TablasMaestras();
$activarTablasMaestras -> mostrarTablasMaestras();