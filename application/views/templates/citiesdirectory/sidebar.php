<div role="navigation">
    <div>
    	<ul class="nav" id="side-menu">
			
			<?php
				foreach($module_groups->result() as $grp){
					echo "<li>";
					echo "<a href='#'><i style='padding-right:3px;' class='fa ".$grp->group_icon." fa-fw'></i>".$grp->group_name. "<span class='fa arrow'></span></a>";
					
					?>
					<ul class="nav nav-second-level">
                        
                            <?php 
                            	foreach($allowed_modules->result() as $module){
                            		if($module->is_show_on_menu == 1 && $module->group_id == $grp->group_id && $grp->group_has_child == 1) {
                            			echo "<li style='padding-left: 10px;'>
                            			<a href='".site_url($module->module_name)."'><span class='fa fa-angle-right' style='padding-right: 4px;'></span>".
                            				$module->module_desc."</a></li>";
                            		}
                            	}
                            ?>
                        
                    </ul>
					<?php  
					
					echo "</li>";                          
				}
			?>

            <?php
            if(!$this->session->userdata('is_city_admin')) {
                ?>
                <li><a href='#'><i style='padding-right:3px;' class='fa fa-hospital-o fa-fw'></i>Gestion Station<span class='fa arrow'></span></a>
                    <ul class="nav nav-second-level">
                        <li style='padding-left: 10px;'>
                            <a href="<?php echo site_url('stations/list'); ?>"><span class='fa fa-angle-right' style='padding-right: 4px;'></span>Liste Stations</a></li><li style='padding-left: 10px;'>
                            <a href="<?php echo site_url('stations/create'); ?>" ><span class='fa fa-angle-right' style='padding-right: 4px;'></span>Ajoutes</a></li><li style='padding-left: 10px;'>
                    </ul>
                </li>
                <li><a href="<?php echo site_url('backup');?>">
                        <span class="glyphicon glyphicon-export" style="padding-right: 3px;"></span>Exporte BDD
                    </a>
                </li>


                <li><a href='#'><i style='padding-right:3px;' class='fa fa-hospital-o fa-fw'></i>Gestion Commune<span class='fa arrow'></span></a>
                    <ul class="nav nav-second-level">
                        <li style='padding-left: 10px;'>
                            <a href="<?php echo site_url('com'); ?>"><span class='fa fa-angle-right' style='padding-right: 4px;'></span>Liste</a></li><li style='padding-left: 10px;'>
                    </ul>
                </li>
                <li><a href="<?php echo site_url('backup');?>">
                        <span class="glyphicon glyphicon-export" style="padding-right: 3px;"></span>Exporte BDD
                    </a>
                </li>

            <?php } ?>


			</ul>

		</div>
</div>