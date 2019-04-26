			<?php
			$this->lang->load('ps', 'english');
			?>
			<ul class="breadcrumb">
				<li><a href="<?php echo site_url(). "/dashboard";?>"><?php echo $this->lang->line('dashboard_label')?></a> <span class="divider"></span></li>
				<li><a href="<?php echo site_url('stations_services');?>">Liste Station</a> <span class="divider"></span></li>
				<li>Ajout Nouveal Station</li>
			</ul>
			<div class="wrapper wrapper-content animated fadeInRight">
			<?php
			$attributes = array('id' => 'item-form','enctype' => 'multipart/form-data');
			echo form_open(site_url('items/add'), $attributes);
			?>
				<legend>Information Sur la Station</legend>

				<?php $this->load->view( 'flash_message' ); ?>
					
				<div class="row">
					<div class="col-sm-6">

							<div class="form-group">
								<label>Station
                                    <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Entrer un nom nominatif de la station ou son nom commercial">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'name',
										'id' => 'name',
										'class' => 'form-control',
										'placeholder' => 'Nom de la Station ',
										'value' => ''
									));
								?>
							</div>

                        <div class="form-group">
                            <label> Mon pays de Geolocalisation
                                <a class="tooltip-ps" data-toggle="tooltip" title="Ne changez pas la localisation de votre service">
                                    <span class='glyphicon glyphicon-info-sign menu-icon'></a>
                            </label>
                            <select class="form-control" name="country_id" id="country_id">
                                <?php
                                $country = $this->city->get_country_list();
                                foreach ($country->result() as $cat) {
                                    echo "<option value='".$cat->id."'";
                                    if($this->session->userdata('country_id') == $cat->id) {
                                        echo " selected ";
                                    }
                                    echo ">".$cat->name."</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Nom de la societe
                                <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Veuillez selectionner le nom de la societe dans le menu deroulant">
										<span class='glyphicon glyphicon-info-sign menu-icon'></a>
                            </label>
                            <select class="form-control"  name="company_id" id="company_id">
                                <option>Selectionne la societe </option>
                                <?php
                                $company = $this->sub_category->get_all_company($this->city->get_current_city()->id);
                                foreach($company->result() as $cat)
                                    echo "<option value='".$cat->user_id."'>".$cat->fullname."</option>";
                                ?>
                            </select>
                        </div>


							
							<div class="form-group">
                                <label>Commune de  (<?php echo $this->city->get_current_city()->name;?>)
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('cat_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<select class="form-control"  name="cat_id" id="cat_id">
								<option><?php echo $this->lang->line('select_cat_message')?></option>
								<?php
									$categories = $this->category->get_all($this->city->get_current_city()->id);
									foreach($categories->result() as $cat)
										echo "<option value='".$cat->id."'>".$cat->name."</option>";
								?>
								</select>
							</div>
							
							<div class="form-group">
                                <label>Arrondissement
                                    <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Sélectionnez dans le menu déroulant l’arrondissement approprié à votre commune">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<select class="form-control" name="sub_cat_id" id="sub_cat_id">
									<option><?php echo $this->lang->line('select_sub_cat_message')?></option>
								</select>
							</div>


                        <div class="form-group">
                            <label>Quartier (village)
                          <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Sélectionnez dans le menu déroulant l’arrondissement approprié à votre commune"><span class='glyphicon glyphicon-info-sign menu-icon'>
                                </a>
                            </label>
                            <select class="form-control select2" data-toggle="select2" name="twon_id" id="twon_id">
                                <option>Selectionne un quartier</option>
                            </select>
                        </div>


                        <div class="form-group">
                            <label>Situation géographique  (<small>Département:</small>  <?php echo $this->city->get_current_city()->name;?>)
                                <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Entrez ou écrivez la situation géographique de la station, par exemple : station Vodjè-Kpota à côté de l’église Pentecôte">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                                </a>
                            </label>
                            <textarea class="form-control" name="address" placeholder="<?php echo $this->lang->line('item_address_label')?>" rows="2"></textarea>
                        </div>

                        <div class="form-group">
                                <label>Téléphone
                                    <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Numero du telephone du responsable ou de service">
								    	<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'phone',
										'id' => '',
										'class' => 'form-control',
										'placeholder' => 'Numéro de téléphone',
										'value' => ''
									));
								?>
							</div>

							<div class="form-group">
								<label><?php echo $this->lang->line('email_label')?>
                                    <a href="#" class="tooltip-ps" data-toggle="tooltip" title="E-mail du responsable ou de service">
								    	<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'email',
										'id' => '',
										'class' => 'form-control',
										'placeholder' => 'Compte e-mail',
										'value' => ''
									));
								?>
							</div>
							
							<div class="form-group">
								<label>Observations
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="Si vous avez autre chose a dire sur votre station">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<textarea class="form-control" name="description" placeholder="<?php echo $this->lang->line('description_label')?>" rows="3"></textarea>
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
										'id' => '',
										'class' => 'form-control',
										'placeholder' => '',
										'value' => ''
									));
								?>
							</div>
					</div>
				</div>

                <div class="clearfix"></div>


                <div class="row">
                    <div class="form-group-lg col-xs-5">
                        <label class="control-label" for="facilities">Service disponible dans la Station</label>
                        <div class="form-group-lg">
                            <div th:each="facility : ${facilities}" class="column_2">
                                <?php

                                $query = $this->db->get('cd_services')->result();
                                //$query = $this->services->get_all()->result();
                                foreach($query as $module)
                                   echo "<span><input type='checkbox' name='permissions[]' value='".$module->cd_services_id."'><label class='checkbox-inline'>".$module->name."</label></span><br/>";
                               ?>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="clearfix"></div><br>



				<input type="submit" name="save" value="<?php echo $this->lang->line('save_button')?>" class="btn btn-primary"/>
				<input type="submit" name="gallery" value="Enregistre & Gallérie" class="btn btn-primary"/>
				<a href="<?php echo site_url('items');?>" class="btn btn-primary"><?php echo $this->lang->line('cancel_button')?></a>
			</form>
			</div>
			<script>
			$(document).ready(function(){
				$('#item-form').validate({
					rules:{
						name:{
							required: true,
							minlength: 4,
							remote: {
								url: '<?php echo site_url("items/exists");?>',
					        	type: "GET",
					        	data: {
					        		name: function () {
					        			return $('#name').val();
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
						name:{
							required: "Nom obligatoire",
							minlength: "The length of item Name must be greater than 4",
							remote: "Item Name is already existed in the system"
						},
						unit_price: {
							number: "Only number is allowed."
						}
					}
				});
				
				$('#cat_id').change(function(){
					var catId = $(this).val();
					$.ajax({
						url: '<?php echo site_url('societe/get_sub_cats');?>/'+catId,
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
				
				$(function () { $("[data-toggle='tooltip']").tooltip(); });
				
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


				// Select quartier

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


				
			});


			</script>

