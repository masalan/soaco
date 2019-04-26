			<?php
				$this->lang->load('ps', 'english');
			?>
			<ul class="breadcrumb">
				<li><a href="<?php echo site_url() . "/dashboard";?>"><?php echo $this->lang->line('dashboard_label')?></a> <span class="divider"></span></li>
				<li><a href="<?php echo site_url('categories');?>"><?php echo $this->lang->line('cat_list_label')?></a> <span class="divider"></span></li>
				<li><?php echo $this->lang->line('add_new_cat_button')?></li>
			</ul>
			
			<?php
				$attributes = array('id' => 'category-form','enctype' => 'multipart/form-data');
				echo form_open(site_url('categories/add'), $attributes);
			?>
				<div class="wrapper wrapper-content animated fadeInRight">
				<legend>Information commune</legend>

				<?php $this->load->view( 'flash_message' ); ?>
					
				<div class="row">
					<div class="col-sm-6">
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
								<label>Nom Commune
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="Entrer le nom de la commune de ce departement">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'name',
										'id' => 'name',
										'class' => 'form-control',
										'placeholder' => 'Nom de la commune',
										'value' => ''
									));
								?>
							</div>
							<div class="form-group">
								<label><?php echo $this->lang->line('ordering_label')?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('cat_ordering_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'ordering',
										'id' => 'ordering',
										'class' => 'form-control',
										'placeholder' => 'Ordering',
										'value' => ''
									));
								?>
							</div>
							<!-----
							<div class="form-group">
								<label><?php echo $this->lang->line('cat_photo_label')?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('cat_photo_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<input class="btn" type="file" name="images1">
							</div>
                        ---->
					</div>
                    <?php $this->load->view('alertcountry'); ?>

                </div>
				
				<hr/>
				<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('save_button')?></button>
				<a href="<?php echo site_url('categories');?>" class="btn btn-primary"><?php echo $this->lang->line('cancel_button')?></a>
			</form>
			</div>

			<script>
				$(document).ready(function(){
					//$('#category-form').validate({
					//	rules:{
					//		name:{
					//			required: true,
					//			minlength: 2,
					//			remote: '<?php //echo site_url('categories/exists/'
					//				. $this->city->get_current_city()->id );?>//'
					//		}
					//	},
					//	messages:{
					//		name:{
					//			required: "S'il vous plaît remplir le nom de la Commune.",
					//			minlength: "La longueur du nom de la Commune doit être supérieure à 3",
					//			remote: "Le nom de la Commune existe déjà dans le système."
					//		}
					//	}
					//});
				});
				
				$(function () { $("[data-toggle='tooltip']").tooltip(); });
			</script>
