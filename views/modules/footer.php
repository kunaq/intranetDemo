<?php
$entrada = "footer";
$empresa = ControladorEmpresa::ctrMostrarEmpresa($entrada);
?>
<footer class="main-footer" style="background: 0px 0px repeat scroll rgb(0, 0, 0); color: #fff; overflow: hidden;">	
        <div>
                <h4 style="font-weight: bold">INFORMACIÓN CORPORATIVA</h4>
		      <p>
                        <strong>
                                <a href="http://indelat.com/" target="_blank" style="color: #fff;"><?php echo $empresa["dsc_razon_social"]; ?>
                                </a>
                        </strong>
                        <br><?php echo $empresa["dsc_direccion"]." ".$empresa["dsc_distrito"]." ".$empresa["dsc_provincia"]." ".$empresa["dsc_departamento"]." ".$empresa["dsc_pais"]; ?>
                </p>
        </div>
        <div style="border-top: 1px solid #fff; padding-top: 9px;">        	
                <div class="col-md-8" style="padding-left: 0;">
        		<strong>Copyright &copy; 2019.</strong>Todos los derechos reservados.	
        	</div>                
        	<div class="col-md-4 text-right">
        		<span>Desarollado por <strong><a href="http://www.kunaq.pe/" target="_blank" style="color: #fff;">Kunaq & Ascociados</a></strong></span>
        	</div>        	
        </div>
</footer>