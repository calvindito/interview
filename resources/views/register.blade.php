<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/zebra-dialog/dist/css/classic/zebra_dialog.min.css') }}" rel="stylesheet">
    <script src="{{ asset('bootstrap/jquery.min.js') }}"></script>
    <script src="{{ asset('datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-number/jquery.number.min.js') }}"></script>
    <script src="{{ asset('plugins/zebra-dialog/dist/zebra_dialog.min.js') }}"></script>
    <title>Daftar</title>
    <style>
        body {
            background: #007bff;
            background: linear-gradient(to right, #0062E6, #33AEFF);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card border-0 shadow rounded-3 my-5">
                    <div class="card-body p-4 p-sm-5">
                        <h5 class="card-title text-center mb-5 font-weight-bold">Daftar Akun</h5>
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @elseif(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <form method="POST" autocomplete="off">
                            @csrf
                            <div class="form-group">
                                <label>Nama :</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Username :</label>
                                <input type="text" class="form-control" name="username" id="username" value="{{ old('username') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Password :</label>
                                <input type="password" class="form-control" name="password" id="password" required>
                            </div>
                            <div class="form-group mb-0 mt-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a href="{{ url('/') }}" class="btn btn-danger text-uppercase font-weight-bold col-12">Kembali</a>
                                    </div>
                                    <div class="col-md-8">
                                        <button type="submit" class="btn btn-success text-uppercase font-weight-bold col-12">Daftar Sekarang</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('bootstrap/bootstrap.min.js') }}"></script>
</body>
</html>
