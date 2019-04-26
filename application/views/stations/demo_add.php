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
    <legend>Information Sur la Station</legend>

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
                <label>Quartier  (<small>Département:</small>  <?php echo $this->city->get_current_city()->name;?>)
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
                <label> Description de la société
                    <a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('item_description_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                    </a>
                </label>
                <textarea class="form-control" name="about_me" placeholder="<?php echo $this->lang->line('description_label')?>" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label>E-mail de connexion a la plateforme de Gestion</label>
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

            <div class="form-group">
                <label>Mot de passe de connexion a la plateforme de Gestion</label>
                <input class="form-control" type="password" placeholder="Password" name='user_password' id='user_password'>
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



    <input type="submit" name="save" value="Enregistre la Société" class="btn btn-primary"/>
    <!--				<input type="submit" name="gallery" value="Enregistre & Gallérie" class="btn btn-primary"/>-->
    <a href="<?php echo site_url('items');?>" class="btn btn-primary"><?php echo $this->lang->line('cancel_button')?></a>
    </form>
</div>

<script>
    $(document).ready(function(){
        $('#item-form').validate({
            focusInvalid: false,
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
                rccm: {
                    number: true
                    required: true,
                    minlength: 10,
                    maxlength: 20
                }
                ifu: {
                    number: true
                    required: true,
                    minlength: 10,
                    maxlength: 20
                }
            },
            messages:{
                name:{
                    required: "Nom de la societe est obligatoire.",
                    minlength: "le nom de la societe dois etre supperieur a 4 lettres au plus",
                    remote: "Le nom de cette société existe déjà se notre système , veillez contacter la centrale pour ample information"
                },
                rccm:{
                    required: "Le numero RCCM est obligatoire.",
                    minlength: "Le numero RCCM de la societe dois etre supperieur a 10 chiffres au plus",
                },
                ifu:{
                    required: "Le numero IFU est obligatoire.",
                    minlength: "Le numero IFU de la societe dois etre supperieur a 10 chiffres au plus",
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



        // Errors
        errorPlacement: function errorPlacement(error, element) {
            var $parent = $(element).parents('.form-group');
            // Do not duplicate errors
            if ($parent.find('.jquery-validation-error').length) {
                return;
            }
            $parent.append(
                error.addClass('jquery-validation-error small form-text invalid-feedback')
            );
        },
        highlight: function(element) {
            var $el = $(element);
            var $parent = $el.parents('.form-group');
            $el.addClass('is-invalid');
            // Select2 and Tagsinput
            if ($el.hasClass('select2-hidden-accessible') || $el.attr('data-role') === 'tagsinput') {
                $el.parent().addClass('is-invalid');
            }
        },
        unhighlight: function(element) {
            $(element).parents('.form-group').find('.is-invalid').removeClass('is-invalid');
        }
    });



</script>
