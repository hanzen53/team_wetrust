@if (session('status'))
	<div class="alert alert-success">
		{{ session('status') }}
	</div>
@endif

@if(session('status_permission'))
	<script type="text/javascript">
		swal("Sorry!","Permission deny", "error")
	</script>
@endif

@if (session('error'))
	<div class="alert alert-danger">
		<strong>Whoops!</strong>  {{ session('error') }}<br><br>
	</div>
@endif

@if (count($errors) > 0)

	<div class="alert alert-danger">
		<strong>Whoops!</strong> There were some problems with your input.<br><br>
		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif