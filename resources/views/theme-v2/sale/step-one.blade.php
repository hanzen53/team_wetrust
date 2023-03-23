@extends('theme-v2/common/master')
@section('content')
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Dashboard
				<small>Control panel</small>
			</h1>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="breadcrumb-item active">Dashboard</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">

			<div class="row">
				<div class="col-12 ">
					<div class="box">
						<div class="row no-gutters py-2">

							<div class="col-sm-6 col-lg-3">
								<div class="box-body br-1 border-light">
									<div class="flexbox mb-1">
              <span class="font-size-18">
                Total Tickets
              </span>
										<span class="text-primary font-size-40">154</span>
									</div>
									<div class="progress progress-xxs mt-10 mb-0">
										<div class="progress-bar" role="progressbar" style="width: 35%; height: 4px;" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
								</div>
							</div>


							<div class="col-sm-6 col-lg-3 hidden-down">
								<div class="box-body br-1 border-light">
									<div class="flexbox mb-1">
              <span class="font-size-18">
                New Tickets
              </span>
										<span class="text-info font-size-40">24</span>
									</div>
									<div class="progress progress-xxs mt-10 mb-0">
										<div class="progress-bar bg-info" role="progressbar" style="width: 55%; height: 4px;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
								</div>
							</div>


							<div class="col-sm-6 col-lg-3 d-none d-lg-block">
								<div class="box-body br-1 border-light">
									<div class="flexbox mb-1">
              <span class="font-size-18">
                Open Tickets
              </span>
										<span class="text-warning font-size-40">74</span>
									</div>
									<div class="progress progress-xxs mt-10 mb-0">
										<div class="progress-bar bg-warning" role="progressbar" style="width: 65%; height: 4px;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
								</div>
							</div>


							<div class="col-sm-6 col-lg-3 d-none d-lg-block">
								<div class="box-body">
									<div class="flexbox mb-1">
              <span class="font-size-18">
                Closed Tickets
              </span>
										<span class="text-danger font-size-40">41</span>
									</div>
									<div class="progress progress-xxs mt-10 mb-0">
										<div class="progress-bar bg-danger" role="progressbar" style="width: 40%; height: 4px;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
								</div>
							</div>


						</div>
					</div>
				</div>
				<!-- /.col -->

			</div>

		</section>
		<!-- /.content -->
	</div>
@endsection