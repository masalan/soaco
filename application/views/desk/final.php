<div class="container">
    <div class="row">

        <div class="col-xl-4">

        </div>



        <div class="col-xl-8 ">
            <div class="card">



                <div class="card-header">
                    <h5 class="card-title">Attention</h5>
                    <h6 class="card-subtitle text-muted">Veillez lire avec Attention, ce qui est en dessous</h6>
                </div>
                <div class="card-body">
                    <?php if ($code->type ==6):?><!----Gaz----->
                        <?php $attributes = array('id' => 'validation-form','enctype' => 'multipart/form-data');
                        echo form_open(site_url('ravit/add_stock_gaz/'.$station->id), $attributes); ?>
                    <?php elseif($code->type ==4):?> <!----Lubrifiant----->
                        <?php $attributes = array('id' => 'validation-form','enctype' => 'multipart/form-data');
                        echo form_open(site_url('ravit/add_stock_fuel/'.$station->id), $attributes); ?>
                    <?php else:?>
                        <?php $attributes = array('id' => 'validation-form','enctype' => 'multipart/form-data');
                        echo form_open(site_url('ravit/add_stock/'.$station->id), $attributes); ?>
                    <?php endif;?>

                    <?php if ($code->type == 1):?>
                        <div class="alert alert-primary alert-outline alert-dismissible" role="alert">
                            <div class="alert-icon">
                                <i class="far fa-fw fa-bell"></i>
                            </div>
                            <div class="alert-message">
                                Inserrer la quantité <strong>d’Essence </strong>
                            </div>
                        </div>


                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Quantité </span>
                            </div>
                            <input type="number" class="form-control" placeholder="Quantité d’Essence" name="quantity">
                        </div>
                        <input type="hidden" name="prix" value="<?php echo $this->db->get_where('cd_price',array('type'=>1))->row()->prix;?>">
                        <input type="hidden" name="name" value="Essence">
                        <input type="hidden" name="type" value="1">

                    <?php elseif($code->type == 2):?>
                        <div class="alert alert-info alert-outline alert-dismissible" role="alert">
                            <div class="alert-icon">
                                <i class="far fa-fw fa-bell"></i>
                            </div>
                            <div class="alert-message">
                                Inserrer la quantité de<strong> Gasoil </strong>
                            </div>
                        </div>


                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Quantité </span>
                            </div>
                            <input type="text" class="form-control" data-mask="0000000000" data-reverse="true"    placeholder="Quantité de Gasoil" name="quantity">
                        </div>

                        <input type="hidden" name="type" value="2">
                        <input type="hidden" name="prix" value="575">
                        <input type="hidden" name="name" value="Gasoil">
                        <input type="hidden" name="prix" value="<?php echo $this->db->get_where('cd_price',array('type'=>2))->row()->prix;?>">

                    <?php elseif($code->type == 3):?>
                        <div class="alert alert-danger alert-outline alert-dismissible" role="alert">
                            <div class="alert-icon">
                                <i class="far fa-fw fa-bell"></i>
                            </div>
                            <div class="alert-message">
                                Inserrer la quantité de <strong>kérosène </strong>
                            </div>
                        </div>
                        <input type="hidden" name="type" value="3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Quantité </span>
                            </div>
                            <input type="text" class="form-control" data-mask="0000000000" data-reverse="true"    placeholder="Quantité de kérosène" name="quantity">
                        </div>
                        <input type="hidden" name="prix" value="600">
                        <input type="hidden" name="name" value="kérosène">
                        <input type="hidden" name="prix" value="<?php echo $this->db->get_where('cd_price',array('type'=>3))->row()->prix;?>">
                    <?php elseif($code->type == 4):?>


                        <div class="alert alert-info alert-outline alert-dismissible" role="alert">
                            <div class="alert-icon"><i class="far fa-fw fa-bell"></i></div>
                            <div class="alert-message">
                                Choisir <strong>la marque</strong> et <strong>le format d`huile</strong>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                                <select name="mark" class="form-control mb-2"  data-validate="required" id="mark"
                                        data-message-required="Selection obligatoire"
                                        onchange="return get_format_fuel(this.value)">
                                    <option selected>Selectionnez marque d`huile </option>

                                    <?php
                                   $mark_list   = $this->item->mark_oil_list($station->id);
                                    if(isset($mark_list) && count($mark_list->result())>0):
                                        foreach($mark_list->result() as $mk):?>
                                        <option  value="<?php echo $mk->id;?>"><?php echo $mk->name;?></option>
                                    <?php
                                    endforeach;
                                    else:?>
                                        <option selected> Aucune marque d`huile dispo! Créez-en dans la plateforme Adminstrateur</option>
                                    <?php endif; ?>

                            </select>
                        </div>
                        <div class="input-group mb-2">
                            <select class="custom-select mb-3" name="type" id="type"  data-validate="required">
                                <option selected>Selectionnez format d`huile </option>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Nombre de format </span>
                            </div>
                            <input type="text" class="form-control" data-mask="0000000000" data-reverse="true"   name="quantity"  placeholder="Entrez le nombre" required>
                        </div>
                        <input type="hidden" name="city_id" value="<?php echo $this->city->get_current_city()->id?>">
                        <input type="hidden" name="station_id" value="<?php echo $station->id?>">
                        <input type="hidden" name="name" value="Huile & Marques">
                    <?php elseif($code->type == 5):?>
                        <div class="alert alert-secondary alert-outline alert-dismissible" role="alert">
                            <div class="alert-icon">
                                <i class="far fa-fw fa-bell"></i>
                            </div>
                            <div class="alert-message">
                                Inserrer la quantité de <strong>Petrole </strong>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Quantité </span>
                            </div>
                            <input type="text" class="form-control" placeholder="Quantité de Petrole" name="quantity">
                        </div>
                        <input type="hidden" name="type" value="5">
                        <input type="hidden" name="name" value="Petrole">
                        <input type="hidden" name="prix" value="<?php echo $this->db->get_where('cd_price',array('type'=>5))->row()->prix;?>">
                        <?php elseif($code->type == 6):?>
                        <div class="alert alert-info alert-outline alert-dismissible" role="alert">
                            <div class="alert-icon">
                                <i class="far fa-fw fa-bell"></i>
                            </div>
                            <div class="alert-message">
                                Inserrer la nombre de <strong>Bouteille de Gaz </strong>
                            </div>
                        </div>

                    <div class="d-flex">
                        <select class="form-control" name="type" style="width: 100%">
                            <option selected>Selectionnez le format</option>


                            <?php
                            $service_list   = $this->item->get_gaz();
                            if(isset($service_list) && count($service_list->result())>0):
                                foreach($service_list->result() as $mk):?>
                                    <option  value="<?php echo $mk->type;?>"><?php echo $mk->name;?></option>
                                <?php
                                endforeach;
                            else:?>
                                <option selected> Aucun format dispo! Contactez votre responsable Adminstrateur</option>
                            <?php endif; ?>


                        </select></div>
                        <div class="clearfix"></div><br>


                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Nombre de Bouteille </span>
                            </div>
                            <input type="number" class="form-control" name="quantity"  placeholder="Entrez le nombre" required>
                        </div>

                        <input type="hidden" name="cd_fluid_id" value="6">
                        <input type="hidden" name="city_id" value="<?php echo $this->city->get_current_city()->id?>">
                        <input type="hidden" name="station_id" value="<?php echo $station->id?>">
                        <input type="hidden" name="prix" value="<?php echo $this->db->get_where('cd_price',array('type'=>6))->row()->prix;?>">
                        <input type="hidden" name="name" value="Bouteille de Gaz">

                    <?php endif;?>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Nom du fournisseur </span>
                        </div>
                        <input type="text" class="form-control" name="company_deliver"  value="<?php echo $code->company_deliver;?>" placeholder="Nom complet du fournisseur" readonly>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Numero du camion </span>
                        </div>
                        <input type="text" class="form-control" name="camion_number" value="<?php echo $code->camion_number;?>" placeholder="Numero de la plaque d`immatriculation" readonly>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Nom du chauffeur </span>
                        </div>
                        <input type="text" class="form-control" name="driver_name" value="<?php echo $code->driver_name;?>" placeholder="Nom du chauffeur du camion" readonly>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Telephone chauffeur</span>
                        </div>
                        <input type="text" class="form-control" name="driver_phone"  value="<?php echo $code->driver_phone;?>" placeholder="Numero de Telephone du chauffeur" readonly>
                    </div>

                    <input type="hidden" name="station_id" value="<?php echo $station->id;?>">
                    <input type="hidden" name="company_id" value="<?php echo $societe->user_id;?>">
                    <input type="hidden" name="fluid_log_id" value="<?php echo $societe->user_id;?>">
                    <input type="hidden" name="user_id" value="<?php echo $this->user->get_logged_in_user_info()->user_id;?>">
                    <input type="hidden" name="code" value="<?php echo $code->code;?>">
                    <input type="hidden" name="departement_id" value="<?php echo $station->city_id?>">
                    <input type="hidden" name="commune_id" value="<?php echo $station->cat_id?>">

                    <button type="submit" class="btn btn-primary">Terminer</button>

                    </form>


                </div>
            </div>
        </div>


        <div class="col-xl-2">
        </div>


    </div>
