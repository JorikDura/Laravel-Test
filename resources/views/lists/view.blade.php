@extends('layouts.app')

@section('styles')
    <link href="{{mix('css/list_styles.css')}}" rel="stylesheet" type="text/css">
@endsection

@section('title', 'Список')

@section('content')
    @isset($list)

        <div class="container">
            <h3 class="mb-5 text-center fs-1">{{$list->title}}</h3>

            <div class="mb-4">
                <form class="row row-cols-lg-1">
                    <div class="col mb-2">
                        <div class="bootstrap-tagsinput">
                            <input type="text" name="q" value="{{$q}}" placeholder="Поиск...">
                        </div>
                    </div>
                    <div class="col mb-2">
                        <input type="text" data-role="tagsinput" class="form-control" name="t" value="{{$t}}" placeholder="Теги...">
                    </div>
                    <div>
                        <button class="btn btn-success">Обновить</button>
                    </div>
                </form>
            </div>

            <div class="row">
                @foreach($articles as $article)
                    <div class="col-md-6 mb-4">
                        <div class="media">
                            @empty(!$article->image)
                                <div class="media-left">
                                    <a href="#">
                                        <img class="media-object"
                                             src="{{asset('storage/files/' . $article->image)}}"
                                             height="150"
                                             width="150"
                                             onClick="window.open(this.src)"
                                             alt="">
                                    </a>
                                </div>
                            @endempty
                            <div class="media-body">
                                <h4 class="media-heading mb-2">{{$article->text}}</h4>
                                @empty(!$article->tags)
                                    @php($tags = explode(",", $article->tags))
                                    @foreach($tags as $tag)
                                        <div class="bootstrap-tagsinput">
                                            <span class="tag label label-info">{{$tag}}</span>
                                        </div>
                                    @endforeach
                                @endempty
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <script src="{{mix('js/bootstrap-inputs.js')}}"></script>
    @endisset
@endsection
