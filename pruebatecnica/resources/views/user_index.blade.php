@extends('layouts.main')

@section('pageTitle', 'Users')

@section('content')
    <div class="col-xs-12 col-md-12 col-xl-12" id="toolbar"></div>
    <div id="tablaClientes"></div>
    <div id="loadpanel"></div>

    <div id="popupContainer"></div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            let anchoPopup = "";
            if (screen.availWidth < 500) {
                anchoPopup = "80%";
            } else if (screen.availWidth >= 500 && screen.availWidth < 1000) {
                anchoPopup = "60%";
            } else {
                anchoPopup = "40%";
            }
            
            var loadPanel = $("#loadpanel").dxLoadPanel({
                shadingColor: "rgba(255,255,255,0.2)",
                visible: false,
                showIndicator: true,
                message: "Cargando...",
                showPane: true,
                shading: false,
                closeOnOutsideClick: false
            }).dxLoadPanel("instance");

            var mainToolbar = $("#toolbar").dxToolbar({
                items: [{
                    location: 'after',
                    locateInMenu: 'auto',
                    widget: 'dxButton',
                    options: {
                        elementAttr: {
                            id: "btnAdicionar"
                        },
                        icon: "plus",
                        text: 'Add Client',
                        onClick: function() {
                            popupClientes(null, "Add User");
                        }
                    }
                }]
            }).dxToolbar("instance");

            var tablaClientes = $("#tablaClientes").dxDataGrid({
                showBorders: true,
                hoverStateEnabled: true,
                rowAlternationEnabled: true,
                allowColumnReordering: true,
                allowColumnResizing: true,
                columnResizingMode: "widget",
                columnAutoWidth: true,
                noDataText: "No se han encontrado datos",
                width: "100%",
                loadPanel: {
                    enabled: true,
                    text: "Procesando"
                },
                paging: {
                    pageSize: 10
                },
                columns: [{
                    dataField: "id",
                    caption: "ID",
                    width: "5%"
                }, {
                    caption: "Cliente",
                    dataField: "nombre",
                    width: "55%"
                },{
                    caption: "Teléfono",
                    dataField: "telefono",
                    width: "10%"
                },{
                    caption: "Zonas",
                    dataField: "nombreZonas",
                    width: "20%"
                },{
                    caption: "Estado",
                    dataField: "estado",
                    width: "10%",
                    cellTemplate(container, options) {
                        if (options.data.estado == 1) {
                            container.append("Activo");
                        } else {
                            container.append("Inactivo");

                        }
                    }
                }],
                onCellClick: function(e) {
                    if (e.rowType == "data") {
                        popupClientes(e.data, "Modificar Cliente");
                    }
                },
            }).dxDataGrid("instance");

            function getClientes() {
                loadPanel.show();
                $.ajax({
                    type: "POST",
                    url: "{{ url('') }}/clientes/getClientes",
                    dataType: "json",
                    success: function(data) {
                        tablaClientes.option("dataSource", data);
                        $("#btnAdicionar").dxButton("instance").option("disabled", false);

                    }
                }).then(function() {
                    loadPanel.hide();
                });
            }

            function popupClientes(cliente = null, titulo) {
                let estado = true;

                if (cliente != null) {
                    if (cliente.estado == "1") {
                        estado = true;
                    } else {
                        estado = false
                    }
                }
                $("#popupClientes").remove();
                $("#popupContainer").append('<div id="popupClientes"></div>');
                $("#popupClientes").dxPopup({
                    height: 'auto',
                    width: anchoPopup,
                    title: titulo,
                    visible: false,
                    closeOnOutsideClick: true,
                    contentTemplate: function(contentElement) {
                        contentElement.addClass("p-3");
                        contentElement.append('<div id="datos"></div>');
                        contentElement.append('<div id="botones" class="mt-4"></div>');

                        texto = '<div class="col-md-12">';
                        texto += '<div style="float: left;" id="inputEstado"></div>';
                        texto += '<div class="ms-1" style="float: right;" id="btnCancel"></div>';
                        texto += '<div class="ms-1" style="float: right;" id="btnAdd"></div>';
                        texto += '</div>';

                        $("#datos").append('<div class="col-md-12 mb-2" id="inputNombre"></div>');
                        $("#datos").append('<div class="col-md-12 mb-2" id="inputTelefono"></div>');
                        $("#datos").append('<div class="col-md-12" id="inputZonas"></div>');

                        $("#botones").append(texto);

                        $("#inputNombre").dxTextBox({
                            name: "inputNombre",
                            stylingMode: "filled",
                            label: "Nombre del Cliente",
                            labelMode: "floating",
                            width: "100%",
                            value: (cliente != null) ? cliente.nombre : "",
                        }).dxValidator({
                            validationRules: [{
                                type: "required",
                                message: "El nombre del cliente es requerido."
                            }]
                        });

                        $("#inputTelefono").dxTextBox({
                            name: "inputTelefono",
                            stylingMode: "filled",
                            label: "Teléfono del Cliente",
                            labelMode: "floating",
                            width: "100%",
                            value: (cliente != null) ? cliente.telefono : "",
                        }).dxValidator({
                            validationRules: [{
                                type: "required",
                                message: "El teléfono del cliente es requerido."
                            }]
                        });

                        $('#inputZonas').dxTagBox({
                            name: "inputZonas",
                            stylingMode: "filled",
                            label: "Zonas del Cliente",
                            labelMode: "floating",
                            width: "100%",
                            displayExpr: 'nombre',
                            valueExpr: 'id',
                        }).dxValidator({
                            validationRules: [{
                                type: "required",
                                message: "Las zonas del cliente son requeridas."
                            }]
                        });

                        $("#inputEstado").dxSwitch({
                            width: 150,
                            value: estado,
                            switchedOffText: "INACTIVO",
                            switchedOnText: "ACTIVO",
                        });

                        $("#btnAdd").dxButton({
                            disabled: false,
                            icon: "check",
                            type: "success",
                            onClick: function(e) {
                                var resultado = e.validationGroup.validate();
                                if (resultado.isValid) {
                                    //$("#btnAdd").dxButton("instance").option("disabled",true);
                                    var datos = {
                                        nombre: $("#inputNombre").dxTextBox('instance').option("value"),
                                        telefono: $("#inputTelefono").dxTextBox('instance').option("value"),
                                        zonas: $("#inputZonas").dxTagBox('instance').option("value").join(","),
                                        estado: $("#inputEstado").dxSwitch('instance').option("value"),

                                    };
                                    if (cliente == null) {
                                        adicionarCliente(datos);
                                    } else {
                                        const idCliente = cliente.id;
                                        updateCliente(datos, idCliente);
                                    }
                                }
                            }
                        });

                        $("#btnCancel").dxButton({
                            icon: "close",
                            type: "danger",
                            onClick: function(e) {
                                $("#popupClientes").dxPopup("instance").hide();
                            }
                        });


                    }
                });

                loadPanel.show();
                $.ajax({
                    type: "POST",
                    url: "{{ url('') }}/zonas/getZonas",
                    dataType: "json",
                    success: function(data) {
                        $("#popupClientes").dxPopup("instance").show();
                        $('#inputZonas').dxTagBox("instance").option("dataSource", data);
                        if(cliente != null){
                            let array = cliente.zonas.split(",").map(function(item) {
                                return parseInt(item, 10);
                            });
                            $('#inputZonas').dxTagBox("instance").option("value", array );
                        } 


                    }
                }).then(function() {
                    loadPanel.hide();
                });
            }

            function adicionarCliente(datos) {
                loadPanel.show();
                $.ajax({
                    type: "POST",
                    url: "{{ url('') }}/clientes/addCliente",
                    data: {
                        "datos": datos
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.respuesta == 'OK') {
                            DevExpress.ui.notify(data.mensaje, "success", 2000);
                            $("#popupClientes").dxPopup("instance").hide();
                            getClientes();
                        } else {
                            $("#btnAdd").dxButton("instance").option("disabled", false);
                            DevExpress.ui.notify(data.mensaje, "error", 2000);
                        }

                    }
                }).then(function() {
                    loadPanel.hide();
                });
            }

            function updateCliente(datos, idCliente) {
                loadPanel.show();
                $.ajax({
                    type: "POST",
                    url: "{{ url('') }}/clientes/updateCliente",
                    data: {
                        "datos": datos,
                        "id": idCliente
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.respuesta == 'OK') {
                            DevExpress.ui.notify(data.mensaje, "success", 2000);
                            $("#popupClientes").dxPopup("instance").hide();
                            getClientes();
                        } else {
                            $("#btnAdd").dxButton("instance").option("disabled", false);
                            DevExpress.ui.notify(data.mensaje, "error", 2000);
                        }

                    }
                }).then(function() {
                    loadPanel.hide();
                });
            }

            getClientes();
        });
    </script>
@endsection
