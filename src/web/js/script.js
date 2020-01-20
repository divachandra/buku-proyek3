var ttl;

function doSearchCustomer(){
	$('#dgCustomers').datagrid('load',{
		search_customer: $('#searchCustomer').val()
	});
}

function newCustomer() {
	$('#dlgCustomer').dialog('open').dialog('setTitle','Tambah Pengguna');
	$('#fmCustomer').form('clear');
	url = 'c_kelola_user/saveCustomer';
	ttl = "new";
}

function editCustomer() {
	var row = $('#dgCustomers').datagrid('getSelected');
	if (row){
		$('#dlgCustomer').dialog('open').dialog('setTitle','Edit');
		$('#fmCustomer').form('load',row);
		url = 'c_kelola_user/updateCustomer/'+row.id_user;
		ttl = "updt";
	}else {
		$.messager.alert('Warning','Contact not selected!');
	}
}

function saveCustomer() {
	$('#fmCustomer').form('submit',{
		url: url,
		onSubmit: function(){
			return $(this).form('validate');
		},
		success: function(result){
			var result = eval('(' + result + ')');
			if (result.errorMsg){
				$.messager.show({
					title: 'Error',
					msg: result.errorMsg
				});
			}else if (result.success){
                $('#dlgCustomer').dialog('close');		// close the dialog
				$('#dgCustomers').datagrid('reload');	// reload the user data
                $('#fmCustomer').form('clear');
                var opts = $('#dgCustomers').datagrid('getColumnFields', true);
                var msg = ttl == "updt" ? "Update data success" : "New data added successfully";
                var title = ttl == "updt" ? "Data Update" : "New data";
                $.messager.alert({
                    title: title,
                    msg: msg,
                    fadeOut: 'slow',
                    showType:'fade',
                });
            }else {
				 $.messager.alert({
                        title: 'Error',
                        msg: "Encourage Error!"
                    });
			}
		}
	});
}

function destroyCustomer() {
	var row = $('#dgCustomers').datagrid('getSelected');
	if (row){
		$.messager.confirm('Confirm','Yakin akan menghapus pengguna  '+row.id_user,function(r){
			if (r){
				$.post('c_kelola_user/destroyCustomer',{id_user:row.id_user},function(result){
					if (result.success){
						$('#dgCustomers').datagrid('reload');	// reload the Vendor data
					} else {
						$.messager.show({	// show error message
							title: 'Error',
							msg: result.errorMsg
						});
					}
				},'json');
			}
		});
	}
}

//Start prodi
function doSearchprodi(){
	$('#dgprodi').datagrid('load',{
		search_prodi: $('#searchprodi').val()
	});
}

function newprodi() {
	$('#dlgprodi').dialog('open').dialog('setTitle','Tambah Jurusan/prodi');
	$('#fmprodi').form('clear');
	url = 'c_kelola_user/saveprodi';
	ttl = "new";
}

function editprodi() {
	var row = $('#dgprodi').datagrid('getSelected');
	if (row){
		$('#dlgprodi').dialog('open').dialog('setTitle','Edit');
		$('#fmprodi').form('load',row);
		url = 'c_kelola_user/updateprodi/'+row.id_prodi;
		ttl = "updt";
	}else {
		$.messager.alert('Warning','Contact not selected!');
	}
}

function saveprodi() {
	$('#fmprodi').form('submit',{
		url: url,
		onSubmit: function(){
			return $(this).form('validate');
		},
		success: function(result){
			var result = eval('(' + result + ')');
			if (result.errorMsg){
				$.messager.show({
					title: 'Error',
					msg: result.errorMsg
				});
			}else if (result.success){
                $('#dlgprodi').dialog('close');		// close the dialog
				$('#dgprodi').datagrid('reload');	// reload the user data
                $('#fmprodi').form('clear');
                var opts = $('#dgprodi').datagrid('getColumnFields', true);
                var msg = ttl == "updt" ? "Update data success" : "New data added successfully";
                var title = ttl == "updt" ? "Data Update" : "New data";
                $.messager.alert({
                    title: title,
                    msg: msg,
                    fadeOut: 'slow',
                    showType:'fade',
                });
            }else {
				 $.messager.alert({
                        title: 'Error',
                        msg: "Encourage Error!"
                    });
			}
		}
	});
}

