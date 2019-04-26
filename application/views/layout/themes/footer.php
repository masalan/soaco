

<!-- BEGIN primary modal -->

<div class="modal modal-colored modal-primary fade" id="NosServices" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nos Services - <?php echo $societe->fullname ;?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body m-3">
                <p class="mb-0"><?php echo $societe->nosServices ;?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>
<!-- END primary modal -->
<!-- BEGIN success modal -->

<div class="modal modal-colored modal-success fade" id="Centrale" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $societe->fullname ;?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body m-3">
                <?php echo $societe->about_me ;?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>
<!-- END success modal -->
<!-- BEGIN danger modal -->

<div class="modal modal-colored modal-danger fade" id="Aides" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">

    <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Besoin D`aide</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body m-6">
                <address>
                    <strong>SOACO, Inc.</strong><br />
                    1355 Market St, Suite 900<br />
                    COTONOU,BENIN Bj 94103<br />
                    <abbr title="Phone">P:</abbr> (123) 456-7890
                </address>

                <address>
                    <strong>AKAMBI Joseph</strong><br />
                    <a href="mailto:services@soaco.com">services@soaco.com</a>
                </address>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>
<!-- END danger modal -->
<!-- BEGIN warning modal -->

<div class="modal modal-colored fade" id="ContactesMe" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Contactez- SOACO e-Station</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body m-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Décrivez-nous votre préoccupation ou problème.
                            Merci</h5>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control" rows="3" placeholder="Je voudrais modifier..." name="station_mail"></textarea>
                    </div>
                </div>            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Ferme</button>
                <button type="button" class="btn btn-light"  data-dismiss="modal">Envoyez</button>
            </div>
        </div>
    </div>
</div>
<!-- END warning modal -->


<!-- BEGIN  modal  NOTES-->
<div class="modal fade" id="notesStation" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Notes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php $attributes = array('id' => 'validation-form','enctype' => 'multipart/form-data');
            echo form_open(site_url("sent_notes/".url_encode($station->id)), $attributes); ?>
            <div class="modal-body m-3">
                <div class="card">
                    <div class="card-body">

                        <div class="row">

                         <div class="col-12 col-xl-6">
                                <div class="form-group">
                            <input type="text" class="form-control" name="titre_msg" placeholder="Entrez un sujets" required="required">
                               </div>
                        </div>

                            <div class="col-12 col-xl-6">
                                <div class="form-group">
                                    <select class="custom-select" name="type_msg">
                                        <option >Selectionner...</option>
                                        <option value="1">Notes journaliere</option>
                                        <option value="1">Message  à <?php echo html_entity_decode($societe->fullname );?></option>
                                        <option value="1">Message  à SOACO e-Station</option>
                                    </select>
                                </div>
                            </div>

                    </div>

                </div>

                <div class="card-body">
                    <div class="clearfix">
                        <div id="quill-toolbar">
			<span class="ql-formats">
              <select class="ql-font"></select>
              <select class="ql-size"></select>
            </span>
                            <span class="ql-formats">
              <button class="ql-bold"></button>
              <button class="ql-italic"></button>
              <button class="ql-underline"></button>
              <button class="ql-strike"></button>
            </span>
                            <span class="ql-formats">
              <select class="ql-color"></select>
              <select class="ql-background"></select>
            </span>
                            <span class="ql-formats">
              <button class="ql-script" value="sub"></button>
              <button class="ql-script" value="super"></button>
            </span>
                            <span class="ql-formats">
              <button class="ql-header" value="1"></button>
              <button class="ql-header" value="2"></button>
              <button class="ql-blockquote"></button>
              <button class="ql-code-block"></button>
            </span>
                            <span class="ql-formats">
              <button class="ql-list" value="ordered"></button>
              <button class="ql-list" value="bullet"></button>
              <button class="ql-indent" value="-1"></button>
              <button class="ql-indent" value="+1"></button>
            </span>
                            <span class="ql-formats">
              <button class="ql-direction" value="rtl"></button>
              <select class="ql-align"></select>
            </span>
                            <span class="ql-formats">
              <button class="ql-link"></button>
              <button class="ql-image"></button>
              <button class="ql-video"></button>
            </span>
                            <span class="ql-formats">
              <button class="ql-clean"></button>
            </span>
                        </div>
                        <textarea id="quill-editor" name="message" class="form-control" rows="4" style="width: 100%;"></textarea>
                    </div>
                </div>
            </div>
            <input type="hidden" name="city_id" value="<?php echo $this->city->get_current_city()->id?>">
            <input type="hidden" name="station_id" value="<?php echo $station->id?>">
            <input type="hidden" name="email" value="<?php echo $station->user_email?>">
            <input type="hidden" name="commune_id" value="<?php echo $station->cat_id?>">
            <input type="hidden" name="user_id" value="<?php echo $this->user->get_logged_in_user_info()->user_id?>">
            <input type="hidden" name="name" value="<?php echo html_entity_decode($station->gerant_name);?> ">
            <input type="hidden" name="station_id" value="<?php echo $station->id?>">
            <input type="hidden" name="is_sending_by_station" value="1">
            <input type="hidden" name="company_id" value="<?php echo html_entity_decode($societe->user_id );?>">
            <input type="hidden" name="country_id" value="<?php echo html_entity_decode($societe->country_id );?>">

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ferme</button>
                <button type="submit" class="btn btn-danger">Envoyez</button>
            </div>

            </form>

        </div>
    </div>
</div>
<!-- END  modal -->



<!-- BEGIN success modal -->

<div class="modal fade" id="sti" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Service Temporairement indisponible (STI)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body m-3">
                <p class="mb-0">Nous sommes desoler de vous informez que ce service est temporairement indispoble, pour plus d`information, veillez contacter votre service le plus proche</p>
            </div>
            <div class="media-body">
                <h4 class="mb-1 text-white font-weight-normal"> <i class="align-middle mr-1 fas fa-fw fa-home"></i> <?php echo html_entity_decode($societe->fullname );?></h4>
                <span style="font-size: 11px;" class=" font-weight-normal"><i class="align-middle mr-1 fas fa-fw fa-location-arrow"></i>  <?php echo html_entity_decode($station->name);?>
                    <?php echo  $societe->company_phone;?> <i class="align-middle mr-1 fas fa-fw fa-phone"></i></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Merci</button>
            </div>
        </div>
    </div>
