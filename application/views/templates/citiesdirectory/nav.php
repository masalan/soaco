<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li>
					<?php
						if ($this->session->userdata('city_id') != "") {
							if (isset($mode) && $mode) { ?>
								<a href="<?php echo site_url("dashboard") ?>">
										<?php echo "Dashboard";?>
										<span class='fa fa-dashboard'></span>
								</a>
					<?php
							} else {?>
								<a  href="<?php echo site_url("modifier/commune/" .url_encode($this->city->get_current_city()->id)) ?>">
										<?php echo $this->city->get_current_city()->name;?>
										<span class='fa fa-edit'></span>
								</a>
					<?php
							}
						}
					?>
				</li>
                <?php
                if(!$this->session->userdata('is_city_admin')) {
                ?>
				<li>
					<a href="<?php echo site_url("soaco") ?>">
                        <?php echo $this->lang->line('cities_nav');?>
						<span class='fa fa-exchange'></span>
					</a>
				</li>
                <?php } ?>
                <?php if ( $this->user->get_logged_in_user_info()->is_owner ): ?>

<!--				<li>-->
<!--					<a href="--><?php //echo site_url("cities/create") ?><!--">-->
<!--						--><?php //echo $this->lang->line('btn_create_new_city'); ?>
<!--						<span class='fa fa-plus-square'></span>-->
<!--					</a>-->
<!--				</li>-->

				<?php endif; ?>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="nav-item">
					<a class="nav-link" href="<?php echo site_url(''); ?>">
                        TABLEAU DE BORD
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
										<!--<p class="text-center small">
											<a href="#">Change Photo</a>
										</p>-->
									</div>
									<div class="col-md-7">
										<span><?php echo $logged_in_user->user_name;?></span>
										<p class="text-muted small"><?php echo $this->role->get_name($logged_in_user->role_id);?></p>
									</div>
								</div>
							</div>
							<div class="navbar-footer">
								<div class="navbar-footer-content">
									<div class="row">
										<div class="col-md-6">
											<a href="<?php echo site_url('profile');?>" class="btn  btn-sm" style="background-color: #fff;background-image:  none;border-radius: 0;">Profil</a>
										</div>
										<div class="col-md-6">
											<a href="<?php echo site_url('login_station/logout');?>" class="btn btn-sm pull-right" style="background-color: #fff; border-radius: 0;">Déconnexion</a>
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
</nav>
