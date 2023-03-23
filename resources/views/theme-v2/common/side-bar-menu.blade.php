<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
	<!-- sidebar -->
	<section class="sidebar">
		<!-- Sidebar user panel -->
		<div class="user-panel">
			<div class="ulogo">
				<a href="/">
					<!-- logo for regular state and mobile devices -->
					<span><b>Wetrust </b>GPS</span>
				</a>
			</div>
			<div class="image">
				@if(Auth::check())
					<img src="{{secure_asset('uploads/'.Auth::user()->avatar)}}" class="rounded-circle" alt="User Image">
				@else
					<img src="{{secure_asset('theme-wetrust/images/user2-160x160.jpg')}}" class="rounded-circle" alt="User Image">
				@endif
			</div>
			<div class="info">
				@if(Auth::check())
				<p>{{Auth::user()->name}}</p>
				<a href="" class="link" data-toggle="tooltip" title="" data-original-title="Settings"><i class="ion ion-gear-b"></i></a>
				<a href="" class="link" data-toggle="tooltip" title="" data-original-title="Email"><i class="ion ion-android-mail"></i></a>
				<a href="" class="link" data-toggle="tooltip" title="" data-original-title="Logout"><i class="ion ion-power"></i></a>
				@endif
			</div>
		</div>
		<!-- sidebar menu -->
		<ul class="sidebar-menu" data-widget="tree">
			<li class="nav-devider"></li>
			<li class="header nav-small-cap">WETRUSTGPS ADMIN</li>
			<li class="active">
				<a href="/">
					<i class="fa fa-dashboard"></i> <span>Dashboard</span>
					<span class="pull-right-container">
        <i class="fa fa-angle-right pull-right"></i>
      </span>
				</a>
			</li>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-users"></i>
					<span>ข้อมูลลูกค้า</span>
					<span class="pull-right-container">
        			<i class="fa fa-angle-right pull-right"></i>
      </span>
				</a>
				<ul class="treeview-menu">
					<li><a href="/sale/dashboard"><i class="fa fa-users"></i> ลูกค้าทั้งหมด</a></li>
					<li><a href="/sale/create"><i class="fa fa-user-plus"></i> เพิ่มลูกค้าใหม่</a></li>
				</ul>
			</li>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-car"></i> <span>ข้อมูลรถ</span>
					<span class="pull-right-container">
        <i class="fa fa-angle-right pull-right"></i>
      </span>
				</a>
				<ul class="treeview-menu">
					<li><a href="/list-all-car"><i class="fa fa-fw fa-exchange"></i> รถทั้งหมด / เปิดปิดข้อมูล</a></li>
					<li><a href="/device-offline"><i class="fa fa-warning text-red"></i> รถที่ไม่ online</a></li>
					<li><a href="/device-status"><i class="fa fa-fw fa-refresh text-green"></i> สถานะรถ</a></li>
					<li><a href="/device-center"><i class="fa fa-braille fa-refresh text-green"></i> รถในระบบ Center</a></li>
				</ul>
			</li>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-laptop"></i>
					<span>Call Center</span>
					<span class="pull-right-container">
        <i class="fa fa-angle-right pull-right"></i>
      </span>
				</a>
				<ul class="treeview-menu">
					<li><a href="/device-status"><i class="fa fa-phone-square"></i> Call center</a></li>
					<li><a href="/crm/car-owner"><i class="fa fa-search-plus"></i> ค้นหาเจ้าของรถ</a></li>
					<li><a href="/crm/list-all-ticket"><i class="fa fa-ticket"></i> All tickets</a></li>
					<li><a href="/raw-file"><i class="fa fa-history "></i> ข้อมูลดิบ</a></li>
				</ul>
			</li>
			<li class="header nav-small-cap">TOOLs and Service</li>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-fw fa-arrows"></i>
					<span>Tools</span>
					<span class="pull-right-container">
        <i class="fa fa-angle-right pull-right"></i>
      </span>
				</a>
				<ul class="treeview-menu">
					<li><a href="/add-line-token"><i class="fa fa-gears"></i> Line token</a></li>
					<li><a href="/forward-2-lite"><i class="fa fa-share"></i> Forward to lite</a></li>
					<li><a href="/edit-plate"><i class="fa fa-edit"></i> ทะเบียนรถหน้า online</a></li>
					<li><a href="/update-speed-limit"><i class="fa fa-sort-numeric-asc"></i> Limit speed</a></li>
					<li><a href="/manual-sent-dlt"><i class="fa fa-terminal"></i> ส่งข้อมูลเข้าขนส่ง</a></li>

				</ul>
			</li>
			<li class="header nav-small-cap">WETRUSTGPS SALE</li>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-navicon"></i> <span>Stock</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-right pull-right"></i>
				   </span>
				</a>
				<ul class="treeview-menu">
					<li><a href="/device-stock"><i class="fa fa-database"></i> Stock</a></li>
					<li><a href="/device-stock/create"><i class="fa fa-plus"></i> เพิ่ม stock</a></li>
					<li><a href="/release-imei"><i class="fa fa-unlock"></i> ปล่อยอุปกรณ์ให้ว่าง</a></li>
					<li><a href="/assign-stock-to-agent"><i class="fa fa-pie-chart"></i> โยน Stock ให้ตัวแทน</a></li>
					<li><a href="/device-stock-used"><i class="fa fa-check-square-o"></i> อุปกรณ์ที่ผูกใช้งานแล้ว</a></li>
				</ul>
			</li>
			<li class="treeview">
				<a href="#">
					<i class="fa fa fa-money"></i> <span>การชำระเงิน</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-right pull-right"></i>
				   </span>
				</a>
				<ul class="treeview-menu">
					<li><a href="/payment-list"><i class="fa fa-database"></i>IMEI ที่ใกล้ครบชำระ</a></li>
					<li><a href="/paid-list"><i class="fa fa-plus"></i>รายการชำระทั้งหมด</a></li>
				</ul>
			</li>
			<li class="treeview">
				<a href="#">
					<i class="fa fa fa-cubes"></i> <span>Agents ตัวแทน</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-right pull-right"></i>
				   </span>
				</a>
				<ul class="treeview-menu">
					<li><a href="/agents"><i class="fa fa-database"></i> ตัวแทนทั้งหมด</a></li>
					<li><a href="/agents/create"><i class="fa fa-plus"></i> เพิ่ม ตัวแทน</a></li>
				</ul>
			</li>

		</ul>
	</section>
</aside>