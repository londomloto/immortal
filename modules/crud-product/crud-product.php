<script type="text/javascript" language="javascript" >

var dTable;

$(document).ready(function() {
	
	dTable = $('#crudProduct').DataTable( {
		"bProcessing": true,
		"bServerSide": true,
		"bJQueryUI": false,
		"responsive": true,
		
		// "sAjaxSource": "process/server-side.php", 
		"sAjaxSource": siteUrl("crud-product/process/server-side"),

		"sServerMethod": "POST",

		"columnDefs": [
			{ "orderable": true, "targets": 0, "searchable": true },
			{ "orderable": true, "targets": 1, "searchable": true },
			{ "orderable": true, "targets": 2, "searchable": true },
			{ "orderable": true, "targets": 3, "searchable": true },
			{ "orderable": false, "targets": 4, "searchable": true }
		]
	});
	
	$('#crudProduct').removeClass( 'display' ).addClass('table table-striped table-bordered');
} );
</script>

<h2>PRODUCT</h2><hr>
<button onClick="showModProduct()" class="btn btn-block btn-success">Tambah</button>
<table id="crudProduct" class="display" width="100%">
    <thead>
        <tr>
            <th>AKSI</th> 
            <th>ID</th>
            <th>NAME</th>
            <th>SLUG</th> 
            <th>CATEGORY</th>                       
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
		
<!-- Modal Popup -->
<div class="modal fade" id="ModProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Tambah Data Product</h4>
            </div>
            <div class="modal-body">
                
                <div class="alert alert-danger" role="alert" id="removeWarning">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    Anda yakin ingin menghapus data ini ?						
                </div>
                <div id="hasil"></div>	
                <br>
                <form class="form-horizontal" id="formProduct">
                    
                    <input type="hidden" class="form-control" id="id" name="id"/>
                    
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">NAME</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="slug" class="col-sm-2 control-label">SLUG</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="slug" name="slug" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category" class="col-sm-2 control-label">CATEGORY</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="category" name="category" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" onClick="submitAddProduct()" class="btn btn-success" data-dismiss="modal" id="simpan">Simpan</button>
                <button type="button" onClick="submiteditProduct()" class="btn btn-success" data-dismiss="modal" id="ubah">Ubah</button> 
                <button type="button" onClick="submitdelProduct()" class="btn btn-success" data-dismiss="modal" id="hapus">Hapus</button>
                <button type="button" class="btn btn-success" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
		
<script>
	//Tampilkan Modal 
	function showModProduct( id )
	{
		//waitingDialog.show();
		clearModals();
		
		// Proses menyiapkan modal Untuk di Edit atau Di Hapus 
		if( id )
		{
			$.ajax({
				type: "POST",

				//edited: clean url
				url: siteUrl('crud-product/process/process-crud-product/tampil'),
				dataType: 'json',
				data: {id:id},
				success: function(res) {
					//waitingDialog.hide();
					setModalData( res );
				}
			});
		}
		// Memanggil modal Untuk Tambahkan Data
		else
		{
			$("#ModProduct").modal("show");
			$("#myModalLabel").html("Tambah Data Product");
			$("#simpan").show(); 
			//waitingDialog.hide();
		}
	}
	
	//Data Yang Di Tampilkan Pada Modal Ketika Di Edit 
	function setModalData( data )
	{
		$("#myModalLabel").html("Edit Data Product");
		$("#id").val(data.id);
		$("#name").val(data.name);
		$("#slug").val(data.slug);
		$("#category").val(data.category);
		$("#ubah").show();
		$("#ModProduct").modal("show");
	}
	
	//Data Yang Di Tampilkan Pada Modal Ketika ingin Hapus Data
	function deleteProduct( id )
	{
		clearModals();

		$.ajax({
			type: "POST",

			url: siteUrl('crud-product/process/process-crud-product/delete'),

			dataType: 'json',
			data: {id:id},
			success: function(data) {

				$("#removeWarning").show();
				$("#myModalLabel").html("Hapus Data Product");		
				$("#id").val(data.id);				
				$("#name").val(data.name).attr("disabled","true");
				$("#slug").val(data.slug).attr("disabled","true");
				$("#category").val(data.category).attr("disabled","true");
				$("#hapus").show();
				$("#ModProduct").modal("show");
				
				//waitingDialog.hide();			
			}
		});
	}

	function submitAddProduct()
	{
		var formData = $("#formProduct").serialize();
		//waitingDialog.show();
		$.ajax({
			type:"POST",

			url: siteUrl('crud-product/process/process-crud-product/save'),

			data:formData,
			success:function(data){
				//waitingDialog.hide();			
				dTable.ajax.reload(); 
				$("#hasil").html(data);	
			}
		});
	}	

	function submiteditProduct()
	{
		var formData = $("#formProduct").serialize();
		//waitingDialog.show();
		$.ajax({
			type:"POST",

			url: siteUrl('crud-product/process/process-crud-product/update'),

			data:formData,
			success:function(data){
				//waitingDialog.hide();			
				dTable.ajax.reload(); 
				$("#hasil").html(data);	
			}
		});
	}

	function submitdelProduct()
	{
		var formData = $("#formProduct").serialize();
		//waitingDialog.show();
		$.ajax({
			type:"POST",
			url: siteUrl('crud-product/process/process-crud-product/delete'),
			data: formData,
			success:function(data){
				//waitingDialog.hide();			
				dTable.ajax.reload(); 
				$("#hasil").html(data);	
			}
		});
	}
		
	//Clear Modal atau menutup modal supaya tidak terjadi duplikat modal
	function clearModals()
	{
		$("#removeWarning").hide();
		$("#id").val("").removeAttr( "disabled" );
		$("#name").val("").removeAttr( "disabled" );
		$("#slug").val("").removeAttr( "disabled" );
		$("#category").val("").removeAttr( "disabled" );
		$("#simpan").hide();
		$("#ubah").hide();
		$("#hapus").hide();
	}
	
</script>
