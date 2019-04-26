			<?php
				$this->lang->load('ps', 'english');
			?>
			<ul class="breadcrumb">
				
				<?php 
					if($this->session->userdata('is_city_admin')) { ?>
							<li><a href="<?php echo site_url() . "/dashboard/index/" . $this->session->userdata('allow_city_id');?>"><?php echo $this->lang->line('dashboard_label')?></a> <span class="divider"></span></li>
				<?php } else { ?>
							<li><a href="<?php echo site_url() . "/dashboard";?>"><?php echo $this->lang->line('dashboard_label')?></a> <span class="divider"></span></li>
				<?php } ?>
				<li>Liste Stations</li>
			</ul>
			
			<div class='row'>
				<div class='col-sm-9'>
					<?php
					$attributes = array('class' => 'form-inline');
					echo form_open(site_url('recherche/station'), $attributes);
					?>
						<div class="form-group">
					   	<?php 
					   		echo form_input( array(
					   			'type' => 'text',
					   			'name' => 'searchterm',
					   			'id' => '',
					   			'class' => 'form-control',
					   			'placeholder' => $this->lang->line('search_message'),
					   			'value' => ''
					   		));
					   	?>
					  	</div>
					  	
					  	<div class="form-group">
							<select class="form-control" name="cat_id" id="cat_id">
				  				<option value="0"><?php echo $this->lang->line('select_cat_message')?></option>
				  				<?php 
				  				foreach($this->category->get_all($this->city->get_current_city()->id)->result() as $category){
				  					echo "<option value='".$category->id."'>".$category->name."</option>";	
				  				}
				  				?>
				  			</select>
					  	</div>
					  	
					  	<div class="form-group">
					  		<select class="form-control" name="sub_cat_id" id="sub_cat_id">
						  		<option value="0"><?php echo $this->lang->line('select_sub_cat_message')?></option>
						  		<?php 
						  		foreach($this->sub_category->get_all($this->city->get_current_city()->id)->result() as $sub_category){
						  			echo "<option value='".$sub_category->id."'>".$sub_category->name."</option>";	
						  		}
						  		?>
					  		</select>
					  	</div>
					  	
					  	<button type="submit" class="btn btn-default"><?php echo $this->lang->line('search_button')?></button>
					</form>
				</div>	
				<div class='col-sm-3'>
					<a href='<?php echo site_url('ajoute/station');?>' class='btn btn-primary pull-right'><span class='glyphicon glyphicon-plus'></span>
					Ajoute Station</a>
				</div>
			</div>
			
			<br/>
			
			<!-- Message -->
			<?php if($this->session->flashdata('success')): ?>
				<div class="alert alert-success fade in">
					<?php echo $this->session->flashdata('success');?>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				</div>
			<?php elseif($this->session->flashdata('error')):?>
				<div class="alert alert-danger fade in">
					<?php echo $this->session->flashdata('error');?>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				</div>
			<?php endif;?>
			 <div class="wrapper wrapper-content animated fadeInRight">
			<table class="table table-striped table-bordered">
				<tr>
					<th><?php echo $this->lang->line('no_label')?></th>
					<th>Nom</th>
					<th><?php echo $this->lang->line('category_name_label')?></th>
					<th><?php echo $this->lang->line('sub_category_name_label')?></th>
                    <th>Quartier</th>

                    <?php
						if(!$this->session->userdata('is_city_admin')) { 
							if(in_array('edit',$allowed_accesses)):?>
								<th><?php echo $this->lang->line('edit_label')?></th>
					<?php endif; } else { ?>
								<th><?php echo $this->lang->line('edit_label')?></th>
					<?php } ?>
					
					<?php 
						if(!$this->session->userdata('is_city_admin')) { 
							if(in_array('delete',$allowed_accesses)):?>
							<th><?php echo $this->lang->line('delete_label')?></th>
					<?php endif; } else { ?>
							<th><?php echo $this->lang->line('delete_label')?></th>
					<?php } ?>
										
					<?php 
						if(!$this->session->userdata('is_city_admin')) { 	
							if(in_array('publish',$allowed_accesses)):?>
                                <th>Actif</th>
					<?php endif; } else { ?>
								<th>Actif</th>
					<?php } ?>
				</tr>
				<?php
					if(!$count=$this->uri->segment(3))
						$count = 0;
					if(isset($items) && count($items->result())>0):
						foreach($items->result() as $item):					
				?>
						<tr>
							<td><?php echo ++$count;?></td>
							<td><?php echo $item->name;?></td>
							<td><?php echo $this->category->get_info($this->sub_category->get_info($item->sub_cat_id)->cat_id)->name;?></td>
							<td><?php echo $this->sub_category->get_info($item->sub_cat_id)->name;?></td>
                            <td><?php echo $this->sub_category->get_info_quartier($item->twon_id)->name;?></td>

                            <?php
								if(!$this->session->userdata('is_city_admin')) { 
									if(in_array('edit',$allowed_accesses)):?>
										<td><a href='<?php echo site_url("modifier/station/".url_encode($item->id));?>'><i class='glyphicon glyphicon-edit'></i></a></td>
							<?php endif; } else { ?>
										<td><a href='<?php echo site_url("items/edit/".url_encode($item->id));?>'><i class='glyphicon glyphicon-edit'></i></a></td>
							<?php } ?>
							
							
							<?php 
								if(!$this->session->userdata('is_city_admin')) { 
									if(in_array('delete',$allowed_accesses)):?>
										<td><a href='<?php echo site_url("items/delete/".$item->id);?>'><i class='glyphicon glyphicon-trash'></i></a></td>
							<?php endif; } else { ?>
										<td><a href='<?php echo site_url("items/delete/".$item->id);?>'><i class='glyphicon glyphicon-trash'></i></a></td>
							<?php } ?>	
						
							
							<?php 
								if(!$this->session->userdata('is_city_admin')) { 
									if(in_array('publish',$allowed_accesses)):?>
										<td>
											<?php if($item->is_published == 1):?>
											
												<button class="btn btn-sm btn-primary unpublish"   
													itemId='<?php echo $item->id;?>'>OUI
												</button>
												
											<?php else:?>
											
												<button class="btn btn-sm btn-danger publish"
												itemId='<?php echo $item->id;?>'>NON</button>
											
											<?php endif;?>
										</td>
							<?php endif; } else { ?>
										<td>
											<?php if($item->is_published == 1):?>
											
												<button class="btn btn-sm btn-primary unpublish"   
													itemId='<?php echo $item->id;?>'>OUI
												</button>
												
											<?php else:?>
											
												<button class="btn btn-sm btn-danger publish"
												itemId='<?php echo $item->id;?>'>NON</button>
											
											<?php endif;?>
										</td>
							<?php } ?>
						</tr>
						<?php
						endforeach;
					else:
				?>
						<tr>
							<td colspan='7'>  Aucune Stations disponible encore</td>
						</tr>
				<?php
					endif;
				?>
			</table>
			</div>
			
			<?php 
				$this->pagination->initialize($pag);
				echo $this->pagination->create_links();
			?>

			<script>
			$(document).ready(function(){
				$(document).delegate('.publish','click',function(){
					
					var btn = $(this);
					var id = $(this).attr('itemId');
					
					$.ajax({
						url: '<?php echo site_url('items/publish');?>/'+id,
						method:'GET',
						success:function(msg){
							if(msg == 'true')
								btn.addClass('unpublish').addClass('btn-primary')
									.removeClass('publish').removeClass('btn-danger')
									.html('OUI');
							else
								alert('System error occured. Please contact your system administrator.');
						}
					});
				});
				
				$(document).delegate('.unpublish','click',function(){
					
					var btn = $(this);
					var id = $(this).attr('itemId');
					
					$.ajax({
						url: '<?php echo site_url('items/unpublish');?>/'+id,
						method:'GET',
						success:function(msg){
							if(msg == 'true')
								btn.addClass('publish').addClass('btn-danger')
									.removeClass('unpublish').removeClass('btn-primary')
									.html('NON');
							else
								alert('System error occured. Please contact your system administrator.');
						}
					});
				});
				
				$('#cat_id').change(function(){
					var catId = $(this).val();
					$.ajax({
						url: '<?php echo site_url('items/get_sub_cats');?>/'+catId,
						method: 'GET',
						dataType: 'JSON',
						success:function(data){
							$('#sub_cat_id').html("");
							$.each(data, function(i, obj){
							    $('#sub_cat_id').append('<option value="'+ obj.id +'">' + obj.name + '</option>');
							});
							$('#name').val($('#name').val() + " ").blur();
						}
					});
				});
				
			});
			</script>

