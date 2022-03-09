<?php

namespace App\Http\Controllers;

use App\Models\ToDo;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller {

    public function index()
    {
        if(!session('email')) {
            session()->flush();
            return redirect('/');
        }

        $data = [
            'title'   => 'Dashboard',
            'content' => 'dashboard'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $column = [
            'id',
            'title',
            'detail',
            'status'
        ];

        $start  = $request->start;
        $length = $request->length;
        $order  = $column[$request->input('order.0.column')];
        $dir    = $request->input('order.0.dir');
        $search = $request->input('search.value');

        $total_data = ToDo::count();

        $query_data = ToDo::where(function($query) use ($search, $request) {
                if($search) {
                    $query->where(function($query) use ($search) {
                        $query->where('title', 'like', "%$search%")
                            ->orWhere('detail', 'like', "%$search%");
                    });
                }
            })
            ->offset($start)
            ->limit($length)
            ->orderBy($order, $dir)
            ->get();

        $total_filtered = ToDo::where(function($query) use ($search, $request) {
                if($search) {
                    $query->where(function($query) use ($search) {
                        $query->where('title', 'like', "%$search%")
                            ->orWhere('detail', 'like', "%$search%");
                    });
                }
            })
            ->count();

        $response['data'] = [];
        if($query_data <> FALSE) {
            $nomor = $start + 1;
            foreach($query_data as $val) {
                $response['data'][] = [
                    $nomor,
                    $val->title,
                    $val->detail,
                    $val->status(),
                    '
                        <button type="button" class="btn btn-warning text-white btn-sm" onclick="show(' . $val->id . ')">Update</button>
                        <button type="button" class="btn btn-danger text-white btn-sm" onclick="destroy(' . $val->id . ')">Delete</button>
                    '
                ];

                $nomor++;
            }
        }

        $response['recordsTotal'] = 0;
        if($total_data <> FALSE) {
            $response['recordsTotal'] = $total_data;
        }

        $response['recordsFiltered'] = 0;
        if($total_filtered <> FALSE) {
            $response['recordsFiltered'] = $total_filtered;
        }

        return response()->json($response);
    }

    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'required'
        ], [
            'title.required' => 'Title cannot be empty.'
        ]);

        if($validation->fails()) {
            $response = [
                'status' => 422,
                'error'  => $validation->errors()
            ];
        } else {
            $query = ToDo::create([
                'title'  => $request->title,
                'detail' => $request->detail,
                'status' => $request->status
            ]);

            if($query) {
                $response = [
                    'status'  => 200,
                    'message' => 'Data added successfully.'
                ];
            } else {
                $response = [
                    'status'  => 500,
                    'message' => 'Data failed to add.'
                ];
            }
        }

        return response()->json($response);
    }

    public function show(Request $request)
    {
        $data = ToDo::find($request->id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'required'
        ], [
            'title.required' => 'Title cannot be empty.'
        ]);

        if($validation->fails()) {
            $response = [
                'status' => 422,
                'error'  => $validation->errors()
            ];
        } else {
            $query = ToDo::find($id)->update([
                'title'  => $request->title,
                'detail' => $request->detail,
                'status' => $request->status
            ]);

            if($query) {
                $response = [
                    'status'  => 200,
                    'message' => 'Data updated successfully.'
                ];
            } else {
                $response = [
                    'status'  => 500,
                    'message' => 'Data failed to update.'
                ];
            }
        }

        return response()->json($response);
    }

    public function changeStatus(Request $request)
    {
        $query = ToDo::find($request->id)->update(['status' => $request->status]);
        if($query) {
            $response = [
                'status'  => 200,
                'message' => 'Data changed successfully.'
            ];
        } else {
            $response = [
                'status'  => 500,
                'message' => 'Data failed to changed.'
            ];
        }

        return response()->json($response);
    }

    public function destroy(Request $request)
    {
        $query = ToDo::destroy($request->id);
        if($query) {
            $response = [
                'status'  => 200,
                'message' => 'Data deleted successfully.'
            ];
        } else {
            $response = [
                'status'  => 500,
                'message' => 'Data failed to delete.'
            ];
        }

        return response()->json($response);
    }

}
