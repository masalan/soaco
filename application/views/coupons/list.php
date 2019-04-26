			<?php
				$this->lang->load('ps', 'english');
			?>
			<ul class="breadcrumb">
				<li><a href="<?php echo site_url() . "/dashboard";?>"><?php echo $this->lang->line('dashboard_label')?></a> <span class="divider"></span></li>
				<li><?php echo $this->lang->line('cat_list_label')?></li>
			</ul>
			
			<div class='row'>
				<div class='col-sm-9'>
					<?php
					$attributes = array('class' => 'form-inline');
					echo form_open(site_url('coupons/search'), $attributes);
					?>
						<div class="form-group">
					   	<?php 
					   		echo form_input( array(
					   			'type' => 'text',
					   			'name' => 'searchterm',
					   			'id' => '',
					   			'class' => 'form-control',
					   			'placeholder' => 'Search',
					   			'value' => ''
					   		));
					   	?>
					  	</div>
					  	<button type="submit" class="btn btn-default"><?php echo $this->lang->line('search_button')?></button>
					</form>
				</div>	
				<div class='col-sm-3'>
					<a href='<?php echo site_url('coupons/add');?>' class='btn btn-primary pull-right'><span class='glyphicon glyphicon-plus'></span>
					<?php echo $this->lang->line('add_new_cat_button')?></a>
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
                    <th>Nom carte</th>
                    <th>Numero de Serie</th>
                    <th>Fournisseur</th>
                    <th>Montant</th>
                    <th>Propriétaire</th>

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
					if(isset($categories) && count($categories->result())>0):
						foreach($categories->result() as $category):					
				?>
						<tr>
							<td><?php echo ++$count;?></td>
							<td><?php echo $category->name;?></td>
                            <td><?php echo $category->card_serial;?></td>
                            <td><?php echo $this->db->get_where('be_users',array('user_id'=>$category->company_id))->row()->fullname;?></td>

                            <td><?php echo $category->initial_moeny.$this->db->get_where('cd_currencies',array('id'=>$category->currency_id))->row()->code;?></td>
                            <td><?php echo $category->username;?></td>

                            <?php
								if(!$this->session->userdata('is_city_admin')) { 
									if(in_array('edit',$allowed_accesses)):?>
										<td><a href='<?php echo site_url("coupons/edit/".url_encode($category->id));?>'><i class='glyphicon glyphicon-edit'></i></a></td>
							<?php endif; } else { ?>
										<td><a href='<?php echo site_url("coupons/edit/".url_encode($category->id));?>'><i class='glyphicon glyphicon-edit'></i></a></td>
							<?php } ?>
							
							<?php 
								if(!$this->session->userdata('is_city_admin')) { 
									if(in_array('delete',$allowed_accesses)):?>
										<td><a class='btn-delete' data-toggle="modal" data-target="#myModal" id="<?php echo $category->id;?>"><i class='glyphicon glyphicon-trash'></i></a></td>
							<?php endif; } else { ?>
										<td><a class='btn-delete' data-toggle="modal" data-target="#myModal" id="<?php echo $category->id;?>"><i class='glyphicon glyphicon-trash'></i></a></td>
							<?php } ?>
							
							<?php 
								if(!$this->session->userdata('is_city_admin')) {
									if(in_array('publish',$allowed_accesses)):?>
										<td>
											<?php if($category->is_published == 1):?>
												<button class="btn btn-sm btn-primary unpublish" 
												catId='<?php echo $category->id;?>'>OUI</button>
											<?php else:?>
												<button class="btn btn-sm btn-danger publish" 
												catId='<?php echo $category->id;?>'>NON</button><?php endif;?>
										</td>
							<?php endif; } else { ?>
										<td>
											<?php if($category->is_published == 1):?>
												<button class="btn btn-sm btn-primary unpublish" 
												catId='<?php echo $category->id;?>'>OUI</button>
											<?php else:?>
												<button class="btn btn-sm btn-danger publish" 
												catId='<?php echo $category->id;?>'>NON</button><?php endif;?>
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
							     Aucune sous-zone disponible disponible encore
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
					var id = $(this).attr('catid');
					$.ajax({
						url: '<?php echo site_url('coupons/publish');?>/'+id,
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
					var id = $(this).attr('catid');
					$.ajax({
						url: '<?php echo site_url('coupons/unpublish');?>/'+id,
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
				
				$('.btn-delete').click(function(){
					var id = $(this).attr('id');
					var btnYes = $('.btn-yes').attr('href');
					var btnNo = $('.btn-no').attr('href');
					$('.btn-yes').attr('href',btnYes+"/"+ id);
					$('.btn-no').attr('href',btnNo+"/"+ id);
				});
			});
			</script>
			
			<div class="modal fade"  id="myModal">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Ferme</span></button>
							<h4 class="modal-title">Suppression de la Commune</h4>
						</div>
						<div class="modal-body">
							<p>Voudriez-vous supprimer toutes les stations associe a cette communes?</p>
							<p>Oui Tous- Communes et toutes les stations seront supprimer de ce systeme</p>
							<p>Seulement Commune- La Communes sera supprimer de ce systeme</p>
						</div>
						<div class="modal-footer">
							<a type="button" class="btn btn-primary btn-yes" href='<?php echo site_url("coupons/delete_items/");?>'>
							Oui Tous</a>
							<a type="button" class="btn btn-primary btn-no" href='<?php echo site_url("coupons/delete/");?>'>
							Seulement le Nom de la Commune</a>
							<a type="button" class="btn btn-primary" data-dismiss="modal">
							<?php echo $this->lang->line('cancel_button')?></a>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
