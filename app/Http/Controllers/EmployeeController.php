<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller {

    public function index()
    {
        $data = [
            'title'   => 'Karyawan',
            'content' => 'employee'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function loadDataAll(Request $request)
    {
        $column = [
            'id',
            'nip',
            'name',
            'address',
            'date_of_birth',
            'date_join'
        ];

        $start  = $request->start;
        $length = $request->length;
        $order  = $column[$request->input('order.0.column')];
        $dir    = $request->input('order.0.dir');
        $search = $request->input('search.value');

        $total_data = Employee::count();

        $query_data = Employee::where(function($query) use ($search, $request) {
                if($search) {
                    $query->where(function($query) use ($search) {
                            $query->where('nip', 'like', "%$search%")
                                ->orWhere('name', 'like', "%$search%")
                                ->orWhere('address', 'like', "%$search%");
                        });
                }
            })
            ->offset($start)
            ->limit($length)
            ->orderBy($order, $dir)
            ->get();

        $total_filtered = Employee::where(function($query) use ($search, $request) {
                if($search) {
                    $query->where(function($query) use ($search) {
                            $query->where('nip', 'like', "%$search%")
                                ->orWhere('name', 'like', "%$search%")
                                ->orWhere('address', 'like', "%$search%");
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
                    $val->nip,
                    $val->name,
                    $val->address,
                    date('d-M-y', strtotime($val->date_of_birth)),
                    date('d-M-y', strtotime($val->date_join)),
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

    public function loadDataFirstJoin()
    {
        $response = [];
        $data     = Employee::orderBy('date_join', 'asc')->take(3)->get();

        foreach($data as $key => $d) {
            $response[] = [
                'no'            => $key + 1,
                'nip'           => $d->nip,
                'name'          => $d->name,
                'address'       => $d->address,
                'date_of_birth' => date('d-M-y', strtotime($d->date_of_birth)),
                'date_join'     => date('d-M-y', strtotime($d->date_join))
            ];
        }

        return response()->json($response);
    }

    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name'          => 'required',
            'address'       => 'required',
            'date_of_birth' => 'required',
            'date_join'     => 'required'
        ], [
            'name.required'          => 'Nama tidak boleh kosong.',
            'address.required'       => 'Alamat tidak boleh kosong.',
            'date_of_birth.required' => 'Tgl lahir tidak boleh kosong.',
            'date_join.required'     => 'Tgl bergabung tidak boleh kosong.'
        ]);

        if($validation->fails()) {
            $response = [
                'status' => 422,
                'error'  => $validation->errors()
            ];
        } else {
            $query = Employee::create([
                'nip'           => 'asddas2',
                'name'          => $request->name,
                'address'       => $request->address,
                'date_of_birth' => $request->date_of_birth,
                'date_join'     => $request->date_join
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
        $data = Employee::find($request->id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'name'          => 'required',
            'address'       => 'required',
            'date_of_birth' => 'required',
            'date_join'     => 'required'
        ], [
            'name.required'          => 'Nama tidak boleh kosong.',
            'address.required'       => 'Alamat tidak boleh kosong.',
            'date_of_birth.required' => 'Tgl lahir tidak boleh kosong.',
            'date_join.required'     => 'Tgl bergabung tidak boleh kosong.'
        ]);

        if($validation->fails()) {
            $response = [
                'status' => 422,
                'error'  => $validation->errors()
            ];
        } else {
            $query = Employee::find($id)->update([
                'name'          => $request->name,
                'address'       => $request->address,
                'date_of_birth' => $request->date_of_birth,
                'date_join'     => $request->date_join
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

    public function destroy(Request $request)
    {
        $query = Employee::destroy($request->id);
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
