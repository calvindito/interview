<h5 class="text-center mb-5">{{ session('name') }}</h5>
<div class="card">
    <div class="card-body">
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form method="POST">
            @csrf
            <div class="form-group mb-0">
                <div class="input-group">
                    <input type="text" class="form-control" name="todo" id="todo" placeholder="Description ..." value="{{ old('todo') }}" required>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-success">Tambah</button>
                    </div>
                </div>
                @error('todo')
                    <span class="text-danger font-italic" style="font-size:12px;">{{ $message }}</span>
                @enderror
            </div>
        </form>
    </div>
</div>
<div class="my-5">
    <h4 class="mb-4">Proses</h4>
    <div id="task_list">
        <ul class="list-group list-group-flush">
            @if($todo_process->count() > 0)
                @foreach($todo_process as $tp)
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-check">
                                    <form action="{{ url('dashboard/checkable') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $tp->id }}">
                                        <input type="checkbox" class="form-check-input pointer" id="idable{{ $tp->id }}" onchange="$(this).parents('form').submit();">
                                        <label class="form-check-label pointer ml-2" for="idable{{ $tp->id }}">{{ $tp->todo }}</label>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-2 text-right">
                                <form action="{{ url('dashboard/destroy') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $tp->id }}">
                                    <a href="javascript:void(0);" class="text-danger font-weight-bold font-italic" style="font-size:12px;" onclick="$(this).parents('form').submit();">Hapus</a>
                                </form>
                            </div>
                        </div>
                        <span class="text-muted font-italic" style="font-size:11px;">tanggal dibuat : {{ $tp->created_at->format('d-m-Y H:i') }}</span>
                    </li>
                @endforeach
            @else
                <div class="alert alert-info">Tidak ada data.</div>
            @endif
        </ul>
    </div>
</div>
<div class="my-5">
    <h4 class="mb-4">Selesai</h4>
    <div id="task_list">
        <ul class="list-group list-group-flush">
            @if($todo_done->count() > 0)
                @foreach($todo_done as $td)
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-check">
                                    <form action="{{ url('dashboard/checkable') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $td->id }}">
                                        <input type="checkbox" class="form-check-input pointer" id="idable{{ $td->id }}" onchange="$(this).parents('form').submit();" checked>
                                        <label class="form-check-label pointer ml-2" for="idable{{ $td->id }}"><s>{{ $td->todo }}</s></label>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-2 text-right">
                                <form action="{{ url('dashboard/destroy') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $td->id }}">
                                    <a href="javascript:void(0);" class="text-danger font-weight-bold font-italic" style="font-size:12px;" onclick="$(this).parents('form').submit();">Hapus</a>
                                </form>
                            </div>
                        </div>
                        <span class="text-muted font-italic" style="font-size:11px;">tanggal selesai : {{ $td->updated_at->format('d-m-Y H:i') }}</span>
                    </li>
                @endforeach
            @else
                <div class="alert alert-info">Tidak ada data.</div>
            @endif
        </ul>
    </div>
</div>
