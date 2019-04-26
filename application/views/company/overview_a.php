<main class="app-main">
    <!-- .wrapper -->
    <div class="wrapper">
        <!-- .page -->
        <div class="page">

            <?php if ($this->inquiry->count_all_msg_unread_from_station($this->user->get_logged_in_user_info()->user_id)== 0):?>
            <?php else:?>
                <div class="page-message" role="alert">
                    <span class="mr-5"><strong> Salut!</strong> Vous avez <strong><?php echo $this->inquiry->count_all_msg_unread_from_station($this->user->get_logged_in_user_info()->user_id);?></strong> message(s) non lu</span> <a href="<?php echo site_url('company/'.url_encode($this->user->get_logged_in_user_info()->user_id));?>" class="btn btn-sm btn-warning circle mr-1"> Voir les messages</a> <a href="#" class="btn btn-sm btn-icon btn-warning" aria-label="Close" onclick="$(this).parent().fadeOut()"><span aria-hidden="true"><i class="fa fa-times"></i></span></a>
                </div>
            <?php endif;?>


            <!-- .page-cover -->
            <header class="page-cover">
                <div class="text-center">
                    <a href="<?php echo site_url('company/'.url_encode($this->user->get_logged_in_user_info()->user_id));?>" class="user-avatar user-avatar-xl"><img src="<?php echo base_url();?>uploads/<?php echo html_entity_decode($societe->logo );?>" alt=""></a>
                    <h2 class="h4 mt-2 mb-0"> <?php echo $societe->company_name?>  </h2>
                    <div class="my-1">
                        <!-- .spinner -->
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div><!-- /.spinner -->                        </div>
                    <p class="text-muted"> <span class="oi oi-media-record text-red pulse"></span>   <?php echo $societe->address?>  </p>
                    <p> Date d`expiration de votre licence SOACO e-station <br> 15 Juin 2022 </p>
                </div><!-- .cover-controls -->
                <div class="cover-controls cover-controls-bottom">
                    <a href="user-profile.html#" class="btn btn-light" data-toggle="modal" data-target="#followersModal"><?php echo $this->user->count_all_societe($this->user->get_logged_in_user_info()->user_id);?> station(s)</a> <a href="user-profile.html#" class="btn btn-light" data-toggle="modal" data-target="#followingModal">
                        <?php if ($this->inquiry->count_all_msg_unread_from_station($this->user->get_logged_in_user_info()->user_id)== 0):?>
                        <?php else:?>
                            <?php echo $this->inquiry->count_all_msg_unread_from_station($this->user->get_logged_in_user_info()->user_id);?>
                        <?php endif;?> Nouveau message(s)</a>
                </div><!-- /.cover-controls -->
            </header><!-- /.page-cover -->


            <!-- Liste station & messages -->
            <?php echo $this->load->view('company/home_modal'); ?>

            <nav class="page-navs">
                <div class="nav-scroller">
                    <!-- .nav -->
                    <div class="nav nav-center nav-tabs">
                        <a class="nav-link" href="<?php echo site_url('company/'.url_encode($this->user->get_logged_in_user_info()->user_id));?>">Resumé</a>
                        <a class="nav-link" href="user-activities.html">Activités <span class="badge">16</span></a>
                        <a class="nav-link" href="user-teams.html">Personneles</a>
                        <a class="nav-link active" href="<?php echo base_url('zones/').url_encode($this->user->get_logged_in_user_info()->user_id);?>">Zone activités</a>
                        <a class="nav-link" href="user-tasks.html">Taches</a>
                        <a class="nav-link" href="user-profile-settings.html">Réglages</a>
                    </div><!-- /.nav -->
                </div><!-- /.nav-scroller -->
            </nav><!-- /.page-navs -->


            <?php echo $this->load->view('company/zones/home_zones_liste'); ?>

        </div>





