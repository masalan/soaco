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


      <script type='text/javascript'
              src='http://code.jquery.com/jquery-1.8.3.js'></script>
      <script type='text/javascript'
              src="http://cdn.jsdelivr.net/select2/3.4.1/select2.min.js"></script>
      <link rel="stylesheet" type="text/css"
            href="http://cdn.jsdelivr.net/select2/3.4.1/select2.css">
      <script type='text/javascript'
              src="http://globaltradeconcierge.com/javascripts/bootstrap.min.js"></script>
      <script type='text/javascript'>
          $(window).load(function(){<!-- w  ww.j a  v a 2 s.  c  o  m-->
              $('#chz-select').select2();
          });
      </script>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('css/bootstrap.min.css');?>" rel="stylesheet">
      <link href="<?php echo base_url('css/bootstrap-theme.min.css');?>" rel="stylesheet">
      <link href="<?php echo base_url('css/ajax-bootstrap-select.css');?>" rel="stylesheet">


      <!-- Menu CSS -->
    <link href="<?php echo base_url('css/menu/metisMenu.min.css');?>" rel="stylesheet">

    <!-- Font CSS -->
    <link href="<?php echo base_url('css/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">

    <!-- Animation core CSS -->
    <link href="<?php echo base_url('css/animate.css');?>" rel="stylesheet">

    <!-- Custom styles for this template -->
	 <link href="<?php echo base_url('fonts/ptsan/stylesheet.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('css/dashboard.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet">
    
    <!-- For Calendar -->
<!---->
<!--    <link href="--><?php //echo base_url('css/fullcalendar/fullcalendar.css');?><!--" rel="stylesheet">-->
<!--    <link href="--><?php //echo base_url('css/fullcalendar/fullcalendar.print.css');?><!--" rel='stylesheet' media='print'>-->

      <script src=" <?php echo base_url('st/js/app.js');?>"></script>
      <link href="<?php echo base_url('css/app.css');?>" rel="stylesheet">
    <?php $this->load->view( 'analytic' ); ?>


      <style type="text/css">
          .column_2{
              -webkit-column-count: 2; /* Chrome, Safari, Opera */
              -moz-column-count: 2; /* Firefox */
              column-count: 2;
          }
          .column_2>span{
              display:block;
          }


      </style>
  </head>

  <body>
  
    <?php $this->load->view( 'ads' ); ?>