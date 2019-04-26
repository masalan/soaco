			<?php
			$this->lang->load('ps', 'english');
			?>
			<ul class="breadcrumb">
				<li><a href="<?php echo site_url() . "/dashboard";?>"><?php echo $this->lang->line('dashboard_label')?></a> <span class="divider"></span></li>
				<li><a href="<?php echo site_url('societe');?>">liste Société </a> <span class="divider"></span></li>
                <li>Mise a jour de la  Société <?php echo $item->fullname;?></li>
			</ul>
			<div class="wrapper wrapper-content animated fadeInRight">
			<?php
			$attributes = array('id' => 'item-form','enctype' => 'multipart/form-data');
			echo form_open(site_url("societe/edit/".url_encode($item->user_id)), $attributes);
			
			?>

                <legend>Information Sur la Société <?php echo $item->fullname;?></legend>

				<?php $this->load->view( 'flash_message' ); ?>
					
				<div class="row">
					<div class="col-sm-6">
							<div class="form-group">
                                <label>Nom commercial
                                    <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Entrer le nom Commercial de la Société qui gere vos stations">
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
										'value' => html_entity_decode( $item->fullname )
									));
								?>
							</div>


                        <div class="form-group">
                            <label>Nom complet du Responsable de la société
                                <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Entrer le Nom complet du Responsable de la Société qui gere les stations">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                                </a>
                            </label>
                            <?php
                            echo form_input( array(
                                'type' => 'text',
                                'name' => 'owner_name',
                                'id' => 'owner_name',
                                'class' => 'form-control',
                                'placeholder' => 'Nom complet du PDG',
                                'value' => html_entity_decode( $item->owner_name )
                            ));
                            ?>
                        </div>

                        <div class="form-group">
                            <label>Numéro RCCM</label>
                            <input class="form-control" type="text" placeholder="Numéro RCCM" name='rccm' id='rccm' value="<?php echo html_entity_decode( $item->rccm );?>" required>
                            <small class="form-text text-info">Numéro RCCM est obligatoire</small>
                        </div>

                        <div class="form-group">
                            <label>Numéro IFU</label>
                            <input class="form-control" type="text" placeholder="Numéro IFU" name='ifu' id='ifu'  value="<?php echo html_entity_decode( $item->ifu );?>"  required>
                            <small class="form-text text-info">Numéro IFU est obligatoire</small>
                        </div>
                        <div class="form-group">
                            <label><?php echo $this->lang->line('phone_label')?>
                                <a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('phone_tooltips')?>">
								    	<span class='glyphicon glyphicon-info-sign menu-icon'>
                                </a>
                            </label>
                            <?php
                            echo form_input( array(
                                'type' => 'text',
                                'name' => 'phone',
                                'id' => '',
                                'class' => 'form-control',
                                'placeholder' => $this->lang->line('phone_label'),
                                'value' => html_entity_decode( $item->phone )
                            ));
                            ?>
                        </div>
                        <div class="form-group">
                            <label>E-mail de connexion a la plateforme de Gestion
                                <a href="#" class="tooltip-ps" data-toggle="tooltip" title="E-mail de connexion a la plateforme de Gestion">
								    	<span class='glyphicon glyphicon-info-sign menu-icon'>
                                </a>
                            </label>
                            <?php
                            echo form_input( array(
                                'type' => 'text',
                                'name' => 'user_email',
                                'id' => 'user_email',
                                'class' => 'form-control',
                                'placeholder' => $this->lang->line('email_label'),
                                'value' => html_entity_decode( $item->user_email )
                            ));
                            ?>
                        </div>

                        <div class="form-group">
                            <label style="color: red;">Département de localisation ( <?php echo $this->db->get_where('cd_cities',array('id'=>$item->city_id ))->row()->name;?>)
                                <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Si vous changez le département de localisation cela affecteras un changement automatique de votre adresse et situation Géographique., ensuite cette société ne sera plus visible dans la commmune de (<?php echo $this->city->get_current_city()->name;?>)">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                                </a>
                            </label>
                            <select class="form-control select2" data-toggle="select2" name="city_id" id="city_id">
                                <option>Selectionne le Département</option>
                                <?php
                                $city = $this->city->get_all_dpt();
                                foreach($city->result() as $ci){
                                    echo "<option value='".$ci->id."'";
                                    if($item->city_id == $ci->id)
                                        echo " selected ";
                                    echo ">".$ci->name."</option>";
                                }
                                ?>
                            </select>
                        </div>


                        <div class="form-group">
                                <label style="color: blue;">Communes de ( <?php echo $this->db->get_where('cd_categories',array('id'=>$item->cat_id ))->row()->name;?>)
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('cat_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<select class="form-control select2" data-toggle="select2" name="cat_id" id="cat_id">
								<?php foreach($this->category->get_all($this->city->get_current_city()->id)->result() as $cat){
										echo "<option value='".$cat->id."'";
										if($item->cat_id == $cat->id) 
											echo " selected ";
										echo ">".$cat->name."</option>";
									}
								?>
								</select>
							</div>
							
							<div class="form-group">
                                <label  style="color: green;">Arrondissement (<?php echo $this->db->get_where('cd_sub_categories',array('id'=>$item->sub_cat_id ))->row()->name;?>)
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
                            <label  style="color: yellowgreen;">Quartier (<?php echo $this->db->get_where('quartier',array('id'=>$item->twon_id ))->row()->name;?>)
                                <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Sélectionnez dans le menu déroulant le quartier approprié à votre arrondissement">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                                </a>
                            </label>
                            <select class="form-control select2" data-toggle="select2" name="twon_id" id="twon_id">
                                <option>Selectionne le quartier</option>
                                <?php
                                foreach($this->sub_category->get_all_quartier($item->sub_cat_id)->result() as $quat){
                                    echo "<option value='".$quat->id."'";
                                    if($item->twon_id == $quat->id)
                                        echo " selected ";
                                    echo ">".$quat->name."</option>";
                                }
                                ?>
                            </select>
                        </div>
							
							<div class="form-group">
								<label><?php echo $this->lang->line('description_label')?> 
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('item_description_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<textarea class="form-control" name="about_me" placeholder="<?php echo $this->lang->line('description_label')?>" rows="4"><?php echo $item->about_me;?></textarea>
							</div>
							
							<div class="form-group">
                                <label>Situez-nous dans le Quartier  (<small>Département:</small> <?php echo $this->city->get_current_city()->name;?>)
                                    <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Entrez ou écrivez la situation géographique de la station, par exemple : station Vodjè-Kpota à côté de l’église Pentecôte">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<textarea class="form-control" name="address" placeholder="<?php echo $this->lang->line('address_label')?>" rows="2"><?php echo $item->address;?></textarea>
							</div>


                        <div class="form-group">
                            <label>Mot de passe de connexion a la plateforme de Gestion</label>
                            <input class="form-control" type="user_pass" placeholder="Password" name='user_pass' id='user_pass'>
                        </div>

                        <div class="form-group">
                            <label>SOACO IDUS
                                <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Identifiant Unique de la société sur la plateforme SOACO e-station ">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                                </a>
                            </label>
                            <input class="form-control" type="text" placeholder="Votre unique IDUS" value="<?php if ($item->idus == 0) { $this->load->helper('string');
                                echo random_string('nozero', 16);} else {echo $item->idus;} ?>" name='idus' id='idus' readonly>
                        </div>
							<div class="form-group">
								<label><?php echo $this->lang->line('publish_label')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="Est publié signifie en ligne et operationnel">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
								: 
								</label>
								<?php echo form_checkbox("is_published",$item->is_published,$item->is_published); ?>
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



                            <div class="row">


                                <div class="row alert alert-success">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Date d`abonnement
                                                <a href="#" class="tooltip-ps" data-toggle="tooltip" title="La date d`abonnement de la licence SOACO, correspont  au demarrage d`activites de tous les service sur SOACO e-Station">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                                                </a>
                                            </label>
                                            <input type="text" name="licence_start" value="<?php echo $this->db->get_where('cd_licence',array('licence_company_id'=>$item->user_id ))->row()->licence_start_time;?>" id="licence_start" class="form-control" placeholder="Date d`abonnement"  readonly/>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Date d`Expiration
                                                <a href="#" class="tooltip-ps" data-toggle="tooltip" title="La date d`expiration de la licence , correspont  a l`arret total de tous les service sur SOACO e-Station">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                                                </a>
                                            </label>
                                            <input type="text" name="licence_expired" value="<?php echo $this->db->get_where('cd_licence',array('licence_company_id'=>$item->user_id ))->row()->licence_end_time;?>" id="licence_expired" class="form-control" placeholder="Date d`Expiration" readonly/>
                                        </div>
                                    </div>

                                </div>

                            </div>



                            <div class="col-sm-6">
                                <address>
                                    <strong><?php echo $item->fullname;?>.</strong><br>
                                    <?php echo $item->address;?><br>
                                    Benin<br>
                                    <abbr title="Phone">Tel.: </abbr><span class='glyphicon glyphicon-phone'></span> <?php echo $item->phone;?>
                                </address>

                                <address>
                                    <strong><?php echo $item->owner_name;?></strong><br>
                                    <a href="mailto:#"><?php echo $item->user_email;?></a>
                                </address>
                            </div>





                        </div>
				</div>
				
				<input type="submit" value="Mise a jour" class="btn btn-primary"/>
<!--				<a class="btn btn-primary" href="--><?php //echo site_url('items/gallery/'.$item->id);?><!--">Enregistre & Gallérie</a>-->
                <input type="hidden" name="country_id" value="<?php echo  $this->session->userdata('country_id');?>">
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
									url: '<?php echo site_url("items/exists/".$item->id);?>',
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
                                required: "Nom de la societe est obligatoire.",
                                minlength: "le nom de la societe dois etre supperieur a 4 lettres au plus",
                                remote: "Le nom de cette société existe déjà se notre système , veillez contacter la centrale pour ample information"
							},
							unit_price: {
								number: "Only number is allowed."
							}
						}
					});


                    // Commune List
                    $('#city_id').change(function(){
                        var catId = $(this).val();
                        $.ajax({
                            url: '<?php echo site_url('societe/get_com_list');?>/'+catId,
                            method: 'GET',
                            dataType: 'JSON',
                            success:function(data){
                                $('#cat_id').html("");
                                $.each(data, function(i, obj){
                                    $('#cat_id').append('<option value="'+ obj.id +'">' + obj.name + '</option>');
                                });
                                $('#name').val($('#name').val() + " ").blur();
                            }
                        });
                    });

                    $('#cat_id').on('change', function(){
                        $('#name').val($('#name').val() + " ").blur();
                    });



					// Arrondissement List
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


					// Quartier List
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

