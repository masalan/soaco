<?php
$this->lang->load('ps', 'english');
?>
<ul class="breadcrumb">
    <li><a href="<?php echo site_url(). "/dashboard";?>"><?php echo $this->lang->line('dashboard_label')?></a> <span class="divider"></span></li>
    <li><a href="<?php echo site_url('societe');?>">Liste de Société</a> <span class="divider"></span></li>
    <li>Ajoute Nouvel Société</li>
</ul>
<div class="wrapper wrapper-content animated fadeInRight">
    <?php
    $attributes = array('id' => 'item-form','enctype' => 'multipart/form-data' );
    echo form_open(site_url('societe/add'), $attributes);
    ?>
    <legend>Information Sur la Société</legend>

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
                    'placeholder' => 'Nom commercial  de la Société ',
                    'value' => ''
                ));
                ?>
            </div>

            <div class="form-group">
                <label>Nom complet du Responsable de la société
                    <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Entrer le Nom complet du Responsable de la Société qui gere les stations">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                    </a>
                </label>
                <input class="form-control" type="text" placeholder="Nom complet du PDG'" name='owner_name' id='owner_name' required>

            </div>

            <div class="form-group">
                <label>Numéro RCCM</label>
                <input class="form-control" type="text" placeholder="Numéro RCCM" name='rccm' id='rccm' required>
                <small class="form-text text-info">Numéro RCCM est obligatoire</small>
            </div>

            <div class="form-group">
                <label>Numéro IFU</label>
                <input class="form-control" type="text" placeholder="Numéro IFU" name='ifu' id='ifu' required>
                <small class="form-text text-info">Numéro IFU est obligatoire</small>
            </div>

            <div class="form-group">
                <label>Téléphone
                    <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Numero du telephone du responsable ou de service">
								    	<span class='glyphicon glyphicon-info-sign menu-icon'>
                    </a>
                </label>
                <input class="form-control" type="text" placeholder="Numéro de téléphone" name='phone' id='phone' required>
            </div>
            <div class="form-group">
                <label>E-mail de connexion a la plateforme de Gestion</label>
                <input class="form-control" type="text" placeholder="E-mail" name='user_email' id='user_email' required>
            </div>
            <div class="form-group">
                <label>Communes de  ( <?php echo $this->city->get_current_city()->name;?> )
                    <a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('cat_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                    </a>
                </label>
                <select class="form-control select2" data-toggle="select2" name="cat_id" id="cat_id">
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
                <select class="form-control" data-toggle="select2" name="sub_cat_id" id="sub_cat_id">
                    <option><?php echo $this->lang->line('select_sub_cat_message')?></option>
                </select>
            </div>


            <div class="form-group">
                <label>Quartier (village)
                    <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Sélectionnez dans le menu déroulant l’arrondissement approprié à votre commune"><span class='glyphicon glyphicon-info-sign menu-icon'>
                    </a>
                </label>
                <select class="form-control" data-toggle="select2" name="twon_id" id="twon_id">
                    <option>Selectionne un quartier</option>
                </select>
            </div>


            <div class="form-group">
                <label>Situez-nous dans le Quartier  (<small>Département:</small> <?php echo $this->city->get_current_city()->name;?>)
                    <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Entrez ou écrivez la situation géographique de la station, par exemple : station Vodjè-Kpota à côté de l’église Pentecôte">
						<span class='glyphicon glyphicon-info-sign menu-icon'></a>
                </label>
                <textarea class="form-control" name="address" placeholder="<?php echo $this->lang->line('item_address_label')?>" rows="2" required></textarea>
            </div>




            <div class="form-group">
                <label> Description de la société
                    <a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('item_description_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                    </a>
                </label>
                <textarea class="form-control" name="about_me" data-provide="markdown" placeholder="<?php echo $this->lang->line('description_label')?>" rows="3"></textarea>

            </div>


            <div class="form-group">
                <label>Mot de passe de connexion a la plateforme de Gestion</label>
                <input class="form-control" type="password" placeholder="Mot de passe" name='user_password' id='user_password' required>
            </div>

            <div class="form-group">
                <label>SOACO IDUS
                    <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Identifiant Unique de la société sur la plateforme SOACO e-station ">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                    </a>
                </label>
                <input class="form-control" type="text" placeholder="Votre unique IDUS" value="<?php echo random_string('nozero', 16); ?>" name='idus' id='idus' readonly>
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



    <input type="hidden" value="<?php echo  $this->city->get_current_city()->id; ?>" name="city_id">
    <input type="submit" name="save" value="Enregistre la Société" class="btn btn-primary"/>
    <!--				<input type="submit" name="gallery" value="Enregistre & Gallérie" class="btn btn-primary"/>-->
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


