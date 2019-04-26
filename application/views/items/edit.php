			<?php
			$this->lang->load('ps', 'english');
			?>
			<ul class="breadcrumb">
				<li><a href="<?php echo site_url() . "/dashboard";?>"><?php echo $this->lang->line('dashboard_label')?></a> <span class="divider"></span></li>
				<li><a href="<?php echo site_url('stations_services');?>">liste stations</a> <span class="divider"></span></li>
                <li>Mise a jour  Station</li>
			</ul>
			<div class="wrapper wrapper-content animated fadeInRight">
			<?php
			$attributes = array('id' => 'item-form','enctype' => 'multipart/form-data');
			echo form_open(site_url("items/edit/".url_encode($item->id)), $attributes);
			
			?>

                <legend>Information Sur la Station</legend>

				<?php $this->load->view( 'flash_message' ); ?>
					
				<div class="row">
					<div class="col-sm-6">
							<div class="form-group">
                                <label>Station
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
										'placeholder' => $this->lang->line('item_name_label'),
										'value' => html_entity_decode( $item->name )
									));
								?>
							</div>

                        <div class="form-group">
                            <label>Numero de telephone
                                <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Ce numero de telephone sera aussi utiliser commpe pseudo de connexion a e-station">
								    	<span class='glyphicon glyphicon-info-sign menu-icon'>
                                </a>
                            </label>
                            <?php
                            echo form_input( array(
                                'type' => 'text',
                                'name' => 'phone',
                                'id' => 'phone',
                                'class' => 'form-control',
                                'placeholder' => $this->lang->line('phone_label'),
                                'value' => html_entity_decode( $item->phone )
                            ));
                            ?>
                        </div>

                        <div class="form-group">
                            <label>Nom de la societe
                                <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Veillez selectionner le nom de la societe mer dans le menu deroulant">
                                    <span class='glyphicon glyphicon-info-sign menu-icon'></a>
                            </label>
                            <select class="form-control"  name="company_id" id="company_id">
                                <option>Selectionne la societe </option>
                                <?php
                                $company = $this->db->get_where('be_users' , array('city_id'=>$this->city->get_current_city()->id,'is_published' =>1));
                                foreach($company->result()  as $cat){
                                    echo "<option value='".$cat->user_id."'";
                                    if($item->company_id == $cat->user_id)
                                        echo " selected ";
                                    echo ">".$cat->fullname."</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                                <label>Commune de  (<?php echo $this->city->get_current_city()->name;?> )
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('cat_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<select class="form-control select2" data-toggle="select2" name="cat_id" id="cat_id">
								<?php
									foreach($this->category->get_all($this->city->get_current_city()->id)->result() as $cat){
										echo "<option value='".$cat->id."'";
										if($item->cat_id == $cat->id) 
											echo " selected ";
										echo ">".$cat->name."</option>";
									}
								?>
								</select>
							</div>
							
							<div class="form-group">
                                <label>Arrondissement
                                    <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Sélectionnez dans le menu déroulant l’arrondissement approprié à votre commune">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<select class="form-control select2" data-toggle="select2" name="sub_cat_id" id="sub_cat_id">
								<option><?php echo $this->lang->line('select_sub_cat_message')?></option>
								<?php
									foreach($this->sub_category->get_all_by_cat_id($item->cat_id)->result() as $sub_cat){
										echo "<option value='".$sub_cat->id."'";
										if($item->sub_cat_id == $sub_cat->id) 
											echo " selected ";
										echo ">".$sub_cat->name."</option>";
									}
								?>
								</select>
							</div>



                        <div class="form-group">
                            <label>Quartier (village)
                                <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Sélectionnez dans le menu déroulant le quartier approprié à votre arrondissement">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                                </a>
                            </label>
                            <select class="form-control select2" data-toggle="select2" name="twon_id" id="twon_id">
                                <option>Selectionne le quartier</option>
                                <?php
                                foreach($this->sub_category->get_all_quartier($item->sub_cat_id)->result() as $sub_cat){
                                    echo "<option value='".$sub_cat->id."'";
                                    if($item->twon_id == $sub_cat->id)
                                        echo " selected ";
                                    echo ">".$sub_cat->name."</option>";
                                }
                                ?>
                            </select>
                        </div>



							<div class="form-group">
								<label><?php echo $this->lang->line('email_label')?> 
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('email_tooltips')?>">
								    	<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'email',
										'id' => '',
										'class' => 'form-control',
										'placeholder' => $this->lang->line('email_label'),
										'value' => html_entity_decode( $item->email )
									));
								?>
							</div>
							
							<div class="form-group">
								<label><?php echo $this->lang->line('description_label')?> 
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('item_description_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<textarea class="form-control" name="description" placeholder="<?php echo $this->lang->line('description_label')?>" rows="4"><?php echo $item->description;?></textarea>
							</div>
							
							<div class="form-group">
                                <label>Situez-nous dans le Quartier  (<small>Département:</small> <?php echo $this->city->get_current_city()->name;?> )
                                    <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Entrez ou écrivez la situation géographique de la station, par exemple : station Vodjè-Kpota à côté de l’église Pentecôte">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<textarea class="form-control" name="address" placeholder="<?php echo $this->lang->line('address_label')?>" rows="2"><?php echo $item->address;?></textarea>
							</div>
							
							
							<div class="form-group">
								<label><?php echo $this->lang->line('publish_label')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="Est publié signifie en ligne et operationnel">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
								: 
								</label>
								<?php
									echo form_checkbox("is_published",$item->is_published,$item->is_published);
								 ?>
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
							        		'value' => $item->lat
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
							        		'value' => $item->lng
							        	));
							        ?>
						        </div>
						    </div>
							
							<div class="form-group">
                                <label>Balise de recherche / mot clé
                                    <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Entrez des mot clé pour la recherche en ligne ">
								    	<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'search_tag',
										'id' => 'search_tag',
										'class' => 'form-control',
										'placeholder' => '',
										'value' => html_entity_decode( $item->search_tag )
									));
								?>
							</div>
							
					</div>
				</div>
				
				<input type="submit" value="Mise a jour" class="btn btn-primary"/>
