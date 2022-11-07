<header class="page-header">
  <div class="container-fluid">
    <h2 class="no-margin-bottom">Film Details</h2>
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
				<a href="#add" data-toggle="modal" class="btn btn-primary btn-sm rounded-0 pull-right"><i class="fa fa-plus"></i> Add New Film</a>
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
							<td>Film Title</td>
							<td>Kode Film</td>
							<td>Launch Date</td>
							<td>Price</td>
							<td>Category</td>							
							<td>Author</td>							
							<td>Action</td>
						</tr></thead>
						<tbody style="background-color: white;">
						<?php $no=0; foreach ($get_film as $film) : $no++;?>

						<tr>
							<td><?=$no?></td>
							<td><?=$film->judul_film?></td>
							<td><?=$film->kd_film?></td>
							<!--<td><img src="<?=base_url('assets/gambar/'.$film->film_img)?>" style="width:40px"></td>-->
							<td><?=$film->tgl_launch?></td>
							<td>$<?=number_format($film->price)?></td>
							<td><?=$film->category_name?></td>							
							<td><?=$film->writer?></td>							
							<td class="text-center">
								<a href="#edit" onclick="edit('<?=$film->id?>')" class="btn btn-primary btn-sm rounded-0" data-toggle="modal"><i class="fa fa-pencil"></i></a>
								<a href="<?=base_url('index.php/film/hapus/'.$film->id)?>" onclick="return confirm('Are you sure to delete this film?')" class="btn btn-danger btn-sm rounded-0"><i class="fa fa-trash"></i></a>
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
					Add New film
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
					</button>
				</div>
				<form action="<?=base_url('index.php/film/add')?>" method="post" enctype="multipart/form-data">
					<div class="modal-body">
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>film Title</label></div>
							<div class="col-sm-7">
								<input type="text" name="film_title" required="form-control" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Year</label></div>
							<div class="col-sm-7">
								<input type="datetime-local" name="tgl_launch">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Price</label></div>
							<div class="col-sm-7">
								<input type="number" name="price" required="form-control" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Category</label></div>
							<div class="col-sm-7">
								<select name="category" required="form-control" class="form-control">
									<?php foreach ($category as $kat): ?>
										<option value="<?=$kat->category_code?>">
											<?=$kat->category_name ?>
										</option> 
									<?php endforeach ?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Cover Photo</label></div>
							<div class="col-sm-7">
								<input type="file" name="gambar" class="form-control">
							</div>
						</div>						
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Author</label></div>
							<div class="col-sm-7">
								<input type="text" name="writer" required="form-control" class="form-control">
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
					Update film
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
					</button>
				</div>
				<form action="<?=base_url('index.php/film/film_update')?>" method="post" enctype="multipart/form-data">
					<input type="hidden" name="film_code" id="film_code">
					<div class="modal-body">
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>film Title</label></div>
							<div class="col-sm-7">
								<input type="text" name="film_title" id="film_title" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Year</label></div>
							<div class="col-sm-7">
								<input type="datetime-local" name="tgl_launch" id="tgl_launch">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Price</label></div>
							<div class="col-sm-7">
								<input type="number" name="price" id="price" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Category</label></div>
							<div class="col-sm-7">
								<select name="category" id="category" class="form-control">
									<?php foreach ($category as $kat): ?>
										<option value="<?=$kat->category_code?>">
											<?=$kat->category_name ?>
										</option> <?php endforeach ?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>CoverPhoto</label></div>
							<div class="col-sm-7">
								<input type="file" name="gambar" id="gambar" class="form-control">
							</div>
						</div>						
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Author</label></div>
							<div class="col-sm-7">
								<input type="text" name="writer" id="writer" class="form-control">
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
			url:"<?=base_url()?>index.php/film/edit_film/"+a,
			dataType:"json",
			success:function(data){
				$("#film_code").val(data.id);
				$("#film_title").val(data.judul_film);
				$("#tgl_launch").val(data.tgl_launch);
				$("#price").val(data.price);
				$("#category").val(data.category_code);				
				$("#writer").val(data.writer);
			}
		});
	}
</script>
