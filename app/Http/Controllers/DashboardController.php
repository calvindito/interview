<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class DashboardController extends Controller {

    public function index(Request $request)
    {
        $url              = 'http://tes-web.landa.id/intermediate/';
        $json_menu        = file_get_contents($url . 'menu');
        $data_menu        = json_decode($json_menu);
        $json_transaction = file_get_contents($url . 'transaksi?tahun=' . $request->year);
        $data_transaction = json_decode($json_transaction, true);
        $result           = [];
        $total_all        = 0;
        $detail_all       = [];

        foreach($data_menu as $dm) {
            $detail      = [];
            $group_menu  = $dm->kategori == 'makanan' ? 'Makanan' : 'Minuman';

            for($i = 1; $i <= 12; $i++) {
                $transaction = Arr::where($data_transaction, function($value, $key) use ($dm) {
                    return ($value['menu'] == $dm->menu);
                });

                $total = 0;
                foreach($transaction as $t) {
                    $date  = explode('-', $t['tanggal']);
                    $year  = $request->year;
                    $month = $i < 10 ? '0' . $i : $i;

                    if($date[0] == $year && $date[1] == $month) {
                        $total += $t['total'];
                    }
                }

                $detail_all[$i][] = $total;
                $detail[]         = $total;
            }

            $total_all            += array_sum($detail);
            $result[$group_menu][] = ['menu' => $dm->menu, 'detail' => $detail, 'total' => array_sum($detail)];
        }

        $data_detail = [];
        foreach($detail_all as $key => $da) {
            $data_detail[] = array_sum($detail_all[$key]);
        }

        $grandtotal = [
            'detail' => $data_detail,
            'total'  => $total_all
        ];

        $data = [
            'title'      => 'Dashboard',
            'url'        => $url,
            'year'       => $request->year,
            'result'     => $result,
            'grandtotal' => $grandtotal,
            'content'    => 'dashboard'
        ];

        return view('layouts.index', ['data' => $data]);
    }

}
