			<h2 class="page-header"><?php echo $this->lang->line('Welcome_dash'); ?>, <?php echo $this->user->get_logged_in_user_info()->user_name;?>!</h2>

			
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
			
			<div class="wrapper wrapper-content animated fadeInRight">
		 	<div class="row">
		  		<div class="col-sm-3">
		  			<a href="<?php  echo site_url('appusers') ?>">
			  			<span class="badge red-bg">
			  				<?php echo $this->appuser->count_all();?>
			  			</span>
			  			
			  			<div class="hero-widget">
			  				<div class="icon">
			  					<i class="fa fa-group"></i>
			  				</div>
			  				<div class="text">
			  					<label class="text-muted">
                                    <?php echo $this->lang->line('registered_user_counts'); ?></label>
			  				</div>
			  			</div>
		  			</a>
		  		</div>
			  	<div class="col-sm-3">
			  		<a href="<?php  echo site_url('reviews') ?>">
			  		
			  			<span class="badge red-bg">
				  			<?php echo $this->review->count_all($this->city->get_current_city()->id);?>
				  		</span>
				  		
				  		<div class="hero-widget">
				  			<div class="icon">
				  				<i class="fa fa-pencil-square"></i>
				  			</div>
				  			<div class="text">
				  				<label class="text-muted">
                                    <?php echo $this->lang->line('item_review_counts'); ?>
                                    </label>
				  			</div>
				  		</div>
			  		
			  		</a>
			  	</div>
			  	<div class="col-sm-3">
			  		<a href="<?php  echo site_url('likes') ?>">
			  		
			  			<span class="badge red-bg">
				  			<?php echo $this->like->count_all($this->city->get_current_city()->id);?>
				  		</span>
				  		
				  		<div class="hero-widget">
				  			
				  			<div class="icon">
				  				<i class="fa fa-thumbs-up"></i>
				  			</div>
				  			<div class="text">
				  				
				  				<label class="text-muted">
                                    <?php echo $this->lang->line('item_like_counts'); ?>
                                    </label>
				  			</div>
				  		</div>
			  		
			  		</a>
			  	</div>
			  	
			  	<div class="col-sm-3">
		  			<a href="<?php  echo site_url('soaco_Liste_msg') ?>">
		  			
			  			<span class="badge red-bg">
		  	  			<?php echo $this->inquiry->count_all($this->city->get_current_city()->id);?>
		  	  		</span>
		  	  		
		  	  		<div class="hero-widget">
		  	  			
		  	  			<div class="icon">
		  	  				<i class="fa fa-envelope"></i>
		  	  			</div>
		  	  			<div class="text">
		  	  				
		  	  				<label class="text-muted">
                                <?php echo $this->lang->line('f_next'); ?>
                            </label>
		  	  			</div>
		  	  		</div>
		  			
		  			</a>
		  		</div>
			  	
		  	</div>
			<hr/>



                <div class="row">
		            <div class="col-lg-4">


						<div class="ibox float-e-margins ">
						    <div class="ibox-title">
						        <h5>Communes</h5>
						        <div class="ibox-tools">
						            <span class="label label-warning-light"><?php echo $this->category->count_all($this->city->get_current_city()->id); ?> Communes</span>
						        </div>
						    </div>
						    <div class="ibox-content">
						        
						        <div>
						        	<?php 
						        		$all_categories = $this->category->get_all($this->city->get_current_city()->id, 5);
						        		foreach($all_categories->result() as $cat)
						        			echo '<h5>'.$cat->name.' <br/><small class="m-r">'.
						        				'<a href="'.site_url('categories/edit/' . $cat->id).'">Detail!</a></small></h5>';
						        	?>
						         </div>
						         
						    </div>
						</div>
						
		                <div class="ibox float-e-margins">
		                    <div class="ibox-title">
                                <?php
                                $all_inquiries = $this->inquiry->get_all($this->city->get_current_city()->id, 5);
                                $all_inquiries_count = $this->inquiry->count_all($this->city->get_current_city()->id);
                                ?>
		                        <h5> Messages</h5>
		                        <div class="ibox-tools">
		                            <span class="label label-warning-light">Total : <?php echo $all_inquiries_count; ?> Messages</span>
		                        </div>
		                    </div>

                            <div class="ibox-content">
                                <div class="feed-activity-list">

                                    <?php
                                    foreach($all_inquiries->result() as $inquiry)
                                        echo "<div class='feed-element'><div>".
                                            "<small class='pull-right text-navy'>".$this->inquiry->ago($inquiry->added)."</small>".
                                            "<strong>".$inquiry->name."</strong>".
                                            "<div><i class='glyphicon glyphicon-envelope'></i>    ".$this->feed->read_more_text($inquiry->message)."</div>".
                                            "</div></div>";
                                    ?>

                                </div>
                                <small class="pull-right text-navy"><a href='<?php echo site_url('soaco_Liste_msg');?>'>Tous voir</a></small>
                            </div>
		                </div>
		            </div>
		        
		            <div class="col-lg-8">
		                <div class="row">
		                    <div class="col-lg-6">

		                        <!--
		                        <div class="ibox float-e-margins">
			                        <?php
			                        	$all_items = $this->item->get_all($this->city->get_current_city()->id, 7);
			                        	$all_items_count = $this->item->count_all($this->city->get_current_city()->id);
			                         ?>
		                            <div class="ibox-title">
		                                <h5>Recent Items list</h5>
		                                <div class="ibox-tools">
		                                    <span class="label label-warning-light">Total : <?php echo $all_items_count;?> Items</span>
		                                </div>
		                            </div>
		                            <div class="ibox-content">
		                                <table class="table table-hover no-margins">
		                                    <thead>
		                                    <tr>
		                                        <th>Name</th>
		                                        <th>Category</th>
		                                        <th>Sub Cat.</th>
		                                    </tr>
		                                    </thead>

		                                    <tbody>

		                                    <?php

		                                    	foreach($all_items->result() as $item)
		                                    		echo '<tr>'.
		                                    			 '<td><small>'.$item->name.'</small></td>'.
		                                    			 '<td><small>'.$this->category->get_info($item->cat_id)->name.'</small></td>'.
		                                    			 '<td><small>'.$this->sub_category->get_info($item->sub_cat_id)->name.'</small></td>'.
		                                    		     '</tr>';
		                                    ?>
		                                   </tbody>
		                                </table>
		                                <small class="pull-right text-navy"><a href='<?php echo site_url('items');?>'>Tous voir</a></small>
		                            </div>
		                        </div>-->
		                        <div class="ibox float-e-margins">
		                            <div class="ibox-title">
		                                <h5>Arrondissements</h5>
		                                <div class="ibox-tools">
		                                    <span class="label label-warning-light"> <?php echo $this->sub_category->count_all($this->city->get_current_city()->id); ?> Arrondissements</span>
		                                </div>
		                            </div>
		                            <div class="ibox-content">
		                                
		                                <div>
		                                	<?php 
		                                		$all_sub_categories = $this->sub_category->get_all($this->city->get_current_city()->id, 5);
		                                		foreach($all_sub_categories->result() as $sub_cat)
		                                			echo '<h5>'.$sub_cat->name.' <br/><small class="m-r">'.
		                                				'<a href="'.site_url('sub_categories/edit/' . $cat->id).'">Detail!</a></small></h5>';
		                                	?>
		                                 </div>
		                                 
		                            </div>
		                        </div>


		                    </div>
		                   <div class="col-lg-6">
		                        <div class="ibox float-e-margins">
                                    <?php
                                    $all_feeds = $this->feed->get_all($this->city->get_current_city()->id, 3);
                                    $all_feeds_count = $this->feed->count_all($this->city->get_current_city()->id);
                                    ?>
		                            <div class="ibox-title">
		                                <h5>Gerants station</h5>
		                                <div class="ibox-tools">
                                            <span class="label label-warning-light"> <?php echo $all_feeds_count;?> Gerants</span>
		                                </div>
		                            </div>
                                    <div class="ibox-content">
                                        <div>
                                            <div class="feed-activity-list">
                                                <?php
                                                foreach($all_feeds->result() as $feed){
                                                    $feed_all =  $this->image->get_all_by_type($feed->id,'feed')->result();

                                                    if(count($feed_all)<1){
                                                        $feed_image = "avatar.png";
                                                    } else {
                                                        $feed_image = $feed_all[0]->path;
                                                    }


                                                    echo "<div class='feed-element'>".
                                                        "<a href='#'><img class='img-circle pull-left' src='".base_url('uploads/'.$feed->profile_photo)."'></a>".
                                                        "<div class='media-body '>".
                                                        "<small class='pull-right'>".$this->inquiry->ago($feed->added)."</small>".
                                                        "<strong>".$feed->fullname."</strong><br>".
                                                        "<small class='text-muted'><a href='#'>".$this->db->get_where('cd_items' , array('id' => $feed->station_id))->row()->name."</a></small>".
                                                        "</div>".
                                                        "</div>";
                                                }
                                                ?>
                                            </div>
                                            <small class="pull-right text-navy"><a href='<?php echo site_url('feeds');?>'>Tous voir</a></small>
                                        </div>
                                    </div>

		                    </div>
		                </div>
		                
		                <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <?php
                                    $all_items = $this->item->get_all($this->city->get_current_city()->id, 11);
                                    $all_items_count = $this->item->count_all($this->city->get_current_city()->id);
                                    ?>
                                    <div class="ibox-title">
                                        <h5>Station de <?php echo $this->city->get_current_city()->name;?></h5>
                                        <div class="ibox-tools">
                                            <span class="label label-warning-light"> <?php echo $all_items_count;?> Stations</span>
                                        </div>
                                    </div>
                                    <div class="ibox-content">
                                        <table class="table table-hover no-margins">
                                            <thead>
                                            <tr style="font-size: 11px;">
                                                <th>Nom Station</th>
                                                <th>Commune</th>
                                                <th>Arrondissement</th>
                                                <th>Quartier</th>
                                            </tr>
                                            </thead>

                                            <tbody>

                                            <?php

                                            foreach($all_items->result() as $item)
                                                echo '<tr>'.
                                                    '<td><small><a href="#" data-toggle="modal" data-target="#myModal" >'.$item->name.'</a></small></td>'.
                                                    '<td><small>'.$this->category->get_info($item->cat_id)->name.'</small></td>'.
                                                    '<td><small>'.$this->sub_category->get_info($item->sub_cat_id)->name.'</small></td>'.
                                                    '<td><small>'.$item->address.'</small></td>'.
                                                    '</tr>';
                                            ?>
                                            </tbody>
                                        </table>
                                        <small class="pull-right text-navy"><a href='<?php echo site_url('items');?>'>Tous voir</a></small>
                                    </div>
                                </div>
                            </div>
                        </div>
		
		            </div>
		
		
		        </div>
		        </div>
			</div>

            <div class="modal fade"  id="myModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Ferme</span></button>
                            <h4 class="modal-title">Profile de la Station</h4>
                        </div>

                        <div class="row">
                            <div class="ibox float-e-margins">

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Panel title</h3>
                                            </div>
                                            <div class="panel-body">
                                                Panel content
                                            </div>
                                        </div>
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Panel title</h3>
                                            </div>
                                            <div class="panel-body">
                                                Panel content
                                            </div>
                                        </div>
                                    </div><!-- /.col-sm-4 -->
                                    <div class="col-sm-4">
                                        <div class="panel panel-success">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Panel title</h3>
                                            </div>
                                            <div class="panel-body">
                                                Panel content
                                            </div>
                                        </div>
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Panel title</h3>
                                            </div>
                                            <div class="panel-body">
                                                Panel content
                                            </div>
                                        </div>
                                    </div><!-- /.col-sm-4 -->
                                    <div class="col-sm-4">
                                        <div class="panel panel-warning">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Panel title</h3>
                                            </div>
                                            <div class="panel-body">
                                                Panel content
                                            </div>
                                        </div>
                                        <div class="panel panel-danger">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Panel title</h3>
                                            </div>
                                            <div class="panel-body">
                                                Panel content
                                            </div>
                                        </div>
                                    </div><!-- /.col-sm-4 -->
                                </div>

                            <div class="clearfix"></div>
                            <div class="col-sm-12">
                                <div class="modal-body">
                                    <p>Voudriez-vous supprimer toutes les stations associe a cette communes?</p>
                                    <p>Oui Tous- Communes et toutes les stations seront supprimer de ce systeme</p>
                                </div>
                            </div>

                            </div>
                        </div>


                        <div class="modal-footer">
                            <a type="button" class="btn btn-primary" data-dismiss="modal">Ok</a>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
