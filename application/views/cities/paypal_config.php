 			<?php $this->lang->load('ps', 'english'); ?>

			<ul class="breadcrumb">
				<li><a href="<?php echo site_url() . "/dashboard";?>"><?php echo $this->lang->line('dashboard_label')?></a> <span class="divider"></span></li>
				<li><?php echo $this->lang->line('paypal_config_label')?></li>
			</ul>
			
			<br/>
			
			<!-- Message -->
			<?php if($this->session->flashdata('success')): ?>
				<div class="alert alert-success fade in">
					<?php echo $this->session->flashdata('success');?>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				</div>
			<?php elseif($this->session->flashdata('error')):?>
				<div class="alert alert-danger fade in">
					<?php echo $this->session->flashdata('error');?>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				</div>
			<?php endif;?>

			<?php $attributes = array('id' => 'city-form' ); ?>

			<?php echo form_open(site_url("cities/paypal_config"), $attributes); ?>

			<div class="row">

				<div class="col-sm-6">
					<div class="form-group">
						<label><?php echo $this->lang->line('paypal_price_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('paypal_price_tooltips')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>
						<?php 
							echo form_input( array(
								'type' => 'text',
								'name' => 'price',
								'id' => 'price',
								'class' => 'form-control',
								'placeholder' => 'Price',
								'value' => $paypal_config->price
							));
						?>
					</div>
					
					<div class="form-group">
						<label><?php echo $this->lang->line('paypal_currency_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('paypal_currency_tooltips')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>
						<?php 
							echo form_input( array(
								'type' => 'text',
								'name' => 'currency',
								'id' => 'currency',
								'class' => 'form-control',
								'placeholder' => 'currency',
								'value' => $paypal_config->currency_code
							));
						?>
					</div>
					<div class="form-group">
						<label><?php echo $this->lang->line('paypal_status_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('paypal_status_tooltips')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>
						<?php echo form_dropdown('status', array( '0' => 'No', '1' => 'Yes'), $paypal_config->status,'class="form-control"'); ?>
					</div>
				</div>

			</div>

			<hr/>

			<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('save_button')?></button>
			<a href="<?php echo site_url('cities');?>" class="btn btn-primary"><?php echo $this->lang->line('cancel_button')?></a>

			<?php echo form_close(); ?>
			<script>
			$(document).ready(function(){

			});
			$(function () { $("[data-toggle='tooltip']").tooltip(); });
			</script>