$(document).ready(function () {
    let validoFecha = false;
    let actualiza = false;
    let codigo_horario;
    selectTutores();
    selectHorarios();
    selectEstudiantes();

    function selectTutores() {
        $.ajax({
            url: 'php/l_tutores.php',
            type: 'GET',
            success: function (response) {
                let data = JSON.parse(response);
                let template = '';
                template += `<option selected disabled>Seleccione...</option>`;
                data.forEach(dat => {
                    let nTutor = dat.n_tutor + " " + dat.a_tutor;
                    template += `<option value="${dat.id_tutor}">${nTutor}</option>`;

                });
                $('#t_horario').html(template);
            }
        });
    }

    function selectEstudiantes() {
        $.ajax({
            url: 'php/l_estudiantes.php',
            type: 'GET',
            success: function (response) {
                let data = JSON.parse(response);
                let template = '';
                template += `<option selected disabled>Seleccione...</option>`;
                data.forEach(dat => {
                    let nTutor = dat.nombre + " " + dat.apellidos;
                    template += `<option value="${dat.id}">${nTutor}</option>`;

                });
                $('#est_horario').html(template);
            }
        });
    }

    function selectHorarios() {
        $.ajax({
            url: 'php/l_horario.php',
            type: 'GET',
            success: function (response) {
                let data = JSON.parse(response);
                let template = '';
                data.forEach(dat => {
                    let nTutor = dat.t_nombre + " " + dat.t_apellidos;
                    let nEst = dat.e_nombre + " " + dat.e_apellidos;
                    let fecha = dat.fecha + " " + dat.hora;
                    let asist = dat.asistencia == 1 ? '<i class="fas fa-check-square"></i>' : '<i class="fas fa-exclamation-circle"></i>';
                    template += `
                    <tr codigo="${dat.codigo}">
                        <td><small>${dat.codigo}</small></td>
                        <td><small>${fecha}</small></td>
                        <td><small>${nTutor}</small></td>
                        <td><small>${nEst}</small></td>
                        <td><small>${asist}</small></td>
                        <td>
                            <button class="text-white horario-editar btn btn-warning btn-sm">
                                <i class="fas fa-pen"></i> Editar
                            </button>
                            <button class="text-white horario-eliminar btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                `;
                });
                $('#table-horario').html(template);
            }
        });
    }

    $('#f_horarios').on('input', function (e) {
        let fe_horario = $(this).val();
        let fecha = new Date(fe_horario)
        let hoy = new Date();
        let resta = hoy.getTime() - fecha.getTime()
        let dias = (Math.round(resta / (1000 * 60 * 60 * 24)) - 1);
        console.log(dias);
        if (dias < 0) {
            validoFecha = true;
            $('#f_horarios').removeClass("is-invalid");
            $('#f_horarios').addClass("is-valid");
        } else {
            validoFecha = false;
            $('#f_horarios').removeClass("is-valid");
            $('#f_horarios').addClass("is-invalid");
        }
    });

    $('#horario-form').submit(function (e) {
        let select = document.getElementById("t_horario");
        let valTut = select.options[select.selectedIndex].value;
        let selectEst = document.getElementById("est_horario");
        let valEst = selectEst.options[selectEst.selectedIndex].value;
        let asistencia = $('#as_horario').is(':checked') ? 1 : 0;
        const dataPost = {
            f_horarios: $('#f_horarios').val(),
            h_horario: $('#h_horario').val(),
            t_horario: valTut,
            s_horario: $('#s_horario').val(),
            est_horario: valEst,
            as_horario: asistencia,
            c_horario: codigo_horario
        };
        let url = actualiza == false ? 'php/i_horario.php' : 'php/u_horario.php';
        console.log(selectEst.selectedIndex);
        if (validoFecha && select.selectedIndex > 0 && selectEst.selectedIndex > 0) {
            $.post(url, dataPost, function (response) {
                console.log(response);
                $('#horario-form').trigger('reset');
                selectTutores();
                selectHorarios();
                selectEstudiantes();
                $('#btn_horarios').html("Asignar horario");
                $('#btn_horarios').removeClass("btn-warning");
                $('#btn_horarios').addClass("btn-primary");
                $('#btn_horarios').addClass("text-white");
                actualiza = false;
            });
        }
        e.preventDefault();
    });

    $(document).on('click', '.horario-editar', function () {
        let element = $(this)[0].parentElement.parentElement;
        let id_horario = $(element).attr('codigo');
        $.post('php/s_horario_tutor.php', {id_horario}, function (response) {
            codigo_horario = id_horario;
            let data = JSON.parse(response);
            let asis = data.asistencia == 1 ? true : false;
            actualiza = true;
            validoFecha = true;
            $('#f_horarios').val(data.fecha);
            $('#h_horario').val(data.hora);
            $('#s_horario').val(data.semana);
            $('#as_horario').prop('checked', asis);

            $('#btn_horarios').html("Actualizar");
            $('#btn_horarios').removeClass("btn-primary");
            $('#btn_horarios').addClass("btn-warning");
            $('#btn_horarios').addClass("text-white");
        });
    });

    $(document).on('click', '.horario-eliminar', function () {
        if (confirm('Estas seguro de eliminar el horario?')) {
            let element = $(this)[0].parentElement.parentElement;
            let cod_horario = $(element).attr('codigo');
            $.post('php/e_horario.php', {cod_horario}, function (response) {
                console.log(response);
                selectTutores();
                selectHorarios();
                selectEstudiantes();
            });
        }
    });
});