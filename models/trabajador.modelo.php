<?php
require_once "conexion.php";
class ModeloTrabajador{
	/*=============================================
	MOSTRAR TRABAJADORES
	=============================================*/
	static public function mdlMostrarTrabajador($item1,$valor1,$item2,$valor2,$item3,$valor3,$entrada,$tabla1,$tabla2){
		$db = new Conexion();
		if($item1 != null){
			if($entrada == "cumpleaños"){
				$fechaCumpleaños = explode("-",$valor1);
				$sql = $db->consulta("SELECT rhuma_trabajador.dsc_apellido_paterno,rhuma_trabajador.dsc_apellido_materno,rhuma_trabajador.dsc_nombres,rhuma_cargo_trabajador.dsc_cargo,rhuma_trabajador.imagen FROM $tabla1 INNER JOIN rhuma_cargo_trabajador ON rhuma_cargo_trabajador.cod_cargo = rhuma_trabajador.cod_cargo WHERE MONTH($item1)=".$fechaCumpleaños[0]." AND DAY($item1)=".$fechaCumpleaños[1]);
				$datos = [];
				while($key = $db->recorrer($sql)){
			    	$datos[] = arrayMapUtf8Encode($key);
			    }
			}else if($entrada == "calendarioCumpleaños"){
				$rangoFecha = explode("|", $valor1);
				$sql = $db->consulta("SELECT dsc_apellido_paterno,dsc_apellido_materno,dsc_nombres,fch_nacimiento,imagen,rhuma_cargo_trabajador.dsc_cargo FROM $tabla1 INNER JOIN rhuma_cargo_trabajador ON rhuma_cargo_trabajador.cod_cargo = rhuma_trabajador.cod_cargo WHERE MONTH($item1) BETWEEN ".$rangoFecha[0]." AND ".$rangoFecha[1]);
				$datos = [];
				while($key = $db->recorrer($sql)){
			    	$datos[] = arrayMapUtf8Encode($key);
			    }
			}else if($entrada == "login"){
				$sql = $db->consulta("SELECT rhuma_trabajador.cod_trabajador,rhuma_trabajador.dsc_apellido_paterno,rhuma_trabajador.dsc_apellido_materno, rhuma_trabajador.dsc_nombres,rhuma_trabajador.dsc_usuario,rhuma_trabajador.dsc_clave,rhuma_cargo_trabajador.dsc_cargo,vtama_perfil.cod_perfil,vtama_perfil.flg_administrador,vtama_perfil.flg_especial,vtama_perfil.flg_usuario,rhuma_trabajador.imagen FROM rhuma_trabajador LEFT JOIN rhuma_cargo_trabajador ON rhuma_cargo_trabajador.cod_cargo = rhuma_trabajador.cod_cargo LEFT JOIN vtama_perfil ON vtama_perfil.cod_perfil = rhuma_trabajador.cod_perfil WHERE $item1 = '$valor1'");
				$datos = arrayMapUtf8Encode($db->recorrer($sql));
			}else if($entrada == "modalTrabajador"){
				$sql = $db->consulta("SELECT $tabla1.cod_trabajador,$tabla1.dsc_apellido_paterno,$tabla1.dsc_apellido_materno,$tabla1.dsc_nombres,$tabla1.dsc_anexo,$tabla1.dsc_contacto,$tabla1.dsc_telefono_contacto_1,$tabla1.dsc_grupo_sanguineo  FROM $tabla1 WHERE $item1 = '$valor1'");
				$datos = arrayMapUtf8Encode($db->recorrer($sql));
			}else if($entrada == 'vtnOrdenProduccion'){
				$sql = $db->consulta("SELECT $tabla1.cod_trabajador,$tabla1.dsc_apellido_paterno+' '+$tabla1.dsc_apellido_materno+' '+$tabla1.dsc_nombres AS full_nombre,CASE WHEN $tabla2.$item1 = '$valor1' AND $tabla2.$item2 = '$valor2' AND $tabla2.$item3 = $valor3 THEN 'SI' ELSE 'NO' END AS flgUsuarioDoc FROM $tabla1 LEFT JOIN $tabla2 ON $tabla1.cod_trabajador = $tabla2.cod_usuario AND $tabla2.$item1 = '$valor1' AND $tabla2.$item2 = '$valor2' AND $tabla2.$item3 = $valor3");
				$datos = array();
			    while($key = $db->recorrer($sql)){
			    	$datos[] = arrayMapUtf8Encode($key);
			    }
			}else{
				$sql = $db->consulta("SELECT rhuma_trabajador.cod_trabajador,rhuma_trabajador.dsc_apellido_paterno,rhuma_trabajador.dsc_apellido_materno, rhuma_trabajador.dsc_nombres,rhuma_trabajador.dsc_usuario,rhuma_trabajador.dsc_clave,rhuma_cargo_trabajador.dsc_cargo,vtama_perfil.cod_perfil,rhuma_trabajador.imagen,rhuma_trabajador.dsc_contacto,rhuma_trabajador.dsc_telefono_contacto_1,rhuma_trabajador.dsc_grupo_sanguineo,rhuma_trabajador.dsc_anexo FROM rhuma_trabajador INNER JOIN rhuma_cargo_trabajador ON rhuma_cargo_trabajador.cod_cargo = rhuma_trabajador.cod_cargo LEFT JOIN vtama_perfil ON vtama_perfil.cod_perfil = rhuma_trabajador.cod_perfil WHERE $item1 = '$valor1'");
				$datos = arrayMapUtf8Encode($db->recorrer($sql));
			}				
		}else{
			if($entrada == "ultimosIngresos"){
				$sql = $db->consulta("SELECT TOP(8) rhuma_trabajador.dsc_nombres,rhuma_trabajador.dsc_apellido_paterno,rhuma_trabajador.dsc_apellido_materno,rhuma_cargo_trabajador.dsc_cargo,rhuma_trabajador.imagen,rhuma_trabajador.fch_ingreso FROM $tabla1 INNER JOIN rhuma_cargo_trabajador ON rhuma_cargo_trabajador.cod_cargo = rhuma_trabajador.cod_cargo ORDER BY fch_ingreso DESC");
			}else if($entrada == "modalContacto"){
				$sql = $db->consulta("SELECT cod_trabajador,dsc_nombres,dsc_apellido_paterno,dsc_apellido_materno FROM $tabla1");
			}else if($entrada == "inputSelect"){
				$sql = $db->consulta("SELECT cod_trabajador,dsc_apellido_paterno+' '+dsc_apellido_materno+' '+dsc_nombres AS full_nombre FROM $tabla1");
			}else{
				$sql = $db->consulta("SELECT rhuma_trabajador.cod_trabajador,rhuma_trabajador.dsc_apellido_paterno,rhuma_trabajador.dsc_apellido_materno,rhuma_trabajador.dsc_nombres,rhuma_cargo_trabajador.dsc_cargo,rhuma_trabajador.dsc_mail,rhuma_trabajador.dsc_telefono_1,rhuma_trabajador.fch_ingreso,rhuma_trabajador.fch_nacimiento,rhuma_trabajador.imagen,rhuma_trabajador.dsc_contacto,rhuma_trabajador.dsc_telefono_contacto_1,rhuma_trabajador.dsc_grupo_sanguineo,rhuma_trabajador.dsc_anexo FROM $tabla1 INNER JOIN rhuma_cargo_trabajador ON rhuma_cargo_trabajador.cod_cargo = rhuma_trabajador.cod_cargo");
			}			
			$datos = array();
		    while($key = $db->recorrer($sql)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		}
		$db->liberar($sql);
        $db->cerrar();
		return $datos;
	}//function mdlMostrarTrabajador
	/*=============================================
	EDITAR TRABAJADOR
	=============================================*/
	static public function mdlEditarTrabajador($tabla, $datos){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$sql = $db->consulta("UPDATE $tabla SET dsc_anexo = '".$datos["dsc_anexo"]."', dsc_grupo_sanguineo = '".$datos["dsc_grupo_sanguineo"]."', dsc_contacto = '".$datos["dsc_contacto"]."', dsc_telefono_contacto_1 = '".$datos["dsc_telefono_contacto_1"]."', cod_usr_modifica = '".$datos["cod_usr_modifica"]."', fch_modifica = CONVERT(datetime,'".$datos["fch_modifica"]."',21) WHERE cod_trabajador = '".$datos["cod_trabajador"]."'");
		/*$sql = $db->consulta("UPDATE $tabla SET dsc_anexo = '".$datos["dsc_anexo"]."', dsc_grupo_sanguineo = '".$datos["dsc_grupo_sanguineo"]."', dsc_contacto = '".$datos["dsc_contacto"]."', dsc_telefono_contacto_1 = '".$datos["dsc_telefono_contacto_1"]."', dsc_usuario = '".$datos["dsc_usuario"]."', dsc_clave = '".$datos["dsc_clave"]."', cod_usr_modifica = '".$datos["cod_usr_modifica"]."', fch_modifica = CONVERT(datetime,'".$datos["fch_modifica"]."',21) WHERE cod_trabajador = '".$datos["cod_trabajador"]."'");*/
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEditarTrabajador
	/*=============================================
	MOSTRAR TRABAJADORES
	=============================================*/
	static public function mdlMostrarPermisos($tabla,$item,$valor){
		$db = new Conexion();
		$sql = $db->consulta("SELECT flg_empresa,flg_cotizacion,flg_area_pedido_ordProduccion,flg_area_compra_ordProduccion,flg_area_diseño_ordProduccion,flg_area_fabricacion_ordProduccion,flg_area_rev_mold_ordProduccion,flg_area_pintura_ordProduccion,flg_area_control_calidad_ordProduccion,flg_area_despacho_ordProduccion,flg_area_facturacion_ordProduccion,flg_crear,flg_editar,flg_clonar,flg_eliminar,flg_enviar_correo,flg_impresion_normal,flg_impresion_reducida,flg_estadistica FROM $tabla INNER JOIN vtade_permiso_ventana_usuario ON $tabla.cod_permiso = vtade_permiso_ventana_usuario.cod_permiso WHERE vtade_permiso_ventana_usuario.cod_usuario = '".$valor."'");
		$datos = array();
	    while($key = $db->recorrer($sql)){
	    	$datos[] = arrayMapUtf8Encode($key);
	    }
	    return $datos;
	}//function mdlMostrarPermisos
}//class ModeloTrabajador