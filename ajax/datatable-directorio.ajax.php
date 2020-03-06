<?php
require_once "../core.php";
require "../funciones.php";
require "../controllers/trabajador.controlador.php";
require "../models/trabajador.modelo.php";
class TablaDirectorio{
	/*=============================================
	MOSTRAR TABLA DIRECTORIO
	=============================================*/
	public function mostrarTablaDirectorio(){
		$item1 = $valor1 = $item2 = $valor2 = $item3 = $valor3 = $entrada = null;
        $trabajador = ControladorTrabajador::ctrMostrarTrabajador($item1,$valor1,$item2,$valor2,$item3,$valor3,$entrada);
        if(count($trabajador) > 0){
        	$datosJson = '{
			 	"data": [';
				 	for ($i=0; $i < count($trabajador) ; $i++) {
				 		/*=============================================
						TRAEMOS LA IMAGEN
						=============================================*/
						if($trabajador[$i]["imagen"] == '' || $trabajador[$i]["imagen"] == NULL){
							$imagen = "<img src='archivos/trabajador/anonymous.png' class='img-thumbnail' width='40px'>";
						}else{
							$imagen = "<img src='archivos/trabajador/".$trabajador[$i]["imagen"]."' class='img-thumbnail' width='40px'>";
						}
						/*=============================================
						TRAEMOS EL NOMBRE
						=============================================*/
						$nombre = $trabajador[$i]["dsc_apellido_paterno"].' '.$trabajador[$i]["dsc_apellido_materno"].', '.$trabajador[$i]["dsc_nombres"];
						/*=============================================
						TRAEMOS LA FECHA DE INGRESO
						=============================================*/
						$fechaIngreso = dateFormat($trabajador[$i]["fch_ingreso"]);
						/*=============================================
						TRAEMOS LA FECHA DE NACIMIENTO
						=============================================*/
						if(empty($trabajador[$i]["fch_nacimiento"])){
							$fechaCumpleaños = '';
						}else{
							$fechaCumpleaños = dateFormatCumpleanios2($trabajador[$i]["fch_nacimiento"]);	
						}
						/*=============================================
						TRAEMOS LAS ACCIONES
						=============================================*/
						if($_SESSION["flgEmpresa"] == 'SI'){
							$botones = "<div class='btn-group'><button class='btn btn-sm btn-warning btnEditarDirectorio' data-toggle='modal' data-target='#modalDirectorio' codTrabajador='".$trabajador[$i]["cod_trabajador"]."' title='Editar'><i class='fa fa-pencil-square-o'></i></button></div>";
						}else{
							$botones = "";	
						}
				 		
				 		/*=============================================
						TRAEMOS LOS DATOS EXTERNOS
						=============================================*/
						$datosExternos = "<p><p><span>* Grupo Sanguineo: </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".escapeComillasJson($trabajador[$i]["dsc_grupo_sanguineo"])."</p><span>* Contacto de emergencia: </span>&nbsp;&nbsp;&nbsp;&nbsp;".escapeComillasJson($trabajador[$i]["dsc_contacto"])."</p><p><span>* Teléfono de Emergencia: </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".escapeComillasJson($trabajador[$i]["dsc_telefono_contacto_1"])."</p>";
				 		$datosJson .= '[ 
							"'.($i+1).'",
							"'.$imagen.'",
							"'.$nombre.'",
							"'.escapeComillasJson($trabajador[$i]["dsc_cargo"]).'",
							"'.escapeComillasJson($trabajador[$i]["dsc_mail"]).'",
							"'.escapeComillasJson($trabajador[$i]["dsc_telefono_1"]).'",
							"'.escapeComillasJson($trabajador[$i]["dsc_anexo"]).'",
							"'.$fechaIngreso.'",
							"'.$fechaCumpleaños.'",
							"",
							"'.$botones.'",
							"'.$datosExternos.'"
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
	}//function mostrarTablaDirectorio
	/*=============================================
	MOSTRAR TABLA DE USUARIOS / VENTANA ORDEN DE
	PRODUCCION TAB DE DOCUMENTOS
	=============================================*/
	public function mostrarTablaUsuariosOrdProd(){
		$item1 = "cod_localidad";
		$valor1 = $_GET["localidad"];
		$item2 = "num_orden_produccion";
		$valor2 =$_GET["numOrdenProd"];
		$item3 = "num_linea";
		$valor3 =$_GET["numLineaDoc"];
		$entrada = $_GET["entrada"];
        $trabajador = ControladorTrabajador::ctrMostrarTrabajador($item1,$valor1,$item2,$valor2,$item3,$valor3,$entrada);
        if(count($trabajador) > 0){
        	$datosJson = '{
			 	"data": [';
				 	for ($i=0; $i < count($trabajador) ; $i++) {
				 		$checked = ($trabajador[$i]["flgUsuarioDoc"] == 'SI') ? 'checked' : '';
				 		$disabled = ($_GET["flgAnulado"] == 'SI') ? 'disabled' : '';
				 		$checkFila = "<input class='checkUsrDocOrdPrd' type='checkbox' codTrabajador='".$trabajador[$i]["cod_trabajador"]."' $checked value='".$trabajador[$i]["flgUsuarioDoc"]."' $disabled />";
				 		$datosJson .= '[
							"'.escapeComillasJson($trabajador[$i]["full_nombre"]).'",
							"'.$checkFila.'"
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
	}//function mostrarTablaUsuariosOrdProd
}//class TablaProductos
/*=============================================
ACTIVAR TABLA DIRECTORIO
=============================================*/
$activarTablaDirectorio = new TablaDirectorio();
if($_GET["entrada"] == 'vtnOrdenProduccion'){
	$activarTablaDirectorio -> mostrarTablaUsuariosOrdProd();
}else if($_GET["entrada"] == 'vtnDirectorio'){
	$activarTablaDirectorio -> mostrarTablaDirectorio();	
}