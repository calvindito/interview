<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemTax;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller {

    public function data(Request $request)
    {
        if($request->has('id')) {
            $data     = Item::find($request->id);
            $tax      = [];

            if($data) {
                if($data->itemTax->count() > 0) {
                    foreach($data->itemTax as $it) {
                        $tax[] = [
                            'name' => $it->tax->name,
                            'tax'  => $it->tax->rate . '%'
                        ];
                    }
                }

                $result = [
                    'id'         => $data->id,
                    'name'       => $data->name,
                    'created_at' => $data->created_at,
                    'updated_at' => $data->updated_at,
                    'tax'        => $tax
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
            $data     = Item::where(function($query) use ($request) {
                if($request->name) {
                    $query->where('name', 'like', "%$request->name%");
                }

                if($request->name_tax || $request->rate_tax) {
                    $query->whereHas('itemTax', function($query) use ($request) {
                        $query->whereHas('tax', function($query) use ($request) {
                            if($request->name_tax) {
                                $query->where('name', 'like', "%$request->name_tax%");
                            }

                            if($request->rate_tax) {
                                $query->where('rate', $request->rate_tax);
                            }
                        });
                    });
                }
            })
            ->paginate($per_page);

            if($data->total() > 0) {
                $result     = [];
                $pagination = [
                    'page'         => $data->currentPage(),
                    'per_page'     => $data->perPage(),
                    'current_data' => $data->count(),
                    'total_data'   => $data->total()
                ];

                foreach($data->items() as $i) {
                    $tax = [];
                    if($i->itemTax->count() > 0) {
                        foreach($i->itemTax as $it) {
                            $tax[] = [
                                'name' => $it->tax->name,
                                'tax'  => $it->tax->rate . '%'
                            ];
                        }
                    }

                    $result[] = [
                        'id'         => $i->id,
                        'name'       => $i->name,
                        'created_at' => $i->created_at->format('Y-m-d H:i:s'),
                        'updated_at' => $i->updated_at->format('Y-m-d H:i:s'),
                        'tax'        => $tax
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
            'name'     => 'required',
            'tax_id'   => 'required|array',
            'tax_id.*' => 'required'
        ], [
            'name.required'     => 'Name cannot be empty',
            'tax_id.required'   => 'Tax id cannot be empty',
            'tax_id.array'      => 'Tax id must be array',
            'tax_id.*.required' => 'Tax id value cannot be empty'
        ]);

        if($validation->fails()) {
            $response = [
                'status'  => 422,
                'message' => 'Validation active',
                'result'  => $validation->errors()
            ];
        } else {
            $query = Item::create([
                'name' => $request->name
            ]);

            if($query) {
                if($request->tax_id) {
                    foreach($request->tax_id as $ti) {
                        ItemTax::create([
                            'item_id' => $query->id,
                            'tax_id'  => $ti
                        ]);
                    }
                }

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
            'id'       => 'required',
            'name'     => 'required',
            'tax_id'   => 'required|array',
            'tax_id.*' => 'required'
        ], [
            'id.required'       => 'Id cannot be empty',
            'name.required'     => 'Name cannot be empty',
            'tax_id.required'   => 'Tax id cannot be empty',
            'tax_id.array'      => 'Tax id must be array',
            'tax_id.*.required' => 'Tax id value cannot be empty'
        ]);

        if($validation->fails()) {
            $response = [
                'status'  => 422,
                'message' => 'Validation active',
                'result'  => $validation->errors()
            ];
        } else {
            $query = Item::find($request->id)->update([
                'name' => $request->name
            ]);

            if($query) {
                ItemTax::where('item_id', $request->id)->delete();
                if($request->tax_id) {
                    foreach($request->tax_id as $ti) {
                        ItemTax::create([
                            'item_id' => $request->id,
                            'tax_id'  => $ti
                        ]);
                    }
                }

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
            $query = Item::destroy($request->id);
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
