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
    <title>{{ $title }}</title>
    <style>
        body {
            background: #F3F3F3;
        }

        .nowrap {
            white-space: nowrap;
        }

        .btn:focus {
            outline: none;
            box-shadow: none;
        }

        .btn-outline-primary:hover {
            border: 1px solid #007BFF;
            color: #007BFF;
            background: #F3F3F3;
        }

        .btn-outline-primary:active {
            border: 1px solid #007BFF !important;
            color: #007BFF !important;
            background: #F3F3F3 !important;
        }

        .navbar .navbar-nav a.active {
            font-weight: bold !important;
        }

        table thead tr {
            font-size: 14px;
        }

        table tbody tr {
            font-size: 12px;
        }
    </style>
</head>
<body>
