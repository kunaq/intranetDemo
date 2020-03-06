<!--=====================================
MODAL ENVIAR CORREO
======================================-->
<div id="modalEnviarCorreo" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
     		<form method="post" id="formEnviarCorreoCotizacion">
                <div class="overlay overlay-kq hidden">
                    <i class="fa fa-refresh fa-spin fa-spin-kq"></i>
                </div>
     			<!--=====================================
        		CABEZA DEL MODAL
        		======================================-->
        		<div class="modal-header modal-header-kq-2">
        			<button type="button" class="close" data-dismiss="modal" style="color: #fff;">&times;</button>
          			<h4 class="modal-title" style="font-weight: bold;">Enviar correo</h4>
        		</div>
        		<!--=====================================
        		CUERPO DEL MODAL
        		======================================-->
        		<div class="modal-body">
        			<div class="box-body">
                        <div class="form-group">
                            <label>De:</label>
                            <input type="text" class="form-control" value="indelat_prueba@hotmail.com" readonly>
                        </div>
            			<div class="form-group">
            				<label>Para:</label>
            				<input type="email" class="form-control" value="" name="receptorCorreoCotizacion" id="receptorCorreoCotizacion">            				
            			</div>
            			<div class="form-group hidden">
            				<label>Copia:</label>
            				<input type="email" class="form-control" id="emailCopia" name="emailCopia">
            			</div>
        			</div>
        		</div>
        		<!--=====================================
                PIE DEL MODAL
                ======================================-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-agregar-kq" id="enviarCorreo">Enviar correo</button>
                </div>
     		</form>
     	</div>
    </div>
</div>