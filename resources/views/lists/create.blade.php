@extends('layouts.app')

@section('styles')

@endsection

@section('title', 'Создание списка')

@section('content')
    <div class="row content d-flex justify-content-center align-items-center">
        <div class="col-md-6">
            <h3 class="mb-4 text-center fs-1">Создание списка</h3>
            <div id="status"></div>
            <form method="post" class="mb-3" action="{{route('lists.store')}}" enctype="multipart/form-data" id="form">
                @csrf
                <div class="mb-3">
                    <label for="title">Наименование списка</label>
                    <input type="text" class="form-control rounded-0" id="title" name="title">
                </div>
                <div class="show_item">
                    <div class="row counter">
                        <div class="mb-3">
                            <label for="text">Пункт</label>
                            <input type="text" class="form-control rounded-0" id="text" name="item[0][text]">
                        </div>
                        <div class="mb-3">
                            <label for="tags">Теги</label>
                            <input class="tag_update" type="text" data-role="tagsinput" id="tags" name="item[0][tags]">
                        </div>
                        <div class="mb-4">
                            <label for="picture">Картинка</label>
                            <input type="file" class="form-control rounded-0" id="picture" name="item[0][picture]"
                                   accept="image/png, image/jpeg">
                        </div>
                    </div>
                </div>
                <div class="text-left">
                    <button class="btn btn-success border-0 rounded-0 add_item_btn">
                        Добавить пункт
                    </button>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-dark btn-lg border-0 rounded-0 save">Создать</button>
                </div>

            </form>
        </div>
    </div>
    <script src="{{mix('js/create_list.js')}}"></script>
@endsection
