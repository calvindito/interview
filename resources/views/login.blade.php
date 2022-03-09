<div class="container p-3">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="jumbotron bg-light shadow-sm">
                <h4 class="text-center">SILAHKAN LOGIN</h4>
                <div class="form-group"><hr></div>
                @if(session('failed'))
                    <div class="alert alert-danger">{{ session('failed') }}</div>
                @elseif(session('logout'))
                    <div class="alert alert-success">{{ session('logout') }}</div>
                @endif
                <form method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Email :<span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password :<span class="text-danger">*</span></label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-success">Masuk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
