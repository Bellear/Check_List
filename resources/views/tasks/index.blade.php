@extends('layouts.layout')

@section('content')

    @if(isset($_GET['search']))
        @if(count($tasks)>0)
            <h2>Результаты запросу <?php $_GET['search']?></h2>
            <p class="lead">Всего найдено {{ count($tasks) }} совпадений</p>
        @else
            <h2>По запросу <?php $_GET['search']?> нет совпадений</h2>
            <a href="{{ route('task.index') }}" class="btn btn-outline-primary">Все задания</a>
        @endif
    @endif


    @foreach($tasks as $task)
        @if(Auth::user()->id == $task->executor_id || Auth::user()->is_admin == 1)
        <div class="card">
            <div class="card-header">
                {{ $task->title }}
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $task->descr }}</h5>
                @if ($task->done == 0)
                <div class="text-right">
                    <button type="button" class="btn btn-warning">Не выполнено</button>
                </div>
                    @else
                    <div class="text-right">
                        <button type="button" class="btn btn-success">Выполнено</button>
                    </div>
                @endif


                @if(Auth::user()->is_admin == 1)
                <p class="card-text">Исполнитель: {{ $task->name }}</p>
                @endif
                <a href="{{ route('task.show', ['id' => $task->task_id]) }}" class="btn btn-primary">Подробнее</a>

            </div>
        </div>
        @endif
    @endforeach
    @if(!isset($_GET['search']))
        {{ $tasks->links() }}
    @endif
@endsection