function destroyprodi() {
	var row = $('#dgprodi').datagrid('getSelected');
	if (row){
		$.messager.confirm('Confirm','Yakin akan menghapus Data  '+row.id_prodi,function(r){
			if (r){
				$.post('c_kelola_user/destroyprodi',{id_prodi:row.id_prodi},function(result){
					if (result.success){
						$('#dgprodi').datagrid('reload');	// reload the Vendor data
					} else {
						$.messager.show({	// show error message
							title: 'Error',
							msg: result.errorMsg
						});
					}
				},'json');
			}
		});
	}
}

//end prodi

//start dosen

function doSearchdosen(){
	$('#dgdosen').datagrid('load',{
		search_dosen: $('#searchdosen').val()
	});
}

function newdosen() {
	$('#dlgdosen').dialog('open').dialog('setTitle','Tambah dosen');
	$('#fmdosen').form('clear');
	url = 'c_kelola_user/savedosen';
	ttl = "new";
}

function editdosen() {
	var row = $('#dgdosen').datagrid('getSelected');
	if (row){
		$('#dlgdosen').dialog('open').dialog('setTitle','Edit');
		$('#fmdosen').form('load',row);
		url = 'c_kelola_user/updatedosen/'+row.id_dosen;
		ttl = "updt";
	}else {
		$.messager.alert('Warning','Contact not selected!');
	}
}

function savedosen() {
	$('#fmdosen').form('submit',{
		url: url,
		onSubmit: function(){
			return $(this).form('validate');
		},
		success: function(result){
			var result = eval('(' + result + ')');
			if (result.errorMsg){
				$.messager.show({
					title: 'Error',
					msg: result.errorMsg
				});
			}else if (result.success){
                $('#dlgdosen').dialog('close');		// close the dialog
				$('#dgdosen').datagrid('reload');	// reload the user data
                $('#fmdosen').form('clear');
                var opts = $('#dgdosen').datagrid('getColumnFields', true);
                var msg = ttl == "updt" ? "Update data success" : "New data added successfully";
                var title = ttl == "updt" ? "Data Update" : "New data";
                $.messager.alert({
                    title: title,
                    msg: msg,
                    fadeOut: 'slow',
                    showType:'fade',
                });
            }else {
				 $.messager.alert({
                        title: 'Error',
                        msg: "Encourage Error!"
                    });
			}
		}
	});
}

function destroydosen() {
	var row = $('#dgdosen').datagrid('getSelected');
	if (row){
		$.messager.confirm('Confirm','Yakin akan menghapus pengguna  '+row.id_dosen,function(r){
			if (r){
				$.post('c_kelola_user/destroydosen',{id_dosen:row.id_dosen},function(result){
					if (result.success){
						$('#dgdosen').datagrid('reload');	// reload the Vendor data
					} else {
						$.messager.show({	// show error message
							title: 'Error',
							msg: result.errorMsg
						});
					}
				},'json');
			}
		});
	}
}

//end dosen

//start mahasiswa

function doSearchmahasiswa(){
	$('#dgmahasiswa').datagrid('load',{
		search_mahasiswa: $('#searchmahasiswa').val()
	});
}

function newmahasiswa() {
	$('#dlgmahasiswa').dialog('open').dialog('setTitle','Tambah mahasiswa');
	$('#fmmahasiswa').form('clear');
	url = 'c_kelola_user/savemahasiswa';
	ttl = "new";
}

function editmahasiswa() {
	var row = $('#dgmahasiswa').datagrid('getSelected');
	if (row){
		$('#dlgmahasiswa').dialog('open').dialog('setTitle','Edit');
		$('#fmmahasiswa').form('load',row);
		url = 'c_kelola_user/updatemahasiswa/'+row.id_mahasiswa;
		ttl = "updt";
	}else {
		$.messager.alert('Warning','Contact not selected!');
	}
}

function savemahasiswa() {
	$('#fmmahasiswa').form('submit',{
		url: url,
		onSubmit: function(){
			return $(this).form('validate');
		},
		success: function(result){
			var result = eval('(' + result + ')');
			if (result.errorMsg){
				$.messager.show({
					title: 'Error',
					msg: result.errorMsg
				});
			}else if (result.success){
                $('#dlgmahasiswa').dialog('close');		// close the dialog
				$('#dgmahasiswa').datagrid('reload');	// reload the user data
                $('#fmmahasiswa').form('clear');
                var opts = $('#dgmahasiswa').datagrid('getColumnFields', true);
                var msg = ttl == "updt" ? "Update data success" : "New data added successfully";
                var title = ttl == "updt" ? "Data Update" : "New data";
                $.messager.alert({
                    title: title,
                    msg: msg,
                    fadeOut: 'slow',
                    showType:'fade',
                });
            }else {
				 $.messager.alert({
                        title: 'Error',
                        msg: "Encourage Error!"
                    });
			}
		}
	});
}

