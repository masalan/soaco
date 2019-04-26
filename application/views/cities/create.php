			<?php
			$this->lang->load('ps', 'english');
			?>
			<ul class="breadcrumb">
				<li><a href="<?php echo site_url('cities');?>"><?php echo $this->lang->line('cities_list_label')?></a> <span class="divider"></span></li>
				<li><?php echo $this->lang->line('city_info_label')?></li>
			</ul>
		
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
			
			<?php
			$attributes = array('id' => 'city-form','enctype' => 'multipart/form-data');
			echo form_open(site_url("cities/create"), $attributes);
			?>
				<div class="row">
					
							 <div class="col-sm-6">
							 	
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
						 			<label><?php echo $this->lang->line('address_label')?>
						 				<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('city_location_tooltips')?>">
						 					<span class='glyphicon glyphicon-info-sign menu-icon'>
						 				</a>
						 			</label>
						 			<textarea class="form-control" name="address" placeholder="Location" rows="3"></textarea>
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
							 
							 <div class="col-sm-6">
							 	
							 		<div class="form-group">
							 	        <label><?php echo $this->lang->line('find_location_label')?>
							 	        	<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('find_location_tooltips')?>">
							 	        		<span class='glyphicon glyphicon-info-sign menu-icon'>
							 	        	</a>
							 	        </label><br>
							 	
							 	        <?php 
							 	        	echo form_input( array(
							 	        		'type' => 'text',
							 	        		'name' => 'find_location',
							 	        		'id' => 'find_location',
							 	        		'class' => 'form-control',
							 	        		'placeholder' => 'Type & Find Location',
							 	        		'value' => ''
							 	        	));
							 	        ?>
							 	    </div>
							 	    
							 	    <div id="us3" style="width: 550px; height: 300px;"></div>
							 	    <div class="clearfix">&nbsp;</div>
							 	    <div class="m-t-small">
							 	        <div class="form-group">
							 		        <label><?php echo $this->lang->line('city_lat_label')?>
							 		        	<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('city_lat_tooltips')?>">
							 		        		<span class='glyphicon glyphicon-info-sign menu-icon'>
							 		        	</a>
							 		        </label>
							 				<br>
							 		        <?php 
							 		        	echo form_input( array(
							 		        		'type' => 'text',
							 		        		'name' => 'lat',
							 		        		'id' => 'lat',
							 		        		'class' => 'form-control',
							 		        		'placeholder' => '',
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
							 		        		'placeholder' => '',
							 		        		'value' => ''
							 		        	));
							 		        ?>
							 	        </div>
							 	    </div>
							 	
							 </div>
						</div>
				<hr/>
				
				<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('save_button')?></button>
				
				<a href="<?php echo site_url('cities');?>" class="btn btn-primary"><?php echo $this->lang->line('cancel_button')?></a>
			</form>
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
						email: {
							required: true,
							email: true
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
						email: {
							email: "Email format is wrong.",
							required : "Please Fill Email."
						}
					}
				});	
				
				$('#us3').locationpicker({
				    location: {latitude: 0.0, longitude: 0.0},
				    radius: 300,
				    inputBinding: {
				        latitudeInput: $('#lat'),
				        longitudeInput: $('#lng'),
				        radiusInput: $('#us3-radius'),
				        locationNameInput: $('#find_location')
				    },
				    enableAutocomplete: true,
				    onchanged: function (currentLocation, radius, isMarkerDropped) {
				        // Uncomment line below to show alert on each Location Changed event
				        //alert("Location changed. New location (" + currentLocation.latitude + ", " + currentLocation.longitude + ")");
				    }
				});
			</script>