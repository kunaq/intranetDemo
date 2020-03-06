<!--=====================================
MODAL AGREGAR CLIENTE
======================================-->
<div id="modalFacturacionAreaOrdProd" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width: 465px;">
        <div class="modal-content">
            <form id="formAreaFacturacionOrdProd" method="post">
                <div class="overlay overlay-kq hidden">
                    <i class="fa fa-refresh fa-spin fa-spin-kq"></i>
                </div>
                <!--=====================================
                CABEZA DEL MODAL
                ======================================-->
                <div class="modal-header modal-header-kq-2">
                    <button type="button" class="close" data-dismiss="modal" style="color: #fff;">&times;</button>
                    <h4 class="modal-title" style="font-weight: bold;" id="modalTituloAreaFacturacionEstOrd">Area</h4>
                </div>
                <!--=====================================
                CUERPO DEL MODAL
                ======================================-->
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group overflowHidden">
                            <label class="col-md-4 control-label">Estado:</label>
                            <div class="col-md-7">
                                <select class="form-control" id="estadoFctAreaFctOrdPrd" name="estadoFctAreaFctOrdPrd">
                                    <option value="" selected>Seleccione un estado</option>
                                    <?php
                                    $item1 =  'flg_activo';
                                    $valor1 = 'SI';
                                    $item2 = $valor2 = null;
                                    $entrada = 'inputSelect';
                                    $estado = ControladorEstadoAreaOrdProd::ctrMostrarEstadoAreaOrdProd($item1,$valor1,$item2,$valor2,$entrada);
                                    foreach ($estado as $key => $value) {
                                        echo '<option value="'.$value["cod_estado"].'">'.$value["dsc_estado"].'</option>';
                                    }//foreach
                                    ?>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group overflowHidden divSiTerminadoFct">
                            <label class="col-md-4 control-label" for="serieGuiaRmsAreaFctOrdPrd">Guia de remision:</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" id="numGuiaRmsAreaFctOrdPrd" name="numGuiaRmsAreaFctOrdPrd" placeholder="Ingrese la guía">
                            </div>                            
                        </div>
                        <div class="form-group overflowHidden divSiTerminadoFct">
                            <label for="" class="col-md-4 control-label">Fecha de Emisión:</label>
                            <div class="col-md-7">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right inputFecha" id="fchEmsGuiRmAreaFctOrdPrd" name="fchEmsGuiRmAreaFctOrdPrd" value="<?php echo date('d-m-Y'); ?>" placeholder="Ingrese la fecha de emision" />
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered tablaKq" id="tblGuiaRemisionOrdProdModal" style="width: 100% !important;">
                                <thead class="thead-kq-2">
                                    <tr>
                                        <td class="text-center tdWidthFchRgstArFctRmOrdProd">Fecha Registro</td>
                                        <td class="text-center tdWidthGuiaRAtdArFctRmOrdProd" id="tdCtdAtHead">Nº Guia Remisión</td>
                                        <td class="text-center tdWidthFchEArFctRmOrdProd">Fecha de Emisión</td>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <hr>
                        <div class="form-group overflowHidden divSiTerminadoFct">
                            <label class="col-md-4 control-label" for="serieFctAreaFctOrdPrd">Facturación:</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" id="numFctAreaFctOrdPrd" name="numFctAreaFctOrdPrd" placeholder="Ingrese la facturacion">
                            </div>
                        </div>
                        <div class="form-group overflowHidden divSiTerminadoFct">
                            <label for="" class="col-md-4 control-label">Fecha de Emisión:</label>
                            <div class="col-md-7">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right inputFecha" id="fchEmsFactAreaFctOrdPrd" name="fchEmsFactAreaFctOrdPrd" value="<?php echo date('d-m-Y'); ?>" placeholder="Ingrese la fecha de emision" />
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered tablaKq" id="tblFacturacionOrdProdModal" style="width: 100% !important;">
                                <thead class="thead-kq-2">
                                    <tr>
                                        <td class="text-center tdWidthFchRgstArFctFctOrdProd">Fecha Registro</td>
                                        <td class="text-center tdWidthNumFAtdArFctFctOrdProd" id="tdCtdAtHead">Nº Facturación</td>
                                        <td class="text-center tdWidthFchEArFctFctOrdProd">Fecha de Emisión</td>
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
                    <button type="submit" class="btn btn-primary btn-agregar-kq divSiTerminadoFct">Guardar</button>
                </div>
                <input type="hidden" class="inputHidden" id="codLocalFctAreaFctOrdPrd" name="codLocalFctAreaFctOrdPrd" />
                <input type="hidden" class="inputHidden" id="numOrdFctAreaFctOrdPrd" name="numOrdFctAreaFctOrdPrd" />
                <input type="hidden" class="inputHidden" id="numLnaFctAreaFctOrdPrd" name="numLnaFctAreaFctOrdPrd" />
                <input type="hidden" class="inputHidden" id="codPrdFctAreaFctOrdPrd" name="codPrdFctAreaFctOrdPrd" />
                <input type="hidden" class="inputHidden" id="codAreaFctOrdPrd" name="codAreaFctOrdPrd" />
                <input type="hidden" name="accionOrdenProduccion" value="editar">
                <input type="hidden" name="entrada" value="areaFacturacionRelacOrdProd">
            </form>
        </div>
    </div>
</div>