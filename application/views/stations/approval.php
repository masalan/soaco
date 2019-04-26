 			<?php $this->lang->load('ps', 'english'); ?>

			<ul class="breadcrumb">
				<li><a href="<?php echo site_url() . "/dashboard";?>"><?php echo $this->lang->line('dashboard_label')?></a> <span class="divider"></span></li>
				<li><?php echo $this->lang->line('cities_approval_list_label')?></li>
			</ul>
			
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
						<th>No</th>
						<th><?php echo $this->lang->line( 'city_name_label' ); ?></th>
						<th><?php echo $this->lang->line( 'username_label' ); ?></th>
						<th><?php echo $this->lang->line( 'detail_label' ); ?></th>
						<th><?php echo $this->lang->line( 'approve_label' ); ?></th>
					</tr>

					<?php if ( ! $count=$this->uri->segment( 3 )) $count = 0; ?>

					<?php if ( isset( $cities ) && count( $cities->result() ) > 0 ): ?>

						<?php foreach ( $cities->result() as $city ): ?>

						<tr>
							<td><?php echo ++$count; ?></td>
							<td><?php echo $city->name; ?></td>
							<td><?php echo $this->user->get_info( $city->admin_id )->user_name; ?></td>
							<td>
								<a href="<?php echo site_url( 'cities/detail/'. $city->id ); ?>">Detail</a>
							</td>
							<td>
								<button class="btn btn-sm btn-primary approve" 
								catId='<?php echo $city->id;?>'>Approve</button>
								<button class="btn btn-sm btn-primary reject" 
								catId='<?php echo $city->id;?>'>Reject</button>
							</td>
						</tr>

						<?php endforeach; ?>
					
					<?php else:?>

						<tr>
							<td colspan='7'>
							<span class='glyphicon glyphicon-warning-sign menu-icon'></span>
							<?php echo $this->lang->line('no_cat_data_message')?>
							</td>
						</tr>

					<?php endif; ?>

				</table>
			</div>

			<?php $this->pagination->initialize($pag); ?>
		
			<?php echo $this->pagination->create_links(); ?>

			<script>
			$(document).ready(function(){
				$(document).delegate('.approve','click',function(){
					var btn = $(this);
					var id = $(this).attr('catid');
					$.ajax({
						url: '<?php echo site_url('cities/approve');?>/'+id,
						method:'GET',
						success:function(msg){
							if ( msg == 'true' ) {
								btn.parent().html('Approved');
								btn.remove();
							} else if ( msg == 'email-error' ) {
								alert('System error occured in sending email');
							} else {
								alert('System error occured. Please contact your system administrator');
							}	
						}
					});
				});

				$(document).delegate('.reject','click',function(){
					var btn = $(this);
					var id = $(this).attr('catid');
					$.ajax({
						url: '<?php echo site_url('cities/reject');?>/'+id,
						method:'GET',
						success:function(msg){
							if ( msg == 'true' ) {
								btn.parent().html('Reject');
								btn.remove();
							} else if ( msg == 'email-error' ) {
								alert('System error occured in sending email');
							} else {
								alert('System error occured. Please contact your system administrator');
							}	
						}
					});
				});
			});
			</script>