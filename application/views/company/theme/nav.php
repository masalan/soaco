
<!-- .top-bar -->




<!-- .top-bar -->
<div class="top-bar">
    <div class="top-bar-brand">
        <a href="<?php echo site_url('company/'.url_encode($this->user->get_logged_in_user_info()->user_id));?>"><img src="<?php echo base_url();?>uploads/<?php echo html_entity_decode($societe->logo );?>" alt="" style="height: 32px;width: auto;"></a>
    </div>
    <div class="top-bar-list">
        <div class="top-bar-item px-2 d-md-none d-lg-none d-xl-none">
            <button class="hamburger hamburger-squeeze" type="button" data-toggle="aside" aria-label="toggle menu"><span class="hamburger-box"><span class="hamburger-inner"></span></span></button> <!-- /toggle menu -->
        </div>
        <div class="top-bar-item top-bar-item-right px-0 d-none d-sm-flex">
            <ul class="header-nav nav">
                <li class="nav-item dropdown header-nav-dropdown">
                    <a class="nav-link has-badge" href="layout-nosearch.html#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php if ($this->inquiry->count_all_msg_unread_from_station($this->user->get_logged_in_user_info()->user_id)== 0):?>
                        <?php else:?>
                            <span class="badge badge-pill badge-warning"><?php echo $this->inquiry->count_all_msg_unread_from_station($this->user->get_logged_in_user_info()->user_id);?></span>
                        <?php endif;?>
                        <span class="oi oi-pulse"></span>3</a>
                    <div class="dropdown-arrow"></div>
                    <div class="dropdown-menu dropdown-menu-rich dropdown-menu-right">
                        <h6 class="dropdown-header stop-propagation">
                            <span>Activités du Jour <span class="badge"></span></span>
                        </h6>
                        <div class="dropdown-scroll perfect-scrollbar">
                            <?php if(!$count=$this->uri->segment(3))
                                $count = 0;
                            if(isset($activite) && count($activite->result())>0):
                            foreach($activite->result() as $ms):
                            ?>


                            <a href="<?php echo base_url().$ms->id; ?>" class="dropdown-item unread">
                                <div class="user-avatar">
                                    <img src="<?php echo base_url();?>uploads/soaco.png" alt="">
                                </div>
                                <div class="dropdown-item-body">
                                    <p class="text" style="font-size: 12px;"> <?php echo $ms->name.' | '.$ms->quantity_out .' | '. $this->db->get_where('cd_items',array('id'=>$ms->station_id))->row()->name; ?> </p><span class="date"><?php echo time_ago($ms->time_out); ?> </span>
                                </div>
                            </a>


                            <?php
                            endforeach;
                            else:?>
                                <a class="dropdown-item unread">

                                    <div class="dropdown-item-body">
                                        <p class="text"> Aucune activités </p>
                                    </div>
                                </a>
                            <?php
                            endif;
                            ?>


                        </div><!-- /.dropdown-scroll -->
                        <a  class="dropdown-footer">Toutes les activités <i class="fas fa-fw fa-long-arrow-alt-right"></i></a>
                    </div><!-- /.dropdown-menu -->
                </li><!-- /.nav-item -->
                <!-- .nav-item -->
                <li class="nav-item dropdown header-nav-dropdown">
                    <a class="nav-link" href="layout-nosearch.html#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="oi oi-envelope-open"></span><?php if ($this->inquiry->count_all_msg_unread_from_station($this->user->get_logged_in_user_info()->user_id)== 0):?>
                        <?php else:?>
                            <span class="badge badge-pill badge-warning"><?php echo $this->inquiry->count_all_msg_unread_from_station($this->user->get_logged_in_user_info()->user_id);?></span>
                        <?php endif;?></a>
                    <div class="dropdown-arrow"></div><!-- .dropdown-menu -->
                    <div class="dropdown-menu dropdown-menu-rich dropdown-menu-right">
                        <h6 class="dropdown-header stop-propagation">
                            <span>Messages</span>
                        </h6>
                        <div class="dropdown-scroll perfect-scrollbar">
                            <?php
                            if(!$count=$this->uri->segment(3))
                                $count = 0;
                            if(isset($msg) && count($msg->result())>0):
                            foreach($msg->result() as $ms):
                            ?>
                            <a href="layout-nosearch.html#" class="dropdown-item unread">
                                <div class="user-avatar">
                                    <img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('be_users',array('user_id'=>$ms->user_id))->row()->profile_photo;?>" alt="">
                                </div>
                                <div class="dropdown-item-body">
                                    <p class="subject"> <?php echo $this->db->get_where('be_users',array('user_id'=>$ms->user_id))->row()->fullname;?> </p>
                                    <p class="text text-truncate"> <?php echo $ms->titre_msg;?> </p><span class="date"><?php echo time_ago($ms->added);?></span>
                                </div>
                            </a>
                            <?php
                            endforeach;
                            else:?>
                                <a  class="dropdown-item unread">

                                    <div class="dropdown-item-body">
                                        <p class="text text-truncate"> Aucun Message</p>
                                    </div>
                                </a>
                            <?php
                            endif;
                            ?>
                        </div><!-- /.dropdown-scroll -->
                        <a href="page-messages.html" class="dropdown-footer">Tous les messages <i class="fas fa-fw fa-long-arrow-alt-right"></i></a>
                    </div><!-- /.dropdown-menu -->
                </li><!-- /.nav-item -->
                <!-- .nav-item -->
                <li class="nav-item dropdown header-nav-dropdown">
                    <a class="nav-link" href="layout-nosearch.html#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="oi oi-grid-three-up"></span></a>
                    <div class="dropdown-arrow"></div><!-- .dropdown-menu -->
                    <div class="dropdown-menu dropdown-menu-rich dropdown-menu-right">
                        <!-- .dropdown-sheets -->
                        <div class="dropdown-sheets">
                            <!-- .dropdown-sheet-item -->
                            <div class="dropdown-sheet-item">
                                <a href="layout-nosearch.html#" class="tile-wrapper"><span class="tile tile-lg bg-indigo"><i class="oi oi-people"></i></span> <span class="tile-peek">Teams</span></a>
                            </div><!-- /.dropdown-sheet-item -->
                            <!-- .dropdown-sheet-item -->
                            <div class="dropdown-sheet-item">
                                <a href="layout-nosearch.html#" class="tile-wrapper"><span class="tile tile-lg bg-teal"><i class="oi oi-fork"></i></span> <span class="tile-peek">Projects</span></a>
                            </div><!-- /.dropdown-sheet-item -->
                            <!-- .dropdown-sheet-item -->
                            <div class="dropdown-sheet-item">
                                <a href="layout-nosearch.html#" class="tile-wrapper"><span class="tile tile-lg bg-pink"><i class="fa fa-tasks"></i></span> <span class="tile-peek">Tasks</span></a>
                            </div><!-- /.dropdown-sheet-item -->
                            <!-- .dropdown-sheet-item -->
                            <div class="dropdown-sheet-item">
                                <a href="layout-nosearch.html#" class="tile-wrapper"><span class="tile tile-lg bg-yellow"><i class="oi oi-fire"></i></span> <span class="tile-peek">Feeds</span></a>
                            </div><!-- /.dropdown-sheet-item -->
                            <!-- .dropdown-sheet-item -->
                            <div class="dropdown-sheet-item">
                                <a href="layout-nosearch.html#" class="tile-wrapper"><span class="tile tile-lg bg-cyan"><i class="oi oi-document"></i></span> <span class="tile-peek">Files</span></a>
                            </div><!-- /.dropdown-sheet-item -->
                        </div><!-- .dropdown-sheets -->
                    </div><!-- .dropdown-menu -->
                </li><!-- /.nav-item -->
            </ul><!-- /.nav -->
            <!-- .btn-account -->
            <div class="dropdown d-none d-sm-flex">

                <footer class="aside-footer border-top p-3">
                    <button class="btn btn-secondary" data-toggle="skin">Mode Nuit <i class="fas fa-moon ml-1"></i></button>
                </footer><!-- /Skin changer -->


                <button class="btn-account" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="user-avatar user-avatar-md"><img src="<?php echo base_url();?>uploads/<?php echo html_entity_decode($societe->logo );?>" alt="<?php echo $societe->company_name?> "></span>
                    <span class="account-summary pr-md-4 d-none d-md-block"><span class="account-name" style="font-size: 12px;"><?php echo $societe->company_name?> </span>
                        <span class="account-description" style="font-size: 10px; text-align: center;">SOACO e-Station ( <?php echo $this->city->get_current_country()->name;?>)</span></span></button>
                <div class="dropdown-arrow dropdown-arrow-left"></div><!-- .dropdown-menu -->
                <div class="dropdown-menu">
                    <h6 class="dropdown-header d-none d-sm-block d-md-none"><?php echo $societe->company_name?> </h6>
                    <a class="dropdown-item" href="user-profile.html"><span class="dropdown-icon oi oi-person"></span> Profile</a>
                    <a class="dropdown-item" href="<?php echo site_url('exit');?>"><span class="dropdown-icon oi oi-account-logout"></span> Déconnexion</a>
                    <div class="dropdown-divider"></div><a class="dropdown-item" >Aides</a>
                </div><!-- /.dropdown-menu -->
            </div><!-- /.btn-account -->
        </div><!-- /.top-bar-item -->
    </div><!-- /.top-bar-list -->
