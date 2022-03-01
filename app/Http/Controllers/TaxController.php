<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TaxController extends Controller {

    public function data(Request $request)
    {
        if($request->has('id')) {
            $data = Tax::find($request->id);

            if($data) {
                $result = [
                    'id'         => $data->id,
                    'name'       => $data->name,
                    'rate'       => $data->rate . '%',
                    'created_at' => $data->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $data->updated_at->format('Y-m-d H:i:s')
                ];
            } else {
                $result = null;
            }

            $response = [
                'status'  => $data ? 200 : 404,
                'message' => $data ? 'Data found' : 'Data not found',
                'result'  => $result
            ];
        } else {
            $per_page = $request->per_page ? $request->per_page : 10;
            $data     = Tax::where(function($query) use ($request) {
                if($request->name) {
                    $query->where('name', 'like', "%$request->name%");
                }

                if($request->rate) {
                    $query->where('rate', $request->rate);
                }
            })
            ->paginate($per_page);

            if($data->total() > 0) {
                $result     = [];
                $pagination =  [
                    'page'         => $data->currentPage(),
                    'per_page'     => $data->perPage(),
                    'current_data' => $data->count(),
                    'total_data'   => $data->total()
                ];

                foreach($data->items() as $i) {
                    $result[] = [
                        'id'         => $i->id,
                        'name'       => $i->name,
                        'rate'       => $i->rate . '%',
                        'created_at' => $i->created_at->format('Y-m-d H:i:s'),
                        'updated_at' => $i->updated_at->format('Y-m-d H:i:s')
                    ];
                }
            } else {
                $pagination = null;
                $result     = null;
            }

            $response = [
                'status'     => 200,
                'message'    => $data->total() > 0 ? 'Data found' : 'Data empty',
                'pagination' => $pagination,
                'result'     => $result
            ];
        }

        return response()->json($response, $response['status']);
    }

    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'rate' => 'required'
        ], [
            'name.required' => 'Name cannot be empty',
            'rate.required' => 'Rate cannot be empty'
        ]);

        if($validation->fails()) {
            $response = [
                'status'  => 422,
                'message' => 'Validation active',
                'result'  => $validation->errors()
            ];
        } else {
            $query = Tax::create([
                'name' => $request->name,
                'rate' => $request->rate
            ]);

            if($query) {
                $response = [
                    'status'  => 200,
                    'message' => 'Data added successfully',
                    'result'  => $query
                ];
            } else {
                $response = [
                    'status'  => 500,
                    'message' => 'Data failed to add',
                    'result'  => null
                ];
            }
        }

        return response()->json($response, $response['status']);
    }

    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id'   => 'required',
            'name' => 'required',
            'rate' => 'required'
        ], [
            'id.required'   => 'Id cannot be empty',
            'name.required' => 'Name cannot be empty',
            'rate.required' => 'Rate cannot be empty'
        ]);

        if($validation->fails()) {
            $response = [
                'status'  => 422,
                'message' => 'Validation active',
                'result'  => $validation->errors()
            ];
        } else {
            $query = Tax::find($request->id)->update([
                'name' => $request->name,
                'rate' => $request->rate
            ]);

            if($query) {
                $response = [
                    'status'  => 200,
                    'message' => 'Data updated successfully'
                ];
            } else {
                $response = [
                    'status'  => 500,
                    'message' => 'Data failed to update'
                ];
            }
        }

        return response()->json($response, $response['status']);
    }

    public function destroy(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required',
        ], [
            'id.required' => 'Id cannot be empty'
        ]);

        if($validation->fails()) {
            $response = [
                'status'  => 422,
                'message' => 'Validation active',
                'result'  => $validation->errors()
            ];
        } else {
            $query = Tax::destroy($request->id);
            if($query) {
                $response = [
                    'status'  => 200,
                    'message' => 'Data deleted successfully'
                ];
            } else {
                $response = [
                    'status'  => 500,
                    'message' => 'Data failed to delete'
                ];
            }
        }

        return response()->json($response, $response['status']);
    }

}
