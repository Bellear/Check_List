<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Task;
use App\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->search && \Auth::user()->is_admin == 1) {
            $tasks = Task::join('users', 'executor_id', '=', 'users.id')
                ->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('descr', 'like', '%' . $request->search . '%')
                ->orWhere('name', 'like', '%' . $request->search . '%')
                ->orderBy('tasks.created_at', 'desc')
                ->get();

            return view('tasks.index', compact('tasks'));
        }

        if (\Auth::user()->is_admin == 1){
            $tasks = Task::join('users', 'executor_id', '=', 'users.id')
                ->orderBy('tasks.created_at', 'desc')
                ->paginate(3);
            return view('tasks.index', compact('tasks'));
        }


        $tasks = Task::join('users', 'executor_id', '=', 'users.id')
            ->where('executor_id', 'like', '%' . \Auth::user()->id . '%')
            ->orderBy('tasks.created_at', 'desc')
            ->paginate(3);
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        $task = new Task();
        $task->title = $request->title;
        $task->descr = $request->descr;
        $task->deadline = $request->date;

        if(\Auth::user()->is_admin == 1){
            $user = \DB::table('users')
                ->where('name', 'like', '%' . $request->executor . '%')
                ->get();
            if (!isset($user[0])){
                return redirect()->route('task.create')->with('success', 'Исполнитель не найден');
            } else {
                $task->executor_id = $user[0]->id;
            }
        } else {
            $task2 = Task::join('users', 'executor_id', '=', 'users.id')
                ->where('executor_id', 'like', '%' . \Auth::user()->id . '%')
                ->get();
            if ($task2->count()>=\Auth::user()->maxtasks){
                return redirect()->route('task.create')->with('success', 'Превышение максимального допустимого количества заданий');
            } else {
                $task->executor_id = \Auth::user()->id;
            }

        }

        $task->save();

        return redirect()->route('task.index')->with('success', 'Задание успешно добавлено');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::join('users', 'executor_id', '=', 'users.id')
            ->find($id);

        if ($task->executor_id != \Auth::user()->id && \Auth::user()->is_admin != 1){
            return redirect()->route('task.index')->withErrors('Вы не можете просматривать данное задание');
        }

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);

        if ($task->executor_id != \Auth::user()->id && \Auth::user()->is_admin != 1){
            return redirect()->route('task.index')->withErrors('Вы не можете редактировать данное задание');
        }

        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, $id)
    {
        $task = Task::find($id);

        if ($task->executor_id != \Auth::user()->id && \Auth::user()->is_admin != 1){
            return redirect()->route('task.index')->withErrors('Вы не можете редактировать данное задание');
        }

        $task->title = $request->title;
        $task->descr = $request->descr;
        $task->deadline = $request->date;
        $task->update();

        $id = $task->task_id;
        return redirect()->route('task.show', compact('id'))->with('success', 'Задание успешно обновлено');
    }

    public function done(Request $request, $id)
    {
        $task = Task::find($id);

        if ($task->executor_id != \Auth::user()->id && \Auth::user()->is_admin != 1){
            return redirect()->route('task.index')->withErrors('Вы не можете редактировать данное задание');
        }
        $task->done = 1;
        $task->update();
        $id = $task->task_id;
        return redirect()->route('task.show', compact('id'))->with('success', 'Задание успешно обновлено');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);

        if ($task->executor_id != \Auth::user()->id && \Auth::user()->is_admin != 1){
            return redirect()->route('task.index')->withErrors('Вы не можете удалить данное задание');
        }

        $task -> delete();
        return redirect()->route('task.index')->with('success', 'Задание успешно удалено');
    }
}
