

<div class="wrapper">

    <div class="main">
        <nav class="navbar navbar-expand navbar-dark">
            <a class="sidebar-toggle d-flex mr-2"  href="<?php echo base_url('soaco_e-Station/').url_encode($station->id);?>">
                <i class="align-middle mr-2 fas fa-fw fa-gas-pump text-danger"></i>
            </a>
            <p style="color: white;"> e-Station <small class="d-none d-sm-inline">| v 1.0</small></p>
            <div class="navbar-collapse collapse">
                <ul class="navbar-nav ml-auto">

                    <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="modal" data-target="#checkMycardsNow" >
                            <span class="d-none d-lg-inline-block">Verification</span>
                            <span class="d-lg-none"><i class="align-middle fas fa-envelope-open"></i></span>
                        </a>
                    </li>



                    <li class="nav-item dropdown ">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="modal" data-target="#notesStation" >
                            <span class="d-none d-lg-inline-block">Notes</span>
                            <span class="d-lg-none"><i class="align-middle fas fa-envelope-open"></i></span>
                        </a>
                    </li>


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" data-toggle="dropdown">
                        <span class="d-none d-lg-inline-block">

<?php if ($this->inquiry->count_all_msg_unread($station->id)== 0):?>
<?php else:?>
    <span class="badge badge-pill badge-danger"><?php echo $this->inquiry->count_all_msg_unread($station->id);?></span>
<?php endif;?>
                            Messages</span><span class="d-lg-none"><i class="align-middle fas fa-envelope-open"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right py-0" aria-labelledby="messagesDropdown">
                            <div class="dropdown-menu-header">
                                <div class="position-relative">
                                    Nouveau <span class="badge badge-pill badge-danger"><?php echo $this->inquiry->count_all_msg_unread($station->id);?></span>
                                    Lu <span class="badge badge-pill badge-secondary"><?php echo $this->inquiry->count_all_msg_read($station->id);?></span>


                                </div>
                            </div>

                            <div class="list-group">
                                <?php
                                if(!$count=$this->uri->segment(3))
                                    $count = 0;
                                if(isset($msg) && count($msg->result())>0):
                                    foreach($msg->result() as $ms):
                                        ?>

                                        <a href="<?php echo base_url('messages/')?>" class="list-group-item">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-2">
                                                    <img src=" <?php echo base_url();?>uploads/<?php echo $this->db->get_where('be_users',array('user_id'=>$ms->user_id))->row()->profile_photo;?>" class="avatar img-fluid rounded-circle" alt="">
                                                </div>
                                                <div class="col-10 pl-2">
                                                    <div class="text-dark"><?php echo $this->db->get_where('be_users',array('user_id'=>$ms->user_id))->row()->fullname;?></div>
                                                    <div class="text-muted small mt-1"><?php echo $ms->titre_msg?></div>
                                                    <div class="text-muted small mt-1">
                                                        <?php if ($ms->is_read == 0):?>
                                                            <span class="badge badge-pill badge-danger">Non Lu</span>
                                                        <?php else:?>
                                                            <span class="badge badge-pill badge-info">Lu</span>
                                                        <?php endif;?><?php echo $ms->added?></div>
                                                </div>
                                            </div>
                                        </a>
                                    <?php
                                    endforeach;
                                else:
                                    ?>
                                    <a class="list-group-item">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-12 pl-2">
                                                <div class="text-muted">Aucun Message</div>
                                            </div>
                                        </div>
                                    </a>
                                <?php
                                endif;
                                ?>
                            </div>
                            <div class="dropdown-menu-footer">
                                <a href="<?php echo base_url('messages/')?>" target="_blank" class="text-muted">Tous les messages</a>
                            </div>
                        </div>
                    </li>







                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" data-toggle="dropdown">
                        <span class="d-none d-lg-inline-block">

<?php if ($this->item->count_all_code_valid($station->id)== 0):?>
<?php else:?>
    <span class="badge badge-pill badge-danger"><?php echo $this->item->count_all_code_valid($station->id);?></span>
