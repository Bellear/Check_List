@extends('layouts.layout')

@section('content')
    <form action="{{ route('task.update', ['id' => $task->task_id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <h3>Редактировать задание задание</h3>
        <div class="form-group">
            <input type="text" class="form-control" name="title" placeholder="Заголовок" required value="{{$task->title}}">
        </div>
        <div class="form-group">
            <textarea name="descr" rows="10" class="form-control" placeholder="Описание" required>{{$task->descr}}</textarea>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="date" placeholder="Срок выполнения" value="{{$task->deadline}}">
        </div>
        <input type="submit" value="Редактировать задание" class="btn btn-outline-success">
    </form>
@endsection
