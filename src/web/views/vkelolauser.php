<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Actspot505</title>
	<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/css/styles.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/easyui.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/icon.css') ?>">
	
	<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.easyui.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/script.js') ?>"></script>

	
	
	
	
	
	
	<link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css">
    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.1.1/build/ol.js"></script>
	<!--Custom Font-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
	
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
				<!--
				<ul class="nav navbar-top-links navbar-right">
					<li class="dropdown"><a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
						<span class="label label-danger">15</span>
					</a>
						<ul class="dropdown-menu dropdown-messages">
							<li>
								<div class="dropdown-messages-box"><a href="profile.html" class="pull-left">
									<img alt="image" class="img-circle" src="http://placehold.it/40/30a5ff/fff">
									</a>
									<div class="message-body"><small class="pull-right">3 mins ago</small>
										<a href="#"><strong>John Doe</strong> commented on <strong>your photo</strong>.</a>
									<br /><small class="text-muted">1:24 pm - 25/03/2015</small></div>
								</div>
							</li>
							<li class="divider"></li>
							<li>
								<div class="dropdown-messages-box"><a href="profile.html" class="pull-left">
									<img alt="image" class="img-circle" src="http://placehold.it/40/30a5ff/fff">
									</a>
									<div class="message-body"><small class="pull-right">1 hour ago</small>
										<a href="#">New message from <strong>Jane Doe</strong>.</a>
									<br /><small class="text-muted">12:27 pm - 25/03/2015</small></div>
								</div>
							</li>
							<li class="divider"></li>
							<li>
								<div class="all-button"><a href="#">
									<strong>All Messages</strong>
								</a></div>
							</li>
						</ul>
					</li>
					<li class="dropdown"><a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
						<span class="label label-info">5</span>
					</a>
						<ul class="dropdown-menu dropdown-alerts">
							<li><a href="#">
								<div><em class="fa fa-envelope"></em> 1 New Message
									<span class="pull-right text-muted small">3 mins ago</span></div>
							</a></li>
							<li class="divider"></li>
							<li><a href="#">
								<div><em class="fa fa-heart"></em> 12 New Likes
									<span class="pull-right text-muted small">4 mins ago</span></div>
							</a></li>
							<li class="divider"></li>
							<li><a href="#">
								<div><em class="fa fa-user"></em> 5 New Followers
									<span class="pull-right text-muted small">4 mins ago</span></div>
							</a></li>
						</ul>
					</li>
				</ul>
				-->
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
		<form role="search">
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Search">
			</div>
		</form>
		<ul class="nav menu" style="width:100%; margin:auto; border-style:none; padding:inherit;">
			<li class=""><a href="<?php echo site_url(); ?>/dashboard">Dashboard</a></li>
			<li class="parent active"><a data-toggle="collapse" href="#sub-item-1">
				Kelola <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"></span>
				</a>
				<ul class="children collapse" id="sub-item-1">
					<li><a class="active" href="<?php echo site_url(); ?>/c_kelola_user">
						 User
					</a></li>
					<li><a class="" href="#">
						 Track
					</a></li>
					<li><a class="" href="#">
						 Dosen
					</a></li>
				</ul>
			</li>
			<li><a href="<?php echo site_url('c_login/logout'); ?>"> Logout</a></li>
		</ul>
	</div><!--/.sidebar-->
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Kelola User</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Kelola User </h1>
			</div>
		</div><!--/.row-->
		
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
										<th field="status" width="100">Status</th>
									</tr>
								</thead>
							</table>
							<div id="toolbarCustomer">
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onClick="newCustomer()">New</a>
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onClick="editCustomer()">Edit</a>
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onClick="destroyCustomer()">Destroy</a>
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
											<input type="text" name="status" class="easyui-textbox" style="width: 100%;">
										</div>
									</div>
								</div>
								
								</div>
							</form>
						</div>
						<div id="dlgCustomerBtn">
							<a href="javascript:void(0)" id="btn_save" class="easyui-linkbutton" iconCls="icon-ok-a" onclick="saveCustomer()" style="width:90px">Save</a>
							<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-del-a" onclick="javascript:$('#dlgCustomer').dialog('close'); $('#fmEmployee').form(clear)
							" style="width:90px">Cancel</a>
						</div>
					</div>

					</div>
					
			</div><!--/.row-->
		</div>
		
			
			<div class="col-sm-12">
				<p class="back-link">Lumino Theme by <a href="https://www.medialoot.com">Medialoot</a></p>
			</div>
		</div><!--/.row-->
	</div>	<!--/.main-->>
 	
	
	

		
</body>


	<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/chart.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/chart-data.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/easypiechart.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/easypiechart-data.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
</html>


