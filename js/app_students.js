$(document).ready(function () {
    setDate();

    let validoFechaNacimiento = false;
    let validoProxFechaPago = false;

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
});