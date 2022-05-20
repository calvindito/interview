<div class="container p-5">
    <div class="shadow-sm p-3">
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-5">
            <a class="navbar-brand text-uppercase" href="{{ url('dashboard') }}">My Todo</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ml-auto">
                    <a class="nav-link badge badge-danger text-white p-2" href="{{ url('logout') }}">Keluar</a>
                </div>
            </div>
        </nav>
