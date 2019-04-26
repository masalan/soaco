<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" type="image/png" href="<?php echo base_url('/images/favicon.ico'); ?>">

    <title>
        <?php
        $this->lang->load('ps', 'english');
        echo $this->lang->line('site_title');
        ?>
    </title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('css/bootstrap.min.css');?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url('fonts/ptsan/stylesheet.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('css/dashboard.css');?>" rel="stylesheet">


    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url('js/jquery.js');?>"></script>
    <script src="<?php echo base_url('js/bootstrap.min.js');?>"></script>
    <script src="<?php echo base_url('js/dashboard.js');?>"></script>
    <script src="<?php echo base_url('js/jquery.validate.js');?>"></script>

    <?php $this->load->view( 'analytic' ); ?>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


    <style>
        body {
            background-color: #ffffff;
        }

        .left-login {
            height: auto;
            min-height: 100%;
            background: #fff;
            -webkit-box-shadow: 2px 0px 7px 1px rgba(0, 0, 0, 0.08);
            -moz-box-shadow: 2px 0px 7px 1px rgba(0, 0, 0, 0.08);
            box-shadow: 2px 0px 7px 1px rgba(0, 0, 0, 0.08);
        }

        .left-login-panel {
            -webkit-box-shadow: 0px 0px 28px -9px rgba(0, 0, 0, 0.74);
            -moz-box-shadow: 0px 0px 28px -9px rgba(0, 0, 0, 0.74);
            box-shadow: 0px 0px 28px -9px rgba(0, 0, 0, 0.74);
        }

        .apply_jobs {
            position: absolute;
            z-index: 1;
            right: 0;
            top: 0
        }

        .login-center {
            background: #fff;
            width: 400px;
            margin: 0 auto;
        }

        @media only screen and (max-width: 380px) {
            .login-center {
                width: 320px;
                padding: 10px;
            }

            .wd-xl {
                width: 260px;
            }
        }
    </style>
</head>

<?php $this->load->view( 'ads' ); ?>

<body background="<?php echo base_url('images/a.jpg'); ?>">
<div class='fluid-container'>
    <div class='row'>
        <div class='col-sm-4 col-sm-offset-4 left-login'>
            <div class="wrapper" style="margin: 20% 0 0 auto">
                <div class="block-center mt-xl wd-xl">

                    <div class="text-center" style="margin-bottom: 20px">
                        <img style="width: 100%;" src="http://ecolerecher:8888/uploads/sd.png" class="m-r-sm">
                    </div>

                    <div class="panel-body">
                        <?php
                        $attributes = array('id' => 'login-form','method' => 'POST');
                        echo form_open(site_url('login'), $attributes);
                        ?>

                        <!--            <h2>-->
                        <!--                <label class="login-title">-->
                        <!--                    --><?php //echo $this->lang->line('f_hero_text'); ?>
                        <!--                </label>-->
                        <!--            </h2>-->
                        <!--            <hr/>-->
                        <?php if( null != $this->session->flashdata('success')):?>
                            <div class='alert alert-success fade in'>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <?php echo $this->session->flashdata('success');?>
                            </div>
                        <?php elseif( null != $this->session->flashdata('error')):?>
                            <div class='alert alert-danger fade in'>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <?php echo $this->session->flashdata('error');?>
                            </div>
                        <?php endif;?>


                        <div class="form-group has-feedback">
                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon2"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></span>
                                <?php
                                echo form_input( array(
                                    'type' => 'text',
                                    'name' => 'user_email',
                                    'id' => 'inputEmail',
                                    'class' => 'form-control',
                                    'placeholder' => 'votre e-mail ou Pseudo',
                                    'value' => ''
                                ));
                                ?>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="form-group has-feedback">
                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon2"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></span>
                                <input class="form-control" type="password" id="inputPassword" placeholder="Votre mot de passe" name='user_pass'>
                                <span class="fa fa-lock form-control-feedback text-muted"></span>
                            </div></div>

                        <button class="btn btn-primary" type="submit">Connexion</button>

                        <?php echo form_close();  ?>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#login-form').validate({
            rules:{
                user_email: {
                    required: true,
                    // email: true
                },
                user_pass: "required"
            },
            messages:{
                user_email: {
                    required: "Votre pseudo est obligtoire",
                    // email: "Invalid Email Address"
                },
                user_pass: "Votre Mot de passe est obligtoire"
            }
        });
    });
</script>
</body>
</html>