</div>
<!-- END success modal -->






<div class="modal modal-colored modal-primary fade" id="checkMycardsNow" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">vérification  de  de la carte</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php $attributes = array('id' => 'upload-form','enctype' => 'multipart/form-data');
            echo form_open(site_url("check_code"), $attributes); ?>
            <div class="card-body">
                <input  class="form-control form-control-lg mb-3" name="code"  type="text" placeholder="Numero de la carte" required="required">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ferme</button>
                <button type="submit" class="btn btn-warning">vérification </button>
            </div>
            </form>
        </div>
    </div>
</div>



<footer class="footer">
    <div class="container">
        <hr />
        <div class="text-muted text-center">
            <ul class="list-inline mb-2">
                <li class="list-inline-item">
                    <a class="text-muted" href="#" data-toggle="modal" data-target="#NosServices">Nos Services</a>
                </li>
                <li class="list-inline-item">
                    <a class="text-muted" href="#" data-toggle="modal" data-target="#Centrale">Nous</a>
                </li>
                <li class="list-inline-item">
                    <a class="text-muted" href="#" data-toggle="modal" data-target="#Aides">SOACO - Aides</a>
                </li>
                <li class="list-inline-item">
                    <a class="text-muted" href="#" data-toggle="modal" data-target="#ContactesMe">Contactes</a>
                </li>
            </ul>
            <p>
                &copy; Copyrights <?= date('Y') ?> <?php echo $societe->fullname ;?>. All Rights Reserved
                <a href="<?php echo base_url()?>soaco_e-Station" class="text-white"><?php echo $this->db->get_where('settings' , array('type'=>'system_name'))->row()->description; ?></a>
            </p>
        </div>
    </div>
</footer>

</div>
</div>
<script src=" <?php echo base_url('st/js/app.js');?>"></script>

<script src=" <?php echo base_url('js/bootstrap.js');?>"></script>


<!-- Load Font Awesome's CSS for Bootstrap Markdown pseudo element icons -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ"
      crossorigin="anonymous">

<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        if (!window.Quill) {
            return $('#quill-editor,#quill-toolbar,#quill-bubble-editor,#quill-bubble-toolbar').remove();
        }
        var editor = new Quill('#quill-editor', {
            modules: {
                toolbar: '#quill-toolbar'
            },
            placeholder: 'Descrivez l`anomalie ou le probleme constater',
            theme: 'snow'
        });
        var bubbleEditor = new Quill('#quill-bubble-editor', {
            placeholder: 'Compose an epic...',
            modules: {
                toolbar: '#quill-bubble-toolbar'
            },
            theme: 'bubble'
        });
    });

// Mode de paiement
    $(function() {
        var $span = $('span.group');
        var $div = $('div.group');
        $div.each(function() { $('div',this).first().show(); });
        $('input[type=radio]').on('change',function() {
            var group = $span.index( $(this).closest( 'span.group' ) );
            $div.eq( group ).children().hide();
            $div.eq( group ).children().eq( $('span.group:eq(' + group + ') > input[type=radio]').index( this ) ).show();
        });
    });
</script>


<svg width="0" height="0" style="position:absolute">
    <defs>
        <symbol viewBox="0 0 512 512" id="ion-ios-pulse-strong">
            <path
                    d="M448 273.001c-21.27 0-39.296 13.999-45.596 32.999h-38.857l-28.361-85.417a15.999 15.999 0 0 0-15.183-10.956c-.112 0-.224 0-.335.004a15.997 15.997 0 0 0-15.049 11.588l-44.484 155.262-52.353-314.108C206.535 54.893 200.333 48 192 48s-13.693 5.776-15.525 13.135L115.496 306H16v31.999h112c7.348 0 13.75-5.003 15.525-12.134l45.368-182.177 51.324 307.94c1.229 7.377 7.397 11.92 14.864 12.344.308.018.614.028.919.028 7.097 0 13.406-3.701 15.381-10.594l49.744-173.617 15.689 47.252A16.001 16.001 0 0 0 352 337.999h51.108C409.973 355.999 427.477 369 448 369c26.511 0 48-22.492 48-49 0-26.509-21.489-46.999-48-46.999z">
            </path>
        </symbol>
    </defs>
</svg>



<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        // Initialize Select2 select box
        $('select[name="type"]').select2({
            allowClear: true,
            placeholder: 'Selectionne un produit...',
        }).change(function() {
            $(this).valid();
        });
        // Initialize Select2 select box
        $('select[name="pay_id"]').select2({
            allowClear: true,
            placeholder: 'Selectionne un produit...',
        }).change(function() {
            $(this).valid();
        });

        $('select[name="type_msg"]').select2({
            allowClear: true,
            placeholder: 'Selectionne ...',
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
                'pay_id': {
                    required: true,
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
                'titre_msg': {
                    required: true,
                },
                'type_msg': {
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







</body>
</html>