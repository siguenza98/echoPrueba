@extends('layouts.main')

@section('pageTitle', 'Users')

@section('content')
    <div class="col-xs-12 col-md-12 col-xl-12" id="toolbar"></div>
    <div id="userTable"></div>
    <div id="loadpanel"></div>

    <div id="popupContainer"></div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            let popupWidth = "";
            //determina el ancho de los popup a partir del ancho disponible de la pantalla
            if (screen.availWidth < 500) {
                popupWidth = "80%";
            } else if (screen.availWidth >= 500 && screen.availWidth < 1000) {
                popupWidth = "60%";
            } else {
                popupWidth = "30%";
            }

            //array con roles
            const roles = [
                {
                    "id": "admin",
                    "value": "Administrator"
                },
                {
                    "id": "inventory_manager",
                    "value": "Inventory Manager"
                },
                {
                    "id": "accountant",
                    "value": "Accountant"
                },
                {
                    "id": "client",
                    "value": "Client"
                },
            ];
            
            var loadPanel = $("#loadpanel").dxLoadPanel({
                shadingColor: "rgba(255,255,255,0.2)",
                visible: false,
                showIndicator: true,
                message: "Loading...",
                showPane: true,
                shading: false,
                closeOnOutsideClick: false
            }).dxLoadPanel("instance");

            //toolbar con opciones
            var mainToolbar = $("#toolbar").dxToolbar({
                items: [{
                    location: 'after',
                    locateInMenu: 'auto',
                    widget: 'dxButton',
                    options: {
                        elementAttr: {
                            id: "btnAddUser"
                        },
                        icon: "plus",
                        text: 'Add User',
                        onClick: function() {
                            userPopup(null, "Add User");
                        }
                    }
                }]
            }).dxToolbar("instance");

            //tabla de listado de usuarios
            var userTable = $("#userTable").dxDataGrid({
                showBorders: true,
                hoverStateEnabled: true,
                rowAlternationEnabled: true,
                allowColumnReordering: true,
                allowColumnResizing: true,
                columnResizingMode: "widget",
                columnAutoWidth: true,
                noDataText: "No data found",
                width: "100%",
                loadPanel: {
                    enabled: true,
                    text: "Processing..."
                },
                paging: {
                    pageSize: 15
                },
                pager: {
                    allowedPageSizes: [15, 25, 50, 100],
                    infoText: "Page {0} out of {1} | {2} Records",
                    showInfo: true,
                    showNavigationButtons: true,
                    showPageSizeSelector: true,
                    visible: true
                },
                columns: [{
                    dataField: "id",
                    caption: "ID",
                    visible: false
                }, {
                    caption: "First Name",
                    dataField: "first_name",
                    width: "20%"
                },{
                    caption: "Last Name",
                    dataField: "last_name",
                    width: "20%"
                },{
                    caption: "Email",
                    dataField: "email",
                    width: "20%"
                },{
                    caption: "DUI",
                    dataField: "dui",
                    width: "20%"
                },{
                    caption: "Role",
                    dataField: "role",
                    width: "20%"
                }],
                onCellClick: function(e) {
                    if (e.rowType == "data") {
                        userPopup(e.data, "Update User");
                    }
                },
            }).dxDataGrid("instance");

            //formulario popup para la ceracion/edicion de usuarios
            function userPopup(user = null, title) {
                $("#userPopup").remove();
                $("#popupContainer").append('<div id="userPopup"></div>');
                $("#userPopup").dxPopup({
                    height: 'auto',
                    width: popupWidth,
                    title: title,
                    visible: false,
                    closeOnOutsideClick: true,
                    contentTemplate: function(contentElement) {
                        contentElement.addClass("p-3");
                        contentElement.append('<div id="data"></div>');
                        contentElement.append('<div id="buttons" class="mt-4"></div>');

                        texto = '<div class="col-md-12">';
                        texto += '<div class="ms-1" style="float: right;" id="btnAdd"></div>';
                        texto += '</div>';

                        $("#data").append('<div class="col-md-12 mb-2" id="inputFirstName"></div>');
                        $("#data").append('<div class="col-md-12 mb-2" id="inputLastName"></div>');
                        $("#data").append('<div class="col-md-12 mb-2" id="inputEmail"></div>');
                        $("#data").append('<div class="col-md-12 mb-2" id="inputDui"></div>');
                        $("#data").append('<div class="col-md-12 mb-2" id="inputRole"></div>');

                        $("#buttons").append(texto);

                        //declaracion de componentes
                        $("#inputFirstName").dxTextBox({
                            name: "inputFirstName",
                            stylingMode: "filled",
                            label: "First Name",
                            width: "100%",
                            value: (user != null) ? user.first_name : "",
                        }).dxValidator({
                            validationRules: [{
                                type: "required",
                                message: "First name is required."
                            }]
                        });

                        $("#inputLastName").dxTextBox({
                            name: "inputLastName",
                            stylingMode: "filled",
                            label: "Last Name",
                            width: "100%",
                            value: (user != null) ? user.last_name : "",
                        }).dxValidator({
                            validationRules: [{
                                type: "required",
                                message: "Last name is required."
                            }]
                        });

                        $("#inputEmail").dxTextBox({
                            name: "inputEmail",
                            stylingMode: "filled",
                            label: "Email",
                            width: "100%",
                            value: (user != null) ? user.email : "",
                        }).dxValidator({
                            validationRules: [{
                                type: "required",
                                message: "Email is required."
                            }]
                        });

                        $("#inputDui").dxTextBox({
                            name: "inputDui",
                            stylingMode: "filled",
                            label: "DUI",
                            width: "100%",
                            value: (user != null) ? user.dui : "",
                        }).dxValidator({
                            validationRules: [{
                                type: "required",
                                message: "DUI is required."
                            }]
                        });

                        $('#inputRole').dxSelectBox({
                            name: "inputRole",
                            dataSource: roles,
                            stylingMode: "filled",
                            label: "Role",
                            width: "100%",
                            displayExpr: 'value',
                            valueExpr: 'id',
                            value: (user != null) ? user.role : "",
                        }).dxValidator({
                            validationRules: [{
                                type: "required",
                                message: "Role is required."
                            }]
                        });

                        $("#btnAdd").dxButton({
                            disabled: false,
                            icon: "check",
                            type: "normal",
                            onClick: function(e) {
                                var resultado = e.validationGroup.validate();
                                if (resultado.isValid) {
                                    //$("#btnAdd").dxButton("instance").option("disabled",true);

                                    //obtiene los datos ingresados de los inputs del formulario
                                    var data = {
                                        first_name: $("#inputFirstName").dxTextBox('instance').option("value"),
                                        last_name: $("#inputLastName").dxTextBox('instance').option("value"),
                                        email: $("#inputEmail").dxTextBox('instance').option("value"),
                                        dui: $("#inputDui").dxTextBox('instance').option("value"),
                                        role: $("#inputRole").dxSelectBox('instance').option("value"),
                                    };

                                    //determina si agregar un nuevo usuario o modificar uno existente
                                    if (user == null) {
                                        addUser(data);
                                    } else {
                                        const userId = user.id;
                                        updateUser(data, userId);
                                    }
                                }
                            }
                        });
                    }
                });

                $("#userPopup").dxPopup("instance").show();

            }

            //funcion que obtiene el listado de usuarios del sistema
            function getUsers() {
                loadPanel.show();
                $.ajax({
                    type: "POST",
                    url: "{{ url('') }}/users/getUsers",
                    data: {"id": {{Auth::user()->id}}},
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        userTable.option("dataSource", data);
                        $("#btnAddUser").dxButton("instance").option("disabled", false);

                    }
                }).then(function() {
                    loadPanel.hide();
                });
            }

            function addUser(data) {
                loadPanel.show();
                $.ajax({
                    type: "POST",
                    url: "{{ url('') }}/users/addUser",
                    data: {
                        "data": data
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.isValid) {
                            
                            DevExpress.ui.notify(data.message, "success", 2000);
                            $("#userPopup").dxPopup("instance").hide();
                            getUsers();

                        } else {
                            $("#btnAdd").dxButton("instance").option("disabled", false);
                            DevExpress.ui.notify(data.message, "error", 2000);
                        }

                    }
                }).then(function() {
                    loadPanel.hide();
                });
            }

            function updateUser(data, userId) {
                loadPanel.show();
                $.ajax({
                    type: "POST",
                    url: "{{ url('') }}/users/updateUser",
                    data: {
                        "data": data,
                        "userId": userId
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.isValid) {
                            DevExpress.ui.notify(data.message, "success", 2000);
                            $("#userPopup").dxPopup("instance").hide();
                            getUsers();
                        } else {
                            $("#btnAdd").dxButton("instance").option("disabled", false);
                            DevExpress.ui.notify(data.message, "error", 2000);
                        }

                    }
                }).then(function() {
                    loadPanel.hide();
                });
            }

            //carga inicial de datos
            getUsers();
        });
    </script>
@endsection
