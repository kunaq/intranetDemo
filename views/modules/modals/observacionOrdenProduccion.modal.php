<!--=====================================
MODAL AGREGAR OBSERVACION ORDEN DE PRODUCCION
======================================-->
<div id="modalObservacionOrdPrd" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
   		<form role="form" id="formObservacionOrdPrd" method="post">
        <div class="overlay overlay-kq hidden">
          <i class="fa fa-refresh fa-spin fa-spin-kq"></i>
        </div>
   			<!--=====================================
      	CABEZA DEL MODAL
      	======================================-->
    		<div class="modal-header modal-header-kq-2">
    			<button type="button" class="close" data-dismiss="modal" style="color: #fff;">&times;</button>
      			<h4 class="modal-title" style="font-weight: bold;" id="modalTituloProducto">Agregar Observación</h4>
    		</div>
    		<!--=====================================
    		CUERPO DEL MODAL
    		======================================-->
    		<div class="modal-body">
    			<div class="box-body">
            <div class="form-group">              
              <div class="input-group">              
                <span class="input-group-addon"><i class="fa fa-book"></i></span>
                <textarea class="form-control input-lg" placeholder="Ingresar las observaciones" id="descripcionObsOrdPrd" name="descripcionObsOrdPrd"></textarea>
              </div>
            </div>            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            <button type="submit" class="btn btn-primary btn-agregar-kq">Guardar</button>
          </div>
          <input type="hidden" id="localidadObsOrdProd" name="localidadObsOrdProd" value="" />
          <input type="hidden" id="numOrdObsOrdProd" name="numOrdObsOrdProd" value="" />
          <input type="hidden" id="numLnObsOrdProd" name="numLnObsOrdProd" value="" />
          <input type="hidden" id="accionOrdenProduccion" name="accionOrdenProduccion" value="crear" />
          <input type="hidden" name="entrada" value="modalObservacionOrdenProduccion" />
        </div>
      </form>
    </div>
  </div>
</div>