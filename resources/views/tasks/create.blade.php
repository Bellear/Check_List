@extends('layouts.layout')

@section('content')
    <form action="{{ route('task.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <h3>Добавить новое задание</h3>
        <div class="form-group">
            <input type="text" class="form-control" name="title" placeholder="Заголовок" required value="{{old('title')}}">
        </div>
        <div class="form-group">
            <textarea name="descr" rows="10" class="form-control" placeholder="Описание" required>{{old('descr')}}</textarea>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="date" placeholder="Срок выполнения" value="{{old('title')}}">
        </div>
        @if(Auth::user()->is_admin == 1)
            <div class="form-group">
                <input type="text" class="form-control" name="executor" placeholder="Исполнитель" value="{{old('title')}}">
            </div>
        @endif
        <input type="submit" value="Добавить задание" class="btn btn-outline-success">
    </form>
@endsection
