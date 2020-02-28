<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Actspot505</title>
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
	<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
	
	<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script>
    
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/leaflet.css" />
    
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/MarkerCluster.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/MarkerCluster.Default.css" />
    <link href="<?php echo base_url(); ?>assets/css/styles.css" rel="stylesheet">
	
		
	<style>
	#mapid{
		width: 100%;
		height: 400px;
	}

	* {
  box-sizing: border-box;
}

body {
  font-family: Arial, Helvetica, sans-serif;
}

/* Float four columns side by side */
.columna {
  float: left;
  width: 25%;
  margin-top:20px;
  padding: 0 10px;
}

/* Remove extra left and right margins, due to padding */
.rowa {margin: 0 -5px;}

/* Clear floats after the columns */
.rowa:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive columns */
@media screen and (max-width: 600px) {
  .column {
    width: 100%;
    display: block;
    margin-bottom: 20px;
  }
}

/* Style the counter cards */
.carda {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  padding: 16px;
  text-align: center;
  background-color: #f1f1f1;
}
	
	</style>
	
</head>
<body>	
	<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span></button>
				<a class="navbar-brand" href="#"><span>Lumino</span>Admin</a>				
			</div>
		</div><!-- /.container-fluid -->
	</nav>
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<div class="profile-sidebar">
			<div class="profile-userpic">
				<img src="http://placehold.it/50/30a5ff/fff" class="img-responsive" alt="">
			</div>
			<div class="profile-usertitle">
				<div class="profile-usertitle-name"> <?php echo $this->session->userdata("nama"); ?></div>
				<div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="divider"></div>
		<ul class="nav menu" style="position:relative; border:none; padding:unset;">
			<li class="active"><a href="<?php echo site_url(); ?>/dashboard">Dashboard</a></li>
			<li><a href="<?php echo site_url('c_login/logout'); ?>"> Logout</a></li>
		</ul>
	</div><!--/.sidebar-->
	
	

	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="rowa">
	<div class="columna">
		<div class="carda">
		<h4>Jumlah Pembimbing </h4>
		<table class="table table-bordered">
			<thead>
			<tr>
				<th style="text-align: center;">Eksternal</th>
				<th style="text-align: center;">Internal</th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td><?php echo $totaldosen; ?></td>
				<td><?php echo $totaldoseninternal; ?></td>
			</tr>
			
			</tbody>
		</table>
		</div>
	</div>

	<div class="columna">
		<div class="carda">
		<h4>Jumlah Mahasiswa</h4>
		<table class="table table-bordered">
			<thead>
			<tr>
			<?php                                
				foreach ($gettahunangkatan  as $row) {  
					echo "<th style='text-align: center;'>$row->angkatan_mahasiswa</th>";
				}
				"
				"
			?>
			</tr>
			</thead>
			<tbody>
			<tr>
				
				<td><?php echo $totalmahasiswa2015; ?></td>
				<td><?php echo $totalmahasiswa2016; ?></td>
				<td><?php echo $totalmahasiswa2017; ?></td>
			</tr>
			
			</tbody>
		</table>
		</div>
	</div>
	
	<div class="columna">
		<div class="carda">
		<h4>Jumlah Lokasi Internship</h4>
		
		<table class="table table-bordered">
			<thead>
			<tr>
				<th style="text-align: center;">Total</th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td><?php echo $totallokasiinternship; ?></td>
			</tr>
			
			</tbody>
		</table>
		</div>
	</div>
	
	<div class="columna">
		<div class="carda">
		<h4>Jumlah pengguna aktif </h4>
		<table class="table table-bordered">
			<thead>
			<tr>
				<th style="text-align: center;">Total</th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td><?php echo $totaluser; ?></td>
			</tr>
			
			</tbody>
		</table>
		</div>
	</div>
	</div>
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Peta Lokasi Internship Mahasiswa </h1>
			</div>
		</div><!--/.row-->
		<div class="row">
			<div class="col-sm-12">
				<div id="map" style="width:100%; height:280px;">
					
				</div> 
			</div>
		</div><!--/.row-->
		<!--
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">View Tabel Trigger radius </h1>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-12">
				
			<div class="panel panel-container">
			<div class="row">
					<div class="col-sm-12">
					<div id="container" class="easyui-layout" fit="true" style="height:300px;">
						<div region="center">
							<table id="dgtrigger_radius" toolbar="#toolbartrigger_radius" class="easyui-datagrid" fit="true" singleSelect="true" fitColumns="true" rowNumbers="false" pagination="true" url="<?= site_url('c_kelola_user/gettrigger_radius') ?>" pageSize="50" pageList="[25,50,75,100,125,150,200]" nowrap="false">
								<thead>
									<tr>
										<th field="id_trigger" width="80">ID trigger</th>
										<th field="id_intern" width="100">ID Intern</th>
										<th field="id_track" width="100">ID Track</th>
										<th field="radius" width="100">ID radius</th>
									</tr>
								</thead>
							</table>
							<div id="toolbartrigger_radius">
								<input  id="search_trigger_radius" class="easyui-searchbox" data-options="prompt:'Please Input Value',searcher:doSearchtrigger_radius,
								inputEvents: $.extend({}, $.fn.searchbox.defaults.inputEvents, {
									keyup: function(e){
										var t = $(e.data.target);
										var opts = t.searchbox('options');
										t.searchbox('setValue', $(this).val());
										opts.searcher.call(t[0],t.searchbox('getValue'),t.searchbox('getName'));
									}
								})" style="width:50%;"></input>
							</div>
						</div>
					</div>

					</div>
			</div>
		</div
		-->

		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Print Absensi per mahasiswa </h1>
			</div>
		</div><!--/.row-->
		<div class="row">
			<div class="col-lg-12">
			<form action="<?php echo site_url(). '/dashboard/perorang'; ?>" method="post">
		<table style="margin:20px auto;">
			<tr>
				<td>NPM : </td>
				<td><input type="text" name="npmmahasiswa"></td>
				<td><button type="submit" value="Submit">Submit</button></td>
			</tr>

		</table>
	</form>	
			</div>
		</div><!--/.row-->
		<!-- start kelola absensi-->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Kelola absensi </h1>
			</div>
		</div><!--/.row-->
		<div class="row">
			<div class="col-sm-12">
				 
			<div class="panel panel-container">
			<div class="row">
					<div class="col-sm-12">
					<div id="container" class="easyui-layout" fit="true" style="height:300px;">
						<div region="center">
							<table id="dgabsensi" toolbar="#toolbarabsensi" class="easyui-datagrid" fit="true" singleSelect="true" fitColumns="true" rowNumbers="false" pagination="true" url="<?= site_url('c_kelola_user/getabsensi') ?>" pageSize="50" pageList="[25,50,75,100,125,150,200]" nowrap="false">
								<thead>
									<tr>
										<th field="id_absensi" width="80">ID absensi</th>
										<th field="id_intern_absensi" width="100">ID Mahasiswa</th>
										<th field="id_mahasiswa_absensi" width="100">ID Intern</th>
										<th field="id_dosen_absensi" width="100">ID Dosen</th>
										<th field="latitude_absensi" width="100">Latitude absensi</th>
										<th field="longitude_absensi" width="100">Longtitude absensi</th>
										<th field="tgl_waktu_absensi" width="100">Date Time absensi </th>
										<th field="imei_perangkat_absensi" width="100">Imei absensi </th>
										<th field="kegiatan_absensi" width="100">Kegiatan absensi </th>
										<th field="foto_absensi" width="100">Photo absensi </th>
									</tr>
								</thead>
							</table>
							<div id="toolbarabsensi">
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onClick="newabsensi()">New</a>
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onClick="editabsensi()">Edit</a>
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onClick="destroyabsensi()">Destroy</a>
								<a href="<?php echo site_url(); ?>/dashboard/buatpdfabsensi" plain="true" class="easyui-linkbutton" iconCls="icon-print">Print</a>
								<input  id="searchabsensi" class="easyui-searchbox" data-options="prompt:'Please Input Value',searcher:doSearchabsensi,
								inputEvents: $.extend({}, $.fn.searchbox.defaults.inputEvents, {
									keyup: function(e){
										var t = $(e.data.target);
										var opts = t.searchbox('options');
										t.searchbox('setValue', $(this).val());
										opts.searcher.call(t[0],t.searchbox('getValue'),t.searchbox('getName'));
									}
								})" style="width:50%;"></input>
							</div>
						</div>

						<div id="dlgabsensi" class="easyui-dialog" style="width: 780px; height: auto; padding: 10px;" modal="true" closed="true" buttons="#dlgabsensiBtn">
							<form id="fmabsensi" method="post">
								<div class="col-sm-12 justify-content-sm-center">


								<div class="row" style="width: 100%">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">ID absensi</label>
											<input type="text" name="id_absensi" class="easyui-textbox" style="width: 100%;">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">ID Intern </label>
											<select class="" style="width: 100%; margin: 0px; padding-top: 0px; padding-bottom: 0px; height: 25px; line-height: 25px;" name="id_intern_absensi">
												
											<?php                                
											foreach ($data_intern  as $row) {  
											echo "<option value='".$row->id_intern."'>".$row->id_intern." | ".$row->id_koor_intern."</option>";
											}
											echo"
											"
											?>
											</select>
										</div>
									</div>
								</div>

								<div class="row" style="width: 100%">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Id Mahasiswa</label>
											<select class="" style="width: 100%; margin: 0px; padding-top: 0px; padding-bottom: 0px; height: 25px; line-height: 25px;" name="id_mahasiswa_absensi">
												
											<?php                                
											foreach ($data_mahasiswa  as $row) {  
											echo "<option value='".$row->id_mahasiswa."'>".$row->id_mahasiswa." | ".$row->nama_mahasiswa."</option>";
											}
											echo"
											"
											?>
											</select>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">ID Dosen</label>
											<select class="" style="width: 100%; margin: 0px; padding-top: 0px; padding-bottom: 0px; height: 25px; line-height: 25px;" name="id_dosen_absensi">
												
											<?php                                
											foreach ($data_dosen  as $row) {  
											echo "<option value='".$row->id_dosen."'>".$row->id_dosen." | ".$row->nama_dosen."</option>";
											}
											echo"
											"
											?>
											</select>
										</div>
									</div>
								</div>
								<div class="row" style="width: 100%">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Latitude absensi</label>
											<input type="text" name="latitude_absensi" class="easyui-textbox" style="width: 100%;">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Longitude absensi</label>
											<input type="text" name="longitude_absensi" class="easyui-textbox" style="width: 100%;">
										</div>
									</div>
								</div>
								<div class="row" style="width: 100%">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Tanggal dan waktu</label>
											<input type="date" name="tgl_waktu_absensi" class="easyui-textbox" style="width: 100%;">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Imei Perangkat</label>
											<input type="text" name="imei_perangkat_absensi" class="easyui-textbox" style="width: 100%;">
										</div>
									</div>
								</div>
								<div class="row" style="width: 100%">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Kegiatan absensi</label>
											<input type="text" name="kegiatan_absensi" class="easyui-textbox" style="width: 100%;">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Photo absensi</label>
											<input type="text" name="foto_absensi" class="easyui-textbox" style="width: 100%;">
										</div>
									</div>
								</div>
								
								
								</div>
							</form>
						</div>
						<div id="dlgabsensiBtn">
							<a href="javascript:void(0)" id="btn_save" class="easyui-linkbutton" iconCls="icon-ok-a" onclick="saveabsensi()" style="width:90px">Save</a>
							<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-del-a" onclick="javascript:$('#dlgabsensi').dialog('close'); $('#fmabsensi').form(clear)
							" style="width:90px">Cancel</a>
						</div>
					</div>

					</div>
			

			</div>
		</div><!--/.row-->
		<!-- start kelola absensi-->

		<!-- start kelola intern-->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Kelola Intern </h1>
			</div>
		</div><!--/.row-->
		<div class="row">
			<div class="col-sm-12">
				 
			<div class="panel panel-container">
			<div class="row">
					<div class="col-sm-12">
					<div id="container" class="easyui-layout" fit="true" style="height:300px;">
						<div region="center">
							<table id="dgintern" toolbar="#toolbarintern" class="easyui-datagrid" fit="true" singleSelect="true" fitColumns="true" rowNumbers="false" pagination="true" url="<?= site_url('c_kelola_user/getintern') ?>" pageSize="50" pageList="[25,50,75,100,125,150,200]" nowrap="false">
								<thead>
									<tr>
										<th field="id_intern" width="80">ID intern</th>
										<th field="id_koor_intern" width="100">Koordinator Internship</th>
										<th field="status_intern" width="100">Status Internship</th>
										<th field="tgl_mulai_intern" width="100">Tanggal mulai</th>
										<th field="tgl_akhir_intern" width="100">Tanggal berakhir</th>
									</tr>
								</thead>
							</table>
							<div id="toolbarintern">
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onClick="newintern()">New</a>
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onClick="editintern()">Edit</a>
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onClick="destroyintern()">Destroy</a>
								<a href="<?php echo site_url(); ?>/dashboard/buatpdfintern" plain="true" class="easyui-linkbutton" iconCls="icon-print">Print</a>
								<input  id="searchintern" class="easyui-searchbox" data-options="prompt:'Please Input Value',searcher:doSearchintern,
								inputEvents: $.extend({}, $.fn.searchbox.defaults.inputEvents, {
									keyup: function(e){
										var t = $(e.data.target);
										var opts = t.searchbox('options');
										t.searchbox('setValue', $(this).val());
										opts.searcher.call(t[0],t.searchbox('getValue'),t.searchbox('getName'));
									}
								})" style="width:50%;"></input>
							</div>
						</div>

						<div id="dlgintern" class="easyui-dialog" style="width: 780px; height: auto; padding: 10px;" modal="true" closed="true" buttons="#dlginternBtn">
							<form id="fmintern" method="post">
								<div class="col-sm-12 justify-content-sm-center">


								<div class="row" style="width: 100%">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">ID intern</label>
											<input type="text" name="id_intern" class="easyui-textbox" style="width: 100%;">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">ID Koordinator Internship </label>
											<select class="" style="width: 100%; margin: 0px; padding-top: 0px; padding-bottom: 0px; height: 25px; line-height: 25px;" name="id_koor_intern">
												
											<?php                                
											foreach ($data_dosen  as $row) {  
											echo "<option value='".$row->id_dosen."'>".$row->id_dosen." | ".$row->nama_dosen."</option>";
											}
											echo"
											"
											?>
											</select>
										</div>
									</div>
								</div>

								<div class="row" style="width: 100%">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Status Internship</label>
											<input type="text" name="status_intern" class="easyui-textbox" style="width: 100%;">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Tanggal Mulai</label>
											<input type="datetime-local" data-date="" data-date-format="YYYY MM DD" name="tanggal_mulai" class="easyui-textbox" style="width: 100%;">
										</div>
									</div>
								</div>
								<div class="row" style="width: 100%">
									<div class="col-sm-12">
										<div class="form-group">
											<label for="">Tanggal Berakhir</label>
											<input type="datetime-local" data-date="" data-date-format="YYYY MM DD" name="tanggal_berakhir" class="easyui-textbox" style="width: 100%;">
										</div>
									</div>
								</div>
								
								
								</div>
							</form>
						</div>
						<div id="dlginternBtn">
							<a href="javascript:void(0)" id="btn_save" class="easyui-linkbutton" iconCls="icon-ok-a" onclick="saveintern()" style="width:90px">Save</a>
							<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-del-a" onclick="javascript:$('#dlgintern').dialog('close'); $('#fmintern').form(clear)
							" style="width:90px">Cancel</a>
						</div>
					</div>

					</div>
			

			</div>
		</div><!--/.row-->
		<!-- end kelola intern-->
		
		<!-- start kelola mahasiswa-->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Kelola Mahasiswa </h1>
			</div>
		</div><!--/.row-->
		<div class="row">
			<div class="col-sm-12">
				
			<div class="panel panel-container">
			<div class="row">
					<div class="col-sm-12">
					<div id="container" class="easyui-layout" fit="true" style="height:300px;">
						<div region="center">
							<table id="dgmahasiswa" toolbar="#toolbarmahasiswa" class="easyui-datagrid" fit="true" singleSelect="true" fitColumns="true" rowNumbers="false" pagination="true" url="<?= site_url('c_kelola_user/getmahasiswa') ?>" pageSize="50" pageList="[25,50,75,100,125,150,200]" nowrap="false">
								<thead>
									<tr>
										<th field="id_mahasiswa" width="80">ID</th>
										<th field="nama_mahasiswa" width="100">Nama Mahasiswa</th>
										<th field="kelas_mahasiswa" width="100">Kelas</th>
										<th field="id_prodi_mahasiswa" width="100">Prodi</th>
										<th field="angkatan_mahasiswa" width="100">Angkatan</th>
										<th field="foto_mahasiswa" width="100">Photo mahasiswa</th>
										
									</tr>
								</thead>
							</table>
							<div id="toolbarmahasiswa">
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onClick="newmahasiswa()">New</a>
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onClick="editmahasiswa()">Edit</a>
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onClick="destroymahasiswa()">Destroy</a>
								<a href="<?php echo site_url(); ?>/dashboard/buatpdfmahasiswa" plain="true" class="easyui-linkbutton" iconCls="icon-print">Print</a>
								<input  id="searchmahasiswa" class="easyui-searchbox" data-options="prompt:'Please Input Value',searcher:doSearchmahasiswa,
								inputEvents: $.extend({}, $.fn.searchbox.defaults.inputEvents, {
									keyup: function(e){
										var t = $(e.data.target);
										var opts = t.searchbox('options');
										t.searchbox('setValue', $(this).val());
										opts.searcher.call(t[0],t.searchbox('getValue'),t.searchbox('getName'));
									}
								})" style="width:50%;"></input>
							</div>
						</div>

						<div id="dlgmahasiswa" class="easyui-dialog" style="width: 780px; height: auto; padding: 10px;" modal="true" closed="true" buttons="#dlgmahasiswaBtn">
							<form id="fmmahasiswa" method="post">
								<div class="col-sm-12 justify-content-sm-center">


								<div class="row" style="width: 100%">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">ID mahasiswa</label>
											<select class="" style="width: 100%; margin: 0px; padding-top: 0px; padding-bottom: 0px; height: 25px; line-height: 25px;" name="id_mahasiswa">
												
											<?php                                
											foreach ($data_user  as $row) {  
											echo "<option value='".$row->id_user."'>".$row->id_user." | ".$row->username."</option>";
											}
											echo"
											"
											?>
											</select>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Nama Mahasiswa </label>
											<input type="text" name="nama_mahasiswa" class="easyui-textbox" style="width: 100%;">
										</div>
									</div>
								</div>

								<div class="row" style="width: 100%">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Kelas mahasiswa</label>
											<input type="text" name="kelas_mahasiswa" class="easyui-textbox" style="width: 100%;">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Prodi </label>
											
											<select class="" style="width: 100%; margin: 0px; padding-top: 0px; padding-bottom: 0px; height: 25px; line-height: 25px;" name="id_prodi_mahasiswa">
												
											<?php                                
											foreach ($data_prodi  as $row) {  
											echo "<option value='".$row->id_prodi."'>".$row->nama_prodi."</option>";
											}
											echo"
											"
											?>
											</select>
										</div>
									</div>
									
								</div>
								<div class="row" style="width: 100%">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Tahun Angkatan</label>
											<input type="text" name="angkatan_mahasiswa" class="easyui-textbox" style="width: 100%;">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">foto mahasiswa</label>
											<input type="text" name="foto_mahasiswa" class="easyui-textbox" style="width: 100%;">
										</div>
									</div>
									
								</div>
								
								</div>
							</form>
						</div>
						<div id="dlgmahasiswaBtn">
							<a href="javascript:void(0)" id="btn_save" class="easyui-linkbutton" iconCls="icon-ok-a" onclick="savemahasiswa()" style="width:90px">Save</a>
							<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-del-a" onclick="javascript:$('#dlgmahasiswa').dialog('close'); $('#fmmahasiswa').form(clear)
							" style="width:90px">Cancel</a>
						</div>
					</div>

					</div>
			

			</div>
		</div><!--/.row-->
		<!-- start kelola mahasiswa-->

		<!-- start kelola dosen-->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Kelola Dosen </h1>
			</div>
		</div><!--/.row-->
		<div class="row">
			<div class="col-sm-12">
			<div class="panel panel-container">
			<div class="row">
					<div class="col-sm-12">
					<div id="container" class="easyui-layout" fit="true" style="height:300px;">
						<div region="center">
							<table id="dgdosen" toolbar="#toolbardosen" class="easyui-datagrid" fit="true" singleSelect="true" fitColumns="true" rowNumbers="false" pagination="true" url="<?= site_url('c_kelola_user/getdosen') ?>" pageSize="50" pageList="[25,50,75,100,125,150,200]" nowrap="false">
								<thead>
									<tr>
										<th field="id_dosen" width="80">ID Dosen</th>
										<th field="nama_dosen" width="100">Nama Dosen</th>
										<th field="id_prodi_dosen" width="100">ID Prodi</th>
										<th field="foto_dosen" width="100">Photo Dosen</th>
										<th field="status" width="100">Status Dosen</th>
									</tr>
								</thead>
							</table>
							<div id="toolbardosen">
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onClick="newdosen()">New</a>
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onClick="editdosen()">Edit</a>
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onClick="destroydosen()">Destroy</a>
								<a href="<?php echo site_url(); ?>/dashboard/buatpdfdosen" plain="true" class="easyui-linkbutton" iconCls="icon-print">Print</a>
								<input  id="searchdosen" class="easyui-searchbox" data-options="prompt:'Please Input Value',searcher:doSearchdosen,
								inputEvents: $.extend({}, $.fn.searchbox.defaults.inputEvents, {
									keyup: function(e){
										var t = $(e.data.target);
										var opts = t.searchbox('options');
										t.searchbox('setValue', $(this).val());
										opts.searcher.call(t[0],t.searchbox('getValue'),t.searchbox('getName'));
									}
								})" style="width:50%;"></input>
							</div>
						</div>

						<div id="dlgdosen" class="easyui-dialog" style="width: 780px; height: auto; padding: 10px;" modal="true" closed="true" buttons="#dlgdosenBtn">
							<form id="fmdosen" method="post">
								<div class="col-sm-12 justify-content-sm-center">


								<div class="row" style="width: 100%">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">ID Dosen </label><br>
											<select class="" style="width: 100%; margin: 0px; padding-top: 0px; padding-bottom: 0px; height: 25px; line-height: 25px;" name="id_dosen">
												
											<?php                                
											foreach ($data_user  as $row) {  
											echo "<option value='".$row->id_user."'>".$row->id_user." | ".$row->username."</option>";
											}
											echo"
											"
											?>
											</select>
											
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Nama Dosen</label>
											<input type="text" name="nama_dosen" class="easyui-textbox" style="width: 100%;">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">ID Prodi </label><br>
											<select class="" style="width: 100%; margin: 0px; padding-top: 0px; padding-bottom: 0px; height: 25px; line-height: 25px;" name="id_prodi_dosen">
												
											<?php                                
											foreach ($data_prodi  as $row) {  
											echo "<option value='".$row->id_prodi."'>".$row->nama_prodi."</option>";
											}
											echo"
											"
											?>
											</select>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Photo Dosen</label>
											<input type="text" name="foto_dosen" class="easyui-textbox" style="width: 100%;">
										</div>
									</div>
								</div>

								<div class="row" style="width: 100%">
									
									<div class="col-sm-12">
										<div class="form-group">
											<label for="">Status Dosen</label>
											<select class="" style="width: 100%; margin: 0px; padding-top: 0px; padding-bottom: 0px; height: 25px; line-height: 25px;" name="status">
											<option value="eksternal">Eksternal</option>
											<option value="internal">Internal</option>
											</select>

										</div>
									</div>
									
								</div>

								
								</div>
							</form>
						</div>
						<div id="dlgdosenBtn">
							<a href="javascript:void(0)" id="btn_save" class="easyui-linkbutton" iconCls="icon-ok-a" onclick="savedosen()" style="width:90px">Save</a>
							<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-del-a" onclick="javascript:$('#dlgdosen').dialog('close'); $('#fmdosen').form(clear)
							" style="width:90px">Cancel</a>
						</div>
					</div>

					</div>
			
			</div>
		</div><!--/.row-->


		<!--end kelola dosen-->
	<!--start kelola user-->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Kelola User </h1>
			</div>
		</div><!--/.row-->
		<div class="row">
			<div class="col-sm-12">
			<div class="panel panel-container">
			<div class="row">
					<div class="col-sm-12">
					<div id="container" class="easyui-layout" fit="true" style="height:300px;">
						<div region="center">
							<table id="dgCustomers" toolbar="#toolbarCustomer" class="easyui-datagrid" fit="true" singleSelect="true" fitColumns="true" rowNumbers="false" pagination="true" url="<?= site_url('c_kelola_user/getcustomers') ?>" pageSize="50" pageList="[25,50,75,100,125,150,200]" nowrap="false">
								<thead>
									<tr>
										<th field="id_user" width="80">ID User</th>
										<th field="username" width="100">Username</th>
										<th field="password" width="100">Password</th>
										<th field="status_user" width="100">Status</th>
										<th field="role_user" width="100">Status</th>
									</tr>
								</thead>
							</table>
							<div id="toolbarCustomer">
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onClick="newCustomer()">New</a>
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onClick="editCustomer()">Edit</a>
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onClick="destroyCustomer()">Destroy</a>
								<a href="<?php echo site_url(); ?>/dashboard/buatpdfuser" plain="true" class="easyui-linkbutton" iconCls="icon-print">Print</a>
								<input  id="searchCustomer" class="easyui-searchbox" data-options="prompt:'Please Input Value',searcher:doSearchCustomer,
								inputEvents: $.extend({}, $.fn.searchbox.defaults.inputEvents, {
									keyup: function(e){
										var t = $(e.data.target);
										var opts = t.searchbox('options');
										t.searchbox('setValue', $(this).val());
										opts.searcher.call(t[0],t.searchbox('getValue'),t.searchbox('getName'));
									}
								})" style="width:50%;"></input>
							</div>
						</div>

						<div id="dlgCustomer" class="easyui-dialog" style="width: 780px; height: auto; padding: 10px;" modal="true" closed="true" buttons="#dlgCustomerBtn">
							<form id="fmCustomer" method="post">
								<div class="col-sm-12 justify-content-sm-center">


								<div class="row" style="width: 100%">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">ID</label>
											<input type="text" name="id_user" class="easyui-textbox" style="width: 100%;">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Username </label>
											<input type="text" name="username" class="easyui-textbox" style="width: 100%;">
										</div>
									</div>
								</div>

								<div class="row" style="width: 100%">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Password</label>
											<input type="text" name="password" class="easyui-textbox" style="width: 100%;">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">status</label>
											<input type="text" name="status_user" class="easyui-textbox" style="width: 100%;">
										</div>
									</div>
								</div>

								<div class="row" style="width: 100%">
									<div class="col-sm-12">
										<div class="form-group">
											<label for="">Role User</label>
											<input type="text" name="role_user" class="easyui-textbox" style="width: 100%;">
										</div>
									</div>
									
								</div>
								
								</div>
							</form>
						</div>
						<div id="dlgCustomerBtn">
							<a href="javascript:void(0)" id="btn_save" class="easyui-linkbutton" iconCls="icon-ok-a" onclick="saveCustomer()" style="width:90px">Save</a>
							<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-del-a" onclick="javascript:$('#dlgCustomer').dialog('close'); $('#fmCustomer').form(clear)
							" style="width:90px">Cancel</a>
						</div>
					</div>

					</div>
					
			</div><!--/.row-->
		</div>
		
			</div>
		</div><!--/.row-->

		<!--end kelola user-->


		<!--Start kelola prodi -->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Kelola Prodi </h1>
			</div>
		</div><!--/.row-->
		<div class="row">
			<div class="col-sm-12">
			<div id="container" class="easyui-layout" fit="true" style="height:200px; width:100%;">
						<div region="center">
							<table id="dgprodi" toolbar="#toolbarkelolaprodi" class="easyui-datagrid" fit="true" singleSelect="true" fitColumns="true" rowNumbers="false" pagination="true" url="<?= site_url('c_kelola_user/getProdi') ?>" pageSize="50" pageList="[25,50,75,100,125,150,200]" nowrap="false">
								<thead>
									<tr>
										<th field="id_prodi" width="80">ID Prodi</th>
										<th field="nama_prodi" width="100">Nama Prodi</th>
									</tr>
								</thead>
							</table>
							<div id="toolbarkelolaprodi">
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onClick="newprodi()">New</a>
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onClick="editprodi()">Edit</a>
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onClick="destroyprodi()">Destroy</a>
								<a href="<?php echo site_url(); ?>/dashboard/buatpdfprodi" plain="true" class="easyui-linkbutton" iconCls="icon-print">Print</a>
								<input  id="searchprodi" class="easyui-searchbox" data-options="prompt:'Please Input Value',searcher:doSearchprodi,
								inputEvents: $.extend({}, $.fn.searchbox.defaults.inputEvents, {
									keyup: function(e){
										var t = $(e.data.target);
										var opts = t.searchbox('options');
										t.searchbox('setValue', $(this).val());
										opts.searcher.call(t[0],t.searchbox('getValue'),t.searchbox('getName'));
									}
								})" style="width:50%;"></input>
							</div>
						</div>

						<div id="dlgprodi" class="easyui-dialog" style="width: 780px; height: auto; padding: 10px;" modal="true" closed="true" buttons="#dlgprodiBtn">
							<form id="fmprodi" method="post">
								<div class="col-sm-12 justify-content-sm-center">


								<div class="row" style="width: 100%">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">ID Prodi</label>
											<input type="text" name="id_prodi" class="easyui-textbox" style="width: 100%;">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Nama Prodi </label>
											<input type="text" name="nama_prodi" class="easyui-textbox" style="width: 100%;">
										</div>
									</div>
								</div>

								
								
								</div>
							</form>
						</div>
						<div id="dlgprodiBtn">
							<a href="javascript:void(0)" id="btn_save" class="easyui-linkbutton" iconCls="icon-ok-a" onclick="saveprodi()" style="width:90px">Save</a>
							<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-del-a" onclick="javascript:$('#dlgprodi').dialog('close'); $('#fmprodi').form(clear)
							" style="width:90px">Cancel</a>
						</div>
					</div>
			</div>
		</div><!--/.row-->

		
		
	</div><!--/.row-->
