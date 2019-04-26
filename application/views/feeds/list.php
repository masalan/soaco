			<?php
				$this->lang->load('ps', 'english');
			?>
			<ul class="breadcrumb">
				<li><a href="<?php echo site_url() . "/dashboard";?>"><?php echo $this->lang->line('dashboard_label')?></a> <span class="divider"></span></li>
				<li>Liste de Gerants</li>
			</ul>
			
			<div class='row'>
				<div class='col-sm-9'>
					<?php
					$attributes = array('class' => 'form-inline');
					echo form_open(site_url('resultat/recherche'), $attributes);
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
					  	<button type="submit" class="btn btn-default"><?php echo $this->lang->line('search_button')?></button>
					</form>
				</div>	
				<div class='col-sm-3'>
					<a href='<?php echo site_url('gerants/add');?>' class='btn btn-primary pull-right'><span class='glyphicon glyphicon-plus'></span>
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
                    <th>Station Service</th>
                    <th>Rôle</th>
                    <th>Telephone</th>


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
                            <td><?php echo $this->db->get_where('cd_items' , array('id' => $feed->station_id))->row()->name; ?></td>
                            <td><?php echo $this->db->get_where('be_roles' , array('role_id' => $feed->role_id))->row()->role_desc; ?></td>
                            <td><?php echo $feed->phone;?></td>


                            <?php
								if(!$this->session->userdata('is_city_admin')) { 
									if(in_array('edit',$allowed_accesses)):?>
										<td><a href='<?php echo site_url("gerant/modifier/".url_encode($feed->user_id));?>'><i class='glyphicon glyphicon-edit'></i></a></td>
							<?php endif; } else { ?>
										<td><a href='<?php echo site_url("gerant/modifier/".url_encode($feed->user_id));?>'><i class='glyphicon glyphicon-edit'></i></a></td>
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
											
												<button class="btn btn-sm btn-primary unpublish"   
													feedId='<?php echo $feed->user_id;?>'>Oui
												</button>
											<?php else:?>
												<button class="btn btn-sm btn-danger publish"
												feedId='<?php echo $feed->user_id;?>'>Non</button>
											<?php endif;?>
										</td>
							<?php endif; } else {?>
										<td>
											<?php if($feed->status == 1):?>
												<button class="btn btn-sm btn-primary unpublish"   
													feedId='<?php echo $feed->user_id;?>'>Oui
												</button>
											<?php else:?>
												<button class="btn btn-sm btn-danger publish"
												feedId='<?php echo $feed->user_id;?>'>Non</button>
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
                                    Aucun Gerant de station disponible encore
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
			

