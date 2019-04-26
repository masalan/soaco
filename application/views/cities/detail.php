 			<?php $this->lang->load('ps', 'english'); ?>

			<ul class="breadcrumb">
				<li>
					<a href="<?php echo site_url( "cities/approval" ); ?>">
						<?php echo $this->lang->line( 'cities_approval_list_label' ); ?>
					</a>
			</ul>
			
			<div class="row">

				<div class="thumbnail">

					<img 
						src="<?php echo base_url( 'uploads/'. $this->image->get_cover_image($city->id,'city')->path ); ?>" 
						alt="<?php echo $city->name; ?>">

	  				<div class="caption">

	    				<h3><?php echo $city->name; ?></h3>

	    				<p><?php echo $city->description; ?></p>

	    				<p>
	    					<strong>Paypal Transaction Id : </strong>
							<?php echo ( $city->paypal_trans_id )? $city->paypal_trans_id: 'Not yet'; ?>
						</p>
	  				</div>

  				</div>

			</div>