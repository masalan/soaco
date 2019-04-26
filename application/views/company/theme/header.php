<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="page_article ltr fr no-js ie ie6 lte9 lte8 lte7" xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" dir="ltr"> <![endif]-->
<!--[if IE 7 ]>    <html class="page_article ltr fr no-js ie ie7 lte9 lte8 lte7" xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" dir="ltr"> <![endif]-->
<!--[if IE 8 ]>    <html class="page_article ltr fr no-js ie ie8 lte9 lte8" xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" dir="ltr"> <![endif]-->
<!--[if IE 9 ]>    <html class="page_article ltr fr no-js ie ie9 lte9" xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" dir="ltr"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="<?php echo base_url('/images/favicon.ico'); ?>">
    <meta name="description" content="">
    <meta name="author" content="<?php echo $societe->company_name.'|'.$page_title; ?>">
    <link rel="icon" href="favicon.ico">

    <title><?php echo $societe->company_name.'|'.$page_title; ?></title>
    <meta property="og:title" content="Profile">
    <meta name="author" content="">
    <meta property="og:locale" content="fr_FR">
    <meta name="description" content="">
    <meta property="og:description" content="">
    <link rel="canonical" href="<?php echo base_url('company').url_encode($this->user->get_logged_in_user_info()->user_id)?>">
    <meta property="og:url" content="">
    <meta property="og:site_name" content="">

    <!-- FAVICONS -->
    <link rel="apple-touch-icon" sizes="144x144" href="">
    <link rel="shortcut icon" href="">
    <meta name="theme-color" content="#3063A0"><!-- End FAVICONS -->
    <!-- GOOGLE FONT -->
        <link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600" rel="stylesheet"><!-- End GOOGLE FONT
    <!-- BEGIN PLUGINS STYLES -->
    <link rel="stylesheet" href="<?php echo base_url('cp/assets/vendor/open-iconic/css/open-iconic-bootstrap.min.css  ');?>">
    <link rel="stylesheet" href="<?php echo base_url('cp/assets/vendor/fontawesome/css/all.css  ');?>">
    <link rel="stylesheet" href="<?php echo base_url('cp/assets/vendor/flatpickr/flatpickr.min.css ');?>"><!-- END PLUGINS STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link rel="stylesheet" href="<?php echo base_url('cp/assets/stylesheets/theme.min.css  ');?>" data-skin="default">
    <link rel="stylesheet" href="<?php echo base_url('cp/assets/stylesheets/theme-dark.min.css  ');?>" data-skin="dark">
    <link rel="stylesheet" href="<?php echo base_url('cp/assets/stylesheets/custom.css  ');?>"><!-- Disable unused skin immediately -->


    <script>
        var skin = localStorage.getItem('skin') || 'default';
        var unusedLink = document.querySelector('link[data-skin]:not([data-skin="' + skin + '"])');
        unusedLink.setAttribute('rel', '');
        unusedLink.setAttribute('disabled', true);
    </script><!-- END THEME STYLES -->
</head>
<body>
<!-- .app -->
<div class="app has-fullwidth">

    <!--[if lt IE 10]>
    <div class="page-message" role="alert">You are using an <strong>outdated</strong> browser. Please <a class="alert-link" >upgrade your browser</a> to improve your experience and security.</div>
    <![endif]-->
    <!-- .app-header -->

    <header class="app-header app-header-dark">