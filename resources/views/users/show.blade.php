@extends('layouts.layout')

@section('content')


    <div class="col-12">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    {{ $user->name }}
                </div>
                <div class="card-body">
                    <p class="card-author">E-mail: {{ $user->email }}</p>
                    <p class="card-author">Максимум заданий: {{ $user->maxtasks }}</p>
                    <p class="card-text">Активных заданий: {{ $task->count() }}</p>
                    @if($user->blocked ==1)
                        <span class="d-block">ЗАБЛОКИРОВАН</span>
                    @endif

                    <a href="{{ route('user.edit', ['id' => $user->id]) }}" class="btn btn-success">Редактировать</a>
                </div>
            </div>
        </div>
    </div>


@endsection

