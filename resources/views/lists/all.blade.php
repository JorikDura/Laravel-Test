@extends('layouts.app')

@section('styles')
@endsection

@section('title', 'Списки')

@section('content')
    <div class="row content d-flex justify-content-center align-items-center">
        <div class="col-md-8">
            <div class="text-end mb-4">
                <form action="{{route('lists.create')}}">
                    <button class="btn btn-primary" type="submit">
                        Создать новый список
                    </button>
                </form>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Название</th>
                    <th class="text-center">Действия</th>
                </tr>
                </thead>
                <tbody>
                @isset($lists)
                    @foreach($lists as $list)
                        <tr>
                            <td>
                                {{$list->title}}
                            </td>
                            <td class="text-center">
                                <a href="{{route('lists.show', $list->id)}}" class="btn btn-outline-dark"
                                   role="button">
                                    Открыть
                                </a>
                                <a href="{{route('lists.edit', $list->id)}}" class="btn btn-outline-success"
                                   role="button">
                                    Редактировать
                                </a>
                                <form method="POST" action="{{route('lists.destroy', $list->id)}}" class="m-1">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger">
                                        Удалить
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endisset
                </tbody>
            </table>
        </div>
    </div>
@endsection
