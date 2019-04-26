			<?php
				$this->lang->load('ps', 'english');
			?>
			<ul class="breadcrumb">
				<li><a href="<?php echo site_url() . "/dashboard";?>"><?php echo $this->lang->line('dashboard_label')?></a> <span class="divider"></span></li>
				<li><a href="<?php echo site_url('coupons');?>">liste de cartes</a> <span class="divider"></span></li>
				<li>Ajoute carte</li>
			</ul>
			
			<?php
				$attributes = array('id' => 'cards-form','enctype' => 'multipart/form-data');
				echo form_open(site_url('coupons/add'), $attributes);
			?>
				<div class="wrapper wrapper-content animated fadeInRight">
				<legend>Information Carte/Coupon</legend>

				<?php $this->load->view( 'flash_message' ); ?>
					
				<div class="row">
					<div class="col-sm-6">
                        <div class="form-group">
                            <label>Numero de la carte
                                <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Numero unique de la carte">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                                </a>
                            </label>
                            <input type="text" name="card_serial" id="card_serial" value="<?php echo random_string('nozero', 12);?>" placeholder="nom de la carte" class="form-control" required="required">
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
							<div class="form-group">
								<label>Nom carte
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="Nom nominatif de la carte ou du coupon">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'name',
										'id' => 'name',
										'class' => 'form-control',
										'placeholder' => 'Nom',
										'value' => ''
									));
								?>
							</div>



                        <div class="form-group">
                            <label> Type de carte
                                <a class="tooltip-ps" data-toggle="tooltip" title="Choisir le type de carte">
                                    <span class='glyphicon glyphicon-info-sign menu-icon'></a>
                            </label>
                            <select class="form-control" name="type_cards_id" id="type_cards_id">
                                <option value="">Choisir...</option>
                                <?php
                                $carte =$this->db->get_where('cd_type_cards');
                                foreach ($carte->result() as $cat) {
                                    echo "<option value='".$cat->id."'";
                                    echo ">".$cat->name."</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="row">

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Montant initial
                                        <a href="#" class="tooltip-ps" data-toggle="tooltip" title="Montant dans la carte, par exemple 10000">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                                        </a>
                                    </label>
                                    <input type="number" name="initial_moeny" id="initial_moeny"  placeholder="Montant dans la carte" class="form-control" required="required">
                                </div></div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label> Devise
                                        <a class="tooltip-ps" data-toggle="tooltip" title="Device monnetaire">
                                            <span class='glyphicon glyphicon-info-sign menu-icon'></a>
                                    </label>
                                    <select class="form-control" name="currency_id" id="currency_id">
                                        <option value="">Choisir...</option>
                                        <?php
                                        $carte =$this->db->get_where('cd_currencies',array('status'=>1));
                                        foreach ($carte->result() as $cat) {
                                            echo "<option value='".$cat->id."'";
                                            echo ">".$cat->code.' ('.$cat->name.')'."</option>";
                                        } ?>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label> Nom de la compagnie
                                <a class="tooltip-ps" data-toggle="tooltip" title="Nom de la compagnie proprietaire de la carte">
                                    <span class='glyphicon glyphicon-info-sign menu-icon'></a>
                            </label>
                            <select class="form-control" name="company_id" id="company_id">
                                <option value="">choisir...</option>
                                <?php
                                $carte =$this->db->get_where('be_users',array('is_gerant'=>2,'country_id'=>$this->session->userdata('country_id')));
                                foreach ($carte->result() as $cat) {
                                    echo "<option value='".$cat->user_id."'";
                                    echo ">".$cat->fullname."</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Propriétaire de la carte
                                <a href="#" class="tooltip-ps" data-toggle="tooltip" title=" propriétaire de la carte">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                                </a>
                            </label>
                            <input type="text" name="username" id="username" placeholder="Nom du propriétaire de la carte (Facultative)" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Telephone
                                <a href="#" class="tooltip-ps" data-toggle="tooltip" title=" Numéro de telephone du propriétaire  de la carte">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
                                </a>
                            </label>
                            <input type="text" name="phone" id="phone" placeholder="Numéro du propriétaire de la carte " class="form-control" required="required">
                        </div>


					</div>
                    <?php $this->load->view('alertcountry'); ?>

                </div>
				
				<hr/>
				<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('save_button')?></button>
				<a href="<?php echo site_url('coupons');?>" class="btn btn-primary"><?php echo $this->lang->line('cancel_button')?></a>
			</form>
			</div>

			<script>
				$(document).ready(function(){
					$('#cards-form').validate({
						rules:{
                            name:{
                                required: true,
                                minlength: 4,
                                remote: {
                                    url: '<?php echo site_url("coupons/exists");?>',
                                    type: "GET",
                                    data: {
                                        name: function () {
                                            return $('#name').val();
                                        },
                                        card_serial: function() {
                                            return $('#card_serial').val();
                                        }
                                    }
                                }
                            },
                            unit_price: {
                                number: true
                            }
                        },
						messages:{
							name:{
								required: "S'il vous plaît remplir le numero de serie .",
								minlength: "La longueur du numero de serie doit être supérieure à 3",
								remote: "Ce numero de serie existe déjà dans le système."
							}
						}
					});
				});
                $('#card_serial').on('change', function(){
                    $('#name').val($('#name').val() + " ").blur();
                });

				$(function () { $("[data-toggle='tooltip']").tooltip(); });
			</script>
