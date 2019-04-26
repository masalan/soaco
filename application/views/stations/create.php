			<?php
			$this->lang->load('ps', 'english');
			?>
			<ul class="breadcrumb">
				<li><a href="<?php echo site_url('stations/list');?>">Listes des stations</a> <span class="divider"></span></li>
				<li>Station Informations</li>
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
			echo form_open(site_url("stations/create"), $attributes);
			?>
				<div class="row">
					
							 <div class="col-sm-6">
							 	
							 	<div class="form-group">
							 		<label>Nom de la Station  (<?php
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
							 				'placeholder' => 'Nom de la station ou magasin',
							 				'value' => ''
							 			));
							 		?>
							 	</div>



                                 <div class="form-group">
                                     <label>Communes de  (<?php
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
                                         <a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('cat_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                                         </a>
                                     </label>
                                     <select class="form-control" name="cd_commune_id" id="cd_commune_id">
                                         <option><?php echo $this->lang->line('select_cat_message')?></option>
                                         <?php
                                         $commune = $this->db->get_where('cd_commune' , array('city_id' =>$city_id ));
                                         foreach($commune->result() as $co)
                                             echo "<option value='".$co->cd_commune_id."'>".$co->name."</option>";
                                         ?>
                                     </select>
                                 </div>


                                 <div class="form-group">
                                     <label>Arrondissement
                                         <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Sélectionnez dans le menu déroulant l’arrondissement approprié à votre commune">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                                         </a>
                                     </label>
                                     <select class="form-control" name="cd_arrondissement_id" id="cd_arrondissement_id">
                                         <option>Selectionner l`arrondissement</option>
                                     </select>
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
                                         'value' => ''
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
                                         'value' => ''
                                     ));
                                     ?>
                                 </div>

							 	<div class="form-group">
							 		<label>Description
							 			<a href="#" class="tooltip-ps" data-toggle="tooltip" title="Description de la station ou de sa geolocalisation">
							 				<span class='glyphicon glyphicon-info-sign menu-icon'>
							 			</a>
							 		</label>
							 		<textarea class="form-control" name="description" placeholder="Description" rows="3"></textarea>
							 	</div>
							 	
							 	<div class="form-group">
                                    <label>Nom du Quartier  (<small>Département:</small> <?php
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
                                        $query = $this->db->get_where('cd_twon' , array('city_id' => $city_id ))->result();
                                        foreach($query as $role)
                                            echo "<option value='".$role->twon_id."'>".$role->name."</option>";
                                        ?>
                                    </select>
                                </div>
						 		
						 		<div class="form-group">
						 			<label>Image de couverture de la Station
						 				<a href="#" class="tooltip-ps" data-toggle="tooltip" title="Une image de la station en Grand plan">
						 					<span class='glyphicon glyphicon-info-sign menu-icon'>
						 				</a>
						 			</label> 
						 			<br>
						 			<?php echo $this->lang->line('city_image_recommended_size')?>
						 			<input class="btn" type="file" name="images1">
						 			<br/>
						 			<label>nom de la photo
						 				<a href="#" class="tooltip-ps" data-toggle="tooltip" title="Une brieve description de la photo">
						 				<span class='glyphicon glyphicon-info-sign menu-icon'>
						 				</a></label>
						 			<textarea class="form-control" name="image_desc" rows="2"></textarea>
						 		</div>
							 
							 </div>
							 
							 <div class="col-sm-6">
							 	
							 		<div class="form-group">
							 	        <label>Écrivez et trouvez votre location sur Google Map
							 	        	<a href="#" class="tooltip-ps" data-toggle="tooltip" title="S’il vous plaît écrivez votre Location et sélectionnez dans la liste déroulante">
							 	        		<span class='glyphicon glyphicon-info-sign menu-icon'>
							 	        	</a>
							 	        </label><br>
							 	
							 	        <?php 
							 	        	echo form_input( array(
							 	        		'type' => 'text',
							 	        		'name' => 'find_location',
							 	        		'id' => 'find_location',
							 	        		'class' => 'form-control',
							 	        		'placeholder' => 'Rue 2381, Cotonou, Bénin',
							 	        		'value' => ''
							 	        	));
							 	        ?>
							 	    </div>
							 	    
							 	    <div id="us3" style="width: 550px; height: 300px;"></div>
							 	    <div class="clearfix">&nbsp;</div>
							 	    <div class="m-t-small">
							 	        <div class="form-group">
							 		        <label><?php echo $this->lang->line('city_lat_label')?>
							 		        	<a href="#" class="tooltip-ps" data-toggle="tooltip" title="Entrez la latitude de la station">
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
							 		        		'placeholder' => '6.3702928',
							 		        		'value' => ''
							 		        	));
							 		        ?>
							 	        </div>
							 	        
							 	        <div class="form-group">
							 		        <label><?php echo $this->lang->line('city_lng_label')?>
							 		        	<a href="#" class="tooltip-ps" data-toggle="tooltip" title="Entrez la longitude de la station">
							 		        		<span class='glyphicon glyphicon-info-sign menu-icon'>
							 		        	</a>
							 		        </label><br>
							 		        <?php 
							 		        	echo form_input( array(
							 		        		'type' => 'text',
							 		        		'name' => 'lng',
							 		        		'id' => 'lng',
							 		        		'class' => 'form-control',
							 		        		'placeholder' => '2.391',
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
							required: "S'il vous plaît remplir le nom de la ville ou quartier."
						},
						description:{
							required: "S'il vous plaît remplir la  Description."
						},
						lat:{
							required: "S'il vous plaît remplir la Lattitude."
						},
						lng:{
							required: "S'il vous plaît remplir la  Longitude."
						},
						email: {
							email: "Email format is wrong.",
							required : "Please Fill Email."
						}
					}
				});	
				
				$('#us3').locationpicker({
				    //location: {latitude: 0.0, longitude: 0.0},
                   location: {latitude: 6.3702928, longitude: 2.3912361999999803},
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
				       // alert("Location changed. New location (" + currentLocation.latitude + ", " + currentLocation.longitude + ")");
				    }
				});


                $('#cd_commune_id').change(function(){
                    var catId = $(this).val();
                    $.ajax({
                        url: '<?php echo site_url('stations/get_com');?>/'+catId,
                        method: 'GET',
                        dataType: 'JSON',
                        success:function(data){
                            $('#cd_arrondissement_id').html("serge");
                            $.each(data, function(i, obj){
                                $('#cd_arrondissement_id').append('<option value="'+ obj.cd_arrondissement_id +'">' + obj.name + '</option>');
                            });
                            $('#name').val($('#name').val() + " ").blur();
                        }
                    });
                });

                $('#cd_arrondissement_id').on('change', function(){
                    $('#name').val($('#name').val() + " ").blur();
                });

			</script>