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
    <meta name="author" content="SOACO e-Station">
    <link rel="icon" href="favicon.ico">

    <title><?php echo $page_title; ?></title>
    <link href="<?php echo base_url('st/css/app.css');?>" rel="stylesheet">
    <script src="<?php echo base_url('st/js/settings.js ');?>"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->




    <style type="text/css">
        html,
        body {
            position: relative;
            width: 100%;
            height: 100%;
            background-color:#0c4573;
            /*background-image: url("/uploads/1-background1.jpg");*/
            background-repeat: repeat-y;
            background-size: cover;
            display: block;


        }

        .print_invoice {

            position: relative;

            width: 21cm;
            min-height: 29.7cm;
            padding: 0cm;
            margin: 1cm auto;
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);


        }

        .hide {
            display: none;
        }
        div.group div {
            display:none;
        }
        .print_invoice:after {
            content: '';
            width: 7px;
            display: block;
            height: 100px;
            position: absolute;
            top: 105px;
            border-radius: 0 5px 5px 0;
        }

        .print_invoice:before {
            content: '';
            width: 7px;
            display: block;
            height: 100px;
            position: absolute;
            top: 105px;
            left: 222px;
            border-radius: 5px 0 0 5px;
        }


        @page  {
            size: A5; margin-top: 0cm;
        }
        @page :left {
            margin-left: 3cm;
        }
        @page :right {
            margin-left: 4cm;
        }
    </style>





</head>
<body class="theme-blue">
<div class="splash active">
    <div class="splash-icon"></div>
</div>
<!-----
<body >
<div class="splash active">
    <div class="splash-icon"></div>
</div>
--->
