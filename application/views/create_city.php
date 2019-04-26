<?php $this->lang->load('ps', 'english'); ?>

<?php $this->load->view('templates/theme/header');?>

<div class="navbar navbar-fixed-top" role="navigation">
	<div class="container-fluid">
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li>
					<a class="navbar-brand" href="<?php echo site_url(); ?>"><?php echo $this->lang->line('site_title')?></a>
				</li>
			</ul>
			
		</div>
	</div>
</div>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 main teamps-sidebar-push">

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

			<div class="col-md-12">
				<p class="page-header"><?php echo $this->lang->line('paypal_feature_only_on_server'); ?></p>
			</div>
			
			<?php
			$attributes = array('id' => 'city-form','enctype' => 'multipart/form-data');
			echo form_open(site_url("theme/create_city"), $attributes);
			?>
				<div class="row">
					
					<ul id="myTab" class="nav nav-tabs">
					   <li class="active"><a href="#cityinfo" data-toggle="tab"><?php echo $this->lang->line('city_user_title')?></a></li>
					</ul>
					
					<div id="myTabContent" class="tab-content">
						<div class="tab-pane fade in active" id="cityinfo">

							<div class="row">

								<div class="col-md-6">

									<br>
									<div class="form-group">
										<label><?php echo $this->lang->line('name_label'); ?>
											<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('city_name_tooltips')?>">
												<span class='glyphicon glyphicon-info-sign menu-icon'>
											</a>
										</label>
										<?php 
											echo form_input( array(
												'type' => 'text',
												'name' => 'name',
												'id' => 'name',
												'class' => 'form-control',
												'placeholder' => 'Name',
												'value' => ''
											));
										?>
									</div>
									
									<div class="form-group">
										<label><?php echo $this->lang->line('description_label')?>
											<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('city_desc_tooltips')?>">
												<span class='glyphicon glyphicon-info-sign menu-icon'>
											</a>
										</label>
										<textarea class="form-control" name="description" placeholder="Description" rows="9"></textarea>
									</div>
										
									<div class="form-group">
										<label><?php echo $this->lang->line('location_label')?>
											<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('city_location_tooltips')?>">
												<span class='glyphicon glyphicon-info-sign menu-icon'>
											</a>
										</label>
										<textarea class="form-control" name="address" placeholder="Location" rows="5"></textarea>
									</div>
								</div>

								<div class="col-md-6">
									<br/>
									<div class="form-group">
										<label><?php echo $this->lang->line('city_lat_label')?>
											<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('city_lat_tooltips')?>">
												<span class='glyphicon glyphicon-info-sign menu-icon'>
											</a>
										</label><br>
										<?php 
											echo form_input( array(
												'type' => 'text',
												'name' => 'lat',
												'id' => 'lat',
												'class' => 'form-control',
												'placeholder' => 'Latitude',
												'value' => ''
											));
										?>
									</div>
									
									<div class="form-group">
										<label><?php echo $this->lang->line('city_lng_label')?>
											<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('city_lng_tooltips')?>">
												<span class='glyphicon glyphicon-info-sign menu-icon'>
											</a>
										</label><br>
										<?php 
											echo form_input( array(
												'type' => 'text',
												'name' => 'lng',
												'id' => 'lng',
												'class' => 'form-control',
												'placeholder' => 'Longitude',
												'value' => ''
											));
										?>
									</div>
									
									<div class="form-group">
										<label><?php echo $this->lang->line('city_cover_photo_label')?>
											<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('city_photo_tooltips')?>">
												<span class='glyphicon glyphicon-info-sign menu-icon'>
											</a>
										</label> 
										<br>
										<?php echo $this->lang->line('city_image_recommended_size')?>
										<input class="btn" type="file" name="images1">
										<br/>
										<label><?php echo $this->lang->line('photo_desc_label')?> 
											<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('city_photo_desc_tooltips')?>">
											<span class='glyphicon glyphicon-info-sign menu-icon'>
											</a></label>
										<textarea class="form-control" name="image_desc" rows="9"></textarea>
									</div>
								</div>
							</div>

							<hr/>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label><?php echo $this->lang->line('username_label')?></label>
										<?php 
											echo form_input( array(
												'type' => 'text',
												'name' => 'user_name',
												'id' => 'user_name',
												'class' => 'form-control',
												'placeholder' => 'Username',
												'value' => ''
											));
										?>
									</div>
									
									<div class="form-group">
										<label><?php echo $this->lang->line('email_label')?></label>
										<?php 
											echo form_input( array(
												'type' => 'text',
												'name' => 'user_email',
												'id' => 'user_email',
												'class' => 'form-control',
												'placeholder' => 'Email',
												'value' => ''
											));
										?>
									</div>
									
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label><?php echo $this->lang->line('password_label')?></label>
										<input class="form-control" type="password" placeholder="Password" name='user_password' id='user_password'>
									</div>
												
									<div class="form-group">
										<label><?php echo $this->lang->line('confirm_password_label')?></label>
										<input class="form-control" type="password" placeholder="Confirm Password" name='conf_password' id='conf_password'>
									</div>
								</div>
							</div>
						</div>
				   </div>		
				</div>
				
				<hr/>
				
				<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('register_payment_button')?></button>
				
				<a href="<?php echo site_url('cities');?>" class="btn btn-primary"><?php echo $this->lang->line('cancel_button')?></a>
			</form>
		
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		$(function () { $("[data-toggle='tooltip']").tooltip(); });
	});
	
	$('#city-form').validate({
		rules:{
			name:{
				required: true
			},
			description:{
				required : true
			},
			lat:{
				required : true
			},
			lng:{
				required : true
			},
			user_name:{
				required: true,
				minlength: 4,
				remote: '<?php echo site_url("theme/exists");?>'
			},
			user_email:{
				required: true,
				email: true
			},
			user_password:{
				required: true,
				minlength: 4
			},
			conf_password:{
				required: true,
				equalTo: '#user_password'
			}
		},
		messages:{
			name:{
				required: "Please Fill City Name."
			},
			description:{
				required: "Please Fill City Description."
			},
			lat:{
				required: "Please Fill City Lattitude."
			},
			lng:{
				required: "Please Fill City Longitude."
			},
			user_name:{
				required: "Please Fill Username.",
				minlength: "The length of username must be greater than 4",
				remote: "Username is already existed in the system"
			},
			user_email:{
				required: "Please Fill Email Address",
				email: "Please provide valid email address"
			},
			user_password:{
				required: "Please Fill User Password.",
				minlength: "The length of password must be greater than 4"
			},
			conf_password:{
				required: "Please Fill Confirm Password",
				equalTo: "Password and Confirm Password do not match."
			}
		}
	});
</script>

<?php $this->load->view('templates/theme/footer');?>