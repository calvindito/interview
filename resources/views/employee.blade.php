<div class="card bg-light shadow-sm">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3 text-left">
                        <button type="button" class="btn btn-light btn-sm col-12" id="refresh_data">Refresh Data</button>
                    </div>
                    <div class="col-md-6 text-center mt-auto">
                        <span style="font-weight:400; font-size:20px;">DATA KARYAWAN</h6>
                    </div>
                    <div class="col-md-3 text-right">
                        <button type="button" class="btn btn-light col-12 btn-sm" onclick="openModal()" data-toggle="modal" data-target="#modal_form">Tambah Data</button>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-4 mb-4">
                <div class="text-center">
                    <label class="btn btn-outline-dark btn-sm active" id="radio_all">
                        <input type="radio" name="filter_radio" onclick="radioChange('all')" checked> Semua
                    </label>
                    <label class="btn btn-outline-dark btn-sm" id="radio_first_join">
                        <input type="radio" name="filter_radio" onclick="radioChange('first_join')"> Pertama Bergabung
                    </label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <div id="table_all">
                        <table class="table table-striped display table-bordered w-100">
                            <thead class="table-secondary">
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Tgl Lahir</th>
                                    <th>Tgl Bergabung</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div id="table_first_join">
                        <table class="table table-striped table-bordered w-100">
                            <thead class="table-secondary">
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Tgl Lahir</th>
                                    <th>Tgl Bergabung</th>
                                </tr>
                            </thead>
                            <tbody id="data_first_join"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_form" data-backdrop="static" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="exampleModalLabel">Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_data" autocomplete="off">
                    <div class="alert alert-danger" id="validation_alert" style="display:none;">
                        <ul id="validation_content" class="mb-0"></ul>
                    </div>
                    <div class="form-group">
                        <label>NIP :<span class="text-danger">*</span></label>
                        <input type="text" id="nip" class="form-control" placeholder="Auto Generate" disabled>
                    </div>
                    <div class="form-group">
                        <label>Nama :<span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Tgl Lahir :<span class="text-danger">*</span></label>
                        <input type="date" name="date_of_birth" id="date_of_birth" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Alamat :<span class="text-danger">*</span></label>
                        <textarea name="address" id="address" class="form-control" style="resize:none;"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Tgl Bergabung :<span class="text-danger">*</span></label>
                        <input type="date" name="date_join" id="date_join" value="{{ date('Y-m-d') }}" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <div class="form-group">
                    <button type="button" class="btn btn-danger ml-1" id="btn_cancel" onclick="openModal()" style="display:none;">Cancel</button>
                    <button type="button" class="btn btn-warning ml-1" id="btn_update" onclick="update()" style="display:none;">Simpan</button>
                    <button type="button" class="btn btn-primary ml-1" id="btn_create" onclick="create()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        radioChange('all');
    });

    function radioChange(param) {
        if(param == 'all') {
            $('#radio_all input').attr('checked', true);
            $('#radio_all').addClass('active');
            $('#radio_first_join input').attr('checked', false);
            $('#radio_first_join').removeClass('active');
            $('#table_all').fadeIn(500);
            $('#table_first_join').hide();
            $('#refresh_data').attr('onclick', 'loadDataAll()');
            loadDataAll();
        } else {
            $('#radio_first_join input').attr('checked', true);
            $('#radio_first_join').addClass('active');
            $('#radio_all input').attr('checked', false);
            $('#radio_all').removeClass('active');
            $('#table_first_join').fadeIn(500);
            $('#table_all').hide();
            $('#refresh_data').attr('onclick', 'loadDataFirstJoin()');
            loadDataFirstJoin();
        }
    }

    function openModal() {
        reset();
        $('#btn_create').show();
        $('#btn_update').hide();
        $('#btn_cancel').hide();
    }

    function cancel() {
        reset();
        $('#modal_form').modal('hide');
        $('#btn_create').show();
        $('#btn_update').hide();
        $('#btn_cancel').hide();
    }

    function toShow() {
        reset();
        $('#modal_form').modal('show');
        $('#validation_alert').hide();
        $('#validation_content').html('');
        $('#btn_create').hide();
        $('#btn_update').show();
        $('#btn_cancel').show();
    }

    function reset() {
        $('#form_data').trigger('reset');
        $('#date_join').val('{{ date("Y-m-d") }}');
        $('#validation_alert').hide();
        $('#validation_content').html('');
    }

    function success() {
        reset();
        $('#modal_form').modal('hide');
        $('#table_all table').DataTable().ajax.reload(null, false);
        loadDataFirstJoin();
    }

    function loadDataAll() {
        $('#table_all table').DataTable({
            serverSide: true,
            deferRender: true,
            destroy: true,
            iDisplayInLength: 10,
            order: [[0, 'asc']],
            ajax: {
                url: '{{ url("employee/load_data_all") }}',
                type: 'GET'
            },
            columns: [
                { name: 'id', searchable: false, className: 'text-center align-middle' },
                { name: 'nip', className: 'text-center align-middle' },
                { name: 'name', className: 'text-center align-middle' },
                { name: 'address', className: 'text-center align-middle' },
                { name: 'date_of_birth', searchable: false, className: 'text-center align-middle' },
                { name: 'date_join', searchable: false, className: 'text-center align-middle' },
                { name: 'action', orderable: false, searchable: false, className: 'text-center align-middle' }
            ]
        });
    }

    function loadDataFirstJoin() {
        $.ajax({
            url: '{{ url("employee/load_data_first_join") }}',
            type: 'GET',
            dataType: 'JSON',
            beforeSend: function() {
                $('#data_first_join').html('');
            },
            success: function(response) {
                $.each(response, function(i, val) {
                    $('#data_first_join').append(`
                        <tr class="text-center">
                            <td class="align-middle">` + val.no + `</td>
                            <td class="align-middle">` + val.nip + `</td>
                            <td class="align-middle">` + val.name + `</td>
                            <td class="align-middle">` + val.address + `</td>
                            <td class="align-middle">` + val.date_of_birth + `</td>
                            <td class="align-middle">` + val.date_join + `</td>
                        </tr>
                    `);
                });
            }
        });
    }

    function create() {
        $.ajax({
            url: '{{ url("employee/create") }}',
            type: 'POST',
            dataType: 'JSON',
            data: $('#form_data').serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $('#validation_alert').hide();
                $('#validation_content').html('');
            },
            success: function(response) {
                if(response.status == 200) {
                    success();
                    new $.Zebra_Dialog(response.message, {
                        type: 'confirmation',
                        title: 'Success'
                    });
                } else if(response.status == 422) {
                    $('#validation_alert').show();
                    $('.modal-body').scrollTop(0);

                    $.each(response.error, function(i, val) {
                        $.each(val, function(i, val) {
                            $('#validation_content').append(`
                                <li>` + val + `</li>
                            `);
                        });
                    });
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                $('.modal-body').scrollTop(0);
                alert('Server error');
            }
        });
    }

    function show(id) {
        toShow();
        $.ajax({
            url: '{{ url("employee/show") }}',
            type: 'GET',
            dataType: 'JSON',
            data: {
                id: id
            },
            success: function(response) {
                $('#nip').val(response.nip);
                $('#name').val(response.name);
                $('#address').val(response.address);
                $('#date_of_birth').val(response.date_of_birth);
                $('#date_join').val(response.date_join);
                $('#btn_update').attr('onclick', 'update(' + id + ')');
            },
            error: function() {
                cancel();
                new $.Zebra_Dialog('Server error!!', {
                    type: 'error',
                    title: 'Error'
                });
            }
        });
    }

    function update(id) {
        $.ajax({
            url: '{{ url("employee/update") }}' + '/' + id,
            type: 'POST',
            dataType: 'JSON',
            data: $('#form_data').serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $('#validation_alert').hide();
                $('#validation_content').html('');
            },
            success: function(response) {
                if(response.status == 200) {
                    success();
                    new $.Zebra_Dialog(response.message, {
                        type: 'confirmation',
                        title: 'Success'
                    });
                } else if(response.status == 422) {
                    $('#validation_alert').show();
                    $('.modal-body').scrollTop(0);

                    $.each(response.error, function(i, val) {
                        $.each(val, function(i, val) {
                            $('#validation_content').append(`
                                <li>` + val + `</li>
                            `);
                        });
                    });
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                $('.modal-body').scrollTop(0);
                alert('Server error');
            }
        });
    }

    function destroy(id) {
        new $.Zebra_Dialog('Anda yakin ingin menghapus data ini?', {
            type: 'question',
            title: 'Penghapusan Data',
            buttons: [
                {
                    caption: 'Ya, hapus', callback: function() {
                        $.ajax({
                            url: '{{ url("employee/destroy") }}',
                            type: 'POST',
                            dataType: 'JSON',
                            data: {
                                id: id
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if(response.status == 200) {
                                    $('#table_all table').DataTable().ajax.reload(null, false);
                                    loadDataFirstJoin();

                                    new $.Zebra_Dialog(response.message, {
                                        type: 'confirmation',
                                        title: 'Success'
                                    });
                                } else {
                                    alert(response.message);
                                }
                            },
                            error: function() {
                                alert('Server error');
                            }
                        });
                    }
                },
                {
                    caption: 'Batal', callback: function() {
                        return false;
                    }
                },
            ]
        });
    }
</script>
