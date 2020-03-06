<!--=====================================
MODAL AGREGAR CLIENTE
======================================-->
<div id="modalCliente" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formCliente" method="post">
                <div class="overlay overlay-kq hidden">
                    <i class="fa fa-refresh fa-spin fa-spin-kq"></i>
                </div>
                <!--=====================================
                CABEZA DEL MODAL
                ======================================-->
                <div class="modal-header modal-header-kq-2">
                    <button type="button" class="close" data-dismiss="modal" style="color: #fff;">&times;</button>
                    <h4 class="modal-title" style="font-weight: bold;" id="modalTituloCliente">Agregar cliente</h4>
                </div>
                <!--=====================================
                CUERPO DEL MODAL
                ======================================-->
                <div class="modal-body">
                    <div class="box-body">
                        <!-- ENTRADA PARA EL RUC -->
                        <div class="form-group">              
                            <div class="input-group">              
                                <span class="input-group-addon"><i class="fa fa-key"></i></span> 
                                <input type="text" class="form-control input-lg" id="documentoCliente" name="documentoCliente" placeholder="Ingresar RUC / ID" autofocus required>
                            </div>
                        </div>
                        <!-- ENTRADA PARA LA RAZÓN SOCIAL -->
                        <div class="form-group">              
                            <div class="input-group">              
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control input-lg" id="nombreCliente" name="nombreCliente" placeholder="Ingresar razon social" required>
                            </div>
                        </div>
                        <!-- SELECCIONAR LA CATEGORÍA -->
                        <div class="form-group">
                            <div class="input-group select2-input-lg-kq">
                                <span class="input-group-addon" title="Categoría"><i class="fa fa-recycle"></i></span>
                                <select class="form-control input-lg" id="categoriaCliente" name="categoriaCliente" style="width: 100%" required>
                                    <option disabled selected value="">Seleccione una categoria</option>
                                    <?php
                                    $item = null;
                                    $valor = null;
                                    $categoriaClientes = ControladorCategoriaCliente::ctrMostrarCategoriaClientes($item,$valor);
                                    foreach ($categoriaClientes as $key => $value) {
                                        echo '<option value="'.$value["cod_categoria_cliente"].'">'.$value["dsc_categoria_cliente"].'</option>';
                                    }//foreach
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- SELECCIONAR LA FORMA DE PAGO -->
                        <div class="form-group">
                            <div class="input-group select2-input-lg-kq">
                                <span class="input-group-addon" title="Categoría"><i class="fa fa-recycle"></i></span>
                                <select class="form-control input-lg" id="formaPagoCliente" name="formaPagoCliente" style="width: 100%" required>
                                    <option disabled selected value="">Seleccione una forma de pago</option>
                                    <?php
                                    $item = null;
                                    $valor = null;
                                    $formaPagos = ControladorFormaPago::ctrMostrarFormaPago($item,$valor);
                                    foreach ($formaPagos as $key => $value) {   
                                        echo '<option value="'.$value["cod_forma_pago"].'">'.$value["dsc_forma_pago"].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- ENTRADA PARA LA DIRECCIÓN -->
                        <div class="form-group">              
                            <div class="input-group">              
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <input type="text" class="form-control input-lg" id="direccionCliente" name="direccionCliente" placeholder="Ingresar dirección" required>
                            </div>
                        </div>
                        <!-- SELECCIONAR EL PAÍS -->
                        <div class="form-group">
                            <div class="input-group select2-input-lg-kq">
                                <span class="input-group-addon" title="Pais"><i class="fa fa-flag-o"></i></span>
                                <select class="form-control select2" id="paisCliente" name="paisCliente" style="width: 100%" required>
                                    <option value='' disabled selected>Seleccione un pais</option>
                                    <?php
                                    $item = null;
                                    $valor = null;
                                    $paises = ControladorPais::ctrMostrarPaises($item,$valor);
                                    foreach ($paises as $key => $value) {       
                                        echo '<option value="'.$value["cod_pais"].'">'.$value["dsc_pais"].'</option>';
                                    }
                                    ?>
                                </select>
                                <input type="hidden" id="editarCodDepartamento">
                            </div>
                        </div>
                        <!-- SELECCIONAR EL DEPARTAMENTO -->
                        <div class="form-group formDepartamentoCliente">
                            <div class="input-group select2-input-lg-kq hide select2DepartamentoCliente">
                                <span class="input-group-addon" title="Departamento"><i class="fa fa-flag-o"></i></span>
                                <select class="form-control select2" id="departamentoCliente" name="departamentoCliente" style="width: 100%"></select>
                                <input type="hidden" id="editarCodProvincia">
                            </div>
                            <div class="input-group vacioDepartamentoCliente">
                                <span class="input-group-addon" title="Departamento"><i class="fa fa-flag-o"></i></span>
                                <input type="text" class="form-control input-lg" readonly>
                            </div>
                        </div>
                        <!-- SELECCIONAR LA PROVINCIA -->                        
                        <div class="form-group formProvinciaCliente">
                            <div class="input-group select2-input-lg-kq select2ProvinciaCliente hide">
                                <span class="input-group-addon" title="Provincia"><i class="fa fa-flag-o"></i></span>
                                <select class="form-control select2" id="provinciaCliente" name="provinciaCliente" style="width: 100%"></select>
                                <input type="hidden" id="editarCodDistrito">
                            </div>
                            <div class="input-group vacioProvinciaCliente">
                                <span class="input-group-addon" title="Provincia"><i class="fa fa-flag-o"></i></span>
                                <input type="text" class="form-control input-lg" readonly>
                            </div>
                        </div>
                        <!-- SELECCIONAR EL DISTRITO -->                        
                        <div class="form-group formDistritoCliente">
                            <div class="input-group select2-input-lg-kq select2DistritoCliente hide">
                                <span class="input-group-addon" title="Distrito"><i class="fa fa-flag-o"></i></span>
                                <select class="form-control select2" id="distritoCliente" name="distritoCliente" style="width: 100%"></select>
                            </div>
                            <div class="input-group vacioDistritoCliente">
                                <span class="input-group-addon" title="Distrito"><i class="fa fa-flag-o"></i></span>
                                <input type="text" class="form-control input-lg" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <!--=====================================
                PIE DEL MODAL
                ======================================-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="guardarCliente" type="submit" class="btn btn-primary btn-agregar-kq">Guardar cliente</button>
                </div>
                <input type="hidden" id="codigoCliente" name="codigoCliente">
                <input type="hidden" id="accionCliente" name="accionCliente">
            </form>
        </div>
    </div>
</div>