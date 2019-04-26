			<?php
			$this->lang->load('ps', 'english');
			?>
            <ul class="breadcrumb">
                <li><a href="<?php echo site_url(). "/dashboard";?>"><?php echo $this->lang->line('dashboard_label')?></a> <span class="divider"></span></li>
                <li><a href="<?php echo site_url('gerants');?>">Liste de Gerants</a> <span class="divider"></span></li>
                <li>Modifier Gerant</li>
            </ul>
			<div class="wrapper wrapper-content animated fadeInRight">
			<?php
			$this->lang->load('ps', 'english');
			$attributes = array('id' => 'feed-form','enctype' => 'multipart/form-data');
			echo form_open(site_url("feeds/edit/".url_encode($user->user_id)), $attributes);
			?>
                <legend>Information du Gerant </legend>

				<?php $this->load->view( 'flash_message' ); ?>

                <div class="row">
                    <div class="col-sm-10">

                        <div class="form-group">
                            <label>Nom complet
                                <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Nom complet du responsable de la station">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                                </a>
                            </label>
                            <?php
                            echo form_input( array(
                                'type' => 'text',
                                'name' => 'title',
                                'id' => 'title',
                                'class' => 'form-control',
                                'placeholder' => html_entity_decode( $user->fullname ),
                                'value' => html_entity_decode( $user->fullname )
                            ));
                            ?>
                        </div>

                        <div class="row alert alert-success">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Nom du père
                                        <a href="#" class="tooltip-ps" data-toggle="tooltip" title="">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                                        </a>
                                    </label>
                                    <input type="text" name="father" value="<?php echo html_entity_decode($user->father );?>" id="father" class="form-control" placeholder="Nom complet de votre "  />
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Nom de la mère
                                        <a href="#" class="tooltip-ps" data-toggle="tooltip" title="">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                                        </a>
                                    </label>
                                    <input type="text" name="mother" value="<?php echo html_entity_decode($user->mother );?>" id="mother" class="form-control" placeholder="Nom complet de votre mère"  />
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Question
                                        <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Cette question vous serez pose en cas d`oublie de mot de passe">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                                        </a>
                                    </label>
                                    <input type="text" name="question" value="<?php echo html_entity_decode($user->question );?>" id="question" class="form-control" placeholder=" La question secrete"  />
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Réponse
                                        <a href="#" class="tooltip-ps" data-toggle="tooltip" title="La Reponse a votre question">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                                        </a>
                                    </label>
                                    <input type="text" name="answer" value="<?php echo html_entity_decode($user->answer );?>" id="answer" class="form-control" placeholder="Réponse a votre question"  />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Numero de telehone
                                <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Numero de telehone responsable de la station">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                                </a>
                            </label>
                            <?php
                            echo form_input( array(
                                'type' => 'text',
                                'name' => 'phone',
                                'id' => 'phone',
                                'class' => 'form-control',
                                'placeholder' => html_entity_decode( $user->phone ),
                                'value' => html_entity_decode( $user->phone )
                            ));
                            ?>
                        </div>
                        <div class="form-group">
                            <label><?php echo $this->lang->line('username_label')?>
                                <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Le spseudo ne pourras pas etre modifier">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                                </a>
                            </label>
                            <input class="form-control" type="text" placeholder="<?php echo html_entity_decode($user->user_name );?>" name='user_name' value="<?php echo html_entity_decode($user->user_name );?>" >

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
                            <input class="form-control" type="password" placeholder="Mot de passe" name='user_password' id='user_password' >
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang->line('confirm_password_label')?></label>
                            <input class="form-control" type="password" placeholder="confirmation de Mot de passe" name='conf_password' id='conf_password'>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang->line('user_role_label')?></label>
                            <select class="form-control" name='role_id' id='role_id'>
                                <?php
                                $query = $this->db->get_where('be_roles' , array('type' => 2))->result();

                                foreach($query as $role){
                                    echo "<option value='".$role->role_id."' ";
                                    echo ($role->role_id == $user->role_id)? "selected":"";
                                    echo ">".$role->role_desc."</option>";
                                }
                                ?>
                            </select>
                        </div>



                        <div class="form-group">
                            <label>Arrondissements de  (<?php
                                if ($this->session->userdata('city_id') != "") {
                                    if (isset($mode) && $mode) {
                                        ?>
                                        <a href="<?php echo site_url("stations") ?>">
                                            <?php echo "Les Stations";?>
                                            <span class='fa fa-dashboard'></span>
                                        </a>
                                        <?php
                                    } else {
                                        ?>
                                        <a href="<?php echo site_url("stations") ?>">
                                            <?php echo $this->city->get_current_city()->name;?>
                                            <span class='fa fa-edit'></span>
                                        </a>
                                        <?php
                                    }
                                }
                                ?> )
                                <a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('cat_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                                </a>
                            </label>
                            <select class="form-control" name="arrondissement_id" id="cat_id">
                                <?php
                                $categories = $this->sub_category->get_all($this->city->get_current_city()->id);

                                foreach($categories->result()  as $cat){
                                    echo "<option value='".$cat->id."'";
                                    if($user->arrondissement_id == $cat->id)
                                        echo " selected ";
                                    echo ">".$cat->name."</option>";
                                }
                                ?>
                            </select>
                        </div>


                        <div class="form-group">
                            <label>Nom de la station
                                <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Sélectionnez dans le menu déroulant l’arrondissement approprié à votre commune">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                                </a>
                            </label>
                            <select class="form-control" name="station_id" id="sub_cat_id">
                                <option><?php echo $this->lang->line('select_sub_cat_message')?></option>
                                <?php
                                $query = $this->db->get_where('cd_items' , array('city_id'=>$this->city->get_current_city()->id, 'is_published' =>1))->result();
                                foreach($query as $st){
                                    echo "<option value='".$st->id."'";
                                    if($user->station_id == $st->id)
                                        echo " selected ";
                                    echo ">".$st->name."</option>";
                                }
                                ?>
                            </select>
                        </div>


                    </div>


                    <hr/>
                </div>

                <input type="hidden" name="city_id" value="<?php echo $city->id ;?>">
                    <input type="hidden" name="description" id="description" value="*************************************">
                    <button type="submit" class="btn btn-primary">Mise a jour</button>
                    <a href="<?php echo site_url('gerants');?>" class="btn"><?php echo $this->lang->line('cancel_button')?></a>

			</form>
			</div>			
			<script>
				$(document).ready(function(){
					$('#feed-form').validate({
						rules:{
							title:{
								required: true,
								minlength: 4
							},user_password:{
                                minlength: 6
                            },
                            conf_password:{
                                equalTo: '#user_password'
                            }
						},
						messages:{
							name:{
								required: "Please fill feed name.",
								minlength: "The length of feed name must be greater than 4"
							},
                            user_password:{
                                minlength: "la longueuer du mot de passe est d`au moins 6 caracteres"
                            },
                            conf_password:{
                                equalTo: "Les deux mot de passe ne sont pas identique."
                            },
						}
					});				
				});
				
				$(function () { $("[data-toggle='tooltip']").tooltip(); });

                // select
                $('#cat_id').change(function(){
                    var catId = $(this).val();
                    $.ajax({
                        url: '<?php echo site_url('items/get_station_modif');?>/'+catId,
                        method: 'GET',
                        dataType: 'JSON',
                        success:function(data){
                            $('#sub_cat_id').html("");
                            $.each(data, function(i, obj){
                                $('#sub_cat_id').append('<option value="'+ obj.id +'">' + obj.name + '</option>');
                            });
                            $('#name').val($('#name').val() + " ").blur();
                        }
                    });
                });

                $('#sub_cat_id').on('change', function(){
                    $('#name').val($('#name').val() + " ").blur();
                });
				
			</script>

