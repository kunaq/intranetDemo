<aside class="main-sidebar" style="background: #000000 repeat scroll 0 0; cursor: default;">
	<section class="sidebar">
		<?php
		if(isset($_SESSION["iniciarSesionIntranet"])){
		?>
		<ul class="sidebar-menu">
			<li class="active border-bottom-kq">
				<a href="inicio" class="sidebar-color-sys">
					<i class="fa fa-home"></i>
					<span>Inicio</span>
				</a>
			</li>
			<li class="treeview active border-bottom-kq">
				<a href="#" class="sidebar-color-sys">
					<i class="fa fa-university"></i>
					<span>Empresa</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-down pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu" style="background: #e0b30f;">
					<li class="border-bottom-kq">
						<a href="nosotros">
							<i class="fa fa-building-o"></i>
							<span>Nosotros</span>
						</a>
					</li>
					<li class="border-bottom-kq">
						<a href="directorio">
							<i class="fa fa-group"></i>
							<span>Directorio</span>
						</a>
					</li>
					<li class="border-bottom-kq">
						<a href="galeria">
							<i class="fa fa-camera-retro"></i>
							<span>Galeria</span>
						</a>
					</li>
					<li class="border-bottom-kq">
						<a href="noticia">
							<i class="fa fa-newspaper-o"></i>
							<span>Noticia</span>
						</a>
					</li>
					<li class="border-bottom-kq">
						<a href="politica-procedimiento">
							<i class="fa fa-pencil-square-o"></i>
							<span>Política y Procedimientos</span>
						</a>
					</li>
					<li>
						<a href="consultas-frecuentes">
							<i class="fa fa-question-circle"></i>
							<span>Consultas Frecuentes</span>
						</a>
					</li>
				</ul>
			</li>
			<li class="treeview active border-bottom-kq">
				<a href="#" class="sidebar-color-sys" >
					<i class="fa fa-object-ungroup"></i>
					<span>Módulos de control</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-down pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu" style="background: #e0b30f;">
					<li class="treeview active">
						<a href="#">
							<i class="fa fa-cc"></i>
							<span>Cotizaciones</span>
							<span class="pull-right-container">
                  				<i class="fa fa-angle-down pull-right"></i>
                			</span>
						</a>
						<ul class="treeview-menu">
							<li class="border-bottom-kq">
								<a href="cotizaciones">
									<i class="fa fa-circle-o"></i>
									<span>Control de cotizaciones</span>
								</a>
							</li>
							<li class="border-bottom-kq">
								<a href="graficos">
									<i class="fa fa-circle-o"></i>
									<span>Estadísticas</span>
								</a>
							</li>
							<li class="border-bottom-kq">
								<a href="cotizacion">
									<i class="fa fa-circle-o"></i>
									<span>Crear cotización</span>
								</a>
							</li>
							<li class="border-bottom-kq">
								<a href="productos">
									<i class="fa fa-circle-o"></i>
									<span>Productos</span>
								</a>
							</li>
						</ul>
					</li>
					<li class="border-bottom-kq">
						<a href="ordenes-produccion">
							<i class="fa fa-book"></i>
							<span>Seguimiento de OP</span>
						</a>
					</li>
					<li class="border-bottom-kq">
						<a href="resumen-ordenes-produccion">
							<i class="fa fa-book"></i>
							<span>Resumen de OP</span>
						</a>
					</li>
					<li class="border-bottom-kq">
						<a href="contactos">
							<i class="fa fa-book"></i>
							<span>Contactos con clientes</span>
						</a>
					</li>
					<li class="border-bottom-kq">
						<a href="tabla-control">
							<i class="fa fa-leanpub"></i>
							<span>Tabla Control</span>
						</a>
					</li>
					<li>
						<a href="seguridad">
							<i class="fa fa-exclamation-triangle"></i>
							<span>Seguridad</span>
						</a>
					</li>
				</ul>
			</li>

			<li class="treeview active border-bottom-kq">
				<a href="#" class="sidebar-color-sys">
					<i class="fa fa-cube"></i>
					<span>Utilidades</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-down pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu" style="background: #e0b30f;">
					<li class="border-bottom-kq">
						<a href="clientes">
							<i class="fa fa-group"></i>
							<span>Clientes</span>
						</a>
					</li>
					<li class="border-bottom-kq">
						<a href="accesos-directos">
							<i class="fa fa-arrows"></i>
							<span>Accesos directos</span>
						</a>
					</li>
					<li>
						<a href="tablas-maestras">
							<i class="fa fa-database"></i>
							<span>Tablas Maestras</span>
						</a>
					</li>
				</ul>
			</li>
		</ul>
		<?php
		}else{
		?>
		<ul class="sidebar-menu">
			<li class="active border-bottom-kq">
				<a href="inicio" class="sidebar-color-sys">
					<i class="fa fa-home"></i>
					<span>Inicio</span>
				</a>
			</li>
			<li class="treeview border-bottom-kq">
				<a class="sidebar-color-sys">
					<i class="fa fa-university"></i>
					<span>Empresa</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-down pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu" style="background: #e0b30f;">
					<li class="border-bottom-kq">
						<a>
							<i class="fa fa-building-o"></i>
							<span>Nosotros</span>
						</a>
					</li>
					<li class="border-bottom-kq">
						<a>
							<i class="fa fa-group"></i>
							<span>Directorio</span>
						</a>
					</li>
					<li class="border-bottom-kq">
						<a>
							<i class="fa fa-camera-retro"></i>
							<span>Galeria</span>
						</a>
					</li>
					<li class="border-bottom-kq">
						<a>
							<i class="fa fa-newspaper-o"></i>
							<span>Noticia</span>
						</a>
					</li>
					<li class="border-bottom-kq">
						<a>
							<i class="fa fa-pencil-square-o"></i>
							<span>Política y Procedimientos</span>
						</a>
					</li>
					<li>
						<a>
							<i class="fa fa-question-circle"></i>
							<span>Consultas Frecuentes</span>
						</a>
					</li>
				</ul>
			</li>
			<li class="treeview border-bottom-kq">
				<a class="sidebar-color-sys">
					<i class="fa fa-object-ungroup"></i>
					<span>Módulos de control</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-down pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu" style="background: #e0b30f;">
					<li class="treeview active">
						<a>
							<i class="fa fa-cc"></i>
							<span>Cotizaciones</span>
							<span class="pull-right-container">
                  				<i class="fa fa-angle-down pull-right"></i>
                			</span>
						</a>
						<ul class="treeview-menu">
							<li class="border-bottom-kq">
								<a>
									<i class="fa fa-circle-o"></i>
									<span>Control de cotizaciones</span>
								</a>
							</li>
							<li class="border-bottom-kq">
								<a>
									<i class="fa fa-circle-o"></i>
									<span>Crear cotización</span>
								</a>
							</li>
							<li class="border-bottom-kq">
								<a>
									<i class="fa fa-circle-o"></i>
									<span>Productos</span>
								</a>
							</li>
						</ul>
					</li>
					<li class="border-bottom-kq">
						<a>
							<i class="fa fa-book"></i>
							<span>Contactos con clientes</span>
						</a>
					</li>
					<li class="border-bottom-kq">
						<a>
							<i class="fa fa-leanpub"></i>
							<span>Tabla Control</span>
						</a>
					</li>
					<li>
						<a>
							<i class="fa fa-exclamation-triangle"></i>
							<span>Seguridad</span>
						</a>
					</li>
				</ul>
			</li>
			<li class="treeview border-bottom-kq">
				<a class="sidebar-color-sys">
					<i class="fa fa-cube"></i>
					<span>Utilidades</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-down pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu" style="background: #e0b30f;">
					<li class="border-bottom-kq">
						<a>
							<i class="fa fa-group"></i>
							<span>Clientes</span>
						</a>
					</li>
					<li class="border-bottom-kq">
						<a>
							<i class="fa fa-arrows"></i>
							<span>Accesos directos</span>
						</a>
					</li>
					<li>
						<a>
							<i class="fa fa-database"></i>
							<span>Tablas Maestras</span>
						</a>
					</li>
				</ul>
			</li>
		</ul>
		<?php
		}
		?>
	</section>
</aside>
