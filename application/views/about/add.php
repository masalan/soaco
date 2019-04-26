			<?php
			$this->lang->load('ps', 'english');
			?>
			<ul class="breadcrumb">
				<li><a href="<?php echo site_url(). "/dashboard";?>"><?php echo $this->lang->line('dashboard_label')?></a> <span class="divider"></span></li>
				<li>Apropos du Systeme</li>
			</ul>
			<div class="wrapper wrapper-content animated fadeInRight">

			<?php
			$attributes = array('id' => 'about-form','enctype' => 'multipart/form-data');
			echo form_open(site_url('abouts/add'), $attributes);
			?>
				<legend>Apropos du Systeme</legend>
				
				<div class="row">
					<div class="col-sm-8">

						<!-- Message -->
						<?php $this->load->view( 'flash_message' ); ?>
						
							<div class="form-group">
								<label>Nom du Systeme
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="Ecrivez le nom du systeme">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'title',
										'id' => 'title',
										'class' => 'form-control',
										'placeholder' => 'Nom du Systeme',
										'value' => $about->title
									));
								?>
							</div>
							
							<div class="form-group">
								<label>Descriptioon et fonctionnement du systeme
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('about_description_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<textarea class="form-control" name="description" placeholder="Description" rows="9"><?php echo $about->description; ?></textarea>
							</div>

							<div class="form-group">
								<label><?php echo $this->lang->line('about_email_label')?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('about_email_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'email',
										'id' => 'email',
										'class' => 'form-control',
										'placeholder' => 'Email',
										'value' => $about->email
									));
								?>
							</div>

							<div class="form-group">
								<label><?php echo $this->lang->line('about_phone_label')?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('about_phone_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'phone',
										'id' => 'phone',
										'class' => 'form-control',
										'placeholder' => 'Phone',
										'value' => $about->phone
									));
								?>
							</div>

							<div class="form-group">
								<label><?php echo $this->lang->line('about_website_label')?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('about_website_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'website',
										'id' => 'website',
										'class' => 'form-control',
										'placeholder' => 'Website',
										'value' => $about->website
									));
								?>
							</div>

							<div class="form-group">
								<label><?php echo $this->lang->line('about_website_name')?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('about_website_name_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'website_name',
										'id' => 'website_name',
										'class' => 'form-control',
										'placeholder' => 'website_name',
										'value' => $about->website_name
									));
								?>
							</div>

							<hr>

							<legend><?php echo $this->lang->line('about_color')?></legend>

							<label>
								<?php echo $this->lang->line('about_theme')?>
							</label>

							<select class="form-control" name="style" id="style">
								<option value=""><?php echo $this->lang->line('select_style')?></option>
								<?php
									$styles = array('style','style-blue','style-green');
									foreach($styles as $style){
										echo "<option value='". $style ."'";
										if ( $style == $about->style ) echo " selected ";
										echo ">". $style ."</option>";										
									}
								?>
							</select>

							<hr>

							<legend><?php echo $this->lang->line('about_seo')?></legend>

							<div class="form-group">
								<label><?php echo $this->lang->line('about_keywords')?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('about_keywords_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'keywords',
										'id' => 'keywords',
										'class' => 'form-control',
										'placeholder' => 'keywords',
										'value' => $about->keywords
									));
								?>
							</div>

							<div class="form-group">

								<label>
									<?php echo $this->lang->line('about_sitemap_url'); ?>
								</label>

								<br/><br/>

								<a href="<?php echo base_url( 'sitemap.xml' ); ?>">
								<?php echo base_url( 'sitemap.xml' ); ?>
								</a>

								<br/><br/>

								<input type="submit" name="generate-sitemap" value="<?php echo $this->lang->line('about_sitemap_generate')?>" class="btn btn-primary"/>

							</div>

							<hr>

							<legend><?php echo $this->lang->line('about_social')?></legend>

							<div class="form-group">
								<label><?php echo $this->lang->line('about_facebook')?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('about_facebook_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'facebook',
										'id' => 'facebook',
										'class' => 'form-control',
										'placeholder' => 'facebook',
										'value' => $about->facebook
									));
								?>
							</div>
							<div class="form-group">
								<label><?php echo $this->lang->line('about_twitter')?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('about_twitter_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'twitter',
										'id' => 'twitter',
										'class' => 'form-control',
										'placeholder' => 'twitter',
										'value' => $about->twitter
									));
								?>
							</div>
							<div class="form-group">
								<label><?php echo $this->lang->line('about_google')?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('about_google_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'google',
										'id' => 'google',
										'class' => 'form-control',
										'placeholder' => 'google',
										'value' => $about->google
									));
								?>
							</div>
							<div class="form-group">
								<label><?php echo $this->lang->line('about_instagram')?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('about_instagram_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'instagram',
										'id' => 'instagram',
										'class' => 'form-control',
										'placeholder' => 'instagram',
										'value' => $about->instagram
									));
								?>
							</div>
							<div class="form-group">
								<label><?php echo $this->lang->line('about_youtube')?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('about_youtube_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'youtube',
										'id' => 'youtube',
										'class' => 'form-control',
										'placeholder' => 'youtube',
										'value' => $about->youtube
									));
								?>
							</div>
							<div class="form-group">
								<label><?php echo $this->lang->line('about_pinterest')?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('about_pinterest_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'pinterest',
										'id' => 'pinterest',
										'class' => 'form-control',
										'placeholder' => 'pinterest',
										'value' => $about->pinterest
									));
								?>
							</div>

					</div>
				</div>
				
				<hr/>
				
				<input type="submit" name="save" value="<?php echo $this->lang->line('save_button')?>" class="btn btn-primary"/>
				<input type="submit" name="gallery" value="<?php echo $this->lang->line('save_go_button')?>" class="btn btn-primary"/>
				<a href="<?php echo site_url('abouts');?>" class="btn btn-primary"><?php echo $this->lang->line('cancel_button')?></a>
			</form>
			</div>
			<script>
			$(document).ready(function(){
				$('#about-form').validate({
					rules:{
						title:{
							required: true,
							minlength: 4
						}
					},
					messages:{
						title:{
							required: "Please fill title.",
							minlength: "The length of title must be greater than 4"
						}
					}
				});
			});
			
			$(function () { $("[data-toggle='tooltip']").tooltip(); });
			
			</script>

