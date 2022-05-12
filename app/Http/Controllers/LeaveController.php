<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeaveController extends Controller {

    public function index()
    {
        $data = [
            'title'   => 'Cuti',
            'content' => 'leave'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function loadCurrentData(Request $request)
    {
        $column = [
            'id',
            'employee_nip',
            'employee_name',
            'date_leave',
            'address',
            'date_of_birth',
            'date_join'
        ];

        $start  = $request->start;
        $length = $request->length;
        $order  = $column[$request->input('order.0.column')];
        $dir    = $request->input('order.0.dir');
        $search = $request->input('search.value');

        $total_data = Leave::count();

        $query_data = Leave::where(function($query) use ($search, $request) {
                if($search) {
                    $query->where(function($query) use ($search) {
                        $query->whereHas('employee', function($query) use ($search) {
                                $query->where('nip', 'like', "%$search%")
                                    ->where('name', 'like', "%$search%");
                            });
                    });
                }

                if($request->year) {
                    $query->whereYear('date_leave', $request->year);
                }
            })
            ->offset($start)
            ->limit($length)
            ->orderBy($order, $dir)
            ->get();

        $total_filtered = Leave::where(function($query) use ($search, $request) {
                if($search) {
                    $query->where(function($query) use ($search) {
                        $query->whereHas('employee', function($query) use ($search) {
                                $query->where('nip', 'like', "%$search%")
                                    ->where('name', 'like', "%$search%");
                            });
                    });
                }

                if($request->year) {
                    $query->whereYear('date_leave', $request->year);
                }
            })
            ->count();

        $response['data'] = [];
        if($query_data <> FALSE) {
            $nomor = $start + 1;
            foreach($query_data as $val) {
                $response['data'][] = [
                    $nomor,
                    $val->employee->nip,
                    $val->employee->name,
                    date('d-M-y', strtotime($val->date_leave)),
                    $val->long_leave,
                    $val->description
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

    public function loadLeaveMoreThanOne(Request $request)
    {
        $column = [
            'id',
            'employee_nip',
            'employee_name',
            'date_leave',
            'address',
            'date_of_birth',
            'date_join'
        ];

        $start  = $request->start;
        $length = $request->length;
        $order  = $column[$request->input('order.0.column')];
        $dir    = $request->input('order.0.dir');
        $search = $request->input('search.value');

        $total_data = Leave::where('long_leave', '>', 1)
            ->count();

        $query_data = Leave::where(function($query) use ($search, $request) {
                if($search) {
                    $query->where(function($query) use ($search) {
                        $query->whereHas('employee', function($query) use ($search) {
                                $query->where('nip', 'like', "%$search%")
                                    ->where('name', 'like', "%$search%");
                            });
                    });
                }

                if($request->year) {
                    $query->whereYear('date_leave', $request->year);
                }
            })
            ->where('long_leave', '>', 1)
            ->offset($start)
            ->limit($length)
            ->orderBy($order, $dir)
            ->get();

        $total_filtered = Leave::where(function($query) use ($search, $request) {
                if($search) {
                    $query->where(function($query) use ($search) {
                        $query->whereHas('employee', function($query) use ($search) {
                                $query->where('nip', 'like', "%$search%")
                                    ->where('name', 'like', "%$search%");
                            });
                    });
                }

                if($request->year) {
                    $query->whereYear('date_leave', $request->year);
                }
            })
            ->where('long_leave', '>', 1)
            ->count();

        $response['data'] = [];
        if($query_data <> FALSE) {
            $nomor = $start + 1;
            foreach($query_data as $val) {
                $response['data'][] = [
                    $nomor,
                    $val->employee->nip,
                    $val->employee->name,
                    date('d-M-y', strtotime($val->date_leave)),
                    $val->long_leave,
                    $val->description
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

    public function loadLeaveOver(Request $request)
    {
        $column = [
            'employees.id',
            'nip',
            'name',
            'use',
            'residual',
            'total'
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
                                ->where('name', 'like', "%$search%");
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
                                ->where('name', 'like', "%$search%");
                        });
                }
            })
            ->count();

        $response['data'] = [];
        if($query_data <> FALSE) {
            $nomor = $start + 1;
            foreach($query_data as $val) {
                $year     = $request->year;
                $total    = 12;
                $use      = $val->leave()->whereYear('date_leave', $year)->sum('long_leave');
                $residual = $total - $use;

                $response['data'][] = [
                    $nomor,
                    $val->nip,
                    $val->name,
                    $use,
                    $residual,
                    $total
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

}