<!--				<a class="btn btn-primary" href="--><?php //echo site_url('items/gallery/'.$item->id);?><!--">Enregistre & Gallérie</a>-->
				<a href="<?php echo site_url('items');?>" class="btn btn-primary"><?php echo $this->lang->line('cancel_button')?></a>
			</form>
			</div>
			<script>
				$(document).ready(function(){
					$('#item-form').validate({
						rules:{
                            phone:{
								required: true,
								minlength: 4,
								remote: {
									url: '<?php echo site_url("items/exists_phone/".$item->id);?>',
								  	type: "GET",
								  	data: {
								  		phone: function () {
								  			return $('#phone').val();
								  		},
								    	sub_cat_id: function() {
								    		return $('#sub_cat_id').val();
								    	}
								  	}
								}
							},
							unit_price: {
								number: true
							}
						},
						messages:{
                            phone:{
								required: "Please fill item name.",
								minlength: "The length of item name must be greater than 4",
								remote: "Ce numéro de téléphone existe déjà , veuillez choisir un autre"
							},
							unit_price: {
								number: "Only number is allowed."
							}
						}
					});

					// Arrondissement
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
					
					$('#sub_cat_id').on('change', function(){
						$('#name').val($('#name').val() + " ").blur();
					});

					// Selecte Quartier

                    $('#sub_cat_id').change(function(){
                        var catId = $(this).val();
                        $.ajax({
                            url: '<?php echo site_url('societe/get_quartier_station');?>/'+catId,
                            method: 'GET',
                            dataType: 'JSON',
                            success:function(data){
                                $('#twon_id').html("");
                                $.each(data, function(i, obj){
                                    $('#twon_id').append('<option value="'+ obj.id +'">' + obj.name + '</option>');
                                });
                                $('#name').val($('#name').val() + " ").blur();
                            }
                        });
                    });

                    $('#twon_id').on('change', function(){
                        $('#name').val($('#name').val() + " ").blur();
                    });



					$(function () { $("[data-toggle='tooltip']").tooltip(); });
					
					$('#us3').locationpicker({
					    location: {latitude: <?php echo $item->lat;?>, longitude: <?php echo $item->lng;?>},
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
				});



			</script>