function destroymahasiswa() {
	var row = $('#dgmahasiswa').datagrid('getSelected');
	if (row){
		$.messager.confirm('Confirm','Yakin akan menghapus pengguna  '+row.id_mahasiswa,function(r){
			if (r){
				$.post('c_kelola_user/destroymahasiswa',{id_mahasiswa:row.id_mahasiswa},function(result){
					if (result.success){
						$('#dgmahasiswa').datagrid('reload');	// reload the Vendor data
					} else {
						$.messager.show({	// show error message
							title: 'Error',
							msg: result.errorMsg
						});
					}
				},'json');
			}
		});
	}
}

//end mahasiswa

//start intern

function doSearchintern(){
	$('#dgintern').datagrid('load',{
		search_intern: $('#searchintern').val()
	});
}

function newintern() {
	$('#dlgintern').dialog('open').dialog('setTitle','Tambah intern');
	$('#fmintern').form('clear');
	url = 'c_kelola_user/saveintern';
	ttl = "new";
}

function editintern() {
	var row = $('#dgintern').datagrid('getSelected');
	if (row){
		$('#dlgintern').dialog('open').dialog('setTitle','Edit');
		$('#fmintern').form('load',row);
		url = 'c_kelola_user/updateintern/'+row.id_intern;
		ttl = "updt";
	}else {
		$.messager.alert('Warning','Contact not selected!');
	}
}

function saveintern() {
	$('#fmintern').form('submit',{
		url: url,
		onSubmit: function(){
			return $(this).form('validate');
		},
		success: function(result){
			var result = eval('(' + result + ')');
			if (result.errorMsg){
				$.messager.show({
					title: 'Error',
					msg: result.errorMsg
				});
			}else if (result.success){
                $('#dlgintern').dialog('close');		// close the dialog
				$('#dgintern').datagrid('reload');	// reload the user data
                $('#fmintern').form('clear');
                var opts = $('#dgintern').datagrid('getColumnFields', true);
                var msg = ttl == "updt" ? "Update data success" : "New data added successfully";
                var title = ttl == "updt" ? "Data Update" : "New data";
                $.messager.alert({
                    title: title,
                    msg: msg,
                    fadeOut: 'slow',
                    showType:'fade',
                });
            }else {
				 $.messager.alert({
                        title: 'Error',
                        msg: "Encourage Error!"
                    });
			}
		}
	});
}

function destroyintern() {
	var row = $('#dgintern').datagrid('getSelected');
	if (row){
		$.messager.confirm('Confirm','Yakin akan menghapus  '+row.id_intern,function(r){
			if (r){
				$.post('c_kelola_user/destroyintern',{id_intern:row.id_intern},function(result){
					if (result.success){
						$('#dgintern').datagrid('reload');	// reload the Vendor data
					} else {
						$.messager.show({	// show error message
							title: 'Error',
							msg: result.errorMsg
						});
					}
				},'json');
			}
		});
	}
}

//end intern

//start absensi

function doSearchabsensi(){
	$('#dgabsensi').datagrid('load',{
		search_absensi: $('#searchabsensi').val()
	});
}

function newabsensi() {
	$('#dlgabsensi').dialog('open').dialog('setTitle','Tambah absensi');
	$('#fmabsensi').form('clear');
	url = 'c_kelola_user/saveabsensi';
	ttl = "new";
}

function editabsensi() {
	var row = $('#dgabsensi').datagrid('getSelected');
	if (row){
		$('#dlgabsensi').dialog('open').dialog('setTitle','Edit');
		$('#fmabsensi').form('load',row);
		url = 'c_kelola_user/updateabsensi/'+row.id_absensi;
		ttl = "updt";
	}else {
		$.messager.alert('Warning','Contact not selected!');
	}
}

function saveabsensi() {
	$('#fmabsensi').form('submit',{
		url: url,
		onSubmit: function(){
			return $(this).form('validate');
		},
		success: function(result){
			var result = eval('(' + result + ')');
			if (result.errorMsg){
				$.messager.show({
					title: 'Error',
					msg: result.errorMsg
				});
			}else if (result.success){
                $('#dlgabsensi').dialog('close');		// close the dialog
				$('#dgabsensi').datagrid('reload');	// reload the user data
                $('#fmabsensi').form('clear');
                var opts = $('#dgabsensi').datagrid('getColumnFields', true);
                var msg = ttl == "updt" ? "Update data success" : "New data added successfully";
                var title = ttl == "updt" ? "Data Update" : "New data";
                $.messager.alert({
                    title: title,
                    msg: msg,
                    fadeOut: 'slow',
                    showType:'fade',
                });
            }else {
				 $.messager.alert({
                        title: 'Error',
                        msg: "Encourage Error!"
                    });
			}
		}
	});
}

