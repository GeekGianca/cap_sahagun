$(document).ready(function () {
    selectTutores();

    let editaTutor = false;

    function selectTutores() {
        $.ajax({
            url: 'php/l_tutores.php',
            type: 'GET',
            success: function (response) {
                console.log(response);
                let data = JSON.parse(response);
                let template = '';
                data.forEach(dat => {
                    template += `
                    <tr idtutor="${dat.id_tutor}">
                        <td>${dat.id_tutor}</td>
                        <td>${dat.n_tutor}</td>
                        <td>${dat.a_tutor}</td>
                        <td>${dat.c_tutor}</td>
                        <td>${dat.t_tutor}</td>
                        <td>
                            <button class="tutor-edit btn btn-warning btn-sm text-white">
                                Editar <i class="fas fa-user-edit"></i>
                            </button>
                            <!--<button class="tutor-delete btn btn-danger btn-sm text-white">
                                Eliminar <i class="fas fa-user-times"></i>
                            </button>-->
                        </td>
                    </tr>`;
                });
                $('#table_tutores').html(template);
            },
            error: function (err) {

            }
        });
    }

    $('#form-tutor').submit(function (e) {
        const dataPost = {
            id_tutor: $('#id_tutor').val(),
            n_tutor: $('#n_tutor').val(),
            a_tutor: $('#a_tutor').val(),
            c_tutor: $('#c_tutor').val(),
            t_tutor: $('#t_tutor').val(),
            d_tutor: $('#d_tutor').val()
        };
        let url = (editaTutor == false) ? 'php/i_tutores.php' : 'php/u_tutores.php';
        $.post(url, dataPost, function (response) {
            console.log(response);
            selectTutores();
            $('#form-tutor').trigger('reset');
            editaTutor = false;
            $('#btn_form_tutor').removeClass("btn-warning");
            $('#btn_form_tutor').addClass("btn-primary");
            $('#btn_form_tutor').html("Registrar");
            $('#id_tutor').attr('readonly', false);
            $('#n_tutor').attr('readonly', false);
            $('#a_tutor').attr('readonly', false);
        });
        e.preventDefault();
    });

    $(document).on('click', '.tutor-edit', function () {
        let element = $(this)[0].parentElement.parentElement;
        let id_tutor = $(element).attr('idtutor');
        $.post('php/s_tutor.php', {id_tutor}, function (response) {
            const data = JSON.parse(response);
            $('#id_tutor').val(data.id_tutor);
            $('#n_tutor').val(data.n_tutor);
            $('#a_tutor').val(data.a_tutor);
            $('#c_tutor').val(data.c_tutor);
            $('#t_tutor').val(data.t_tutor);
            $('#d_tutor').val(data.d_tutor);

            $('#id_tutor').attr('readonly', true);
            $('#n_tutor').attr('readonly', true);
            $('#a_tutor').attr('readonly', true);

            $('#btn_form_tutor').html("Actualizar");
            $('#btn_form_tutor').removeClass("btn-primary");
            $('#btn_form_tutor').addClass("btn-warning");
            $('#btn_form_tutor').addClass("text-white");
            editaTutor = true;
        });
    });

});