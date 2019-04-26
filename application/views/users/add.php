			<?php
			$this->lang->load('ps', 'english');
			?>
			<ul class="breadcrumb">
				<li><a href="<?php echo site_url(). "/dashboard";?>"><?php echo $this->lang->line('dashboard_label')?></a> <span class="divider"></span></li>
				<li><a href="<?php echo site_url('users');?>">Liste des responsables</a> <span class="divider"></span></li>
				<li>Ajout d`un Responsable de commune</li>
			</ul>
			
			<!-- Message -->
			<?php $this->load->view( 'flash_message' ); ?>

			<div id="perm_err" class="alert alert-danger fade in" style="display: none">
				<label for="permissions[]" class="error"></label>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			</div>
			
			<div class="wrapper wrapper-content animated fadeInRight">
				<?php
				$attributes = array('id' => 'user-form');
				echo form_open(site_url('users/add'), $attributes);
				?>
					<legend><?php echo $this->lang->line('user_info_label')?></legend>
						
					<div class="row">
						<div class="col-sm-8">

								<div class="form-group">
									<label><?php echo $this->lang->line('username_label')?></label>
									<?php 
										echo form_input( array(
											'type' => 'text',
											'name' => 'user_name',
											'id' => 'user_name',
											'class' => 'form-control',
											'placeholder' => 'Votre Pseudo',
											'value' => ''
										));
									?>
								</div>

                            <div class="form-group">
                                <label>Nom complet</label>
                                <?php
                                echo form_input( array(
                                    'type' => 'text',
                                    'name' => 'fullname',
                                    'id' => 'fullname',
                                    'class' => 'form-control',
                                    'placeholder' => 'Nom complet du Responsable de la commune',
                                    'value' => ''
                                ));
                                ?>
                            </div>

                            <div class="form-group">
                                <label>Numero de telephone</label>
                                <?php
                                echo form_input( array(
                                    'type' => 'tel',
                                    'name' => 'phone',
                                    'id' => 'phone',
                                    'class' => 'form-control',
                                    'placeholder' => 'Numero de telephone du Responsable de la commune',
                                    'value' => ''
                                ));
                                ?>
                            </div>



                            <div class="form-group">
									<label><?php echo $this->lang->line('email_label')?></label>
									<?php 
										echo form_input( array(
											'type' => 'text',
											'name' => 'user_email',
											'id' => 'user_email',
											'class' => 'form-control',
											'placeholder' => 'Email',
											'value' => ''
										));
									?>
								</div>
								
								<div class="form-group">
									<label><?php echo $this->lang->line('password_label')?></label>
									<input class="form-control" type="password" placeholder="Password" name='user_password' id='user_password'>
								</div>
											
								<div class="form-group">
									<label><?php echo $this->lang->line('confirm_password_label')?></label>
									<input class="form-control" type="password" placeholder="Confirm Password" name='conf_password' id='conf_password'>
								</div>
								
								<div class="form-group">
									<label><?php echo $this->lang->line('user_role_label')?></label>
									<select class="form-control" name='role_id' id='role_id'>
                                        // $query = $this->db->get_where('section' , array('class_id' => $class_id));
										<?php $query = $this->db->get_where('be_roles' , array('type' => 1))->result();
                                        foreach($query as $role)
												echo "<option value='".$role->role_id."'>".$role->role_desc."</option>";
										?>
									</select>
								</div>
								<hr>
								<div class="form-group">
									<label>Choisir la commune a laquelle il sera responsable</label> <br>
									<select class="form-control" name='city_id' id='city_id'>
										<?php
											foreach($this->city->get_all()->result() as $city)
												echo "<option value='".$city->id."'>".$city->name."</option>";
										?>
									</select>
								</div>
								
								
						</div>
						
						<div class="col-sm-4">
							<div class="form-group">
								<label><?php echo $this->lang->line('allowed_modules_label')?></label>
								<?php
									foreach($this->module->get_all()->result() as $module)
										echo "<label class='checkbox'><input type='checkbox' name='permissions[]' value='".$module->module_id."'>".$module->module_desc."</label><br/>";
								?>
							</div>
						</div>
					</div>
					
					<hr/>
					
					<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('save_button')?></button>
					<a href="<?php echo site_url('users');?>" class="btn btn-primary"><?php echo $this->lang->line('cancel_button')?></a>
				</form>
			</div>
			<script>
			$(document).ready(function(){
				$('#user-form').validate({
					rules:{
						user_name:{
							required: true,
							minlength: 4
						},
						user_email:{
							required: true,
							email: true,
							remote: '<?php echo site_url("users/exists");?>'
						},
						user_password:{
							required: true,
							minlength: 4
						},
						conf_password:{
							required: true,
							equalTo: '#user_password'
						},
						"permissions[]": { 
							required: true, 
							minlength: 1 
						} 
					},
					messages:{
						user_name:{
							required: "Please fill user name.",
							minlength: "The length of username must be greater than 4"
						},
						user_email:{
							required: "Please fill email address",
							email: "Please provide valid email address",
							remote: "Email Address is already existed in the system"
						},
						user_password:{
							required: "Please fill user password.",
							minlength: "The length of password must be greater than 4"
						},
						conf_password:{
							required: "Please fill confirm password",
							equalTo: "Password and confirm password do not match."
						},
						"permissions[]": "Please select which modules are able to access."
					},
					errorPlacement: function(error, element) {
						if (element.attr("name") == "permissions[]" ) {
							$("#perm_err label").html($(error).text());
							$("#perm_err").show();
						} else {
							error.insertAfter(element);
						}
					}
				});
			});
		</script>

