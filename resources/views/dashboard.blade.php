<div class="container-fluid">
    <div class="card" style="margin:2rem 0rem;">
        <div class="card-header">Venturo - Laporan penjualan tahunan per menu</div>
        <div class="card-body">
            <form action="" method="GET">
                @csrf
                <div class="row">
                    <div class="col-2">
                        <div class="form-group">
                            <select id="my-select" class="form-control" name="year">
                                <option value="">Pilih Tahun</option>
                                @for($i = 2021; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}" {{ $i == $year ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary">Tampilkan</button>
                        @if($year)
                            <a href="{{ $url }}/menu" target="_blank" rel="Array Menu" class="btn btn-secondary">Json Menu</a>
                            <a href="{{ $url }}/transaksi?tahun=2021" target="_blank" rel="Array Transaksi" class="btn btn-secondary">Json Transaksi</a>
                        @endif
                    </div>
                </div>
            </form>
            @if($year)
                <hr>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" style="margin:0;">
                        <thead>
                            <tr class="bg-dark text-white">
                                <th rowspan="2" style="text-align:center;vertical-align: middle;width:250px;">Menu</th>
                                <th colspan="12" style="text-align: center;">Periode Pada {{ $year }}</th>
                                <th rowspan="2" style="text-align:center;vertical-align: middle;width:75px">Total</th>
                            </tr>
                            <tr class="bg-dark text-white">
                                <th style="text-align: center;width:75px;">Jan</th>
                                <th style="text-align: center;width:75px;">Feb</th>
                                <th style="text-align: center;width:75px;">Mar</th>
                                <th style="text-align: center;width:75px;">Apr</th>
                                <th style="text-align: center;width:75px;">Mei</th>
                                <th style="text-align: center;width:75px;">Jun</th>
                                <th style="text-align: center;width:75px;">Jul</th>
                                <th style="text-align: center;width:75px;">Ags</th>
                                <th style="text-align: center;width:75px;">Sep</th>
                                <th style="text-align: center;width:75px;">Okt</th>
                                <th style="text-align: center;width:75px;">Nov</th>
                                <th style="text-align: center;width:75px;">Des</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($result as $key => $r)
                                <tr>
                                    <td class="table-secondary" colspan="14"><b>{{ $key }}</b></td>
                                </tr>
                                @foreach($r as $val)
                                    <tr>
                                        <td>{{ $val['menu'] }}</td>
                                        @foreach($val['detail'] as $d)
                                            <td>{{ number_format($d) }}</td>
                                        @endforeach
                                        <td><b>{{ number_format($val['total']) }}</b></td>
                                    </tr>
                                @endforeach
                            @endforeach
                            <tr class="bg-dark font-weight-bold text-white">
                                <td>Total</td>
                                @foreach($grandtotal['detail'] as $d)
                                    <td>{{ number_format($d) }}</td>
                                @endforeach
                                <td>{{ number_format($grandtotal['total']) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
