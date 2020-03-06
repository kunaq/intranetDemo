<?php
if(isset($_GET["codigo"]) && $_GET["codigo"] != ''){
	$item = "cod_noticia";
	$valor = $_GET["codigo"];
	$entrada = "detalleNoticia";
	$respuesta = ControladorNoticia::ctrMostrarNoticia($item,$valor,$entrada);
}
?>
<div class="content-wrapper fondo-content-wrapper-kq">
	<section class="content-header">    
	    <h1 class="page-header color-h2-kq">	      
	      <?php echo $respuesta["dsc_titulo"];?>
	    </h1>
	    <ol class="breadcrumb">
	      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
	      <li class=""><a href="noticia">Noticia</a></li>
	      <li class="active">Ver Noticia</li>
	    </ol>
	</section>
	<section class="content">
		<div class="box box-widget">
			<div class="box-header with-border">
            	<div class="user-block">
                	<img class="img-circle" src="archivos/trabajador/<?php echo $respuesta["imagenTrabajador"]; ?>" alt="User Image">
                	<span class="username"><a href="#"><?php echo $respuesta["dsc_nombres"]." ".$respuesta["dsc_apellido_paterno"]." ".$respuesta["dsc_apellido_materno"]; ?></a></span>
                	<span class="description">Compartió esta publicación el <?php echo dateTimeFormat($respuesta["fch_publicacion"]); ?></span>
            	</div>
            </div>
            <div class="box-body">
            	<img class="img-responsive pad" src="archivos/noticia/<?php echo $respuesta["imagen"]; ?>" alt="Photo" style="margin: auto; height: 320px;">
            	<p><?php echo $respuesta["dsc_resumen"]; ?></p>
            </div>
		</div>
	</section>
</div>