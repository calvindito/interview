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
        td, th {
            font-size: 11px;
        }
    </style>
</head>
<body>
