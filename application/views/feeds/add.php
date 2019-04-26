			<?php
			$this->lang->load('ps', 'english');
			?>
			<ul class="breadcrumb">
				<li><a href="<?php echo site_url(). "/dashboard";?>"><?php echo $this->lang->line('dashboard_label')?></a> <span class="divider"></span></li>
				<li><a href="<?php echo site_url('gerants');?>">Liste de Gerants</a> <span class="divider"></span></li>
				<li>Nouveau Gerant</li>
			</ul>
			<div class="wrapper wrapper-content animated fadeInRight">
			<?php $attributes = array('id' => 'feed-form','enctype' => 'multipart/form-data');
			echo form_open(site_url('gerants/add'), $attributes); ?>
				<legend>Information du Gerant </legend>
				<?php $this->load->view( 'flash_message' ); ?>
				<div class="row">
					<div class="col-sm-12">
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
										'placeholder' => 'Nom complet',
										'value' => ''
									));
								?>
							</div>

                        <div class="form-group">
                            <label> Mon pays de Geolocalisation
                                <a class="tooltip-ps" data-toggle="tooltip" title="Ne changez pas la localisation de votre service">
                                    <span class='glyphicon glyphicon-info-sign menu-icon'></a>
                            </label>
                            <select class="form-control" name="country_id" id="country_id">
                                <?php
                                $country = $this->city->get_country_list();
                                foreach ($country->result() as $cat) {
                                    echo "<option value='".$cat->id."'";
                                    if($this->session->userdata('country_id') == $cat->id) {
                                        echo " selected ";
                                    }
                                    echo ">".$cat->name."</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="row alert alert-success">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Nom du père
                                        <a href="#" class="tooltip-ps" data-toggle="tooltip" title="">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                                        </a>
                                    </label>
                                    <input type="text" name="father" value="" id="title" class="form-control" placeholder="Nom complet de votre"  />
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Nom de la mère
                                        <a href="#" class="tooltip-ps" data-toggle="tooltip" title="">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                                        </a>
                                    </label>
                                    <input type="text" name="mother" value="" id="title" class="form-control" placeholder="Nom complet de votre mère"  />
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Question
                                        <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Cette question vous sera pose en cas d`oublie de mot de passe">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                                        </a>
                                    </label>
                                    <input type="text" name="question" value="" id="title" class="form-control" placeholder=" La question secrete"  />
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Réponse
                                        <a href="#" class="tooltip-ps" data-toggle="tooltip" title="La Reponse a votre question">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                                        </a>
                                    </label>
                                    <input type="text" name="answer" value="" id="title" class="form-control" placeholder="Réponse a votre question"  />
                                </div>
                            </div>
                        </div>


                            <div class="form-group">
                            <label>Numero de telephone
                                <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Numero de telehone responsable de la station">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                                </a>
                            </label>
                            <?php
                            echo form_input( array(
                                'type' => 'tel',
                                'name' => 'phone',
                                'id' => 'phone',
                                'class' => 'form-control',
                                'placeholder' => 'Numero de telephone du Gerant',
                                'value' => '')); ?>
                        </div>


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
                            <label><?php echo $this->lang->line('email_label')?>
                                <a href="#" class="tooltip-ps" data-toggle="tooltip" title=" L`e-mail de connexion du Gerant au systeme">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                                </a>
                            </label>
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
                            <label>Mot de passe
                                <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Mot de passe de connexion au systeme">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                                </a>
                            </label>
                            <input class="form-control" type="password" placeholder="Password" name='user_password' id='user_password'>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang->line('confirm_password_label')?></label>
                            <input class="form-control" type="password" placeholder="Confirm Password" name='conf_password' id='conf_password'>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang->line('user_role_label')?></label>
                            <select class="form-control" name='role_id' id='role_id'>
                                <?php
                                $query = $this->db->get_where('be_roles' , array('type' => 2))->result();
                                foreach($query as $role)
                                    echo "<option value='".$role->role_id."'>".$role->role_desc."</option>";
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
                                <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Selectionner un arrondissement pour afficher toutes les stations">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                                </a>
                            </label>
<!--                            <select class="form-control" name="arrondissement_id" id="cat_id">-->

                                <select name="arrondissement_id" class="form-control" data-validate="required" id="arrondissement_id"
                                        data-message-required="Selection obligatoire" onchange="return get_station_list(this.value)">
                                <option>Selectionne Arrondissement</option>
                                <?php
                                $categories = $this->sub_category->get_all($this->city->get_current_city()->id);
                                foreach($categories->result() as $cat)
                                    echo "<option value='".$cat->id."'>".$cat->name."</option>";
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Nom de la station</label> <br>
                            <select class="form-control" name="station_id" id="station_id">
                                <option>Selectionner une station</option>
                            </select>
                        </div>




					</div>
				</div>
				
				<hr/>
				<input type="hidden" name="city_id" value="<?php echo $city->id ;?>">
                <input type="hidden" name="company_id" value="<?php echo $city->id ;?>">

                <input type="hidden" name="description" id="description" value="*************************************">
                <input type="submit" name="save" value="<?php echo $this->lang->line('save_button')?>" class="btn btn-primary"/>
				<a href="<?php echo site_url('gerants');?>" class="btn btn-primary"><?php echo $this->lang->line('cancel_button')?></a>
			</form>
			</div>
            <script>
                $(document).ready(function(){
                    $('#feed-form').validate({
                        rules:{
                            title:{
                                required: true,
                                minlength: 3
                            }
                        },
                        messages:{
                            title:{
                                required: "Votre Nom complet est obligatoire",
                                minlength: "La longueur dois etre superieur a 4 lettres"
                            }
                        }
                    });
                });

                $(function () { $("[data-toggle='tooltip']").tooltip(); });

                // Select Station online
                function get_station_list(arrondissement_id) {

                    $.ajax({
                        url: '<?php echo site_url('items/get_station_list/');?>' + arrondissement_id ,
                        success: function(response)
                        {
                            jQuery('#station_id').html(response);
                        }
                    });
                }


            </script>

