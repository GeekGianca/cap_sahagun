$(document).ready(function () {
    setDate();
    selectEstudiantes();
    let validoFechaNacimiento = false;
    let validoProxFechaPago = false;
    let editaInscripcion = false;

    function setDate() {
        let date = new Date();
        let month = date.getMonth() + 1;
        let monthFormat = "";
        let dayFormat = "";
        if (month <= 9) {
            monthFormat = "0" + month;
        } else {
            monthFormat = month + "";
        }
        if (date.getDay() <= 9) {
            dayFormat = "0" + date.getDay();
        } else {
            dayFormat = date.getDay();
        }
        $('#f_horario').val(date.getFullYear() + "-" + monthFormat + "-" + dayFormat);
        $('#prox_fecha_pago').prop("min", date.getFullYear() + "-" + monthFormat + "-" + dayFormat);
    }

    function selectEstudiantes(){
        $.ajax({
            url: 'php/l_estudiantes_inscripcion.php',
            type: 'GET',
            success: function (response) {
                let data = JSON.parse(response);
                let template = '';
                data.forEach(dat => {
                    template += `
                    <tr idinscripcion="${dat.id}" class="text-center">
                        <td>${dat.id}</td>
                        <td>${dat.nombre}</td>
                        <td>${dat.apellidos}</td>
                        <td>${dat.fecha_ingreso}</td>
                        <td>${dat.fecha_pago}</td>
                        <td>${dat.a_telefono}</td>
                        <td>${dat.colegio}</td>
                        <td>
                            <button class="stud-edit btn btn-warning btn-sm text-white">
                                Editar <i class="fas fa-user-edit"></i>
                            </button>
                        </td>
                    </tr>
                `;
                });
                $('#table-student').html(template);
            }
        });
    }

    //Detecta los cambios de entrada del input en html
    $('#f_nacimiento').on('input', function (e) {
        let fecha_nac = $('#f_nacimiento').val();
        let edad = calcularEdad(fecha_nac);
        console.log(edad);
        if(edad >= 5){
            validoFechaNacimiento = true;
            $('#f_nacimiento').removeClass("is-invalid");
            $('#f_nacimiento').addClass("is-valid");
        }else{
            validoFechaNacimiento = false;
            $('#f_nacimiento').removeClass("is-valid");
            $('#f_nacimiento').addClass("is-invalid");
        }
    });

    $('#prox_fecha_pago').on('input', function (e) {
        let fecha_pago = $(this).val();
        let fecha = new Date(fecha_pago)
        let hoy = new Date();
        let resta = hoy.getTime() - fecha.getTime()
        let dias = (Math.round(resta/ (1000*60*60*24))-1);
        console.log(dias);
        if(dias <= 0){
            validoProxFechaPago = true;
            $('#prox_fecha_pago').removeClass("is-invalid");
            $('#prox_fecha_pago').addClass("is-valid");
        }else{
            validoProxFechaPago = false;
            $('#prox_fecha_pago').removeClass("is-valid");
            $('#prox_fecha_pago').addClass("is-invalid");
        }
    });

    function calcularEdad(fecha) {
        let hoy = new Date();
        let cumpleanos = new Date(fecha);
        let edad = hoy.getFullYear() - cumpleanos.getFullYear();
        let m = hoy.getMonth() - cumpleanos.getMonth();
        if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
            edad--;
        }
        return edad;
    }

    $('#form-student').submit(function (e) {
        let cod_reg = 1 + Math.floor(Math.random() * 90000);
        let select = document.getElementById("a_de_pago");
        let a_de_pago = select.options[select.selectedIndex].value;
        const dataPost = {
            id_estudiante:$('#id_estudiante').val(),
            n_estudiante:$('#n_estudiante').val(),
            a_estudiante:$('#a_estudiante').val(),
            f_nacimiento:$('#f_nacimiento').val(),
            c_registro:cod_reg,
            f_horario:$('#f_horario').val(),
            a_de_pago:a_de_pago,
            h_disponible:$('#h_disponible').val(),
            g_estudiante:$('#g_estudiante').val(),
            c_mensual:$('#c_mensual').val(),
            prox_fecha_pago:$('#prox_fecha_pago').val(),
            n_acudiente:$('#n_acudiente').val(),
            tel_acudiente:$('#tel_acudiente').val(),
            colegio:$('#colegio').val()
        };
        let url = (editaInscripcion == false) ? 'php/i_estudiante_inscripcion.php' : '';
        $.post(url, dataPost, function (response) {
            selectEstudiantes();
            $('#form-student').trigger('reset');
            editaInscripcion = false;
        });
        e.preventDefault();
    });

});