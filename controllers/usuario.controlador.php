<?php
class ControladorUsuarios{
	static public function ctrIngresoUsuario(){
		if(isset($_POST["ingUsuario"])){
			if("admin" == $_POST['ingUsuario'] && "123456" == $_POST['ingPassword']){
				$_SESSION["nombre"] = "Administrador";
			}else{
				echo'<script>
				swal({
					  type: "error",
					  title: "Los datos ingresados, son incorrectos",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
						if (result.value) {
						window.location = "inicio";
						}
					})
				</script>';
				exit;
			}
			echo '<script>
				window.location = "inicio";
			</script>';
		}
	}
}//class ControladorUsuarios