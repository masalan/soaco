			<?php
				$this->lang->load('ps', 'english');
			?>
			<ul class="breadcrumb">
				<li><a href="<?php echo site_url(). "/dashboard";?>"><?php echo $this->lang->line('dashboard_label')?></a> <span class="divider"></span></li>
				<li><a href="<?php echo site_url('sub_categories');?>"><?php echo $this->lang->line('sub_categories_list_label')?></a> <span class="divider"></span></li>
				<li><?php echo $this->lang->line('add_new_sub_cat_button')?></li>
			</ul>
			<div class="wrapper wrapper-content animated fadeInRight">
			<?php
				$attributes = array('id' => 'sub_category-form','enctype' => 'multipart/form-data');
				echo form_open(site_url('sub_categories/add'), $attributes);
			?>
				<legend><?php echo $this->lang->line('sub_cat_info_label')?></legend>

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
                               // $country = $this->db->get_where('cd_countries',array('is_active'=>1));
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
								<label> <?php echo $this->lang->line('category_name_label')?> 
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('cat_name_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<select class="form-control" name="cat_id" id="cat_id">
								<?php
									$categories = $this->category->get_all($this->city->get_current_city()->id);
									foreach ($categories->result() as $category) {
										echo "<option value='". $category->id ."'>". $category->name ."</option>";
									}
								?>
								</select>
							</div>
					
							<div class="form-group">
								<label><?php echo $this->lang->line('sub_category_name_label')?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('sub_cat_name_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'name',
										'id' => 'name',
										'class' => 'form-control',
										'placeholder' => 'Sub Category Name',
										'value' => ''
									));
								?>
							</div>
							<div class="form-group">
								<label><?php echo $this->lang->line('ordering_label')?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('sub_cat_ordering_tooltips')?>">
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

					</div>
                    <?php $this->load->view('alertcountry'); ?>

                </div>
				
				<hr/>
				
				<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('save_button')?></button>
				<a href="<?php echo site_url('sub_categories');?>" class="btn btn-primary"><?php echo $this->lang->line('cancel_button')?></a>
			</form>
			</div>
			<script>
				$(document).ready(function(){
					//$('#sub_category-form').validate({
					//	rules:{
					//		name:{
					//			required: true,
					//			minlength: 2,
					//			remote: '<?php //echo site_url('sub_categories/exists/'
					//				. $this->city->get_current_city()->id );?>//'
					//		}
					//	},
					//	messages:{
					//		name:{
					//			required: "Please fill for Sub Category Name.",
					//			minlength: "The length of Sub Category Name must be greater than 2",
					//			remote: "Sub Category Name is already existed in the system"
					//		}
					//	}
					//});
				});
				$(function () { $("[data-toggle='tooltip']").tooltip(); });
			</script>
