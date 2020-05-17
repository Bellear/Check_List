@extends('layouts.layout')

@section('content')

    @foreach($users as $user)
        <div class="media text-muted pt-3">
            <svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>Placeholder</title><rect width="100%" height="100%" fill="#007bff"></rect><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text></svg>
            <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <strong class="text-gray-dark">{{ $user->name }}</strong>
                    <a href="{{ route('user.show', ['id' => $user->id]) }}" class="btn btn-primary">Профиль</a>
                </div>
                <span class="d-block">{{ $user->email }}</span>
                @if($user->blocked ==1)
                    <span class="d-block">ЗАБЛОКИРОВАН</span>
                @endif
            </div>
        </div>
{{--        <div class="card">--}}
{{--            <div class="card-header">--}}
{{--                {{ $user->name }}--}}
{{--            </div>--}}
{{--            <div class="card-body">--}}
{{--                <h5 class="card-title">{{ $user->email }}</h5>--}}


{{--                <a href="{{ route('task.show', ['id' => $user->id]) }}" class="btn btn-primary">Подробнее</a>--}}

{{--            </div>--}}
{{--        </div>--}}

    @endforeach
    @if(!isset($_GET['search']))
        {{ $users->links() }}
    @endif
@endsection

