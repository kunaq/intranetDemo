<header class="main-header">
	<!--=====================================
	LOGOTIPO
	======================================-->
	<a href="" class="logo" style="background: #000;">
		<!-- logo mini -->
		<span class="logo-mini">
			<img src="archivos/logo/logo-indelat-corto.png" class="img-responsive" style="height: 54px; width: 42px; padding-left: 2px;">
		</span>
	    <!-- logo for regular state and mobile devices -->
	    <span class="logo-normal">
			<img src="archivos/logo/logo-indelat.png" class="img-responsive" style="padding: 2px; height: 48px; width: 200px;">
		</span>
	</a>
	<!--=====================================
	BARRA DE NAVEGACIÓN
	======================================-->
	<nav class="navbar navbar-static-top" role="navigation" style="background-color: #000 !important;">
		<!-- Botón de navegación -->
		<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        	<span class="sr-only">Toggle navigation</span>
      	</a>
		<!-- Perfil de usuario -->
		<!-- <div class="hidden-xs hidden-sm"> -->
		<div>
			<!-- <div class="collapse navbar-collapse pull-left" id="navbar-collapse" style="width: 480px;"> -->
			<div class="collapse navbar-collapse pull-left" id="navbar-collapse" style="width: 432px;display: none !important;">
				<ul class="nav navbar-nav" style="width: 100%;">
		          <!-- Messages: style can be found in dropdown.less-->
		          <li class="dropdown" style="width: 100%;text-align: center;"><a>Sistema de Información</a></li>
		        </ul>
			</div>
			<div class="navbar-custom-menu">
		        <ul class="nav navbar-nav">
		        	<?php
		        	if(isset($_SESSION["iniciarSesionIntranet"]) && $_SESSION["iniciarSesionIntranet"] == "ok"){
		        	?>
		        	<li class="dropdown user user-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<?php
							if($_SESSION["imagen"] != ""){
								echo '<img src="archivos/trabajador/'.$_SESSION["imagen"].'" class="user-image" alt="User Image">';
							}else{
								echo '<img src="archivos/trabajador/anonymous.png" class="user-image" alt="User Image">';
							}
							?>
							<span class="hidden-xs"><?php echo $_SESSION["nombres"].' '.$_SESSION["apellido_paterno"]; ?></span>
						</a>
						<ul class="dropdown-menu">
              				<!-- User image -->
	              			<li class="user-header" style="background: #fbba00 !important;">
	                			<?php
								if($_SESSION["imagen"] != ""){
									echo '<img src="archivos/trabajador/'.$_SESSION["imagen"].'" class="img-circle" alt="User Image">';
								}else{
									echo '<img src="archivos/trabajador/anonymous.png" class="img-circle" alt="User Image">';
								}
								?>
	                			<p style="font-weight: bold;"><?php echo $_SESSION["nombres"].' '.$_SESSION["apellido_paterno"].' - '.$_SESSION["cargo"]; ?></p>
	              			</li>
              				<!-- Menu Footer-->
              				<li class="user-footer">
				                <div class="pull-left hidden">
				                  <a href="#" class="btn btn-flat btn-agregar-kq" style="color: #fff">Ver perfil</a>
				                </div>
				                <div class="pull-right">
				                  <a href="salir" class="btn btn-flat btn-agregar-kq" style="color: #fff">Cerrar sesión</a>
				                </div>
              				</li>
            			</ul>
					</li>
		        	<?php
		        	}else{
		        	?>
		        	<form id="formIngresarSistema" class="navbar-form navbar-left formularioIngreso" method="post">
			            <div class="form-group">
			              	<input type="email" class="form-control input-login-kq" name="ingTrabajador" required placeholder="Usuario">
			            </div>
			            <div class="form-group">
			              	<input type="password" class="form-control input-login-kq" name="ingPassword" required placeholder="Contraseña">
			            </div>
			            <div class="form-group">
			            	<button type="submit" class="btn btn-primary btn-block btn-flat btn-agregar-kq btnIngresarSistema">Ingresar</button>
			            </div>
			        	<input type="hidden" name="accionTrabajador" value="ingreso">
		        	</form>
		        	<?php
		        	}
		        	?>
				</ul>
			</div>
		</div>
	</nav>
</header>