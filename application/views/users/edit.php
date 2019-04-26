			<?php
			$this->lang->load('ps', 'english');
			?>
			<ul class="breadcrumb">
				<li><a href="<?php echo site_url(). "/dashboard";?>"><?php echo $this->lang->line('dashboard_label')?></a> <span class="divider"></span></li>
				<li><a href="<?php echo site_url('users');?>"><?php echo $this->lang->line('users_list_label')?></a> <span class="divider"></span></li>
				<li><?php echo $this->lang->line('update_user_label')?></li>
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
				echo form_open(site_url('responsable/'.url_encode($user->user_id)), $attributes);
				?>
					<div class="row">
						<div class="col-sm-8">
							<legend><?php echo $this->lang->line('user_info_label')?></legend>
							
							<div class="form-group">
								<label><?php echo $this->lang->line('username_label')?></label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'user_name',
										'id' => 'user_name',
										'class' => 'form-control',
										'placeholder' => 'Username',
										'value' => html_entity_decode( $user->user_name )
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
                                    'value' => html_entity_decode( $user->fullname )
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
                                    'value' => html_entity_decode( $user->phone )
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
										'placeholder' => 'email',
										'value' => html_entity_decode( $user->user_email )
									));
								?>
							</div>
							
							<div class="form-group">
								<label><?php echo $this->lang->line('password_label')?></label>
								<input class="form-control" type="password" placeholder="password" name='user_password' id='user_password' >
							</div>
										
							<div class="form-group">
								<label><?php echo $this->lang->line('confirm_password_label')?></label>
								<input class="form-control" type="password" placeholder="confirm password" name='conf_password' id='conf_password'>
							</div>
							
							<div class="form-group">
								<label><?php echo $this->lang->line('user_role_label')?></label>
								<select class="form-control" name='role_id' id='role_id'>
									<?php
                                    $query = $this->db->get_where('be_roles',array('type'=>1))->result();
                                    // $this->role->get_all()->result()

                                    foreach($query as $role){
											echo "<option value='".$role->role_id."' ";
											echo ($role->role_id == $user->role_id)? "selected":"";
											echo ">".$role->role_desc."</option>";
										}
									?>
								</select>
							</div>
							<hr>
							<div class="form-group">
								<label>Si le Responsable est choisis comme Admin,choisissez une Station Service</label> <br>
								<select class="form-control" name='city_id' id='city_id'>
									<?php
                                    $query = $this->city->get_all()->result() ;
                                    foreach($query as $city)
											echo "<option value='".$city->id."'>".$city->name."</option>";
									?>
								</select>
							</div>
							
						</div>
						
						<div class="col-sm-3">
							<div class="form-group">
								<label class="control-label"><?php echo $this->lang->line('allowed_modules_label')?></label>
								<?php
									foreach($this->module->get_all()->result() as $module)
									{
										echo "<label class='checkbox'>";
										echo form_checkbox("permissions[]",$module->module_id,$this->user->has_permission($module->module_name,$user->user_id));
										echo $module->module_desc."</label><br/>";						
									}
								?>
							</div>
						</div>
					</div>
								
					
					<hr/>
					
					<button type="submit" class="btn btn-primary">Mise a jour</button>
					<a href="<?php echo site_url('users');?>" class="btn">Annuler</a>
				</form>
			</div>
			<script>
				$(document).ready(function(){
					$('#user-form').validate({
						rules:{
							user_name:{
								required: true,
								minlength: 4
                                remote: '<?php echo site_url('users/exists_pseudo/'.$user->user_id);?>'

                            },
							user_email:{
								required: true,
								email: true,
								remote: '<?php echo site_url('users/exists/'.$user->user_id);?>'
							},
							user_password:{
								minlength: 4
							},
							conf_password:{
								equalTo: '#user_password'
							},
							"permissions[]": { 
								required: true, 
								minlength: 1 
							}
						},
						messages:{
							user_name:{
								required: "Pseudo obligatoire.",
								minlength: "La longueur du Pseudo dois etre superieur a 4 lettres"
                                remote: "Pseudo existe deja dans le systeme , veillez choisir un autre"

                            },
							user_email:{
                                required: "E-mail obligatoire.",
								email: "Please provide valid email address",
                                remote: "E-mail existe deja dans le systeme , veillez choisir un autre"
							},
							user_password:{
								minlength: "The length of password must be greater than 4"
							},
							conf_password:{
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
