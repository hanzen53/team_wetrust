@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', 'AdminLTE')

@section('content_header')
@stop

@section('content')
<div class="box box-solid box-primary">
    <div class="box-header">
        <h3 class="box-title">ขั้นตอนที่ 1 Reboot Lite server</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        
            <form action="/reboot-server" method="post">
                @csrf
                <div class="form-group">
                    <label for="server" class="col-sm-2 control-label">Server</label>
                    <div class="col-sm-8">
                        <input type="text" name="tag" value="Lite" readonly class="form-control">
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-success">Reboot</button>
                    </div>
                </div>
            </form>
        
    </div>
</div>

<div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title">ขั้นตอนที่ 2 Reboot Gateway server ทั้งหมด</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            
                <form action="/reboot-server" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="server" class="col-sm-2 control-label">Server</label>
                        <div class="col-sm-8">
                            <input type="text" name="tag" value="Gateway" readonly class="form-control">
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-success">Reboot</button>
                        </div>
                    </div>
                </form>
            
        </div>
    </div>



@stop

@push('js-footer')

@endpush


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>

</script>
@endsection