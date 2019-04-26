<div class="container">
    <div class="row">

        <div class="col-xl-2">

        </div>



        <div class="col-xl-8 ">
            <div class="card">

                <div class="card-header">
                    <h5 class="card-title">Attention</h5>
                    <h6 class="card-subtitle text-muted">Veuillez lire avec Attention, ce qui est en dessous</h6>
                </div>

                <div class="card-body">
                    <p class="card-text">Veuillez entrer le Numero de carte pour continuer </p>
                    <?php $attributes = array('id' => 'validation-form','enctype' => 'multipart/form-data');
                    echo form_open(site_url("check_code"), $attributes); ?>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend ">
                            <span class="input-group-text text-danger">Numero de carte</span>
                        </div>
                        <input type="text" class="form-control" name="code" placeholder="Numero de carte" required="required" autofocus>
                    </div>

                    <a href="<?php echo base_url('soaco_e-Station/').url_encode($station->id);?>" class="btn btn-danger right-btn">Annuler</a>

                    <button type="submit" class="btn btn-primary">verification</button>

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
        // Initialize Select2 multiselect box
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

                'code': {
                    required: true,
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
