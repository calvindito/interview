<div class="card bg-light shadow-sm">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <button type="button" class="btn btn-secondary btn-sm col-12" id="refresh_data">Refresh Data</button>
                    </div>
                    <div class="col-md-6 text-center">
                        <span style="font-weight:400; font-size:20px;">DATA CUTI</h6>
                    </div>
                    <div class="col-md-3 text-right">
                        <div class="form-group">
                            <select name="filter_year" id="filter_year" class="form-control form-control-sm"></select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-4 mb-4">
                <div class="text-center">
                    <label class="btn btn-outline-dark btn-sm active" id="radio_current_data">
                        <input type="radio" name="filter_radio" onclick="radioChange('current_data')" checked> Data Saat Ini
                    </label>
                    <label class="btn btn-outline-dark btn-sm" id="radio_leave_more_than_one">
                        <input type="radio" name="filter_radio" onclick="radioChange('leave_more_than_one')"> Cuti Lebih Dari 1
                    </label>
                    <label class="btn btn-outline-dark btn-sm" id="radio_leave_over">
                        <input type="radio" name="filter_radio" onclick="radioChange('leave_over')"> Sisa Cuti
                    </label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <div id="table_current_data">
                        <table class="table table-striped display table-bordered w-100">
                            <thead class="table-secondary">
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Tgl Cuti</th>
                                    <th>Lama Cuti</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div id="table_leave_more_than_one">
                        <table class="table table-striped display table-bordered w-100">
                            <thead class="table-secondary">
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Tgl Cuti</th>
                                    <th>Lama Cuti</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div id="table_leave_over">
                        <table class="table table-striped display table-bordered w-100">
                            <thead class="table-secondary">
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Terpakai</th>
                                    <th>Sisa</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        radioChange('current_data');
    });

    function radioChange(param) {
        $('#filter_year').html('<option value="" selected>Semua Tahun</option>');
        for(i = new Date().getFullYear(); i >= 2005; i--) {
            $('#filter_year').append(`<option value="` + i + `">Tahun ` + i + `</option>`);
        }

        if(param == 'current_data') {
            $('#radio_current_data input').attr('checked', true);
            $('#radio_current_data').addClass('active');
            $('#radio_leave_more_than_one input').attr('checked', false);
            $('#radio_leave_more_than_one').removeClass('active');
            $('#radio_leave_over input').attr('checked', false);
            $('#radio_leave_over').removeClass('active');
            $('#table_current_data').fadeIn(500);
            $('#table_leave_more_than_one').hide();
            $('#table_leave_over').hide();
            $('#refresh_data').attr('onclick', 'loadCurrentData()');
            $('#filter_year').attr('onchange', 'loadCurrentData()');
            loadCurrentData();
        } else if(param == 'leave_more_than_one') {
            $('#radio_current_data input').attr('checked', false);
            $('#radio_current_data').removeClass('active');
            $('#radio_leave_more_than_one input').attr('checked', true);
            $('#radio_leave_more_than_one').addClass('active');
            $('#radio_leave_over input').attr('checked', false);
            $('#radio_leave_over').removeClass('active');
            $('#table_current_data').hide();
            $('#table_leave_more_than_one').fadeIn(500);
            $('#table_leave_over').hide();
            $('#refresh_data').attr('onclick', 'loadLeaveMoreThanOne()');
            $('#filter_year').attr('onchange', 'loadLeaveMoreThanOne()');
            loadLeaveMoreThanOne();
        } else {
            $('#filter_year').html('');
            for(i = new Date().getFullYear(); i >= 2005; i--) {
                var selected = i == new Date().getFullYear() ? 'selected' : '';
                $('#filter_year').append(`<option value="` + i + `" ` + selected + `>Tahun ` + i + `</option>`);
            }

            $('#radio_current_data input').attr('checked', false);
            $('#radio_current_data').removeClass('active');
            $('#radio_leave_more_than_one input').attr('checked', false);
            $('#radio_leave_more_than_one').removeClass('active');
            $('#radio_leave_over input').attr('checked', true);
            $('#radio_leave_over').addClass('active');
            $('#table_current_data').hide();
            $('#table_leave_more_than_one').hide();
            $('#table_leave_over').fadeIn(500);
            $('#refresh_data').attr('onclick', 'loadLeaveOver()');
            $('#filter_year').attr('onchange', 'loadLeaveOver()');
            loadLeaveOver();
        }
    }

    function loadCurrentData() {
        $('#table_current_data table').DataTable({
            serverSide: true,
            deferRender: true,
            destroy: true,
            iDisplayInLength: 10,
            order: [[0, 'asc']],
            ajax: {
                url: '{{ url("leave/load_current_data") }}',
                type: 'GET',
                data: {
                    year: $('#filter_year').val()
                }
            },
            columns: [
                { name: 'id', searchable: false, className: 'text-center align-middle' },
                { name: 'nip', orderable: false, className: 'text-center align-middle' },
                { name: 'name', orderable: false, className: 'text-center align-middle' },
                { name: 'date_leave', searchable: false, className: 'text-center align-middle' },
                { name: 'long_leave', searchable: false, className: 'text-center align-middle' },
                { name: 'description', className: 'text-center align-middle' }
            ]
        });
    }

    function loadLeaveMoreThanOne() {
        $('#table_leave_more_than_one table').DataTable({
            serverSide: true,
            deferRender: true,
            destroy: true,
            iDisplayInLength: 10,
            order: [[0, 'asc']],
            ajax: {
                url: '{{ url("leave/load_leave_more_than_one") }}',
                type: 'GET',
                data: {
                    year: $('#filter_year').val()
                }
            },
            columns: [
                { name: 'id', searchable: false, className: 'text-center align-middle' },
                { name: 'nip', orderable: false, className: 'text-center align-middle' },
                { name: 'name', orderable: false, className: 'text-center align-middle' },
                { name: 'date_leave', searchable: false, className: 'text-center align-middle' },
                { name: 'long_leave', searchable: false, className: 'text-center align-middle' },
                { name: 'description', className: 'text-center align-middle' }
            ]
        });
    }

    function loadLeaveOver() {
        $('#table_leave_over table').DataTable({
            serverSide: true,
            deferRender: true,
            destroy: true,
            iDisplayInLength: 10,
            order: [[0, 'asc']],
            ajax: {
                url: '{{ url("leave/load_leave_over") }}',
                type: 'GET',
                data: {
                    year: $('#filter_year').val()
                }
            },
            columns: [
                { name: 'id', searchable: false, className: 'text-center align-middle' },
                { name: 'nip', className: 'text-center align-middle' },
                { name: 'name', className: 'text-center align-middle' },
                { name: 'use', orderable: false, searchable: false, className: 'text-center align-middle' },
                { name: 'residual', orderable: false, searchable: false, className: 'text-center align-middle' },
                { name: 'total', orderable: false, searchable: false, className: 'text-center align-middle' }
            ]
        });
    }
</script>
