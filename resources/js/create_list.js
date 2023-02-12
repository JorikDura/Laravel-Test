//бустрап теги
import './bootstrap-inputs';

$(document).ready(function () {

    let count = $('.btn_bd').eq(-1).attr('id');

    if (count == null) {
        count = 0;
    }

    //добавляет новый пункт
    $('.add_item_btn').click(function (event) {
        event.preventDefault();
        count++;
        $('.show_item').append(`<div class="row counter">
                        <div class="mb-3">
                            <label for="text">Пункт</label>
                            <input type="text" class="form-control rounded-0" id="text" name="item[` + count + `][text]">
                        </div>
                        <div class="mb-3">
                            <label for="tags">Теги</label>
                            <input class="tag_update" type="text" data-role="tagsinput" id="tags" name="item[` + count + `][tags]">
                        </div>
                        <div class="mb-4">
                            <label for="picture">Картинка</label>
                            <input type="file" class="form-control rounded-0" id="picture" name="item[` + count + `][picture]"
                                   accept="image/png, image/jpeg">
                        </div>
                        <div>
                        <button class="btn btn-danger border-0 rounded-0 remove_item_btn mb-3">
                            Удалить
                        </button>
                        </div>
                    </div>`);
        $('.tag_update').tagsinput('refresh');
    });

    //удаляет пункт
    $(document).on('click', '.remove_item_btn', function (event) {
        event.preventDefault();
        //обращение к предку - row
        let item = $(this).parent().parent();
        $(item).remove();
    });

    //удаляет существующий пункт из бд
    $('.btn_bd').on('click', function (event) {
        event.preventDefault();

        let articleId = {
            'id': $(this).eq(0).attr('id')
        };

        UseAjax('/lists/delete/article', 'post', articleId);
    })

    $('.btn_bd-img').on('click', function (event) {
        event.preventDefault();

        let articleId = {
            'id': $(this).eq(0).attr('id')
        };

        UseAjax('/lists/delete/article/image', 'post', articleId, function () {
            $('#image' + articleId['id']).remove();
        });
    });

    //отправляет форму
    $('#form').on('submit', function (event) {
        event.preventDefault();

        let status = $('#status');
        $(status).empty();
        let form = this;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: new FormData(form),
            processData: false,
            dataType: 'json',
            contentType: false,
            beforeSend: function () {
                $('html, body').animate({
                    scrollTop: $(status).offset().top - 80
                }, 'slow');
                $(".save").addClass('disabled');
            },
            success: function (data) {
                if (data.status == 400) {
                    $.each(data.errors, function (key, error) {
                        $(status).append('<p class="alert alert-danger">' + error + '</p>')
                    });
                }
                if (data.status == 1) {
                    $(status).append('<p class="alert alert-success">Сохранено!</p>')
                }
                $(".save").removeClass('disabled');
                setTimeout(function () {
                    window.location.href = '/lists';
                }, 2000);
            },
            error: function (data) {
                console.log(data);
            }
        })
    })
});

function UseAjax(url, method, data, successFunc = null) {
    let status = $('#status');
    $(status).empty();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: url, method: method, data: data, dataType: 'json', success: function (data) {
            if (data.status == 1) {
                $(status).append('<p class="alert alert-success">Успешно удалено!</p>')
            }
            if (successFunc != null) {
                successFunc();
            }
        }, error: function (data) {
            console.log(data);
        }
    });
}
