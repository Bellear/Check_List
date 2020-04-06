<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Task;
use Validator;
class ProductController extends BaseController
{

    public function index()
    {

        if (\Auth::user()->is_admin == 1){
            $tasks = Task::join('users', 'executor_id', '=', 'users.id')
                ->orderBy('tasks.created_at', 'desc')
                ->paginate(5);
            return $this->sendResponse($tasks->toArray(), 'Task retrieved successfully.');
        }

        $tasks = Task::join('users', 'executor_id', '=', 'users.id')
            ->where('executor_id', 'like', '%' . \Auth::user()->id . '%')
            ->orderBy('tasks.created_at', 'desc')
            ->paginate(3);
        return $this->sendResponse($tasks->toArray(), 'Task retrieved successfully.');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'descr' => 'required',
            'deadline' => 'required',
            'executor' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $task = new Task();
        $task->title = $request->title;
        $task->descr = $request->descr;
        $task->deadline = $request->deadline;
        if(\Auth::user()->is_admin == 1){
            $user = \DB::table('users')
                ->where('name', 'like', '%' . $request->executor . '%')
                ->get();
            if (!isset($user[0])){
                return $this->sendError('User not found');
            } else {
                $task->executor_id = $user[0]->id;
            }
        } else {
            $task2 = Task::join('users', 'executor_id', '=', 'users.id')
                ->where('executor_id', 'like', '%' . \Auth::user()->id . '%')
                ->get();
            if ($task2->count()>=\Auth::user()->maxtasks){
                return $this->sendError('Already max tasks');
            } else {
                $task->executor_id = \Auth::user()->id;
            }

        }

        $task->save();

        return $this->sendResponse($task->toArray(), 'Task created successfully.');

    }

    public function show($id)
    {

        $task = Task::join('users', 'executor_id', '=', 'users.id')
            ->find($id);

        if (is_null($task)) {
           return $this->sendError('Task not found.');
        }
        if ($task->executor_id != \Auth::user()->id && \Auth::user()->is_admin != 1){
            return $this->sendError('U cant');
        }

        return $this->sendResponse($task->toArray(), 'Task retrieved successfully.');


    }

    public function update(Request $request, Task $task)
    {

        $input = $request->all();

        if ($task->executor_id != \Auth::user()->id && \Auth::user()->is_admin != 1){
            return $this->sendError('U cant');
        }
        if (isset($input['title'])){
            $task->title = $input['title'];
        }
        if (isset($input['descr'])){
            $task->descr = $input['descr'];
        }
        if (isset($input['deadline'])){
            $task->deadline = $input['deadline'];
        }
        if (isset($input['done'])){
            $task->deadline = $input['done'];
        }
        $task->save();
        return $this->sendResponse($task->toArray(), 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        if ($task->executor_id != \Auth::user()->id && \Auth::user()->is_admin != 1){
            return $this->sendError('U cant');
        }

        $task -> delete();
        return $this->sendResponse($task->toArray(), 'Task deleted successfully.');

//        $task->delete();
//        return $this->sendResponse($task->toArray(), 'Task deleted successfully.');
    }
}
