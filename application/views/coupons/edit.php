			<?php
			$this->lang->load('ps','english');
			?>
			<ul class="breadcrumb">
				<li><a href="<?php echo site_url() . "/dashboard";?>"><?php echo $this->lang->line('dashboard_label')?></a> <span class="divider"></span></li>
				<li><a href="<?php echo site_url('categories');?>"><?php echo $this->lang->line('cat_list_label')?></a> <span class="divider"></span></li>
				<li>Mise a jour</li>
			</ul>
			
			<div class="wrapper wrapper-content animated fadeInRight">
			<?php
			$attributes = array('id' => 'category-form');
			echo form_open(site_url('categories/edit/'.url_encode($category->id)), $attributes);
			?>
				
				<?php $this->load->view( 'flash_message' ); ?>
				
				<div class="row">
					<div class="col-sm-6">
                        <legend>Information commune</legend>


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
									'placeholder' => 'Category Name',
									'value' => html_entity_decode( $category->name )
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
									'value' => html_entity_decode($category->ordering)
								));
							?>
						</div>

						
					</div>
                    <?php $this->load->view('alertcountry'); ?>



                    </div>
							
				
				<hr/>
				
				<button type="submit" class="btn btn-primary">Mise a jour</button>
				<a href="<?php echo site_url('categories');?>" class="btn btn-primary">Annuler</a>
			</form>
			</div>
			
			<div class="modal fade"  id="uploadImage">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">
								<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
							</button>
							<h4 class="modal-title"><?php echo $this->lang->line('replace_photo_button')?></h4>
						</div>
						<?php
						$attributes = array('id' => 'upload-form','enctype' => 'multipart/form-data');
						echo form_open(site_url("categories/upload/".$category->id), $attributes);
						?>
							<div class="modal-body">
								<div class="form-group">
									<label><?php echo $this->lang->line('upload_photo_label')?></label>
									<input type="file" name="images1">
								</div>
							</div>
							<div class="modal-footer">
								<input type="submit" value="Upload" class="btn btn-primary"/>
								<a type="button" class="btn btn-primary" data-dismiss="modal"><?php echo $this->lang->line('cancel_button')?></a>
							</div>
						</form>
					</div>
				</div>
			</div>
			
			<div class="modal fade"  id="deletePhoto">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<h4 class="modal-title"><?php echo $this->lang->line('delete_cover_photo_label')?></h4>
						</div>
						<div class="modal-body">
							<p><?php echo $this->lang->line('delete_photo_confirm_message')?></p>
						</div>
						<div class="modal-footer">
							<a type="button" class="btn btn-primary btn-delete-image"><?php echo $this->lang->line('yes_button')?></a>
							<a type="button" class="btn btn-primary" data-dismiss="modal"><?php echo $this->lang->line('cancel_button')?></a>
						</div>
					</div>
				</div>			
			</div>

			<script>
				$(document).ready(function(){
					//$('#category-form').validate({
					//	rules:{
					//		name:{
					//			required: true,
					//			minlength: 4,
					//			remote: '<?php //echo site_url('categories/exists/'
					//				. $this->city->get_current_city()->id .'/'
					//				. $category->id);?>//'
					//		}
					//	},
					//	messages:{
					//		name:{
					//			required: "Please fill category name.",
					//			minlength: "The length of category name must be greater than 4",
					//			remote: "Category name is already existed in the system"
					//		}
					//	}
					//});
					
					$('.delete-img').click(function(e){
						e.preventDefault();
						var id = $(this).attr('id');
						var image = $(this).attr('image');
						var action = '<?php echo site_url('categories/delete_image/'.$category->id);?>/' + id + '/' + image;
						$('.btn-delete-image').attr('href', action);
					});
				});
				
				$(function () { $("[data-toggle='tooltip']").tooltip(); });
			</script>