</div><!-- /.top-bar -->








</header><!-- /.app-header -->
<!-- .app-aside -->
<aside class="app-aside app-aside-light">
    <!-- .aside-content -->
    <div class="aside-content">
        <!-- .aside-header -->
        <header class="aside-header">
            <!-- toggle menu -->
            <button class="hamburger hamburger-squeeze" type="button" data-toggle="aside" aria-label="Menu"><span class="hamburger-box"><span class="hamburger-inner"></span></span></button> <!-- /toggle menu -->
            <!-- .btn-account -->
            <button class="btn-account d-flex d-md-none" type="button" data-toggle="collapse" data-target="#dropdown-aside">
                <span class="user-avatar user-avatar-lg"><img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('be_users',array('user_id'=>$ms->user_id))->row()->profile_photo;?>" alt=""></span>
                <span class="account-icon"><span class="fa fa-caret-down fa-lg"></span></span>
                <span class="account-summary"><span class="account-name"><?php echo $societe->company_name?> </span>
                    <span class="account-description" style="font-size: 11px;">SOACO e-Station ( <?php echo $this->city->get_current_country()->name;?>)</span></span></button> <!-- /.btn-account -->
            <!-- .dropdown-aside -->
            <div id="dropdown-aside" class="dropdown-aside d-md-none collapse">
                <!-- dropdown-items -->
                <div class="pb-3">
                    <a class="dropdown-item" href="<?php echo base_url('')?>"><span class="dropdown-icon oi oi-person"></span> Profile</a>
                    <a class="dropdown-item" href="<?php echo base_url('exit')?>><span class="dropdown-icon oi oi-account-logout"></span> Déconnexion</a>
                </div><!-- /dropdown-items -->
            </div><!-- /.dropdown-aside -->
            <!-- .top-bar-brand -->
            <div class="top-bar-brand bg-primary">
                <a href="<?php echo base_url('');?>"><img src="<?php echo base_url();?>uploads/<?php echo html_entity_decode($societe->logo );?>" height="32" alt=""></a>
            </div><!-- /.top-bar-brand -->





        </header><!-- /.aside-header -->
        <!-- .aside-menu -->

        <!-- Skin changer -->
        <footer class="aside-footer border-top p-3">
            <button class="btn btn-light btn-block text-primary" data-toggle="skin">Mode Nuit <i class="fas fa-moon ml-1"></i></button>
        </footer><!-- /Skin changer -->
    </div><!-- /.aside-content -->
</aside><!-- /.app-aside -->
<!-- .app-main -->x