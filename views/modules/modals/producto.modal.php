<!--=====================================
MODAL AGREGAR PRODUCTO
======================================-->
<div id="modalProducto" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
   		<form role="form" id="formProducto" method="post">
        <div class="overlay overlay-kq hidden">
          <i class="fa fa-refresh fa-spin fa-spin-kq"></i>
        </div>
   			<!--=====================================
      	CABEZA DEL MODAL
      	======================================-->
    		<div class="modal-header modal-header-kq-2">
    			<button type="button" class="close" data-dismiss="modal" style="color: #fff;">&times;</button>
      			<h4 class="modal-title" style="font-weight: bold;" id="modalTituloProducto">Agregar producto</h4>
    		</div>
    		<!--=====================================
    		CUERPO DEL MODAL
    		======================================-->
    		<div class="modal-body">
    			<div class="box-body">
    				<!-- ENTRADA PARA EL CÓDIGO -->
    				<div class="form-group">              
        				<div class="input-group">              
          				<span class="input-group-addon"><i class="fa fa-key"></i></span>
          				<input type="text" class="form-control input-lg" id="codigoProducto" name="codigoProducto" placeholder="Código" readonly>
        				</div>
      			</div>
        			<!-- SELECCIONAR EL TIPO DE PRODUCTO -->
    				<div class="form-group">
    					<div class="input-group">
    						<span class="input-group-addon" title="Pais"><i class="fa fa-users"></i></span>
    						<select class="form-control input-lg" id="tipoProducto" name="tipoProducto" style="width: 100%" >									
							   <option value="" selected>Seleccionar un tipo</option>
    							<?php
    							$item = null;
    							$valor = null;
                  $entrada = null;
    							$tipoProductos = ControladorTipoProducto::ctrMostrarTipoProducto($item,$valor,$entrada);
    							foreach ($tipoProductos as $key => $value) {        								
    								echo '<option value="'.$value["cod_tipo_producto"].'">'.$value["dsc_tipo_producto"].'</option>';
    							}
    							?>
    						</select>
    					</div>
    				</div>
      			<!-- ENTRADA PARA LA DESCRIPCIÓN -->
    				<div class="form-group">              
        				<div class="input-group">              
          				<span class="input-group-addon"><i class="fa fa-product-hunt"></i></span> 
          				<input type="text" class="form-control input-lg" id="nombreProducto" name="nombreProducto" placeholder="Ingresar descripción" required>
        				</div>
      			</div>
      			<!-- ENTRADA PARA LAS OBSERVACIONES -->
    				<div class="form-group">              
        				<div class="input-group">              
          				<span class="input-group-addon"><i class="fa fa-book"></i></span>
          				<textarea class="form-control input-lg" placeholder="Ingresar las observaciones" id="observacionProducto" name="observacionProducto"></textarea>
        				</div>
      			</div>
        	</div>
        </div>
        <!--=====================================
    		PIE DEL MODAL
    		======================================-->
    		<div class="modal-footer">
    			<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
    			<button id="guardarProducto" type="submit" class="btn btn-primary btn-agregar-kq">Guardar producto</button>
    		</div>            
        <input type="hidden" id="accionProducto" name="accionProducto">
   		</form>
   	</div>
  </div>
</div>