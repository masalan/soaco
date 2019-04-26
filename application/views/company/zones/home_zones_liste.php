<div class="page-inner">
    <!-- .page-title-bar -->
    <header class="page-title-bar">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="<?php echo site_url('company/'.url_encode($this->user->get_logged_in_user_info()->user_id));?>"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Accueil</a></li>
            </ol>
        </nav>
        <h1 class="page-title"> Zones <small class="badge">Total : 42 </small>
        </h1>
    </header>


    <div class="page-section">
        <?php $index = 0;
        foreach ($cities as $city) {
        if (($index % 3) == 0) {
            echo '<div class="row">';}
        $index++; ?>
            <div class="col-lg-6 col-xl-4">
                <div class="card card-fluid">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-muted" data-toggle="tooltip" data-placement="bottom" title="Activités du jour"><span class="sr-only">Activités du jour</span> <i class="fa fa-calendar-alt text-muted mr-1"></i> <?php echo mdate('%d-%m-%Y', now());?></span>
                            <div class="dropdown">
                                <button type="button" class="btn btn-icon btn-light" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></button>
                                <div class="dropdown-arrow"></div>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="user-projects.html#" class="dropdown-item">View Project</a>
                                    <a href="user-projects.html#" class="dropdown-item">Add Member</a>
                                    <a href="user-projects.html#" class="dropdown-item">Edit</a>
                                    <a href="user-projects.html#" class="dropdown-item">Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body text-center">
                        <h1 class="card-title  mb-0 badge bg-muted" data-toggle="tooltip" data-placement="top" title="Essence +Gasoil+ Pétrole ">
                            <?php echo ($this->item->fuel_sell_by_zone_today(1,$city->id)->row()->quantity_out?:0)* $this->db->get_where('cd_price',array('company_id'=>$societe->user_id,'type'=>1))->row()->prix
                            + ($this->item->fuel_sell_by_zone_today(2,$city->id)->row()->quantity_out?:0) * $this->db->get_where('cd_price',array('company_id'=>$societe->user_id,'type'=>2))->row()->prix
                            + ($this->item->fuel_sell_by_zone_today(5,$city->id)->row()->quantity_out?:0) * $this->db->get_where('cd_price',array('company_id'=>$societe->user_id,'type'=>5))->row()->prix;?>
                            <sup style="font-size: 10px;">Fcfa</sup></h1>

                        <h5 class="card-title text-info">
                            <a target=" _self" href="<?php echo site_url('zone_details/'.url_encode($city->id));?>">
                                <?php echo $city->name; ?></a>
                        </h5>
                        <p class="card-subtitle text-muted"> Progress in 74% - Last update 1d </p><!-- .my-3 -->
                        <div class="my-3">
                            <div class="avatar-group">
                            <?php
                            $station = $this->db->get_where('cd_items',array('cat_id'=>$city->id,'country_id'=>$city->country_id));
                            foreach ($station->result() as $cat) {

                                echo " <a  class='user-avatar user-avatar-sm' data-toggle='tooltip' title=".$cat->name."> <img src=".base_url().'uploads/'.$cat->avatar." alt=".$cat->name."></a>";
                            } ?>
                                <a href="user-projects.html#" class="tile tile-sm tile-circle" data-toggle="modal" data-target="#membersModal">+<?php echo $this->item->count_all($city->id) ?> </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <strong>Sous zone</strong> <span class="d-block"><?php echo $this->category->count_all($city->id) ?>  </span>
                            </div>
                            <div class="col">
                                <strong>Stations</strong> <span class="d-block"><?php echo $this->item->count_all($city->id) ?> </span>
                            </div>
                            <div class="col">
                                <strong>Messages</strong> <span class="d-block"><?php echo $this->inquiry->count_all($city->id) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="progress progress-xs" data-toggle="tooltip" title="74%">
                        <div class="progress-bar bg-yellow" role="progressbar" aria-valuenow="2181" aria-valuemin="0" aria-valuemax="100" style="width: 74%">
                            <span class="sr-only">74% Complete</span>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if (($index % 3) == 0) {
                echo '</div>';}
        } ?>


        <!-- Modal Members List -->
        <!-- .modal -->
        <div class="modal fade" id="membersModal" tabindex="-1" role="dialog" aria-hidden="true">
            <!-- .modal-dialog -->
            <div class="modal-dialog modal-dialog-overflow" role="document">
                <!-- .modal-content -->
                <div class="modal-content">
                    <!-- .modal-header -->
                    <div class="modal-header">
                        <!-- .input-group -->
                        <div class="input-group has-clearable">
                            <button type="button" class="close" aria-label="Close"><i class="fa fa-times-circle"></i></button>
                            <div class="input-group-prepend">
                                <span class="input-group-text"><span class="oi oi-magnifying-glass"></span></span>
                            </div><input type="text" class="form-control" placeholder="Search Members">
                        </div><!-- /.input-group -->
                    </div><!-- /.modal-header -->
                    <!-- .modal-body -->
                    <div class="modal-body px-0">
                        <!-- .list-group -->
                        <div class="list-group list-group-flush">
                            <!-- .list-group-item -->
                            <div class="list-group-item">
                                <!-- .list-group-item-figure -->
                                <div class="list-group-item-figure">
                                    <a href="user-projects.html#" class="user-avatar"><img src="assets/images/avatars/uifaces5.jpg" alt="Craig Hansen"></a>
                                </div><!-- /.list-group-item-figure -->
                                <!-- .list-group-item-body -->
                                <div class="list-group-item-body">
                                    <h4 class="list-group-item-title">
                                        <a href="user-projects.html#">Craig Hansen</a>
                                    </h4>
                                    <p class="list-group-item-text"> Software Developer </p>
                                </div><!-- /.list-group-item-body -->
                                <!-- .list-group-item-figure -->
                                <div class="list-group-item-figure dropdown">
                                    <button class="btn btn-sm btn-icon btn-light" data-toggle="dropdown"><i class="fa fa-fw fa-ellipsis-v"></i></button>
                                    <div class="dropdown-arrow dropdown-arrow-left"></div>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <button type="button" class="dropdown-item">Message</button> <button type="button" class="dropdown-item">Invite to a team</button> <button type="button" class="dropdown-item">Copy member ID</button>
                                        <div class="dropdown-divider"></div><button type="button" class="dropdown-item">Remove</button>
                                    </div>
                                </div><!-- /.list-group-item-figure -->
                            </div><!-- /.list-group-item -->
                            <!-- .list-group-item -->
                            <div class="list-group-item">
                                <!-- .list-group-item-figure -->
                                <div class="list-group-item-figure">
                                    <a href="user-projects.html#" class="user-avatar"><img src="assets/images/avatars/uifaces9.jpg" alt="Jane Barnes"></a>
                                </div><!-- /.list-group-item-figure -->
                                <!-- .list-group-item-body -->
                                <div class="list-group-item-body">
                                    <h4 class="list-group-item-title">
                                        <a href="user-projects.html#">Jane Barnes</a>
                                    </h4>
                                    <p class="list-group-item-text"> Social Worker </p>
                                </div><!-- /.list-group-item-body -->
                                <!-- .list-group-item-figure -->
                                <div class="list-group-item-figure dropdown">
                                    <button class="btn btn-sm btn-icon btn-light" data-toggle="dropdown"><i class="fa fa-fw fa-ellipsis-v"></i></button>
                                    <div class="dropdown-arrow dropdown-arrow-left"></div>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <button type="button" class="dropdown-item">Message</button> <button type="button" class="dropdown-item">Invite to a team</button> <button type="button" class="dropdown-item">Copy member ID</button>
                                        <div class="dropdown-divider"></div><button type="button" class="dropdown-item">Remove</button>
                                    </div>
                                </div><!-- /.list-group-item-figure -->
                            </div><!-- /.list-group-item -->
                            <!-- .list-group-item -->
                            <div class="list-group-item">
                                <!-- .list-group-item-figure -->
                                <div class="list-group-item-figure">
                                    <a href="user-projects.html#" class="user-avatar"><img src="assets/images/avatars/uifaces4.jpg" alt="Nicole Barnett"></a>
                                </div><!-- /.list-group-item-figure -->
                                <!-- .list-group-item-body -->
                                <div class="list-group-item-body">
                                    <h4 class="list-group-item-title">
                                        <a href="user-projects.html#">Nicole Barnett</a>
                                    </h4>
                                    <p class="list-group-item-text"> Marketing Manager </p>
                                </div><!-- /.list-group-item-body -->
                                <!-- .list-group-item-figure -->
                                <div class="list-group-item-figure dropdown">
                                    <button class="btn btn-sm btn-icon btn-light" data-toggle="dropdown"><i class="fa fa-fw fa-ellipsis-v"></i></button>
                                    <div class="dropdown-arrow dropdown-arrow-left"></div>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <button type="button" class="dropdown-item">Message</button> <button type="button" class="dropdown-item">Invite to a team</button> <button type="button" class="dropdown-item">Copy member ID</button>
                                        <div class="dropdown-divider"></div><button type="button" class="dropdown-item">Remove</button>
                                    </div>
                                </div><!-- /.list-group-item-figure -->
                            </div><!-- /.list-group-item -->
                            <!-- .list-group-item -->
                            <div class="list-group-item">
                                <!-- .list-group-item-figure -->
                                <div class="list-group-item-figure">
                                    <a href="user-projects.html#" class="user-avatar"><img src="assets/images/avatars/uifaces6.jpg" alt="Michael Ward"></a>
                                </div><!-- /.list-group-item-figure -->
                                <!-- .list-group-item-body -->
                                <div class="list-group-item-body">
                                    <h4 class="list-group-item-title">
                                        <a href="user-projects.html#">Michael Ward</a>
                                    </h4>
                                    <p class="list-group-item-text"> Lawyer </p>
                                </div><!-- /.list-group-item-body -->
                                <!-- .list-group-item-figure -->
                                <div class="list-group-item-figure dropdown">
                                    <button class="btn btn-sm btn-icon btn-light" data-toggle="dropdown"><i class="fa fa-fw fa-ellipsis-v"></i></button>
                                    <div class="dropdown-arrow dropdown-arrow-left"></div>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <button type="button" class="dropdown-item">Message</button> <button type="button" class="dropdown-item">Invite to a team</button> <button type="button" class="dropdown-item">Copy member ID</button>
                                        <div class="dropdown-divider"></div><button type="button" class="dropdown-item">Remove</button>
                                    </div>
                                </div><!-- /.list-group-item-figure -->
                            </div><!-- /.list-group-item -->
                            <!-- .list-group-item -->
                            <div class="list-group-item">
                                <!-- .list-group-item-figure -->
                                <div class="list-group-item-figure">
                                    <a href="user-projects.html#" class="user-avatar"><img src="assets/images/avatars/uifaces8.jpg" alt="Juan Fuller"></a>
                                </div><!-- /.list-group-item-figure -->
                                <!-- .list-group-item-body -->
                                <div class="list-group-item-body">
                                    <h4 class="list-group-item-title">
                                        <a href="user-projects.html#">Juan Fuller</a>
                                    </h4>
                                    <p class="list-group-item-text"> Budget analyst </p>
                                </div><!-- /.list-group-item-body -->
                                <!-- .list-group-item-figure -->
                                <div class="list-group-item-figure dropdown">
                                    <button class="btn btn-sm btn-icon btn-light" data-toggle="dropdown"><i class="fa fa-fw fa-ellipsis-v"></i></button>
                                    <div class="dropdown-arrow dropdown-arrow-left"></div>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <button type="button" class="dropdown-item">Message</button> <button type="button" class="dropdown-item">Invite to a team</button> <button type="button" class="dropdown-item">Copy member ID</button>
                                        <div class="dropdown-divider"></div><button type="button" class="dropdown-item">Remove</button>
                                    </div>
                                </div><!-- /.list-group-item-figure -->
                            </div><!-- /.list-group-item -->
                            <!-- .list-group-item -->
                            <div class="list-group-item">
                                <!-- .list-group-item-figure -->
                                <div class="list-group-item-figure">
                                    <a href="user-projects.html#" class="user-avatar"><img src="assets/images/avatars/uifaces7.jpg" alt="Julia Silva"></a>
                                </div><!-- /.list-group-item-figure -->
                                <!-- .list-group-item-body -->
                                <div class="list-group-item-body">
                                    <h4 class="list-group-item-title">
                                        <a href="user-projects.html#">Julia Silva</a>
                                    </h4>
                                    <p class="list-group-item-text"> Photographer </p>
                                </div><!-- /.list-group-item-body -->
                                <!-- .list-group-item-figure -->
                                <div class="list-group-item-figure dropdown">
                                    <button class="btn btn-sm btn-icon btn-light" data-toggle="dropdown"><i class="fa fa-fw fa-ellipsis-v"></i></button>
                                    <div class="dropdown-arrow dropdown-arrow-left"></div>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <button type="button" class="dropdown-item">Message</button> <button type="button" class="dropdown-item">Invite to a team</button> <button type="button" class="dropdown-item">Copy member ID</button>
                                        <div class="dropdown-divider"></div><button type="button" class="dropdown-item">Remove</button>
                                    </div>
                                </div><!-- /.list-group-item-figure -->
                            </div><!-- /.list-group-item -->
                            <!-- .list-group-item -->
                            <div class="list-group-item">
                                <!-- .list-group-item-figure -->
                                <div class="list-group-item-figure">
                                    <a href="user-projects.html#" class="user-avatar"><img src="assets/images/avatars/uifaces10.jpg" alt="Joe Hanson"></a>
                                </div><!-- /.list-group-item-figure -->
                                <!-- .list-group-item-body -->
                                <div class="list-group-item-body">
                                    <h4 class="list-group-item-title">
                                        <a href="user-projects.html#">Joe Hanson</a>
                                    </h4>
                                    <p class="list-group-item-text"> Logistician </p>
                                </div><!-- /.list-group-item-body -->
                                <!-- .list-group-item-figure -->
                                <div class="list-group-item-figure dropdown">
                                    <button class="btn btn-sm btn-icon btn-light" data-toggle="dropdown"><i class="fa fa-fw fa-ellipsis-v"></i></button>
                                    <div class="dropdown-arrow dropdown-arrow-left"></div>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <button type="button" class="dropdown-item">Message</button> <button type="button" class="dropdown-item">Invite to a team</button> <button type="button" class="dropdown-item">Copy member ID</button>
                                        <div class="dropdown-divider"></div><button type="button" class="dropdown-item">Remove</button>
                                    </div>
                                </div><!-- /.list-group-item-figure -->
                            </div><!-- /.list-group-item -->
                            <!-- .list-group-item -->
                            <div class="list-group-item">
                                <!-- .list-group-item-figure -->
                                <div class="list-group-item-figure">
                                    <a href="user-projects.html#" class="user-avatar"><img src="assets/images/avatars/uifaces11.jpg" alt="Brenda Griffin"></a>
                                </div><!-- /.list-group-item-figure -->
                                <!-- .list-group-item-body -->
                                <div class="list-group-item-body">
                                    <h4 class="list-group-item-title">
                                        <a href="user-projects.html#">Brenda Griffin</a>
                                    </h4>
                                    <p class="list-group-item-text"> Medical Assistant </p>
                                </div><!-- /.list-group-item-body -->
                                <!-- .list-group-item-figure -->
                                <div class="list-group-item-figure dropdown">
                                    <button class="btn btn-sm btn-icon btn-light" data-toggle="dropdown"><i class="fa fa-fw fa-ellipsis-v"></i></button>
                                    <div class="dropdown-arrow dropdown-arrow-left"></div>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <button type="button" class="dropdown-item">Message</button> <button type="button" class="dropdown-item">Invite to a team</button> <button type="button" class="dropdown-item">Copy member ID</button>
                                        <div class="dropdown-divider"></div><button type="button" class="dropdown-item">Remove</button>
                                    </div>
                                </div><!-- /.list-group-item-figure -->
                            </div><!-- /.list-group-item -->
                            <!-- .list-group-item -->
                            <div class="list-group-item">
                                <!-- .list-group-item-figure -->
                                <div class="list-group-item-figure">
                                    <a href="user-projects.html#" class="user-avatar"><img src="assets/images/avatars/uifaces12.jpg" alt="Ryan Jimenez"></a>
                                </div><!-- /.list-group-item-figure -->
                                <!-- .list-group-item-body -->
                                <div class="list-group-item-body">
                                    <h4 class="list-group-item-title">
                                        <a href="user-projects.html#">Ryan Jimenez</a>
                                    </h4>
                                    <p class="list-group-item-text"> Photographer </p>
                                </div><!-- /.list-group-item-body -->
                                <!-- .list-group-item-figure -->
                                <div class="list-group-item-figure dropdown">
                                    <button class="btn btn-sm btn-icon btn-light" data-toggle="dropdown"><i class="fa fa-fw fa-ellipsis-v"></i></button>
                                    <div class="dropdown-arrow dropdown-arrow-left"></div>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <button type="button" class="dropdown-item">Message</button> <button type="button" class="dropdown-item">Invite to a team</button> <button type="button" class="dropdown-item">Copy member ID</button>
                                        <div class="dropdown-divider"></div><button type="button" class="dropdown-item">Remove</button>
                                    </div>
                                </div><!-- /.list-group-item-figure -->
                            </div><!-- /.list-group-item -->
                            <!-- .list-group-item -->
                            <div class="list-group-item">
                                <!-- .list-group-item-figure -->
                                <div class="list-group-item-figure">
                                    <a href="user-projects.html#" class="user-avatar"><img src="assets/images/avatars/uifaces13.jpg" alt="Bryan Hayes"></a>
                                </div><!-- /.list-group-item-figure -->
                                <!-- .list-group-item-body -->
                                <div class="list-group-item-body">
                                    <h4 class="list-group-item-title">
                                        <a href="user-projects.html#">Bryan Hayes</a>
                                    </h4>
                                    <p class="list-group-item-text"> Computer Systems Analyst </p>
                                </div><!-- /.list-group-item-body -->
                                <!-- .list-group-item-figure -->
                                <div class="list-group-item-figure dropdown">
                                    <button class="btn btn-sm btn-icon btn-light" data-toggle="dropdown"><i class="fa fa-fw fa-ellipsis-v"></i></button>
                                    <div class="dropdown-arrow dropdown-arrow-left"></div>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <button type="button" class="dropdown-item">Message</button> <button type="button" class="dropdown-item">Invite to a team</button> <button type="button" class="dropdown-item">Copy member ID</button>
                                        <div class="dropdown-divider"></div><button type="button" class="dropdown-item">Remove</button>
                                    </div>
                                </div><!-- /.list-group-item-figure -->
                            </div><!-- /.list-group-item -->
                        </div><!-- /.list-group -->
                    </div><!-- /.modal-body -->
                    <!-- .modal-footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    </div><!-- /.modal-footer -->
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- /Modal Members List -->
    </div><!-- /.page-section -->
</div>
