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
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>
    	<?php
    		$this->lang->load('ps', 'english');
    		echo $this->lang->line('site_title');
    	?>
    </title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('css/bootstrap.min.css');?>" rel="stylesheet">
	 <link href="<?php echo base_url('fonts/ptsan/stylesheet.css');?>" rel="stylesheet">
	 <link href="<?php echo base_url('css/animate.css');?>" rel="stylesheet">
	 <link href="<?php echo base_url('css/dashboard.css');?>" rel="stylesheet">
	 <!-- Font CSS -->
	 <link href="<?php echo base_url('css/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">
    


    <?php $this->load->view( 'analytic' ); ?>

	</head>
	<body>

		<?php $this->load->view( 'ads' ); ?>
		
		<div class="navbar navbar-fixed-top" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">	
						<label class="login-title"><?php echo $this->lang->line('site_title'); ?></label>
					</a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">

						<li class="nav-item">
							<a class="nav-link" href="<?php echo site_url(); ?>">
                                <?php echo $this->lang->line('dashboard_label'); ?>
							</a>
						</li>

						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								Mon compte
								<b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
								<li>
									<div class="navbar-content">

										<?php $logged_in_user = $this->user->get_logged_in_user_info();?>

										<div class="row">
											<div class="col-md-5">
												<img src="<?php echo validate_photo( $logged_in_user->profile_photo, 'profile' );?>" alt="Alternate Text" class="img-responsive"/>
<!--												<p class="text-center small">-->
<!--													<a href="#">Change Photo</a>-->
<!--												</p>-->
											</div>
											<div class="col-md-7">
												<span><?php echo $logged_in_user->user_name;?></span>
												<p class="text-muted small"><?php echo $this->role->get_name($logged_in_user->role_id);?></p>
												<div class="divider"></div>
