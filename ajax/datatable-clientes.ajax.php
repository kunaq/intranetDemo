<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/clientes.controlador.php";
require_once "../models/clientes.modelo.php";
class TablaClientes{
	/*=============================================
	MOSTRAR TABLAS MAESTRAS
	=============================================*/
	public function mostrarTablaClientes(){
		$item = null;
        $valor = null;
        $entrada = null;
        $clientes = ControladorClientes::ctrMostrarClientes($item,$valor,$entrada);
        if(count($clientes) > 0){
	        $datosJson = '{
			 	"data": [';
				 	for ($i=0; $i < count($clientes) ; $i++) {
				 		/*=============================================
						TRAEMOS LAS ACCIONES
						=============================================*/
						$botones = "";
						if($_SESSION["perfilAdministrador"] == 'SI'){
				 			$botones = "<div class='btn-group'><button class='btn btn-sm btn-warning btnEditarCliente' data-toggle='modal' data-target='#modalCliente' codCliente='".$clientes[$i]["cod_cliente"]."' title='Editar'><i class='fa fa-pencil-square-o'></i></button><button class='btn btn-sm btn-danger btnEliminarCliente' codCliente='".$clientes[$i]["cod_cliente"]."' title='Eliminar'><i class='fa fa-trash'></i></button></div>";
				 		}
				 		$datosJson .= '[
							"'.($i+1).'",
							"'.escapeComillasJson($clientes[$i]["dsc_documento"]).'",
							"'.escapeComillasJson($clientes[$i]["dsc_razon_social"]).'",
							"'.escapeComillasJson($clientes[$i]["dsc_categoria_cliente"]).'",
							"'.escapeComillasJson($clientes[$i]["dsc_pais"]).'",
							"'.escapeComillasJson($clientes[$i]["dsc_departamento"]).'",
							"'.escapeComillasJson($clientes[$i]["dsc_provincia"]).'",
							"'.escapeComillasJson($clientes[$i]["dsc_distrito"]).'",
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
		echo $datosJson;	
	}//function mostrarTablaClientes
}//class TablaClientes
/*=============================================
ACTIVAR TABLA CLIENTE
=============================================*/
$activarTablaClientes = new TablaClientes();
$activarTablaClientes -> mostrarTablaClientes();