function destroyabsensi() {
	var row = $('#dgabsensi').datagrid('getSelected');
	if (row){
		$.messager.confirm('Confirm','Yakin akan menghapus pengguna  '+row.id_absensi,function(r){
			if (r){
				$.post('c_kelola_user/destroyabsensi',{id_absensi:row.id_absensi},function(result){
					if (result.success){
						$('#dgabsensi').datagrid('reload');	// reload the Vendor data
					} else {
						$.messager.show({	// show error message
							title: 'Error',
							msg: result.errorMsg
						});
					}
				},'json');
			}
		});
	}
}

//end absensi

//start trigger_radius

function doSearchtrigger_radius(){
	$('#dgtrigger_radius').datagrid('load',{
		search_trigger_radius: $('#search_trigger_radius').val()
	});
}


//end trigger_radius


//start kelola halaman dosen

//start kelola profile dosen

function editprofiledosen() {
	var row = $('#dgprofiledosen').datagrid('getSelected');
	if (row){
		$('#dlgprofiledosen').dialog('open').dialog('setTitle','Edit');
		$('#fmprofiledosen').form('load',row);
		url = 'updateprofiledosen/'+row.id_dosen;
		ttl = "updt";
	}else {
		$.messager.alert('Warning','Contact not selected!');
	}
}

function saveaprofiledosen() {
	$('#fmprofiledosen').form('submit',{
		url: url,
		onSubmit: function(){
			return $(this).form('validate');
		},
		success: function(result){
			var result = eval('(' + result + ')');
			if (result.errorMsg){
				$.messager.show({
					title: 'Error',
					msg: result.errorMsg
				});
			}else if (result.success){
                $('#dlgprofiledosen').dialog('close');		// close the dialog
				$('#dgprofiledosen').datagrid('reload');	// reload the user data
                $('#fmprofiledosen').form('clear');
                var opts = $('#dgprofiledosen').datagrid('getColumnFields', true);
                var msg = ttl == "updt" ? "Update data success" : "New data added successfully";
                var title = ttl == "updt" ? "Data Update" : "New data";
                $.messager.alert({
                    title: title,
                    msg: msg,
                    fadeOut: 'slow',
                    showType:'fade',
                });
            }else {
				 $.messager.alert({
                        title: 'Error',
                        msg: "Encourage Error!"
                    });
			}
		}
	});
}


//end absensi




//end kelola profile dosen

//start view mahasiswa dosen

function doSearchdosenmahasiswa(){
	$('#dgCustomers').datagrid('load',{
		search_customer: $('#searchCustomer').val()
	});
}

//end view mahasiswa dosen

//start kelola dosen intern

//start intern

function doSearchdosenintern(){
	$('#dgdosenintern').datagrid('load',{
		search_intern: $('#searchdosenintern').val()
	});
}


function editdosenintern() {
	var row = $('#dgdosenintern').datagrid('getSelected');
	if (row){
		$('#dlginterndosen').dialog('open').dialog('setTitle','Edit');
		$('#fminterndosen').form('load',row);
		url = 'updatedosenintern/'+row.id_intern;
		ttl = "updt";
	}else {
		$.messager.alert('Warning','Contact not selected!');
	}
}

function savedosenintern() {
	$('#fminterndosen').form('submit',{
		url: url,
		onSubmit: function(){
			return $(this).form('validate');
		},
		success: function(result){
			var result = eval('(' + result + ')');
			if (result.errorMsg){
				$.messager.show({
					title: 'Error',
					msg: result.errorMsg
				});
			}else if (result.success){
                $('#dlginterndosen').dialog('close');		// close the dialog
				$('#dgdosenintern').datagrid('reload');	// reload the user data
                $('#fminterndosen').form('clear');
                var opts = $('#dgdosenintern').datagrid('getColumnFields', true);
                var msg = ttl == "updt" ? "Update data success" : "New data added successfully";
                var title = ttl == "updt" ? "Data Update" : "New data";
                $.messager.alert({
                    title: title,
                    msg: msg,
                    fadeOut: 'slow',
                    showType:'fade',
                });
            }else {
				 $.messager.alert({
                        title: 'Error',
                        msg: "Encourage Error!"
                    });
			}
		}
	});
}


//end kelola dosen intern
//end kelola halaman dosen