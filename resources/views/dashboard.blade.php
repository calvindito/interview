<div class="container p-3">
    <div class="col-md-12">
        <div class="alert shadow-sm alert-light">
            <div class="row">
                <div class="col-md-4">Hi, {{ session('name') }}</div>
                <div class="col-md-4 text-center text-uppercase"><h5>interview</h5></div>
                <div class="col-md-4 text-right">
                    <a href="{{ url('logout') }}" class="btn btn-danger btn-sm">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <div class="card bg-light shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 mt-4">
                    <div class="row">
                        <div class="col-md-3 text-left">
                            <button type="button" class="btn btn-secondary btn-sm col-12" onclick="loadData()">Refresh Data</button>
                        </div>
                        <div class="col-md-6 text-center mt-auto">
                            <span style="font-weight:400; font-size:20px;">TABEL DATA</h6>
                        </div>
                        <div class="col-md-3 text-right">
                            <button type="button" class="btn btn-primary col-12 btn-sm" onclick="openModal()" data-toggle="modal" data-target="#modal_form">Add Data</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-4">
                    <div class="form-group">
                        <table class="table table-striped display table-bordered w-100" id="datatable_serverside">
                            <thead class="table-secondary">
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Title</th>
                                    <th>Detail</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
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
                        <label>Title :<span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Detail :</label>
                        <textarea name="detail" id="detail" class="form-control" style="resize:none;"></textarea>
                    </div>
                    <div class="form-group text-center mt-4">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="status" value="1" checked>
                                Waiting
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="status" value="2">
                                On Process
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="status" value="3">
                                Done
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <div class="form-group">
                    <button type="button" class="btn btn-danger ml-1" id="btn_cancel" onclick="openModal()" style="display:none;">Cancel</button>
                    <button type="button" class="btn btn-warning ml-1" id="btn_update" onclick="update()" style="display:none;">Save</button>
                    <button type="button" class="btn btn-primary ml-1" id="btn_create" onclick="create()">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        loadDataTable();
    });

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
        $('input[name="status"][value="1"]').prop('checked', true);
        $('#validation_alert').hide();
        $('#validation_content').html('');
    }

    function success() {
        reset();
        $('#modal_form').modal('hide');
        $('#datatable_serverside').DataTable().ajax.reload(null, false);
    }

    function loadDataTable() {
        $('#datatable_serverside').DataTable({
            serverSide: true,
            deferRender: true,
            destroy: true,
            iDisplayInLength: 10,
            order: [[0, 'asc']],
            ajax: {
                url: '{{ url("dashboard/datatable") }}',
                type: 'GET'
            },
            columns: [
                { name: 'id', searchable: false, className: 'text-center align-middle' },
                { name: 'title', className: 'text-center align-middle' },
                { name: 'detail', className: 'text-center align-middle' },
                { name: 'status', searchable: false, className: 'text-center align-middle' },
                { name: 'action', orderable: false, searchable: false, className: 'text-center align-middle' }
            ]
        });
    }

    function create() {
        $.ajax({
            url: '{{ url("dashboard/create") }}',
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
            url: '{{ url("dashboard/show") }}',
            type: 'GET',
            dataType: 'JSON',
            data: {
                id: id
            },
            success: function(response) {
                $('#title').val(response.title);
                $('#detail').val(response.detail);
                $('input[name="status"][value="' + response.status + '"]').prop('checked', true);
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
            url: '{{ url("dashboard/update") }}' + '/' + id,
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
        new $.Zebra_Dialog('Are you sure you want to delete this data?', {
            type: 'question',
            title: 'Delete',
            buttons: [
                {
                    caption: 'Yes, delete', callback: function() {
                        $.ajax({
                            url: '{{ url("dashboard/destroy") }}',
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
                                    $('#datatable_serverside').DataTable().ajax.reload(null, false);
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
                    caption: 'Cancel', callback: function() {
                        return false;
                    }
                },
            ]
        });
    }
</script>
