<!--=====================================
MODAL AGREGAR CLIENTE
======================================-->
<div id="modalAreaOrdProd" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formAreaOrdProd" method="post">
                <div class="overlay overlay-kq hidden">
                    <i class="fa fa-refresh fa-spin fa-spin-kq"></i>
                </div>
                <!--=====================================
                CABEZA DEL MODAL
                ======================================-->
                <div class="modal-header modal-header-kq-2">
                    <button type="button" class="close" data-dismiss="modal" style="color: #fff;">&times;</button>
                    <h4 class="modal-title" style="font-weight: bold;" id="modalTituloAreaEstOrd">Area</h4>
                </div>
                <!--=====================================
                CUERPO DEL MODAL
                ======================================-->
                <div class="modal-body">
                    <div class="box-body">
                         <div class="form-group" style="margin-bottom: 15px;overflow:hidden;">
                            <label class="col-md-2 control-label" for="serieGuiaRmsAreaFctOrdPrd">Estado</label>
                            <div class="col-md-8 divEstadoAreaOrdProd">
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="form-group divSiTerminado" style="margin-bottom: 15px;overflow:hidden;">
                            <label class="col-md-2 control-label cajaCantidadAreaOrdProd" for="cantidadAreaOrdProd">Cantidad Antendida</label>
                            <div class="col-md-3  cajaCantidadAreaOrdProd">
                                <input type="text" class="form-control input2Decimales" id="cantidadAreaOrdProd" name="cantidadAreaOrdProd" placeholder="Ingrese la cantidad">
                            </div>
                            <label class="col-md-2 control-label hidden cajaCantidadPorcAreaOrdProd" for="cantidadAreaOrdProd">Porcentaje Avance</label>
                            <div class="col-md-3 hidden cajaCantidadPorcAreaOrdProd">
                                <input type="text" class="form-control input2Decimales" id="cantidadPorcAreaOrdProd" name="cantidadPorcAreaOrdProd" placeholder="Ingrese el %">
                            </div>
                            <label class="col-md-2 control-label" for="fechaIncialAreaFctOrdPrd">
                            Fecha Registro</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control inputFecha" id="fechaIncialAreaFctOrdPrd" name="fechaIncialAreaFctOrdPrd" placeholder="Ingrese la fecha" value="<?php echo date('d-m-Y'); ?>" required>
                            </div>
                        </div>
                        <hr class="divNoPendiente">
                        <div class="table-responsive divNoPendiente">
                            <table class="table table-striped table-bordered tablaKq" id="tblAreaOrdProdModal" style="width: 100% !important;">
                                <thead class="thead-kq-2">
                                    <tr>
                                        <td class="text-center tdWidthFchRgstArOrdProd">Fecha Registro</td>
                                        <td class="text-center tdWidthCtdAtdArOrdProd" id="tdCtdAtHead">Cantidad Atendida</td>
                                        <td class="text-center tdWidthUsrArOrdProd">Usuario</td>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>                                 
                                    <tr>
                                        <th></th>
                                        <th class="totalCtdAtendidaOrdPrd"></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <!--=====================================
                PIE DEL MODAL
                ======================================-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn btn-primary btn-agregar-kq divSiTerminado" id="btnGuardarAreaMdOrdProd">Guardar</button>
                </div>
                <input type="hidden" id="codLocalAreaOrdProd" name="codLocalAreaOrdProd" />
                <input type="hidden" id="numOrdAreaOrdProd" name="numOrdAreaOrdProd" />
                <input type="hidden" id="numLnaDtlAreaOrdProd" name="numLnaDtlAreaOrdProd" />
                <input type="hidden" id="codPrdAreaOrdProd" name="codPrdAreaOrdProd" />
                <input type="hidden" id="codArAreaOrdProd" name="codArAreaOrdProd" />
                <input type="hidden" id="flgPedidoAreaOrdProd" name="flgPedidoAreaOrdProd">
                <input type="hidden" id="flgComprasAreaOrdProd" name="flgComprasAreaOrdProd">
                <input type="hidden" name="accionOrdenProduccion" value="editar">
                <input type="hidden" name="entrada" value="areaRelacOrdProd">
            </form>
        </div>
    </div>
</div>