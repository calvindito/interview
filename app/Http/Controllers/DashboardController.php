<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller {

    public function __construct()
    {
        if(!session('id')) {
            return redirect('/');
        }
    }

    public function index(Request $request)
    {
        if($request->has('_token')) {
            if($request->_token == csrf_token()) {
                $validation = Validator::make($request->all(), [
                    'todo' => 'required'
                ], [
                    'todo.required' => 'Tidak boleh kosong'
                ]);

                if($validation->fails()) {
                    return redirect()->back()->withErrors($validation)->withInput();
                } else {
                    $query = Task::create([
                        'user_id'  => session('id'),
                        'todo'     => $request->todo,
                        'complete' => false
                    ]);

                    if($query) {
                        return redirect()->back();
                    } else {
                        return redirect()->back()->withInput()->with(['error' => 'Data gagal diproses']);
                    }
                }
            }
        }

        $data = [
            'title'        => 'Dashboard',
            'todo_process' => Task::where('user_id', session('id'))->where('complete', false)->get(),
            'todo_done'    => Task::where('user_id', session('id'))->where('complete', true)->get(),
            'content'      => 'dashboard'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function checkable(Request $request)
    {
        if($request->has('_token')) {
            if($request->_token == csrf_token()) {
                $id   = $request->id;
                $task = Task::find($id);
                $task->update(['complete' => $task->complete == true ? false : true]);
            }
        }

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        if($request->has('_token')) {
            if($request->_token == csrf_token()) {
                Task::destroy($request->id);
                return redirect()->back();
            }
        }

        return redirect()->back();
    }

}
