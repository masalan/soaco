<div class="col-12 col-md-12 col-lg-12 col-xl-12 pl-lg-4">

    <div class="row">

        <div class="col-12 col-xl-6">
            <div class="card">
                <div class="alert alert-primary alert-outline alert-dismissible" role="alert">
                    <a href="<?php echo site_url('ensemble/'.url_encode($station->id));?>">
                    <div class="alert-icon">
                        <i class="far fa-fw fa-bell"></i>
                    </div>
                    </a>
                    <div class="alert-message">
                        <strong>Essence</strong> Quantité de vente
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatables-buttons" class="table table-striped" style="width:100%">
                        <thead>
                        <tr>
                            <th class="d-none d-xl-table-cell text-center">Quantité</th>
                            <th class="d-none d-xl-table-cell text-center">Montant</th>
                            <th class="d-none d-xl-table-cell text-center">Date</th>
                            <th class="d-none d-xl-table-cell text-center">Gerant</th>
                        </tr>
                        </thead>
                        <?php
                        if(isset($ess_logs) && count($ess_logs->result())>0):
                        foreach($ess_logs->result() as $sell):?>
                            <tbody>
                            <tr>
                                <td class="d-none d-xl-table-cell text-center"><?php echo $sell->quantity_out;?> Litres</td>
                                <td class="d-none d-xl-table-cell text-center"> <?php echo $this->db->get_where('cd_price' , array('type' =>$sell->type))->row()->prix * $sell->quantity_out;?> Fcfa</td>
                                <td class="d-none d-xl-table-cell text-center"><?php echo $sell->time_out;?></td>
                                <td class="d-none d-xl-table-cell text-center"><?php echo $this->db->get_where('be_users',array('user_id'=>$sell->user_id))->row()->fullname;?></td>
                            </tr>
                            </tbody>
                        <?php endforeach;else:?>
                            <tbody>
                            <td colspan='7'>
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <div class="alert-icon">
                                        <i class="far fa-fw fa-bell"></i>
                                    </div>
                                    <div class="alert-message">
                                        <strong>Bonjour Mr <?php echo html_entity_decode($user->fullname);?>!</strong> Aucune vente disponible effectuée!
                                    </div>
                                </div>
                            </td>
                            </tbody>
                        <?php endif; ?>
                    </table>

                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <?php $this->pagination->initialize($ess_page);echo $this->pagination->create_links(); ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>



        <div class="col-12 col-xl-6">
            <div class="card">
                <div class="alert alert-secondary alert-outline alert-dismissible" role="alert">
                    <a href="<?php echo site_url('ensemble/'.url_encode($station->id));?>">
                    <div class="alert-icon">
                        <i class="far fa-fw fa-bell"></i>
                    </div>
                    </a>
                    <div class="alert-message">
                        <strong>Gasoil</strong> Quantité de vente
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-striped DataTables " id="DataTables" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="d-none d-xl-table-cell text-center">Quantité</th>
                            <th class="d-none d-xl-table-cell text-center">Montant</th>
                            <th class="d-none d-xl-table-cell text-center">Date</th>
                            <th class="d-none d-xl-table-cell text-center">Gerant</th>
                        </tr>
                        </thead>
                        <?php
                        if(isset($gass_logs) && count($gass_logs->result())>0):
                            foreach($gass_logs->result() as $sell):?>
                                <tbody>
                                <tr>
                                    <td class="d-none d-xl-table-cell text-center"><?php echo $sell->quantity_out;?> Litres</td>
                                    <td class="d-none d-xl-table-cell text-center"> <?php echo $this->db->get_where('cd_price' , array('type' =>$sell->type))->row()->prix * $sell->quantity_out;?> Fcfa</td>
                                    <td class="d-none d-xl-table-cell text-center"><?php echo $sell->time_out;?></td>
                                    <td class="d-none d-xl-table-cell text-center"><?php echo $this->db->get_where('be_users',array('user_id'=>$sell->user_id))->row()->fullname;?></td>
                                </tr>
                                </tbody>
                            <?php endforeach;else:?>
                            <tbody>
                            <td colspan='7'>
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <div class="alert-icon">
                                        <i class="far fa-fw fa-bell"></i>
                                    </div>
                                    <div class="alert-message">
                                        <strong>Bonjour Mr <?php echo html_entity_decode($user->fullname);?>!</strong> Aucune vente disponible effectuée!
                                    </div>
                                </div>
                            </td>
                            </tbody>
                        <?php endif; ?>
                    </table>

                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <?php $this->pagination->initialize($gass_page);echo $this->pagination->create_links(); ?>
                        </ul

                        </nav>
                </div>
            </div>
        </div>




        <div class="col-12 col-xl-6">
            <div class="card">
                <div class="alert alert-success alert-outline alert-dismissible" role="alert">
                    <a href="<?php echo site_url('ensemble/'.url_encode($station->id));?>">
                    <div class="alert-icon">
                        <i class="far fa-fw fa-bell"></i>
                    </div>
                    </a>
                    <div class="alert-message">
                        <strong>Petrole</strong> Quantité de vente
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-striped DataTables " id="DataTables" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="d-none d-xl-table-cell text-center">Quantité</th>
                            <th class="d-none d-xl-table-cell text-center">Montant</th>
                            <th class="d-none d-xl-table-cell text-center">Date</th>
                            <th class="d-none d-xl-table-cell text-center">Gerant</th>
                        </tr>
                        </thead>
                        <?php
                        if(isset($pet_logs) && count($pet_logs->result())>0):
                            foreach($pet_logs->result() as $sell):?>
                                <tbody>
                                <tr>
                                    <td class="d-none d-xl-table-cell text-center"><?php echo $sell->quantity_out;?> Litres</td>
                                    <td class="d-none d-xl-table-cell text-center"> <?php echo $this->db->get_where('cd_price' , array('type' =>$sell->type))->row()->prix * $sell->quantity_out;?> Fcfa</td>
                                    <td class="d-none d-xl-table-cell text-center"><?php echo $sell->time_out;?></td>
                                    <td class="d-none d-xl-table-cell text-center"><?php echo $this->db->get_where('be_users',array('user_id'=>$sell->user_id))->row()->fullname;?></td>
                                </tr>
                                </tbody>
                            <?php endforeach;else:?>
                            <tbody>
                            <td colspan='7'>
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <div class="alert-icon">
                                        <i class="far fa-fw fa-bell"></i>
                                    </div>
                                    <div class="alert-message">
                                        <strong>Bonjour Mr <?php echo html_entity_decode($user->fullname);?>!</strong> Aucune vente disponible effectuée!
                                    </div>
                                </div>
                            </td>
                            </tbody>
                        <?php endif; ?>
                    </table>

                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <?php $this->pagination->initialize($pet_page);echo $this->pagination->create_links(); ?>
                        </ul
                    </nav>
                </div>
            </div>
        </div>




        <div class="col-12 col-xl-6">
            <div class="card">
                <div class="alert alert-danger alert-outline alert-dismissible" role="alert">
                    <a href="<?php echo site_url('ensemble/'.url_encode($station->id));?>">
                    <div class="alert-icon">
                        <i class="far fa-fw fa-bell"></i>
                    </div>
                    </a>
                    <div class="alert-message">
                        <strong>Bouteilles de Gaz sans consigne</strong> Quantité de vente
                    </div>
                </div>
                <div class="card-body">

                    <div class="tab">
                    <ul class="nav nav-pills mb-2" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="a-tab" data-toggle="pill" href="#pills-a" role="tab" aria-controls="pills-a" aria-selected="true">5 kg</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="b-tab" data-toggle="pill" href="#pills-b" role="tab" aria-controls="pills-b" aria-selected="false">6 Kg</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="c-tab" data-toggle="pill" href="#pills-c" role="tab" aria-controls="pills-c" aria-selected="false">12,5 Kg</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="d-tab" data-toggle="pill" href="#pills-d" role="tab" aria-controls="pills-d" aria-selected="false">52 Kg</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-a" role="tabpanel" aria-labelledby="a-tab">
                            <table id="datatables-gaz5x" class="table table-striped" style="width:100%">
                                <table id="datatables-buttons" class="table table-striped" style="width:100%">
                                <thead>
                                <tr>
                                    <th class="d-none d-xl-table-cell text-center">Quantité</th>
                                    <th class="d-none d-xl-table-cell text-center">Montant</th>
                                    <th class="d-none d-xl-table-cell text-center">Date</th>
                                    <th class="d-none d-xl-table-cell text-center">Gerant</th>
                                </tr>
                                </thead>
                                <?php
                              //  $query = $this->db->get_where('cd_fluid_log',array('type'=>65,'new_bottle'=>0));
                                $query = $this->db->get_where('cd_fluid_log',array('type'=>65,'new_bottle'=>0,'station_id'=>$station->id,'country_id'=>$this->session->userdata('country_id')));

                                if(isset($query) && count($query->result())>0):
                                    foreach($query->result() as $sell):?>
                                        <tbody>
                                        <tr>
                                            <td class="d-none d-xl-table-cell text-center"><?php echo $sell->quantity_out;?> Bt</td>
                                            <td class="d-none d-xl-table-cell text-center">
                                                <?php echo (($this->db->get_where('gaz_list' , array('type' =>65))->row()->pu * 5))*$sell->quantity_out+($sell->new_bottle * $sell->quantity_out);?>  Fcfa
                                            </td>
                                            <td class="d-none d-xl-table-cell text-center"><?php echo $sell->time_out;?></td>
                                            <td class="d-none d-xl-table-cell text-center"><?php echo $this->db->get_where('be_users',array('user_id'=>$sell->user_id))->row()->fullname;?></td>
                                        </tr>
                                        </tbody>
                                    <?php endforeach;else:?>
                                    <tbody>
                                    <td colspan='7'>
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <div class="alert-icon">
                                                <i class="far fa-fw fa-bell"></i>
                                            </div>
                                            <div class="alert-message">
                                                <strong>Bonjour Mr <?php echo html_entity_decode($user->fullname);?>!</strong> Aucune vente disponible effectuée!
                                            </div>
                                        </div>
                                    </td>
                                    </tbody>
                                <?php endif; ?>
                            </table></div>
                        <div class="tab-pane fade" id="pills-b" role="tabpanel" aria-labelledby="b-tab">
                            <table id="datatables-gaz6x" class="table table-striped" style="width:100%">
                                <thead>
                                <tr>
                                    <th class="d-none d-xl-table-cell text-center">Quantité</th>
                                    <th class="d-none d-xl-table-cell text-center">Montant</th>
                                    <th class="d-none d-xl-table-cell text-center">Date</th>
                                    <th class="d-none d-xl-table-cell text-center">Gerant</th>
                                </tr>
                                </thead>
                                <?php
                                $query = $this->db->get_where('cd_fluid_log',array('type'=>65,'new_bottle'=>0,'station_id'=>$station->id,'country_id'=>$this->session->userdata('country_id')));

                                if(isset($query) && count($query->result())>0):
                                    foreach($query->result() as $sell):?>
                                        <tbody>
                                        <tr>
                                            <td class="d-none d-xl-table-cell text-center"><?php echo $sell->quantity_out;?> Bt</td>
                                            <td class="d-none d-xl-table-cell text-center">
                                                <?php echo (($this->db->get_where('gaz_list' , array('type' =>66))->row()->pu * 5))*$sell->quantity_out+($sell->new_bottle * $sell->quantity_out);?>  Fcfa
                                            </td>
                                            <td class="d-none d-xl-table-cell text-center"><?php echo $sell->time_out;?></td>
                                            <td class="d-none d-xl-table-cell text-center"><?php echo $this->db->get_where('be_users',array('user_id'=>$sell->user_id))->row()->fullname;?></td>
                                        </tr>
                                        </tbody>
                                    <?php endforeach;else:?>
                                    <tbody>
                                    <td colspan='7'>
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <div class="alert-icon">
                                                <i class="far fa-fw fa-bell"></i>
                                            </div>
                                            <div class="alert-message">
                                                <strong>Bonjour Mr <?php echo html_entity_decode($user->fullname);?>!</strong> Aucune vente disponible effectuée!
                                            </div>
                                        </div>
                                    </td>
                                    </tbody>
                                <?php endif; ?>
                            </table></div>
                        <div class="tab-pane fade" id="pills-c" role="tabpanel" aria-labelledby="c-tab">
                            <table id="datatables-gaz12x" class="table table-striped" style="width:100%">
                                <thead>
                                <tr>
                                    <th class="d-none d-xl-table-cell text-center">Quantité</th>
                                    <th class="d-none d-xl-table-cell text-center">Montant</th>
                                    <th class="d-none d-xl-table-cell text-center">Date</th>
                                    <th class="d-none d-xl-table-cell text-center">Gerant</th>
                                </tr>
                                </thead>
                                <?php
                               // $query = $this->db->get_where('cd_fluid_log',array('type'=>612,'new_bottle'=>0));
                                $query = $this->db->get_where('cd_fluid_log',array('type'=>612,'new_bottle'=>0,'station_id'=>$station->id,'country_id'=>$this->session->userdata('country_id')));

                                if(isset($query) && count($query->result())>0):
                                    foreach($query->result() as $sell):?>
                                        <tbody>
                                        <tr>
                                            <td class="d-none d-xl-table-cell text-center"><?php echo $sell->quantity_out;?> Bt</td>
                                            <td class="d-none d-xl-table-cell text-center">
                                                <?php echo (($this->db->get_where('gaz_list' , array('type' =>612))->row()->pu * 5))*$sell->quantity_out+($sell->new_bottle * $sell->quantity_out);?>  Fcfa
                                            </td>
                                            <td class="d-none d-xl-table-cell text-center"><?php echo $sell->time_out;?></td>
                                            <td class="d-none d-xl-table-cell text-center"><?php echo $this->db->get_where('be_users',array('user_id'=>$sell->user_id))->row()->fullname;?></td>
                                        </tr>
                                        </tbody>
                                    <?php endforeach;else:?>
                                    <tbody>
                                    <td colspan='7'>
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <div class="alert-icon">
                                                <i class="far fa-fw fa-bell"></i>
                                            </div>
                                            <div class="alert-message">
                                                <strong>Bonjour Mr <?php echo html_entity_decode($user->fullname);?>!</strong> Aucune vente disponible effectuée!
                                            </div>
                                        </div>
                                    </td>
                                    </tbody>
                                <?php endif; ?>
                            </table></div>
                        <div class="tab-pane fade" id="pills-d" role="tabpanel" aria-labelledby="d-tab">
                            <table id="datatables-gaz52x" class="table table-striped" style="width:100%">
                                <thead>
                                <tr>
                                    <th class="d-none d-xl-table-cell text-center">Quantité</th>
                                    <th class="d-none d-xl-table-cell text-center">Montant</th>
                                    <th class="d-none d-xl-table-cell text-center">Date</th>
                                    <th class="d-none d-xl-table-cell text-center">Gerant</th>
                                </tr>
                                </thead>
                                <?php
                               // $query = $this->db->get_where('cd_fluid_log',array('type'=>652,'new_bottle'=>0));
                                $query = $this->db->get_where('cd_fluid_log',array('type'=>652,'new_bottle'=>0,'station_id'=>$station->id,'country_id'=>$this->session->userdata('country_id')));

                                if(isset($query) && count($query->result())>0):
                                    foreach($query->result() as $sell):?>
                                        <tbody>
                                        <tr>
                                            <td class="d-none d-xl-table-cell text-center"><?php echo $sell->quantity_out;?> Bt</td>
                                            <td class="d-none d-xl-table-cell text-center">
                                                <?php echo (($this->db->get_where('gaz_list' , array('type' =>652))->row()->pu * 5))*$sell->quantity_out+($sell->new_bottle * $sell->quantity_out);?>  Fcfa
                                            </td>
                                            <td class="d-none d-xl-table-cell text-center"><?php echo $sell->time_out;?></td>
                                            <td class="d-none d-xl-table-cell text-center"><?php echo $this->db->get_where('be_users',array('user_id'=>$sell->user_id))->row()->fullname;?></td>
                                        </tr>
                                        </tbody>
                                    <?php endforeach;else:?>
                                    <tbody>
                                    <td colspan='7'>
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <div class="alert-icon">
                                                <i class="far fa-fw fa-bell"></i>
                                            </div>
                                            <div class="alert-message">
                                                <strong>Bonjour Mr <?php echo html_entity_decode($user->fullname);?>!</strong> Aucune vente disponible effectuée!
                                            </div>
                                        </div>
                                    </td>
                                    </tbody>
                                <?php endif; ?>
                            </table></div>
                    </div>
                    </div>


                </div>
            </div>
        </div>







        <div class="col-12 col-xl-6">
            <div class="card">
                <div class="alert alert-warning alert-outline alert-dismissible" role="alert">
                    <a href="<?php echo site_url('ensemble/'.url_encode($station->id));?>">
                    <div class="alert-icon">
                        <i class="far fa-fw fa-bell"></i>
                    </div>
                    </a>
                    <div class="alert-message">
                        <strong>Bouteilles de Gaz avec consigne</strong> Quantité de vente
                    </div>
                </div>
                <div class="card-body">

                    <div class="tab">
                        <ul class="nav nav-pills mb-2" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="a5-tab" data-toggle="pill" href="#pills-a5" role="tab" aria-controls="pills-a5" aria-selected="true">5 kg</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="b5-tab" data-toggle="pill" href="#pills-b5" role="tab" aria-controls="pills-b5" aria-selected="false">6 Kg</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="c5-tab" data-toggle="pill" href="#pills-c5" role="tab" aria-controls="pills-c5" aria-selected="false">12,5 Kg</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="d5-tab" data-toggle="pill" href="#pills-d5" role="tab" aria-controls="pills-d5" aria-selected="false">52 Kg</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-a5" role="tabpanel" aria-labelledby="a5-tab">
                                <table id="datatables-gaz5x" class="table table-striped" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th class="d-none d-xl-table-cell text-center">Quantité</th>
                                        <th class="d-none d-xl-table-cell text-center">Montant</th>
                                        <th class="d-none d-xl-table-cell text-center">Date</th>
                                        <th class="d-none d-xl-table-cell text-center">Gerant</th>
                                    </tr>
                                    </thead>
                                    <?php
                                   // $query = $this->db->get_where('cd_fluid_log',array('type'=>65,'is_consign'=>1));
                                   // $query = $this->db->get_where('cd_fluid_log',array('type'=>65,'is_consign'=>1,'station_id'=>$station->id,'country_id'=>$this->session->userdata('country_id')));
                                    if(isset($sf_logs) && count($sf_logs->result())>0):
                                        foreach($sf_logs->result() as $sell):?>
                                            <tbody>
                                            <tr>
                                                <td class="d-none d-xl-table-cell text-center" style="font-size: 11px;">
                                                    <?php if($sell->new_bottle > 0):?>
                                                        <?php echo $sell->quantity_out;?> Bt
                                                    <?php else:?>
                                                    <?php endif;?>
                                                </td>
                                                <td class="d-none d-xl-table-cell text-center" style="font-size: 11px;">
                                                    <?php if($sell->new_bottle > 0):?>
                                                        <?php echo (($this->db->get_where('gaz_list' , array('type' =>65))->row()->pu * 5))*$sell->quantity_out+($sell->new_bottle * $sell->quantity_out);?>  Fcfa
                                                        <a  data-toggle="tooltip" data-placement="top" title="Prix Unitaire par Consignation: <?php echo $sell->new_bottle;?> Fcfa"><i class="ion ion-ios-information-circle mr-2"></i></a>

                                                    <?php else:?>
                                                    <?php endif;?>
                                                </td>
                                                <td class="d-none d-xl-table-cell text-center" style="font-size: 11px;">
                                                    <?php if($sell->new_bottle > 0):?>
                                                        <?php echo $sell->time_out;?>
                                                    <?php else:?>
                                                    <?php endif;?>
                                                    </td>
                                                <td class="d-none d-xl-table-cell text-center" style="font-size: 11px;">
                                                    <?php if($sell->new_bottle > 0):?>
                                                        <?php echo $this->db->get_where('be_users',array('user_id'=>$sell->user_id))->row()->fullname;?>
                                                    <?php else:?>
                                                    <?php endif;?>
                                                </td>
                                            </tr>
                                            </tbody>
                                        <?php endforeach;else:?>
                                        <tbody>
                                        <td colspan='7'>
                                            <div class="alert alert-danger alert-dismissible" role="alert">
                                                <div class="alert-icon">
                                                    <i class="far fa-fw fa-bell"></i>
                                                </div>
                                                <div class="alert-message">
                                                    <strong>Bonjour Mr <?php echo html_entity_decode($user->fullname);?>!</strong> Aucune vente disponible effectuée!
                                                </div>
                                            </div>
                                        </td>
                                        </tbody>
                                    <?php endif; ?>
                                </table>
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <?php $this->pagination->initialize($sf_page);echo $this->pagination->create_links(); ?>
                                    </ul
                                </nav>
                            </div>
                            <div class="tab-pane fade" id="pills-b5" role="tabpanel" aria-labelledby="b5-tab">
                                <table class="table table-striped DataTables " id="DataTables" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="d-none d-xl-table-cell text-center">Quantité</th>
                                        <th class="d-none d-xl-table-cell text-center">Montant</th>
                                        <th class="d-none d-xl-table-cell text-center">Date</th>
                                        <th class="d-none d-xl-table-cell text-center">Gerant</th>
                                    </tr>
                                    </thead>
                                    <?php
                                    if(isset($ss_logs) && count($ss_logs->result())>0):
                                        foreach($ss_logs->result() as $sell):?>
                                            <tbody>
                                            <tr>
                                                <td class="d-none d-xl-table-cell text-center" style="font-size: 11px;">
                                                    <?php if($sell->new_bottle > 0):?>
                                                        <?php echo $sell->quantity_out;?> Bt
                                                    <?php else:?>
                                                    <?php endif;?>
                                                </td>
                                                <td class="d-none d-xl-table-cell text-center" style="font-size: 11px;">
                                                    <?php if($sell->new_bottle > 0):?>
                                                        <?php echo (($this->db->get_where('gaz_list' , array('type' =>66))->row()->pu * 5))*$sell->quantity_out+($sell->new_bottle * $sell->quantity_out);?>  Fcfa
                                                        <a  data-toggle="tooltip" data-placement="top" title="Prix Unitaire par Consignation: <?php echo $sell->new_bottle;?> Fcfa"><i class="ion ion-ios-information-circle mr-2"></i></a>

                                                    <?php else:?>
                                                    <?php endif;?>
                                                </td>
                                                <td class="d-none d-xl-table-cell text-center" style="font-size: 11px;">
                                                    <?php if($sell->new_bottle > 0):?>
                                                        <?php echo $sell->time_out;?>
                                                    <?php else:?>
                                                    <?php endif;?>
                                                </td>
                                                <td class="d-none d-xl-table-cell text-center" style="font-size: 11px;">
                                                    <?php if($sell->new_bottle > 0):?>
                                                        <?php echo $this->db->get_where('be_users',array('user_id'=>$sell->user_id))->row()->fullname;?>
                                                    <?php else:?>
                                                    <?php endif;?>
                                                </td>
                                            </tr>
                                            </tbody>
                                        <?php endforeach;else:?>
                                        <tbody>
                                        <td colspan='7'>
                                            <div class="alert alert-danger alert-dismissible" role="alert">
                                                <div class="alert-icon">
                                                    <i class="far fa-fw fa-bell"></i>
                                                </div>
                                                <div class="alert-message">
                                                    <strong>Bonjour Mr <?php echo html_entity_decode($user->fullname);?>!</strong> Aucune vente disponible effectuée!
                                                </div>
                                            </div>
                                        </td>
                                        </tbody>
                                    <?php endif; ?>
                                </table>

                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <?php $this->pagination->initialize($ss_page);echo $this->pagination->create_links(); ?>
                                    </ul
                                </nav>

                            </div>
                            <div class="tab-pane fade" id="pills-c5" role="tabpanel" aria-labelledby="c5-tab">
                                <table id="datatables-gaz12x" class="table table-striped" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th class="d-none d-xl-table-cell text-center">Quantité</th>
                                        <th class="d-none d-xl-table-cell text-center">Montant</th>
                                        <th class="d-none d-xl-table-cell text-center">Date</th>
                                        <th class="d-none d-xl-table-cell text-center">Gerant</th>
                                    </tr>
                                    </thead>
                                    <?php
                                    if(isset($sot_logs) && count($sot_logs->result())>0):
                                        foreach($sot_logs->result() as $sell):?>
                                            <tbody>
                                            <tr>
                                                <td class="d-none d-xl-table-cell text-center" style="font-size: 11px;">
                                                    <?php if($sell->new_bottle > 0):?>
                                                        <?php echo $sell->quantity_out;?> Bt
                                                    <?php else:?>
                                                    <?php endif;?>
                                                </td>
                                                <td class="d-none d-xl-table-cell text-center" style="font-size: 11px;">
                                                    <?php if($sell->new_bottle > 0):?>
                                                        <?php echo (($this->db->get_where('gaz_list' , array('type' =>612))->row()->pu * 5))*$sell->quantity_out+($sell->new_bottle * $sell->quantity_out);?>  Fcfa
                                                        <a  data-toggle="tooltip" data-placement="top" title="Prix Unitaire par Consignation: <?php echo $sell->new_bottle;?> Fcfa"><i class="ion ion-ios-information-circle mr-2"></i></a>

                                                    <?php else:?>
                                                    <?php endif;?>
                                                </td>
                                                <td class="d-none d-xl-table-cell text-center" style="font-size: 11px;">
                                                    <?php if($sell->new_bottle > 0):?>
                                                        <?php echo $sell->time_out;?>
                                                    <?php else:?>
                                                    <?php endif;?>
                                                </td>
                                                <td class="d-none d-xl-table-cell text-center" style="font-size: 11px;">
                                                    <?php if($sell->new_bottle > 0):?>
                                                        <?php echo $this->db->get_where('be_users',array('user_id'=>$sell->user_id))->row()->fullname;?>
                                                    <?php else:?>
                                                    <?php endif;?>
                                                </td>
                                            </tr>
                                            </tbody>
                                        <?php endforeach;else:?>
                                        <tbody>
                                        <td colspan='7'>
                                            <div class="alert alert-danger alert-dismissible" role="alert">
                                                <div class="alert-icon">
                                                    <i class="far fa-fw fa-bell"></i>
                                                </div>
                                                <div class="alert-message">
                                                    <strong>Bonjour Mr <?php echo html_entity_decode($user->fullname);?>!</strong> Aucune vente disponible effectuée!
                                                </div>
                                            </div>
                                        </td>
                                        </tbody>
                                    <?php endif; ?>
                                </table>
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <?php $this->pagination->initialize($sot_page);echo $this->pagination->create_links(); ?>
                                    </ul
                                </nav>
                            </div>
                            <div class="tab-pane fade" id="pills-d5" role="tabpanel" aria-labelledby="d5-tab">
                                <table id="datatables-gaz52x" class="table table-striped" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th class="d-none d-xl-table-cell text-center">Quantité</th>
                                        <th class="d-none d-xl-table-cell text-center">Montant</th>
                                        <th class="d-none d-xl-table-cell text-center">Date</th>
                                        <th class="d-none d-xl-table-cell text-center">Gerant </th>
                                    </tr>
                                    </thead>
                                    <?php
                                    //$query = $this->db->get_where('cd_fluid_log',array('type'=>652,'is_consign'=>1));
                                  //  $query = $this->db->get_where('cd_fluid_log',array('type'=>652,'is_consign'=>1,'station_id'=>$station->id,'country_id'=>$this->session->userdata('country_id')));

                                    if(isset($sft_logs) && count($sft_logs->result())>0):
                                        foreach($sft_logs->result() as $sell):?>
                                            <tbody>
                                            <tr>
                                                <td class="d-none d-xl-table-cell text-center" style="font-size: 11px;">
                                                    <?php echo $sell->quantity_out;?> Bt
                                                </td>
                                                <td class="d-none d-xl-table-cell text-center" style="font-size: 11px;">
                                                    <?php echo (($this->db->get_where('gaz_list' , array('type' =>652))->row()->pu * 5))*$sell->quantity_out+($sell->new_bottle * $sell->quantity_out);?>  Fcfa
                                                    <a  data-toggle="tooltip" data-placement="top" title="Prix Unitaire par Consignation: <?php echo $sell->new_bottle;?> Fcfa"><i class="ion ion-ios-information-circle mr-2"></i></a>

                                                </td>
                                                <td class="d-none d-xl-table-cell text-center" style="font-size: 11px;">
                                                    <?php echo $sell->time_out;?>
                                                </td>
                                                <td class="d-none d-xl-table-cell text-center" style="font-size: 11px;">
                                                    <?php echo $this->db->get_where('be_users',array('user_id'=>$sell->user_id))->row()->fullname;?>
                                                </td>
                                            </tr>
                                            </tbody>
                                        <?php endforeach;else:?>
                                        <tbody>
                                        <td colspan='7'>
                                            <div class="alert alert-danger alert-dismissible" role="alert">
                                                <div class="alert-icon">
                                                    <i class="far fa-fw fa-bell"></i>
                                                </div>
                                                <div class="alert-message">
                                                    <strong>Bonjour Mr <?php echo html_entity_decode($user->fullname);?>!</strong> Aucune vente disponible effectuée!
                                                </div>
                                            </div>
                                        </td>
                                        </tbody>
                                    <?php endif; ?>
                                </table>
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <?php $this->pagination->initialize($sft_page);echo $this->pagination->create_links(); ?>
                                    </ul
                                </nav>
                            </div>

                        </div>
                    </div>




                </div>
            </div>
        </div>

    </div><!------End Row------>

