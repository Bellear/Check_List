<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $users = User::paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $task = Task::join('users', 'executor_id', '=', 'users.id')
            ->where('executor_id', 'like', '%' . $id . '%')
            ->get();
//dd($task->count());
        if ($user->id != \Auth::user()->id && \Auth::user()->is_admin != 1){
            return redirect()->route('users.index')->withErrors('Вы не можете просматривать данный профиль');
        }

        return view('users.show', compact(['user', 'task']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $user->name = $request->name;
        $user->maxtasks = $request->maxtasks;
        if ($_POST['radiobutton']==="yes"){
            $user->blocked = 1;
        }
        if ($_POST['radiobutton']==="no"){
            $user->blocked = 0;
        }
        $user->update();

        $id = $user->id;
        return redirect()->route('user.show', compact('id'))->with('success', 'Профиль успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
