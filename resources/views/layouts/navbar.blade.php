<div class="container p-3">
    <div class="row">
        <div class="col-md-12">
            <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4 shadow">
                <a class="navbar-brand" href="#">PT. Otto Menara Globalindo (Mceasy)</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav ml-auto">
                        <a class="nav-link {{ Request::segment(1) == '' ? 'active' : '' }}" href="{{ url('/') }}">Dashboard</a>
                        <a class="nav-link {{ Request::segment(1) == 'employee' ? 'active' : '' }}" href="{{ url('employee') }}">Karyawan</a>
                        <a class="nav-link {{ Request::segment(1) == 'leave' ? 'active' : '' }}" href="{{ url('leave') }}">Cuti</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