</div>






<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        // Datatables basic
        $('#datatables-basic').DataTable({
            responsive: true
        });

        $('#datatables-gasoil').DataTable({
            responsive: true
        });

        $('#datatables-petrole').DataTable({
            responsive: true
        });

        $('#datatables-gaz5').DataTable({
            responsive: true
        });

        $('#datatables-gaz6').DataTable({
            responsive: true
        });

        $('#datatables-gaz12').DataTable({
            responsive: true
        });

        $('#datatables-gaz52').DataTable({
            responsive: true
        });


        $('#datatables-gaz5x').DataTable({
            ordering: true,
            responsive: true
        });

        $('#datatables-gaz6x').DataTable({
            ordering: true,
            responsive: true
        });

        $('#datatables-gaz12x').DataTable({
            ordering: true,
            responsive: true
        });

        $('#datatables-gaz52x').DataTable({
            columnDefs: [
                {
                    "targets": [ 2 ],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [ 3 ],
                    "visible": false
                }
            ],
            ordering: true,
            responsive: true

        });


        $('#datatables-gaz').DataTable({
            responsive: true
        });

        // Datatables with Buttons
        var datatablesButtons = $('#datatables-buttons').DataTable({
            lengthChange: !1,
            buttons: ["copy", "print"],
            responsive: true
        });
        datatablesButtons.buttons().container().appendTo("#datatables-buttons_wrapper .col-md-6:eq(0)")
    });
</script>