<?php endif;?>
                            Code</span><span class="d-lg-none"><i class="align-middle fas fa-envelope-open"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right py-0" aria-labelledby="messagesDropdown">
                            <div class="dropdown-menu-header">
                                <div class="position-relative">
                                    Valide <span class="badge badge-pill badge-danger"><?php echo $this->item->count_all_code_valid($station->id);?></span>
                                    Expiré <span class="badge badge-pill badge-secondary"><?php echo $this->item->count_all_code_invalid($station->id);?></span>


                                </div>
                            </div>

                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

                            <div class="list-group">
                                <?php
                                if(!$count=$this->uri->segment(3))
                                    $count = 0;
                                if(isset($secure_code) && count($secure_code->result())>0):
                                    foreach($secure_code->result() as $ms):
                                        ?>

                                        <a href="#" class="list-group-item" >
                                            <div class="row no-gutters align-items-center">

                                                <div class="col-10 pl-2" >


                                                    <div class="col-md">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="<?php echo $ms->code;?>" id="copy-input">
                                                                <span class="input-group-append">

              <button class="btn btn-warning" type="button" id="copy-button" data-toggle="tooltip" data-placement="button" title="Copy to Clipboard">Copier</button></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="text-muted small mt-1">
                                                        <?php if ($ms->is_valid == 0):?>
                                                            <span class="badge badge-pill badge-danger">Valide</span>
                                                        <?php else:?>
                                                            <span class="badge badge-pill badge-info">Expiré</span>
                                                        <?php endif;?><?php echo time_ago( $ms->created);?></div>
                                                </div>
                                            </div>
                                        </a>
                                    <?php
                                    endforeach;
                                else:
                                    ?>
                                    <a class="list-group-item">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-12 pl-2">
                                                <div class="text-muted">Aucun code</div>
                                            </div>
                                        </div>
                                    </a>
                                <?php
                                endif;
                                ?>
                            </div>
                    </li>




                    <li class="nav-item dropdown ml-lg-2">
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" data-toggle="dropdown">
                            <span class="d-none d-lg-inline-block">Menu</span>
                            <span class="d-lg-none"><i class="align-middle fas fa-book"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right py-0" aria-labelledby="alertsDropdown">
                            <div class="list-group">
                                <div class="dropdown-menu-header">
                                    <div class="position-relative">
                                        Gérant de la Station
                                    </div>
                                </div>
                                <a href="#" class="list-group-item">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-2">
                                            <i class="ml-1 text-primary fas fa-fw fa-building"></i>
                                        </div>
                                        <div class="col-10">
                                            <div class="text-dark">Connecté depuis 192.186.1.1</div>
                                        </div>
                                    </div>
                                </a>
                                <a href="<?php echo site_url('fixer/'.url_encode($station->id));?>" class="list-group-item">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-2">
                                            <i class="text-success ion ion-ios-cloud-done mr-2"></i>
                                        </div>
                                        <div class="col-10">
                                            <div class="text-dark">Réglages</div>
                                            <div class="text-muted small mt-1">Modifications & Ajustement des informations primaires</div>
                                        </div>
                                    </div>
                                </a>

                                <a href="<?php echo site_url('ensemble/'.url_encode($station->id));?>" class="list-group-item">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-2">
                                            <i class="ion ion-ios-list-box mr-2"></i>
                                        </div>
                                        <div class="col-10">
                                            <div class="text-dark">Vue d`ensemble</div>
                                            <div class="text-muted small mt-1">Liste par produits et details</div>
                                        </div>
                                    </div>
                                </a>
                            </div>


                            <div class="dropdown-menu-header">
                                <div class="position-relative">
                                    Responsable de la Station
                                </div>
                            </div>



                            <div class="list-group">
                                <a href="<?php echo site_url('statistiques/'.url_encode($station->id));?>" class="list-group-item">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-2">
                                            <i class="align-middle  text-danger  mr-2 fas fa-fw fa-gas-pump"></i>
                                        </div>
                                        <div class="col-10">
                                            <div class="text-dark">Gestion de Fluides/Services</div>
                                            <div class="text-muted small mt-1">Statistiques</div>
                                        </div>
                                    </div>
                                </a>

                                <a href="<?php echo site_url('stock/'.url_encode($station->id));?>" class="list-group-item">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-2">
                                            <i class="align-middle mr-2 text-dark"  data-feather="database"></i>
                                        </div>
                                        <div class="col-10">
                                            <div class="text-dark">Gestion de Stock</div>
                                            <div class="text-muted small mt-1">Ravitaillement</div>
                                        </div>
                                    </div>
                                </a>


                                <a href="<?php echo base_url('messages/')?>" target="_blank" class="list-group-item">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-2">
                                            <i class="ml-1 text-warning fas fa-fw fa-envelope-open"></i>
                                        </div>
                                        <div class="col-10">
                                            <div class="text-dark">Messages</div>
                                            <div class="text-muted small mt-1">Informations / Alertes/ Actualités.</div>
                                        </div>
                                    </div>
                                </a>
                            </div>



                        </div>
                    </li>
                    <li class="nav-item dropdown ml-lg-2">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-toggle="dropdown">
                            <span class="d-none d-lg-inline-block">Profil</span>
                            <span class="d-lg-none"><i class="align-middle fas fa-cog"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item" ><i class="align-middle mr-1 fas fa-fw fa-user"></i>Mon Profile</a>
                            <a href="<?php echo site_url('code_card');?>" class="dropdown-item" ><i class="align-middle mr-1 fas fa-fw fa-credit-card"></i> Verification</a>
                            <a class="dropdown-item" ><i class="align-middle mr-1 fas fa-fw fa-chart-pie"></i> Statistqiue</a>
                            <a class="dropdown-item" href="<?php echo site_url('fixer/'.url_encode($station->id));?>"><i class="align-middle mr-1 fas fa-fw fa-cogs"></i> Reglages</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?php echo site_url('station_exit');?>"><i class="align-middle mr-1 fas fa-fw fa-arrow-alt-circle-right"></i>Déconnexion</a>

                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="header text-center">
            <h1 class="header-title">
                Welcome back,  <?php echo html_entity_decode($user->fullname);?>!
            </h1>
            <?php if ($this->inquiry->count_all_msg_unread($station->id)== 0):?>
            <?php else:?>
                <p class="header-subtitle"> <strong>Bonjour!</strong> Vous avez <span class="badge badge-pill badge-danger"><?php echo $this->inquiry->count_all_msg_unread($station->id);?></span> messages non lu!</p>
            <?php endif;?>







        </div>

<div class="header">
    <div class="container-fluid">
        <div class="row">

            <div class="col-xl-4">
        <div class="media text-white" >
            <img class="rounded-circle rounded mr-2 mb-2" src="<?php echo base_url();?>uploads/<?php echo html_entity_decode($user->profile_photo );?>" alt="<?php echo html_entity_decode($user->fullname);?>" width="80" height="80">
            <div class="media-body">
                <h4 class="mb-1 text-white font-weight-normal"><?php echo html_entity_decode($station->name);?></h4>
                <span  style="font-size: 11px;"  class=" font-weight-normal"><i class="align-middle mr-1 fas fa-fw fa-gas-pump"></i>
                    <?php echo html_entity_decode($user->fullname);?>
                    <a href="tel:<?php echo  $station->phone;?>"><?php echo  $station->phone;?> </a><i class="align-middle mr-1 fas fa-fw fa-phone"></i></span><br>
                <span  style="font-size: 16px;"  class=" font-weight-normal">
                    <?php if ($user->role_id ==5):?>
                        <i class="ion ion-ios-person mr-2"></i><?php echo $this->db->get_where('be_roles',array('role_id'=>$user->role_id))->row()->role_desc;?>
                    <?php else:?>
                        <i class="ion ion-ios-person mr-2"></i><?php echo $this->db->get_where('be_roles',array('role_id'=>$user->role_id))->row()->role_desc;?>
                    <?php endif;?>
                </span>
            </div>

        </div></div>

            <div class="col-xl-4 text-right" >

            </div>

                <div class="col-xl-4 " >
                <div class="media text-white " >
                    ​<picture>
                        <source srcset="<?php echo base_url();?>uploads/<?php echo html_entity_decode($station->avatar );?>" type="image/svg+xml">
                        <img class="rounded-circle rounded mr-2 mb-2" src="<?php echo base_url();?>uploads/<?php echo html_entity_decode($station->avatar);?>" alt="<?php echo html_entity_decode($societe->fullname );?>" width="80" height="80">
                    </picture>
                    <div class="media-body">
                        <h4 class="mb-1 text-white font-weight-normal"> <i class="align-middle mr-1 fas fa-fw fa-home"></i> <?php echo html_entity_decode($societe->fullname);?></h4>
                        <span style="font-size: 11px;" class=" font-weight-normal"><i class="align-middle mr-1 fas fa-fw fa-location-arrow"></i>  <?php echo html_entity_decode($station->name);?>
                            <?php echo  $societe->company_phone;?> <i class="align-middle mr-1 fas fa-fw fa-phone"></i></span>
                    </div>
                </div>
                </div>

        </div>


    </div>
</div>


<script>
    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
    }





    $(document).ready(function() {
        // Initialize the tooltip.
        $('#copy-button').tooltip();

        // When the copy button is clicked, select the value of the text box, attempt
        // to execute the copy command, and trigger event to update tooltip message
        // to indicate whether the text was successfully copied.
        $('#copy-button').bind('click', function() {
            var input = document.querySelector('#copy-input');
            input.setSelectionRange(0, input.value.length + 1);
            try {
                var success = document.execCommand('copy');
                if (success) {
                    $('#copy-button').trigger('copied', ['Copied!']);
                } else {
                    $('#copy-button').trigger('copied', ['Copy with Ctrl-c']);
                }
            } catch (err) {
                $('#copy-button').trigger('copied', ['Copy with Ctrl-c']);
            }
        });

        // Handler for updating the tooltip message.
        $('#copy-button').bind('copied', function(event, message) {
            $(this).attr('title', message)
                .tooltip('fixTitle')
                .tooltip('show')
                .attr('title', "Copy to Clipboard")
                .tooltip('fixTitle');
        });
    });

</script>



<main class="content">

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-primary alert-dismissible " role="alert" data-auto-dismiss="10000">
            <div class="alert-message ql-align-center">
                <strong>Hey Salut!   </strong> <?php echo $this->session->flashdata('success');?>
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php elseif($this->session->flashdata('error')):?>
        <div class="alert alert-danger alert-dismissible" role="alert" data-auto-dismiss="10000">
            <div class="alert-message">
                <strong>hey Salut!   </strong> <?php echo $this->session->flashdata('error');?>
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif;?>

