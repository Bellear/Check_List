@extends('layouts.layout')

@section('content')


    <div class="col-12">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    {{ $task->title }}
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $task->descr }}</h5>
                    <p class="card-author">Исполнитель: {{ $task->name }}</p>
                    <p class="card-text">Срок выполнения до: {{ $task->deadline }}</p>
                    <p class="card-text">Задание создано: {{ $task->created_at }}</p>
                    @if ($task->done == 0)
                        <div class="text-right">
                            <button type="button" class="btn btn-warning">Не выполнено</button>
                            <form action="{{ route('task.done', ['id' => $task->task_id]) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <input type="submit" value="Отметить как выполненное" class="btn btn-outline-success">
                            </form>
                        </div>
                    @else
                        <div class="text-right">
                            <button type="button" class="btn btn-success">Выполнено</button>
                        </div>
                    @endif
                    <div class="card-btn">
                        <a href="{{ route('task.index') }}" class="btn btn-primary">На главную</a>
                        <a href="{{ route('task.edit', ['id' => $task->task_id]) }}" class="btn btn-success">Редактировать</a>
                        <form action="{{ route('task.destroy', ['id' => $task->task_id]) }}" method="post" onsubmit="if (confirm('Удалить задание?')) {return true} else {return false}">
                            @csrf
                            @method('DELETE')
                            <input type="submit" class="btn btn-danger" value="Удалить">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

