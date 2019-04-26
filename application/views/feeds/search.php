			<?php
				$this->lang->load('ps', 'english');
			?>
			<ul class="breadcrumb">
				<li><a href="<?php echo site_url() . "/dashboard";?>"><?php echo $this->lang->line('dashboard_label')?></a> <span class="divider"></span></li>
				<li><a href="<?php echo site_url('feeds');?>">Liste de Gerants</a> <span class="divider"></span></li>
				<li>Resultat de Recherche</li>
			</ul>
			
			<div class='row'>
				<div class='col-sm-9'>
					<?php
					$attributes = array('class' => 'form-inline');
					echo form_open(site_url('feeds/search'), $attributes);
					?>
						<div class="form-group">
					   	<?php 
					   		echo form_input( array(
					   			'type' => 'text',
					   			'name' => 'searchterm',
					   			'id' => '',
					   			'class' => 'form-control',
					   			'placeholder' => 'Search',
					   			'value' => html_entity_decode( $searchterm )
					   		));
					   	?>
					  	</div>
					  	<button type="submit" class="btn btn-default">Rechercher</button>
					  	<a href='<?php echo site_url('feeds');?>' class="btn btn-default">Effacer</a>
					</form>
				</div>	
				<div class='col-sm-3'>
					<a href='<?php echo site_url('feeds/add');?>' class='btn btn-primary pull-right'><span class='glyphicon glyphicon-plus'></span>
                        Ajoute Nouveau Gerant</a>
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
                    <th>Nom Complet</th>
					
					<?php 
						if(!$this->session->userdata('is_city_admin')) { 
							if(in_array('edit',$allowed_accesses)):?>
								<th><?php echo $this->lang->line('edit_label')?></th>
					<?php endif; } else {?>
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
					if(isset($feeds) && count($feeds->result())>0):
						foreach($feeds->result() as $feed):					
				?>
						<tr>
							<td><?php echo ++$count;?></td>
							<td><?php echo $feed->fullname;?></td>
							
							<?php 
								if(!$this->session->userdata('is_city_admin')) { 
									if(in_array('edit',$allowed_accesses)):?>
										<td><a href='<?php echo site_url("feeds/edit/".$feed->user_id);?>'><i class='glyphicon glyphicon-edit'></i></a></td>
							<?php endif; } else { ?>
										<td><a href='<?php echo site_url("feeds/edit/".$feed->user_id);?>'><i class='glyphicon glyphicon-edit'></i></a></td>
							<?php } ?>
							
							
							<?php 
								if(!$this->session->userdata('is_city_admin')) { 
									if(in_array('delete',$allowed_accesses)):?>
									<td><a href='<?php echo site_url("feeds/delete/".$feed->user_id);?>'><i class='glyphicon glyphicon-trash'></i></a></td>
							<?php endif; } else {?>
									<td><a href='<?php echo site_url("feeds/delete/".$feed->user_id);?>'><i class='glyphicon glyphicon-trash'></i></a></td>
							<?php } ?>
							
							<?php 
								if(!$this->session->userdata('is_city_admin')) { 
									if(in_array('publish',$allowed_accesses)):?>
										<td>
											<?php if($feed->status == 1):?>
											
												<button class="btn btn-sm btn-primary publish"   
													feedId='<?php echo $feed->user_id;?>'>OUI
												</button>
												
											<?php else:?>
											
												<button class="btn btn-sm btn-danger unpublish"
												feedId='<?php echo $feed->user_id;?>'>NON</button>
											
											<?php endif;?>
										</td>
							<?php endif; } else {?>
										<td>
											<?php if($feed->status == 1):?>
											
												<button class="btn btn-sm btn-primary publish"   
													feedId='<?php echo $feed->user_id;?>'>OUI
												</button>
												
											<?php else:?>
											
												<button class="btn btn-sm btn-danger unpublish"
												feedId='<?php echo $feed->user_id;?>'>NON</button>
											
											<?php endif;?>
										</td>
							<?php } ?>
						</tr>
						<?php
						endforeach;
					else:
				?>
						<tr>
							<td colspan='7'>
							<span class='glyphicon glyphicon-warning-sign menu-icon'></span>
							<?php echo $this->lang->line('no_sub_cat_data_message')?>
							</td>
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
					var id = $(this).attr('feedId');
					
					$.ajax({
						url: '<?php echo site_url('feeds/publish');?>/'+id,
						method:'GET',
						success:function(msg){
							if(msg == 'true')
								btn.addClass('unpublish').addClass('btn-primary')
									.removeClass('publish').removeClass('btn-danger')
									.html('OUI');
							else
                                alert('Une erreur système s\'est produite. Veuillez contacter votre administrateur système.');
						}
					});
				});
				
				$(document).delegate('.unpublish','click',function(){
					
					var btn = $(this);
					var id = $(this).attr('feedId');
					
					$.ajax({
						url: '<?php echo site_url('feeds/unpublish');?>/'+id,
						method:'GET',
						success:function(msg){
							if(msg == 'true')
								btn.addClass('publish').addClass('btn-danger')
									.removeClass('unpublish').removeClass('btn-primary')
									.html('NON');
							else
                                alert('Une erreur système s\'est produite. Veuillez contacter votre administrateur système.');
						}
					});
				});
			});
			</script>
