			<?php
			$this->lang->load('ps', 'english');
			?>
			<ul class="breadcrumb">
				<li>
					<a href="<?php echo site_url() . "/dashboard";?>"><?php echo $this->lang->line('dashboard_label')?></a> 
					<span class="divider"></span>
				</li>
				<li>Liste Messages</li>
			</ul>
			
			
			<?php
			$attributes = array('class' => 'form-inline','method' => 'POST');
			echo form_open(site_url('inquiries/search'), $attributes);
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
			
			<?php echo form_close(); ?>
			
			<br/>
			
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
						<th><?php echo $this->lang->line('item_name_label')?></th>
						<th>Nom</th>
						<th><?php echo $this->lang->line('date_label')?></th>
						<th><?php echo $this->lang->line('detail_label')?></th>
						<?php if(in_array('delete',$allowed_accesses)):?>
						<th>Action</th>
						<?php endif;?>
					</tr>
					<?php
						if(!$count=$this->uri->segment(3))
							$count = 0;
						if(isset($inquiries) && count($inquiries->result())>0):
							foreach($inquiries->result() as $inquiry):					
					?>
					<tr>
						<td><?php echo $this->db->get_where('cd_items',array('id'=>$inquiry->station_id))->row()->name;?>
                            <?php if ($inquiry->is_read == 0): ?>
                                <span class="badge" style="background-color: red;">Non Lu</span>
                            <?php elseif ($inquiry->is_read == 1):?>
                                <span class="badge" style="background-color:grey;">Lu</span>
                            <?php else:?>
                                <span class="badge badge-warning">Warning</span>
                            <?php endif;?>

                        </td>
						<td><?php echo $this->db->get_where('be_users',array('user_id'=>$inquiry->user_id,'is_gerant'=>1))->row()->fullname;?></td>
						<td><?php echo time_ago($inquiry->added);?></td>
						<td><a href='<?php echo site_url('soaco_msg_vue/'.url_encode($inquiry->id));?>'>Voir</a></td>
						
						<?php if(in_array('delete',$allowed_accesses)):?>
						<td><a href='<?php echo site_url("inquiries/delete/".$inquiry->id);?>'><i class='glyphicon glyphicon-trash'></i></a></td>
						<?php endif;?>
					</tr>
						<?php
						endforeach;
						else:
						?>
					<tr>
						<td colspan='7'>
						<span class='glyphicon glyphicon-warning-sign menu-icon'></span>
						<?php echo $this->lang->line('no_inquiries_data_message')?>
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
