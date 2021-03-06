<!--=====================================
MODAL AGREGAR CLIENTE
======================================-->
<div id="modalMaterialAreaOrdProd" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formAreaMaterialOrdProd" method="post">
                <div class="overlay overlay-kq hidden">
                    <i class="fa fa-refresh fa-spin fa-spin-kq"></i>
                </div>
                <!--=====================================
                CABEZA DEL MODAL
                ======================================-->
                <div class="modal-header modal-header-kq-2">
                    <button type="button" class="close" data-dismiss="modal" style="color: #fff;">&times;</button>
                    <h4 class="modal-title" style="font-weight: bold;" id="modalTituloAreaMatEstOrd">Material</h4>
                </div>
                <!--=====================================
                CUERPO DEL MODAL
                ======================================-->
                <div class="modal-body">
                    <div class="box-body">
                         <div class="form-group" style="margin-bottom: 15px;overflow:hidden;">
                            <label class="col-md-2 control-label" for="serieGuiaRmsAreaFctOrdPrd">Estado</label>
                            <div class="col-md-8 divEstadoAreaMaterialOrdProd">
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="form-group divSiTerminado" style="margin-bottom: 15px;overflow:hidden;">
                            <label class="col-md-2 control-label" for="cantidadAreaOrdProd">Cantidad Solicitada</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control input2Decimales inputPorcentaje" id="cantidadSolAreaMatOrdProd" placeholder="Ingrese el %" required autofocus>
                            </div>
                            <label class="col-md-2 control-label" for="fechaIncialAreaFctOrdPrd">
                            Fecha Registro</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control inputFecha" id="fechaIncialSolAreaMatFctOrdPrd" name="fechaIncialSolAreaMatFctOrdPrd" placeholder="Ingrese la fecha" value="<?php echo date('d-m-Y'); ?>" required>
                            </div>
                        </div>
                        <div class="form-group divSiTerminado" style="margin-bottom: 15px;overflow:hidden;">
                            <label class="col-md-2 control-label" for="cantidadAreaOrdProd">Cantidad Recibida</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control input2Decimales inputPorcentaje" id="cantidadRecAreaMatOrdProd" data-toggle="tooltip" data-original-title='La cantidad no puede ser mayor a 100%' name="cantidadRecAreaMatOrdProd" placeholder="Ingrese el %" required autofocus>
                            </div>
                            <label class="col-md-2 control-label" for="fechaIncialAreaFctOrdPrd">
                            Fecha Registro</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control inputFecha" id="fechaIncialRecAreaFctOrdPrd" name="fechaIncialRecAreaFctOrdPrd" placeholder="Ingrese la fecha" value="<?php echo date('d-m-Y'); ?>" required>
                            </div>
                        </div>
                        <hr class="divNoPendiente">
                        <div class="table-responsive divNoPendiente" >
                            <table class="table table-striped table-bordered tablaKq" id="tblAreaOrdProdModal" style="width: 100% !important;">
                                <thead class="thead-kq-2">
                                    <tr>
                                        <td class="text-center tdWidthFchRgstArOrdProd">Fecha Registro</td>
                                        <td class="text-center tdWidthCtdAtdArOrdProd" id="tdCtdAtHead">Cantidad Solicitada</td>
                                         <td class="text-center tdWidthCtdAtdArOrdProd" id="tdCtdAtHead">Cantidad Recibida</td>
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
                    <button type="submit" class="btn btn-primary btn-agregar-kq divSiTerminado">Guardar</button>
                </div>
                <input type="hidden" id="codLocalAreaMatOrdProd" name="codLocalAreaMatOrdProd" />
                <input type="hidden" id="numOrdAreaMatOrdProd" name="numOrdAreaMatOrdProd" />
                <input type="hidden" id="numLnaDtlAreaMatOrdProd" name="numLnaDtlAreaMatOrdProd" />
                <input type="hidden" id="codPrdAreaMatOrdProd" name="codPrdAreaMatOrdProd" />
                <input type="hidden" id="codArAreaMatOrdProd" name="codArAreaMatOrdProd" />
                <input type="hidden" id="accionMatOrdenProduccion" name="accionMatOrdenProduccion" value="editar">
                <input type="hidden" name="entrada" value="areaMaterialOrdProd">
            </form>
        </div>
    </div>
</div>