</div>	<!--/.main-->



</body>


<script src="<?php echo base_url(); ?>assets/js/jquery-1.11.1.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
		
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/leaflet.js"></script>
		
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/leaflet.markercluster.js"></script>
		
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/icon.css') ?>">
		
		<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.easyui.min.js') ?>"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/js/script.js') ?>"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/easyui.css') ?>">
		<script type="text/javascript">
      var map, newUser, users, mapquest, firstLoad;

      firstLoad = true;

      //users = new L.FeatureGroup();
      users = new L.MarkerClusterGroup({spiderfyOnMaxZoom: true, showCoverageOnHover: false, zoomToBoundsOnClick: true});
      newUser = new L.LayerGroup();
      
            

      mapquest = new L.TileLayer("https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}", {
        maxZoom: 18,
        id: 'mapbox.streets',
        subdomains: ["otile1", "otile2", "otile3", "otile4"],
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
        accessToken: 'pk.eyJ1IjoiY2hhbmRyYWtwIiwiYSI6ImNrMzJpOWJoMDBhdDczZG1tZXk3MmppeGEifQ.wWJUgnRB1DsKnmYQdsJVxQ'
      });

      map = new L.Map('map', {
        center: new L.LatLng(-6.914744 , 107.609810),
        zoom: 10,
        layers: [mapquest, users, newUser]
      });

      // GeoLocation Control

      //map.locate({setView: true, maxZoom: 3});

      $(document).ready(function() {
        $.ajaxSetup({cache:false});
        $('#map').css('height', ($(window).height() - 300));
        getUsers();
      });

      $(window).resize(function () {
        $('#map').css('height', ($(window).height() - 300));
      }).resize();

      

      function getUsers() {
        $.getJSON("<?php echo site_url(); ?>/c_kelola_user/getCustomerJSON", function (data) {
          for (var i = 0; i < data.length; i++) {
            var location = new L.LatLng(data[i].latitude_absensi, data[i].longitude_absensi);
            var name = data[i].id_mahasiswa_absensi;
            var website = data[i].foto_absensi;
			var host = window.base_url = <?php echo json_encode(base_url()); ?>;

            
            
            var marker = new L.Marker(location, { title: name});
            marker.bindPopup("<div style='text-align: center; margin-left: auto; margin-right: auto;'><img style='width:100px; height:100px;' src="+ host + website+">"+ name +"</div>", {maxWidth: '400'});
            users.addLayer(marker);
          }
        }).complete(function() {
          if (firstLoad == true) {
            map.fitBounds(users.getBounds());
            firstLoad = false;
          };
        });
      }

    


    </script>
</html>


