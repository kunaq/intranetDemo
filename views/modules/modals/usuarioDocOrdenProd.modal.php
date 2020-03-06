<!--=====================================
MODAL AGREGAR CLIENTE
======================================-->
<div id="modalUsuarioDocOrdProd" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width: 59%;">
        <div class="modal-content">
            <form id="formUsuarioDocOrdProd" method="post">
                <div class="overlay overlay-kq hidden">
                    <i class="fa fa-refresh fa-spin fa-spin-kq"></i>
                </div>
                <!--=====================================
                CABEZA DEL MODAL
                ======================================-->
                <div class="modal-header modal-header-kq-2">
                    <button type="button" class="close" data-dismiss="modal" style="color: #fff;">&times;</button>
                    <h4 class="modal-title" style="font-weight: bold;" id="modalTituloCliente">Usuarios</h4>
                </div>
                <!--=====================================
                CUERPO DEL MODAL
                ======================================-->
                <div class="modal-body">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered tablaKq" id="tablaUsuarioDocOrdProd" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <td class="text-center tblUsrDctoOrdProdWidthNmb">Nombre</td>
                                        <td class="tblUsrDctoOrdProdWidthChk"></td>
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
                    <?php
                    if(!isset($_GET["localidad"]) || (isset($_GET["localidad"]) && $ordenProduccion["flg_anulado"] != 'SI')){
                        echo '<button type="submit" class="btn btn-primary btn-agregar-kq">Guardar</button>';
                    }
                    ?>
                </div>
                <input type="hidden" id="localidadUsrDocOrdProd" name="localidadUsrDocOrdProd" value="" />
                <input type="hidden" id="numOrdUsrDocOrdProd" name="numOrdUsrDocOrdProd" value="" />
                <input type="hidden" id="numLnOrdUsrDocOrdProd" name="numLnOrdUsrDocOrdProd" value="" />
                <input type="hidden" name="accionOrdenProduccion" value="crear" />
                <input type="hidden" name="entrada" value="usuarioDocVinc" />
                <input type="hidden" id="listaUsuariosDocOrdPrd" name="listaUsuariosDocOrdPrd" />
            </form>
        </div>
    </div>
</div>