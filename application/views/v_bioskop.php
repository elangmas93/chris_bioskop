<header class="page-header">
  <div class="container-fluid">
    <h2 class="no-margin-bottom">Bioskop Details</h2>
  </div>
</header>

<div class="table-agile-info">
	<div class="container-fluid my-3">
		<?php if ($this->session->flashdata('message')!=null) {
		echo "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>"
			.$this->session->flashdata('message')."<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
			<span aria-hidden='true'>&times;</span>
			</button> </div>";
		} ?>
		<br>
		<div class="card rounded-0 shadow">
			<div class="card-header">
				<a href="#add" data-toggle="modal" class="btn btn-primary btn-sm rounded-0 pull-right"><i class="fa fa-plus"></i> Add New bioskop</a>
			</div>
			<div class="card-body">
				<table class="table table-hover table-bordered" id="example" ui-options=ui-options="{
					&quot;paging&quot;: {
					&quot;enabled&quot;: true
					},
					&quot;filtering&quot;: {
					&quot;enabled&quot;: true
					},
					&quot;sorting&quot;: {
					&quot;enabled&quot;: true
					}}">
					<thead style="background-color: #464b58; color:white;">
						<tr>
							<td>#</td>
							<td>Kode bioskop</td>							
							<td>Nama bioskop</td>													
							<td>Kota</td>
							<td>Action</td>
						</tr></thead>
						<tbody style="background-color: white;">
						<?php $no=0; foreach ($get_bioskop as $bioskop) : $no++;?>

						<tr>
							<td><?=$no?></td>
							<td><?=$bioskop->kd_bioskop?></td>
							<td><?=$bioskop->nama_bioskop?></td>
							<td><?=$bioskop->kota?></td>
							<td class="text-center">
								<a href="#edit" onclick="edit('<?=$bioskop->id?>')" class="btn btn-primary btn-sm rounded-0" data-toggle="modal"><i class="fa fa-pencil"></i></a>
								<a href="<?=base_url('index.php/bioskop/hapus/'.$bioskop->id)?>" onclick="return confirm('Are you sure to delete this bioskop?')" class="btn btn-danger btn-sm rounded-0"><i class="fa fa-trash"></i></a>
							</td>
						</tr>
					<?php endforeach ?>					
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="modal" id="add">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					Add New bioskop
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
					</button>
				</div>
				<form action="<?=base_url('index.php/bioskop/add')?>" method="post" enctype="multipart/form-data">
					<div class="modal-body">
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>bioskop Title</label></div>
							<div class="col-sm-7">
								<input type="text" name="bioskop_title" required="form-control" class="form-control">
							</div>
						</div>	
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Alamat Bioskop</label></div>
							<div class="col-sm-7">
								<input type="text" name="alamat_bioskop" maxlength=255 required="form-control" class="form-control">
							</div>
						</div>														
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Kota</label></div>
							<div class="col-sm-7">
								<input type="text" name="kota" maxlength=255 required="form-control" class="form-control">
							</div>
						</div>						
					</div>
					<div class="modal-footer justify-content-end">
						<input type="submit" name="save" value="Save" class="btn btn-primary btn-sm rounded-0">
						<button type="button" class="btn btn-default btn-sm border rounded-0" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" id="edit">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					Update bioskop
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
					</button>
				</div>
				<form action="<?=base_url('index.php/bioskop/bioskop_update')?>" method="post" enctype="multipart/form-data">
					<input type="hidden" name="bioskop_code" id="bioskop_code">
					<div class="modal-body">
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>bioskop</label></div>
							<div class="col-sm-7">
								<input type="text" name="bioskop_title" id="bioskop_title" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Alamat Bioskop</label></div>
							<div class="col-sm-7">
								<input type="text" id="alamat_bioskop" name="alamat_bioskop" maxlength=255 required="form-control" class="form-control">
							</div>
						</div>														
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Kota</label></div>
							<div class="col-sm-7">
								<input type="text" id="kota" name="kota" maxlength=255 required="form-control" class="form-control">
							</div>
						</div>								
						
					</div>
					<div class="modal-footer justify-content-end">
						<input type="submit" name="save" value="Save" class="btn btn-primary btn-sm rounded-0">
						<button type="button" class="btn btn-default btn-sm border rounded-0" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
			
		</div>
	</div>
</div>


<script type="text/javascript">
	$(document).ready(function(){
			$('#example').DataTable();
		}
	);
	function edit(a) {
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/bioskop/edit_bioskop/"+a,
			dataType:"json",
			success:function(data){
				$("#bioskop_code").val(data.kd_bioskop);
				$("#bioskop_title").val(data.nama_bioskop);
				$("#alamat_bioskop").val(data.alamat_bioskop);
				$("#kota").val(data.kota);				
			}
		});
	}
</script>
