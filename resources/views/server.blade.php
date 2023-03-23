@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', 'AdminLTE')

@section('content_header')
@stop

@section('content')
<div class="box box-solid box-primary" id="">
    <div class="box-header">
        <h3 class="box-title">อุปกรณ์แต่ล่ะ server</h3>
    </div><!-- /.box-header -->
    <div class="box-body">

     
        
        <form action="/list-car-on-server" method="GET">
            <div class="form-group">
                <label for="server" class="col-sm-2 control-label">Server</label>
                <div class="col-sm-8">
                    <select name="server" id="server" class="form-control">
                        <option value="0">เลือก Server</option>
                        @foreach ($servers as $server)
                        <option value="{{$server->id}}" @if($server->id == Request::get('server')) selected @endif>{{$server->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-success">ตรวจสอบ</button>
                </div>
            </div>
        </form>
        
    </div>
</div>

@if(Request::get('server'))
<div class="box box-solid box-primary" id="app">
    <div class="box-header">
        <h3 class="box-title">ข้อมูลรถ</h3>
    </div>
    <div class="box-body">

        <div v-if="loading" class="text-center">
			<i class="fa fa-spinner fa-spin fa-5x fa-fw"></i>
			<span class="sr-only">Loading...</span>
		</div>
        
            <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Protocol</th>
                            <th>Stock ID</th>
                            <th>IMEI</th>
                            <th>ทะเบียน</th>
                            <th>เบอร์โทร</th>
                            <th>Last update</th>
                        </tr>
                    </thead>

                    <tbody>

                    <tr v-for="(car,index) in results">
                    <th scope="row">@{{index+1}}</th>
                        <td>@{{car.protocol}}</td>
                        <td>@{{car.stock_id}}</td>
                        <td>@{{car.imei}}</td>
                        <td>@{{car.name}}</td>
                        <td>@{{car.tel}}</td>
                        <td>@{{car.last_update}}</td>
                    </tr>

                    </tbody>

                    </table>
        
    </div>
</div>
@endif


@stop

@push('js-footer')

@endpush


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    new Vue({
        el: '#app',
        data: {
            results: [],
            server: '<?php echo $url;?>',
        },
        created: function () {
            this.fetchData();
        },
        methods: {
            
            fetchData(){
                this.results = [];
                this.loading = true; //the loading begin
                axios.get(this.server)
                .then(response => {
                    this.loading = false; 
                    this.results = response.data;
                    console.log(this.results);
                    
                })
                .catch(error => {
					this.loading = false;
				})
				.finally(() => this.loading = false)
            }
        }
    })
</script>
@endsection