<!--=====================================
MODAL PRODUCTOS COTIZACION
======================================-->
<div id="modalProductosCotizacion" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width: 59%;">
        <div class="modal-content">
            <!-- <form id="formUsuarioDocOrdProd" method="post"> -->
               <!--  <div class="overlay overlay-kq hidden">
                    <i class="fa fa-refresh fa-spin fa-spin-kq"></i>
                </div> -->
                <!--=====================================
                CABEZA DEL MODAL
                ======================================-->
                <div class="modal-header modal-header-kq-2">
                    <button type="button" class="close" data-dismiss="modal" style="color: #fff;">&times;</button>
                    <h4 class="modal-title" style="font-weight: bold;">Productos</h4>
                </div>
                <!--=====================================
                CUERPO DEL MODAL
                ======================================-->
                <div class="modal-body">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered tablaKq" id="tblProductosCotizacionModal" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <td class="text-center"></td>
                                        <td class="text-center">Cotización</td>
                                        <td class="text-center">Producto</td>
                                        <td class="text-center">Cantidad</td>
                                        <td class="text-center">Unidad</td>    
                                        <td class="hidden"></td>
                                        <td class="hidden"></td>
                                        <td class="hidden"></td>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>   
                    </div>
                </div>
                <!--=====================================
                PIE DEL MODAL
                ======================================-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button type="button" id="btnGuardarProdCtzOrdPrd" class="btn btn-primary btn-agregar-kq">Guardar</button>
                </div>                
            </form>
        </div>
    </div>
</div>