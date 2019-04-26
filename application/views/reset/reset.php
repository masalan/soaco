<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="page_article ltr fr no-js ie ie6 lte9 lte8 lte7" xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" dir="ltr"> <![endif]-->
<!--[if IE 7 ]>    <html class="page_article ltr fr no-js ie ie7 lte9 lte8 lte7" xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" dir="ltr"> <![endif]-->
<!--[if IE 8 ]>    <html class="page_article ltr fr no-js ie ie8 lte9 lte8" xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" dir="ltr"> <![endif]-->
<!--[if IE 9 ]>    <html class="page_article ltr fr no-js ie ie9 lte9" xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" dir="ltr"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="SOACO e-Station est le systeme de digitalisation de Station a Gaz en Republique de Benin">
    <meta name="author" content="SOACO e-Station">

    <link rel="icon" type="image/png" href="<?php echo base_url('/images/favicon.ico'); ?>">
    <meta name="description" content="">
    <meta name="author" content="SOACO e-Station">
    <link rel="icon" href="favicon.ico">

    <title><?php echo $page_title; ?></title>
    <link href="<?php echo base_url('st/css/app.css');?>" rel="stylesheet">

    <style type="text/css">

        /*
                * Base structure
                */

        html,
        body {
            position: relative;
            width: 100%;
            height: 100%;
            /*background-color:black;*/
            /*background-image: url("/images/a.jpg");*/
            background-repeat:repeat-x;
            /*background-size: cover;*/
            display: block;
        }


    </style>

</head>

<body>
<main class="main h-100 w-100">
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                <div class="d-table-cell align-middle">

                    <div class="text-center mt-4">
                        <h1 class="h2">Bienvenue a SOACO e-Station</h1>
                        <p class="lead">
                            Ajoutez un nouveau mot de passe à votre compte SOACO e-Station
                        </p>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <?php if( null != $this->session->flashdata('success')):?>
                                <div class="alert alert-primary alert-dismissible" role="alert">
                                    <div class="alert-icon">
                                        <i class="far fa-fw fa-bell"></i>
                                    </div>
                                    <div class="alert-message">
                                        <strong>Salut! </strong> <?php echo $this->session->flashdata('success');?>
                                    </div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php elseif( null != $this->session->flashdata('error')):?>
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <div class="alert-icon">
                                        <i class="far fa-fw fa-bell"></i>
                                    </div>
                                    <div class="alert-message">
                                        <strong>Salut! </strong><?php echo $this->session->flashdata('error');?>
                                    </div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif;?>

                            <div class="m-sm-4">
                                <div class="text-center">
                                    <img src="<?php echo base_url('uploads/');?>pump.png" alt="SOACO e-Station" class="img-fluid rounded-circle" width="132" height="132" />
                                </div>
                                <div class="clearfix mt-4"></div>
                                <?php
                                $attributes = array('id' => 'login-form','method' => 'POST');
                                echo form_open(site_url('reset/'.$code), $attributes);
                                ?>

                                <div class="input-group input-group-lg mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ion ion-ios-call mr-2"></i></span>
                                    </div>
                                    <input class="form-control" type="password" id="password" placeholder="Entrez votre nouveau mot de passe valide" name='password' required autocomplete="off">

                                </div>

                                <div class="input-group input-group-lg mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ion ion-ios-lock mr-2"></i></span>
                                    </div>
                                    <input class="form-control" type="password" id="conf_password" placeholder="Confirmez votre nouveau mot de passe valide" name='conf_password' required autocomplete="off">
                                </div>

                            <div class="text-center mt-3">
                                <button class="btn btn-lg btn-primary" type="submit">Réinitialisez</button>
                                <a href="<?php echo base_url('station');?>" class="btn btn-lg btn-danger" style="color: white;">Annuler</a>


                            </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
</main>

<script>
    document.addEventListener("DOMContentLoaded", function(event) {

        // Initialize validation
        $('#login-form').validate({
            ignore: '.ignore, .select2-input',
            focusInvalid: false,
            rules: {
                'validation-email': {
                    required: true
                },
                'validation-password': {
                    required: true,
                    minlength: 6,
                    maxlength: 20
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

<script src="<?php echo base_url('st/js/app.js');?>"></script>
<svg width="0" height="0" style="position:absolute">
    <defs>
        <symbol viewBox="0 0 512 512" id="ion-ios-pulse-strong"><path d="M448 273.001c-21.27 0-39.296 13.999-45.596 32.999h-38.857l-28.361-85.417a15.999 15.999 0 0 0-15.183-10.956c-.112 0-.224 0-.335.004a15.997 15.997 0 0 0-15.049 11.588l-44.484 155.262-52.353-314.108C206.535 54.893 200.333 48 192 48s-13.693 5.776-15.525 13.135L115.496 306H16v31.999h112c7.348 0 13.75-5.003 15.525-12.134l45.368-182.177 51.324 307.94c1.229 7.377 7.397 11.92 14.864 12.344.308.018.614.028.919.028 7.097 0 13.406-3.701 15.381-10.594l49.744-173.617 15.689 47.252A16.001 16.001 0 0 0 352 337.999h51.108C409.973 355.999 427.477 369 448 369c26.511 0 48-22.492 48-49 0-26.509-21.489-46.999-48-46.999z"></path></symbol>
    </defs>
</svg>
</body>

</html>