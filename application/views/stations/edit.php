	<?php
	$this->lang->load('ps', 'english');
	?>
	<ul class="breadcrumb">
		<li><a href="<?php echo site_url('dashboard');?>"><?php echo $this->lang->line('dashboard_label')?></a> <span class="divider"></span></li>
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
	$attributes = array('id' => 'city-form');
	echo form_open(site_url("cities/edit/".$city->id), $attributes);
	?>
		<div class="row">
						
			      <div class="col-sm-6">
			      	<div class="form-group">
                            <label>Nom de la Station (<small>Département:</small>  <?php
                                if ($this->session->userdata('city_id') != "") {
                                    if (isset($mode) && $mode) {
                                        ?>
                                        <a href="<?php echo site_url("stations") ?>">
                                            <?php echo "Les Stations";?>
                                            <span class='fa fa-dashboard'></span>
                                        </a>
                                        <?php
                                    } else {
                                        ?>
                                        <a href="<?php echo site_url("stations") ?>">
                                            <?php echo $this->city->get_current_city()->name;?>
                                            <span class='fa fa-edit'></span>
                                        </a>
                                        <?php
                                    }
                                }
                                ?> )
			      			<a href="#" class="tooltip-ps" data-toggle="tooltip" title="Entrer un nom nomminatif de la stations ou Son Commercial">
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
			      				'value' => html_entity_decode( $city->name )
			      			));
			      		?>
			      	</div>

                      <div class="form-group">
                          <label>Adresse de la Station (<small>Département:</small>  <?php
                              if ($this->session->userdata('city_id') != "") {
                                  if (isset($mode) && $mode) {
                                      ?>
                                      <a href="<?php echo site_url("stations") ?>">
                                          <?php echo "Les Stations";?>
                                          <span class='fa fa-dashboard'></span>
                                      </a>
                                      <?php
                                  } else {
                                      ?>
                                      <a href="<?php echo site_url("stations") ?>">
                                          <?php echo $this->city->get_current_city()->name;?>
                                          <span class='fa fa-edit'></span>
                                      </a>
                                      <?php
                                  }
                              }
                              ?> )
                              <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Entrer une adresse de la stations ou un moyen de contacte">
			      				<span class='glyphicon glyphicon-info-sign menu-icon'>
                              </a>
                          </label>
                          <?php
                          echo form_input( array(
                              'type' => 'text',
                              'name' => 'name',
                              'id' => 'name',
                              'class' => 'form-control',
                              'placeholder' => 'Adresse de la stations ',
                              'value' => html_entity_decode( $city->adress )
                          ));
                          ?>
                      </div>

                      <div class="form-group">
                          <label>Numero de telephone
                              <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Numero du telephone du responsable ou de service">
							 				<span class='glyphicon glyphicon-info-sign menu-icon'>
                              </a>
                          </label>
                          <?php
                          echo form_input( array(
                              'type' => 'text',
                              'name' => 'phone',
                              'id' => 'phone',
                              'class' => 'form-control',
                              'placeholder' => 'Numero de telephone',
                              'value' => html_entity_decode( $city->phone )
                          ));
                          ?>
                      </div>
			      	
			      	<div class="form-group">
                        <label>Description
			      			<a href="#" class="tooltip-ps" data-toggle="tooltip" title="Description de la station ou de sa geolocalisation">
			      				<span class='glyphicon glyphicon-info-sign menu-icon'>
			      			</a>
			      		</label>
			      		<textarea class="form-control" name="description" placeholder="Description" rows="3"><?php echo $city->description;?></textarea>
			      	</div>

                      <div class="form-group">
                          <label>Nom du Quartier (<small>Département:</small> <?php
                              if ($this->session->userdata('city_id') != "") {
                                  if (isset($mode) && $mode) {
                                      ?>
                                      <a href="<?php echo site_url("stations") ?>">
                                          <?php echo "Les Stations";?>
                                          <span class='fa fa-dashboard'></span>
                                      </a>
                                      <?php
                                  } else {
                                      ?>
                                      <a href="<?php echo site_url("stations") ?>">
                                          <?php echo $this->city->get_current_city()->name;?>
                                          <span class='fa fa-edit'></span>
                                      </a>
                                      <?php
                                  }
                              }
                              ?> )
                              <a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('city_location_tooltips')?>">
						 					<span class='glyphicon glyphicon-info-sign menu-icon'>
                              </a>
                          </label>
                          <select class="form-control" name='twon_id' id='twon_id'>
                              <?php
                              $twon = $this->db->get_where('cd_twon' , array('city_id' => $city->city_id ))->result();
                              foreach($twon as $t):
                                  ?>
                                  <option value="<?php echo $t->twon_id;?>" <?php if($t->twon_id == $city->twon_id)echo 'selected';?>>
                                      <?php echo $t->name;?>
                                  </option>
                              <?php
                              endforeach;
                              ?>
                          </select>
                      </div>
			      	
			      	<div class="form-group">
			      		<label><input type="checkbox" name="status" value="1" <?php if($city->status == 1) echo "checked";?> >&nbsp;&nbsp;Status For Publish</label>
			      	</div>
			      	
			      	
		      		
		      		<div class="form-group">
                        <label>Image de couverture de la Station
                            <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Une image de la station en Grand plan">
						 					<span class='glyphicon glyphicon-info-sign menu-icon'>
                            </a>
                        </label>  <br>
		      				<?php echo $this->lang->line('city_image_recommended_size')?>
		      				<a class="btn btn-primary btn-upload pull-right" data-toggle="modal" data-target="#uploadImage">
		      					Remplace Couverture
		      				</a>
		      				<hr/>					
		      				<?php
		      					$images = $this->image->get_all_by_type($city->id, 'city')->result();
		      					if(count($images) > 0):
		      				?>
		      					<div class="row">
		      					<?php
		      						$i= 0;
		      						foreach ($images as $img) {
		      							if ($i>0 && $i%3==0) {
		      								echo "</div><div class='row'>";
		      							}
		      							
		      							echo '<div class="col-md-4" style="height:100"><div class="thumbnail">'.
		      								'<img src="'.base_url('uploads/thumbnail/'.$img->path).'"><br/>'.
		      								'<p class="text-center">'.
		      								'<a  data-toggle="modal" data-target="#updateDesc" class="detail-img" id="'.$img->id.'" 
		      									desc="'.$img->description.'" image="'.base_url('uploads/'.$img->path).'">Detail<a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.
		      								'<a data-toggle="modal" data-target="#deletePhoto" class="delete-img" id="'.$img->id.'"   
		      									image="'.$img->path.'">Supprime</a></p>'.
		      								'</div></div>';
		      						   $i++;
		      						}
		      					?>
		      					</div>
		      				
		      				<?php
		      					endif;
		      				?>
		      			</div>
		      		
			      </div>
			      
			      <div class="col-sm-6">
			      	
			      	<div class="form-group">
                        <label>Écrivez et trouvez votre location sur Google Map
                            <a href="#" class="tooltip-ps" data-toggle="tooltip" title="S’il vous plaît écrivez votre Location et sélectionnez dans la liste déroulante">
                                <span class='glyphicon glyphicon-info-sign menu-icon'></span>
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
		      		        		'value' => $city->lat
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
		      		        		'value' => $city->lng
		      		        	));
		      		        ?>
		      	        </div>
		      	    </div>
			      	
			      </div>
			      	
			   	</div>
				
				<hr/>
		
		<input type="submit" value="Mise a jour" class="btn btn-primary"/>
		<input type="submit" value="Supprimer" class="btn btn-primary delete-city" data-toggle="modal" data-target="#deleteCity"/>
		<a href="<?php echo site_url('cities');?>" class="btn btn-primary">Annuler</a>
	</form>
	
	<div class="modal fade"  id="uploadImage">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span><span class="sr-only">Ferme</span>
					</button>
					<h4 class="modal-title"><?php echo $this->lang->line('replace_photo_button')?></h4>
				</div>
				<?php
				$attributes = array('id' => 'upload-form','enctype' => 'multipart/form-data');
				echo form_open(site_url("cities/upload/".$city->id), $attributes);
				?>
					<div class="modal-body">
						<div class="form-group">
							<label><?php echo $this->lang->line('upload_photo_label')?></label>
							<input type="file" name="images1">
							<br/>
							<label><?php echo $this->lang->line('photo_desc_label')?></label>
							<textarea class="form-control" name="image_desc" rows="9"></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<input type="submit" value="<?php echo $this->lang->line('upload_button')?>" class="btn btn-primary"/>
						<a type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel_button')?></a>
					</div>
				</form>
			</div>
		</div>
	</div>
				
	<div class="modal fade"  id="updateDesc">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span><span class="sr-only">Ferme</span>
					</button>
					<h4 class="modal-title"><?php echo $this->lang->line('update_photo_desc_label')?></h4>
				</div>
				<?php
				$attributes = array('id' => 'image-form','enctype' => 'multipart/form-data');
				echo form_open('', $attributes);
				?>
					<div class="modal-body">
						<div class="form-group">
							<div class="row">
								<img class="col-sm-12 image">
							</div>
							<br/>
							<label><?php echo $this->lang->line('photo_desc_label')?></label>
							<textarea class="form-control edit_image_desc" name="image_desc" rows="9"></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<input type="submit" value="Upload" class="btn btn-primary"/>
						<a type="button" class="btn btn-default" data-dismiss="modal">Annuler</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<div class="modal fade"  id="deletePhoto">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Ferme</span></button>
					<h4 class="modal-title"><?php echo $this->lang->line('delete_cover_photo_label')?></h4>
				</div>
				<div class="modal-body">
					<p><?php echo $this->lang->line('delete_photo_confirm_message')?></p>
				</div>
				<div class="modal-footer">
					<a type="button" class="btn btn-default btn-delete-image">Oui</a>
					<a type="button" class="btn btn-default" data-dismiss="modal">Annuler</a>
				</div>
			</div>
		</div>			
	</div>
	
	<div class="modal fade"  id="deleteCity">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Ferme</span></button>
					<h4 class="modal-title">Suppression de la station</h4>
				</div>
				<div class="modal-body">
					<p>Êtes-vous sûr de vouloir supprimer la Station car elle supprimera :</p>
					<p>1. Categories</p>
					<p>2. Sub-Categories</p>
					<p>3. Items</p>
					<p>4. Items Like, Review and Inquiry</p>
					<p>5. News Feed</p>
					<p>6. Analytics Counts</p>
				</div>
				<div class="modal-footer">
					<a type="button" class="btn btn-default btn-delete-city">Oui</a>
					<a type="button" class="btn btn-default" data-dismiss="modal">Annuler</a>
				</div>
			</div>
		</div>			
	</div>
	
	<script>
		$(document).ready(function(){
			
			$('.btn-upload').click(function(e){
				e.preventDefault();
			});
			
			$('.detail-img').click(function(e){
				e.preventDefault();
				var id = $(this).attr('id');
				var desc = $(this).attr('desc');
				var image = $(this).attr('image');
				var action = "<?php echo site_url("cities/edit_image/".$city->id);?>";
				$('#image-form').attr('action', action + "/" + id);
				$('#image-form .edit_image_desc').val(desc);
				$('#image-form .image').attr('src',image);
			});
			
			$('.delete-img').click(function(e){
				e.preventDefault();
				var id = $(this).attr('id');
				var image = $(this).attr('image');
				var action = '<?php echo site_url('cities/delete_image/'.$city->id);?>/' + id + '/' + image;
				$('.btn-delete-image').attr('href', action);
			});
			
			$('.delete-city').click(function(e){
				e.preventDefault();
				var id = $(this).attr('id');
				var image = $(this).attr('image');
				var action = '<?php echo site_url('cities/delete_city/'.$city->id);?>';
				$('.btn-delete-city').attr('href', action);
			});
			
			$(document).ready(function(){
				$(function () { $("[data-toggle='tooltip']").tooltip(); });
			});	
		});
		
		
		$('#city-form').validate({
			rules:{
				name:{
					required: true
				},
				description:{
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
				email: {
					email: "Email format is wrong.",
					required : "Please Fill City Email."
				}
			}
		});	
		
		$('#us3').locationpicker({
		    location: {latitude: <?php echo $city->lat;?>, longitude: <?php echo $city->lng;?>},
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
	
	