<!--												<a href="--><?php //echo site_url('profile');?><!--" class="btn btn-sm active">Edit Profile</a>-->
											</div>
										</div>
									</div>
									<div class="navbar-footer">
										<div class="navbar-footer-content">
											<div class="row">
												<div class="col-md-6">
													<a href="<?php echo site_url('profile');?>" class="btn btn-default btn-sm" style="background-color: #fff; border-radius: 0;">Modifier</a>
												</div>
												<div class="col-md-6">
													<a href="<?php echo site_url('logout');?>" class="btn btn-default btn-sm pull-right" style="background-color: #fff; border-radius: 0;">Sortir</a>
												</div>
											</div>
										</div>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
		
		<div class="container-fluid animated fadeInRight">
			<div class="row" style="padding: 10px 0px;">
				<div class="col-md-12 text-center">
					<?php
						$attributes = array('id' => 'category-form', 'class'=>'form-inline'); 
						echo form_open(site_url('cities'), $attributes);
					?>
					  <div class="form-group">
					    <label class="sr-only" for="cityname">City Name</label>
					    <input name="searchterm" type="text" class="form-control" id="cityname" placeholder="<?php echo $this->lang->line('enter_city_name'); ?> "
					     style="width: 300px" value='<?php echo (isset($searchterm))? $searchterm: ""; ?>'>
					  </div>
					  
					  <button type="submit" class="btn btn-primary"> 
					  		<span class='fa fa-search'></span> &nbsp; <?php echo $this->lang->line('btn_search_city'); ?>
					  </button> <br><br>
					  
					  <?php if ( $this->user->get_logged_in_user_info()->is_owner ): ?>
					  
					  <a class="btn btn-primary" href="<?php echo site_url('cities/create');?>"> 
					  	<span class='fa fa-plus-square-o'></span> &nbsp; <?php echo $this->lang->line('btn_create_new_city'); ?>
					  </a>

					  <?php endif; ?>
					  					  
					  <?php if ( $this->user->is_system_user()): ?>
					  <a class="btn btn-primary" href="<?php echo site_url('cities/approval');?>"> 
					  	<span class='fa fa-list'></span> &nbsp; <?php echo $this->lang->line('btn_approval_list'); ?>					  
					  	</a>
					  <a class="btn btn-primary" href="<?php echo site_url('cities/paypal_config');?>"> 
					  	<span class='fa fa-gear'></span> &nbsp; <?php echo $this->lang->line('btn_paypal_config'); ?>
					  </a>
					  <a class="btn btn-primary" href="<?php echo site_url('cities/send_gcm');?>"> 
					  	<span class='fa fa-send-o'></span> &nbsp; <?php echo $this->lang->line('btn_push_notification'); ?>
					  </a>
					  <a class="btn btn-primary" href="<?php echo site_url('abouts');?>"> 
					  	<span class='fa fa-info-circle'></span> &nbsp; <?php echo $this->lang->line('btn_about_app'); ?>
					  </a> 	
					<?php endif; ?>
						
					  
					
					</form>
				</div>
			</div>
			
			
			<?php
				$index = 0;
				foreach ($cities as $city) {
					if (($index % 3) == 0) {
						echo '<div class="row">';
					}
					$index++;
			?>
			
			<div class="col-md-4">
				<div class="grid" style="text-align: left;">
					<div class="ibox float-e-margins">
					        <div class="ibox-title">
					            <h4><strong><?php echo $city->name; ?></strong></h4>
					        </div>
					        <div>
					            <div class="ibox-content no-padding border-left-right">
					                <a href="<?php echo site_url('dashboard/index/'.url_encode($city->id));?>">
						                <?php
						                	echo "<img alt='image' class='img-responsive' src='".base_url('uploads/'.$city->image)."'/>";
						                ?>
					                </a>
					            </div>
					            <div class="ibox-content profile-content">
					                <h5>
					                    <strong>Address</strong>
					                </h5>
					                <p><i class="fa fa-map-marker" style="padding-right: 5px;"></i><?php echo $city->address; ?></p>
					                <h5>
					                    <strong>A propos de nous</strong>
					                </h5>
					                <p>
					                    <?php 
					                    	
					                    	$cityDesc = strip_tags($city->description);
					                    	
					                    	if (strlen($cityDesc) > 200) {
					                    	
					                    	    $stringCut = substr($cityDesc, 0, 200);
					                
					                    	    $cityDesc = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
					                    	}
					                    	
					                    	echo $cityDesc;
					                    	
					                    ?>
					                </p>
					                <div class="row m-t-lg">
					                    
					                    <div class="col-md-4">
					                        <span class="bar">5,3,9,6,5,9,7,3,5,2</span>
					                        <p><?php echo $this->category->count_all($city->id) ?>  <?php echo $this->lang->line('f_categories'); ?></p>
					                    </div>
					                    <div class="col-md-4">
					                        <span class="bar">5,3,9,6,5,9,7,3,5,2</span>
					                        <p><?php echo $this->item->count_all($city->id) ?> <?php echo $this->lang->line('f_items'); ?></p>
					                    </div>
					                    <div class="col-md-4">
					                        <span class="bar">5,3,9,6,5,9,7,3,5,2</span>
					                        <p><?php echo $this->inquiry->count_all($city->id) ?> <?php echo $this->lang->line('f_inquiry'); ?></p>
					                    </div>
					                </div>
					                <div class="user-button">
					                    <div class="row">
					                        <a href="<?php echo site_url('dashboard/index/'.url_encode($city->id));?>">
					                        	<button type="button" class="btn btn-primary btn-sm btn-block"><i class="fa fa-dashboard" style="padding-right: 5px;"></i><?php echo $this->lang->line('dashboard_label'); ?></button>
					                        </a>
					                    </div>
					                </div>
					            </div>
					    </div>
				    </div>
				</div>
			</div>
			
			<?php
					if (($index % 3) == 0) {
						echo '</div>';
					}
				}
			?>
			
		</div>
		
	</body>
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="<?php echo base_url('js/jquery.js');?>"></script>
  <script src="<?php echo base_url('js/bootstrap.min.js');?>"></script>
  <script src="<?php echo base_url('js/jquery.validate.js');?>"></script>

  <script src="<?php echo base_url('js/peity/jquery.peity.min.js');?>"></script>
  <script src="<?php echo base_url('js/peity/peity-demo.js');?>"></script>

	<script>
	    $(document).ready(function(){
	        $('.grid').each(function() {
	            animationHover(this, 'pulse');
	        });
	    });
	    
	    function animationHover(element, animation){
	        element = $(element);
	        element.hover(
	            function() {
	                element.addClass('animated ' + animation);
	            },
	            function(){
	                window.setTimeout( function(){
	                    element.removeClass('animated ' + animation);
	                }, 1500);
	            });
	    }
	</script>
</html>