</div>
</div>



<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        // Initialize Select2 select box
        $('select[name="type"]').select2({
            allowClear: true,
            placeholder: 'Selectionne un produit...',
        }).change(function() {
            $(this).valid();
        });


        $('select[name="mark"]').select2({
            allowClear: true,
            placeholder: 'Selectionne un produit...',
        }).change(function() {
            $(this).valid();
        });

        // Initialize Select2 multiselect box mark
        $('select[name="validation-select2-multi"]').select2({
            placeholder: 'Select gear...',
        }).change(function() {
            $(this).valid();
        });
        // Trigger validation on tagsinput change
        $('input[name="validation-bs-tagsinput"]').on('itemAdded itemRemoved', function() {
            $(this).valid();
        });
        // Initialize validation
        $('#validation-form').validate({
            ignore: '.ignore, .select2-input',
            focusInvalid: false,
            rules: {
                'validation-email': {
                    required: true,
                    email: true
                },
                'camion_number': {
                    required: true,
                },'driver_name': {
                    required: true,
                },'driver_phone': {
                    required: true,
                },
                'validation-password': {
                    required: true,
                    minlength: 6,
                    maxlength: 20
                },
                'validation-password-confirmation': {
                    required: true,
                    minlength: 6,
                    equalTo: 'input[name="validation-password"]'
                },
                'validation-required': {
                    required: true
                },
                'validation-url': {
                    required: true,
                    url: true
                },
                'validation-select': {
                    required: true
                },
                'validation-multiselect': {
                    required: true,
                    minlength: 2
                },
                'type': {
                    required: true
                },
                'mark':{
                    required: true
                },
                'validation-select2-multi': {
                    required: true,
                    minlength: 2
                },
                'validation-text': {
                    required: true
                },
                'validation-file': {
                    required: true
                },
                'validation-radios': {
                    required: true
                },
                'validation-radios-custom': {
                    required: true
                },
                'validation-checkbox': {
                    required: true
                },
                'validation-checkbox-custom': {
                    required: true
                },
                'validation-checkbox-group-1': {
                    require_from_group: [1, 'input[name="validation-checkbox-group-1"], input[name="validation-checkbox-group-2"]']
                },
                'validation-checkbox-group-2': {
                    require_from_group: [1, 'input[name="validation-checkbox-group-1"], input[name="validation-checkbox-group-2"]']
                },
                'validation-checkbox-custom-group-1': {
                    require_from_group: [1, 'input[name="validation-checkbox-custom-group-1"], input[name="validation-checkbox-custom-group-2"]']
                },
                'validation-checkbox-custom-group-2': {
                    require_from_group: [1, 'input[name="validation-checkbox-custom-group-1"], input[name="validation-checkbox-custom-group-2"]']
                }
            },
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
    });
</script>


<script type="text/javascript">

    function get_format_fuel(mark) {

        $.ajax({
            url: '<?php echo site_url('reglage/get_format_fuel/');?>' + mark ,
            success: function(response)
            {
                jQuery('#type').html(response);
            }
        });

    }

</script>