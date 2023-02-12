@extends('layouts.app')

@section('styles')
@endsection

@section('title', 'Редактирование')

@section('content')
    <div class="row content d-flex justify-content-center align-items-center">
        <div class="col-md-6">
            <h3 class="mb-4 text-center fs-1">Редактирование</h3>
            <div id="status"></div>
            @isset($list)
                <form method="POST" class="mb-3" action="{{route('lists.update', $list->id)}}"
                      enctype="multipart/form-data" id="form">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="title">Наименование</label>
                        <input type="text" class="form-control rounded-0" id="title" name="title"
                               value="{{$list->title}}">
                    </div>
                    @isset($articles)
                        <div class="show_item">
                            @foreach($articles as $article)
                                <div class="row counter">
                                    <div class="mb-3">
                                        <label for="text">Пункт</label>
                                        <input type="text" value="{{$article->text}}" class="form-control rounded-0"
                                               id="text" name="item[{{$article->id}}][text]">
                                    </div>
                                    <div class="mb-3">
                                        <label for="tags">Теги</label>
                                        <input class="tag_update" value="{{$article->tags}}" type="text"
                                               data-role="tagsinput" id="tags" name="item[{{$article->id}}][tags]">
                                    </div>
                                    <div class="mb-4">
                                        @empty(!$article->image)
                                            <div id="image{{$article->id}}">
                                                <img src="{{asset('storage/files/' . $article->image)}}" width="150"
                                                     height="150"
                                                     onClick="window.open(this.src)"
                                                     role="button"
                                                     alt="Здесь должна быть картинка, но ее нет. Интересно почему..."
                                                     class="mb-3">
                                                <br>
                                            </div>
                                        @endempty
                                        <label for="picture">Картинка</label>
                                        <input type="file" class="form-control rounded-0" id="picture"
                                               name="item[{{$article->id}}][picture]"
                                               accept="image/png, image/jpeg">
                                    </div>
                                    <div>
                                        <button class="btn btn-danger border-0 rounded-0 remove_item_btn btn_bd mb-3"
                                                id="{{$article->id}}">
                                            Удалить
                                        </button>
                                        @empty(!$article->image)
                                            <button class="btn btn-secondary border-0 rounded-0 btn_bd-img mb-3"
                                                    id="{{$article->id}}">
                                                Удалить картинку
                                            </button>
                                        @endempty
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-left">
                            <button class="btn btn-success border-0 rounded-0 add_item_btn">
                                Добавить пункт
                            </button>
                        </div>
                    @endisset
                    <div class="text-end">
                        <button type="submit" class="btn btn-dark btn-lg border-0 rounded-0 save">Сохранить</button>
                    </div>
                </form>
            @endisset
        </div>
    </div>
    <script src="{{mix('js/create_list.js')}}"></script>
@endsection
