<header class="page-header">
  <div class="container-fluid">
    <h2 class="no-margin-bottom">tayang Details</h2>
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
				<a href="#add" data-toggle="modal" class="btn btn-primary btn-sm rounded-0 pull-right"><i class="fa fa-plus"></i> Add New tayang</a>
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
							<td>Kode Tayang</td>							
							<td>Launch Date</td>													
							<td>Action</td>
						</tr></thead>
						<tbody style="background-color: white;">
						<?php $no=0; foreach ($get_tayang as $tayang) : $no++;
						$date = new DateTime($tayang->waktu_tayang);
						$date=$date->format("d-m-Y H:i");
						?>

						<tr>
							<td><?=$no?></td>
							<td><?=$tayang->kd_tayang?></td>
							<td><?=$date?></td>
							<td class="text-center">
								<!--<a href="#edit" onclick="edit('<?=$tayang->id?>')" class="btn btn-primary btn-sm rounded-0" data-toggle="modal"><i class="fa fa-pencil"></i></a>-->
								<a href="<?=base_url('index.php/tayang/hapus/'.$tayang->id)?>" onclick="return confirm('Are you sure to delete this tayang?')" class="btn btn-danger btn-sm rounded-0"><i class="fa fa-trash"></i></a>
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
					Add New tayang
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
					</button>
				</div>
				<form action="<?=base_url('index.php/tayang/add')?>" method="post" enctype="multipart/form-data">
					<div class="modal-body">
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Tanggal Tayang</label></div>
							<div class="col-sm-7">
								<input type="datetime-local" id="tgl_launch" name="tgl_launch" value="<?php echo date('Y-m-d\TH:i:s'); ?>">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Bioskop</label></div>
							<div class="col-sm-7">
								<select name="bioskop" required="form-control" class="form-control">
									<?php foreach ($bioskop as $kat): ?>
										<option value="<?=$kat->kd_bioskop.'~'.$kat->nama_bioskop.'~'.$kat->id?>">
											<?=$kat->nama_bioskop ?>
										</option> 
									<?php endforeach ?>
								</select>
							</div>
						</div>						
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Film</label></div>
							<div class="col-sm-7">
								<select name="film" required="form-control" class="form-control">
									<?php foreach ($film as $kat): ?>
										<option value="<?=$kat->kd_film.'~'.$kat->judul_film.'~'.$kat->id?>">
											<?=$kat->judul_film ?>
										</option> 
									<?php endforeach ?>
								</select>
							</div>
						</div>												
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Jumlah Kursi</label></div>
							<div class="col-sm-7">
								<input type="number" name="jml_kursi" required="form-control" class="form-control">
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
					Update tayang
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
					</button>
				</div>
				<form action="<?=base_url('index.php/tayang/tayang_update')?>" method="post" enctype="multipart/form-data">
					<input type="hidden" name="tayang_code" id="tayang_code">
					<div class="modal-body">
					<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Tanggal Tayang</label></div>
							<div class="col-sm-7">
								<input type="datetime-local" id="tgl_launch" name="tgl_launch" value="<?php echo date('Y-m-d\TH:i:s'); ?>">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Bioskop</label></div>
							<div class="col-sm-7">
								<select name="bioskop" required="form-control" class="form-control">
									<?php foreach ($bioskop as $kat): ?>
										<option value="<?=$kat->kd_bioskop.'~'.$kat->nama_bioskop.'~'.$kat->id?>">
											<?=$kat->nama_bioskop ?>
										</option> 
									<?php endforeach ?>
								</select>
							</div>
						</div>						
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Film</label></div>
							<div class="col-sm-7">
								<select name="film" required="form-control" class="form-control">
									<?php foreach ($film as $kat): ?>
										<option value="<?=$kat->kd_film.'~'.$kat->judul_film.'~'.$kat->id?>">
											<?=$kat->judul_film ?>
										</option> 
									<?php endforeach ?>
								</select>
							</div>
						</div>												
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Jumlah Kursi</label></div>
							<div class="col-sm-7">
								<input type="number" name="jml_kursi" required="form-control" class="form-control">
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
			url:"<?=base_url()?>index.php/tayang/edit_tayang/"+a,
			dataType:"json",
			success:function(data){
				$("#tayang_code").val(data.tayang_code);
				$("#tayang_title").val(data.tayang_title);
				$("#tgl_launch").val(data.tgl_launch);
			}
		});
	}
</script>
