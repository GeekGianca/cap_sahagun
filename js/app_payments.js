$(document).ready(function () {

    const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2
    })
    let control_code_caja;
    obtenerTodoPagina();

    function obtenerTodoPagina() {
        selectAllTutores();
        obtenerCodigoControl();
        obtenerEstudiantes();
        obtenerPagosTutores();
    }

    function selectAllTutores() {
        $.ajax({
            url: 'php/l_tutores.php',
            type: 'GET',
            success: function (response) {
                let data = JSON.parse(response);
                let template = '';
                template += `<option selected disabled>Seleccione...</option>`;
                data.forEach(dat => {
                    template += `<option value="${dat.id_tutor}">${dat.n_tutor}</option>`;
                });
                $('#cod_tutor_pago').html(template);
            }
        });
        let codeID = Math.floor((Math.random() * 1000000) + 1);
        $('#cod_pago').val(codeID);
        $('#cod_pago').attr("readonly", true);
    }

    function obtenerEstudiantes() {
        $.ajax({
            url: 'php/l_estudiantes_inscripcion.php',
            type: 'GET',
            success: function (response) {
                let data = JSON.parse(response);
                let template = '';
                template += `<option selected disabled>Seleccione...</option>`;
                data.forEach(dat => {
                    let nomApe = dat.nombre + " " + dat.apellidos;
                    template += `<option value="${dat.id}">${nomApe}</option>`;
                });
                $('#cod_registro').html(template);
            }
        });
    }

    function insertarControl() {
        $.ajax({
            url: 'php/i_control.php',
            type: 'GET',
            success: function (response) {
                obtenerCodigoControl();
            }
        });
    }

    function obtenerCodigoControl() {
        $.ajax({
            url: 'php/s_control.php',
            type: 'GET',
            success: function (response) {
                console.log(response);
                if (response == 'null') {
                    $('#total_entradas').html("Total entradas: $0");
                    $('#total_salidas').html("Total salidas: $0");
                    insertarControl();
                } else {
                    let data = JSON.parse(response);
                    $('#total_entradas').html("Total entradas: " + formatter.format(data.entrada));
                    $('#total_salidas').html("Total salidas: " + formatter.format(data.salida));
                    if(data.fecha_corte != null){
                        $('#fecha_corte').attr("readonly", true);
                    }
                    control_code_caja = data.codigo_control;
                }
            }
        });
    }

    function obtenerPagosTutores() {
        $.ajax({
            url: 'php/l_pagos_tutores.php',
            type: 'GET',
            success: function (response) {
                let data = JSON.parse(response);
                let template = '';
                data.forEach(dat => {
                    let nTutor = dat.nombre + " " + dat.apellidos;
                    let priceFormat = formatter.format(dat.val_pagado);
                    template += `
                    <tr c_control="${dat.c_control}">
                        <td>
                            <small>${dat.c_control}</small>
                        </td>
                        <td>
                            <small>${nTutor}</small>
                        </td>
                        <td>
                            <small>${dat.cre_caja}</small>
                        </td>
                        <td>
                            <small>${priceFormat}</small>
                        </td>
                    </tr>
                `;
                });
                $('#tabla-pagos').html(template);
            }
        });
    }

    $('#cod_registro').on('change', function (e) {
        let opcionSeleccionada = $("option:selected", this);
        let id_est_reg = this.value;
        $.post('php/s_costo_estudiante.php', {id_est_reg}, function (response) {
            let data = JSON.parse(response);
            $('#val_pagar').val(data.costo);
        });
    });

    $('#cod_tutor_pago').on('change', function (e) {
        let opcionSeleccionada = $("option:selected", this);
        let id_tutor = this.value;
        $.post('php/s_tutor.php', {id_tutor}, function (response) {
            let data = JSON.parse(response);
            $('#nom_tutor_pago').val(data.n_tutor);
            $('#ape_tutor_pago').val(data.a_tutor);
            $('#corr_tutor_pago').val(data.c_tutor);
            $('#dir_tutor_pago').val(data.d_tutor);
        });
    });

    $('#pagos-form').submit(function (e) {
        let select = document.getElementById("cod_registro");
        let val = select.options[select.selectedIndex].value;
        const dataPost = {
            cod_pago: $('#cod_pago').val(),
            fec_pago: $('#fec_pago').val(),
            hor_pago: $('#hor_pago').val(),
            val_pagar: $('#val_pagar').val(),
            val_restante: $('#val_restante').val(),
            cod_registro: val,
            cod_control: control_code_caja
        };
        $.post('php/i_pagos.php', dataPost, function (response) {
            console.log(response);
            $('#pagos-form').trigger('reset');
            obtenerTodoPagina();
        });
        e.preventDefault();
    });

    $('#pago-tutores-form').submit(function (e) {
        let select = document.getElementById("cod_tutor_pago");
        let val = select.options[select.selectedIndex].value;
        const dataPost = {
            cod_tutor_pago: val,
            cod_caja_pago: control_code_caja,
            val_tutor_pago: $('#val_tutor_pago').val()
        };
        $.post('php/i_pago_maestro.php', dataPost, function (response) {
            $('#pago-tutores-form').trigger('reset');
            obtenerTodoPagina();
        });
        e.preventDefault();
    });
});