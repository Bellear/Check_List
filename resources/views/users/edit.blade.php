@extends('layouts.layout')

@section('content')
    <form action="{{ route('user.update', ['id' => $user->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <h3>Редактировать профиль</h3>
        <div class="form-group">
            <h6>Имя:</h6>
            <input type="text" class="form-control" name="name" placeholder="Имя" required value="{{$user->name}}">
        </div>
        <div class="form-group">
            <h6>Максимум заданий:</h6>
            <input type="maxtasks" class="form-control" name="maxtasks" required value="{{$user->maxtasks}}">
        </div>
        <div class="form-group">
            <h6>Заблокирован:</h6>
            @if($user->blocked)
                <p><input name="radiobutton" type="radio" value="yes" checked>
                    Да
                    <input name="radiobutton" type="radio" value="no">
                    Нет</p>
            @else
                <p><input name="radiobutton" type="radio" value="yes">
                    Да
                    <input name="radiobutton" type="radio" value="no" checked>
                    Нет</p>
            @endif

        </div>
        <input type="submit" value="Редактировать профиль" class="btn btn-outline-success">
    </form>
@endsection
