
    <div class="container">
        <div class="row">
            <!---side bar-->
            <div class="col-12 col-md-12 col-lg-12 col-xl-12 pl-lg-12"> <!-------- Containt  6c757d-------->
                <div class="row">
                    <!-----Essence----->
                        <?php if ($essence->quantity  <= ($this->db->get_where('cd_sell_permission',array('station_id'=>$station->id,'country_id'=>$station->country_id,'service_id'=>1))->row()->alert_limit)):?>
                    <div class="col-4 col-xl-2 d-flex" >
                    <div class="card flex-fill" style="background-color:red;">
                                <?php if (($this->db->get_where('cd_sell_permission',array('station_id'=>$station->id,'country_id'=>$station->country_id,'service_id'=>1))->row()->is_active) == 1):?>
                                <!----<a href="#" data-toggle="modal" data-target="#essence">--->
                                    <?php else:?>
                                    <a href="#" data-toggle="modal" data-target="#sti">
                                        <?php endif;?>

                                        <div class="card-body py-3">
                                            <div class="row">
                                                <div class="col-12 col-sm-12 align-self-center text-center text-sm-left">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-warning" role="progressbar" style="width:<?php echo $essence->quantity.'%';?> " aria-valuenow="<?php echo $kerosene->quantity;?>" aria-valuemin="0" aria-valuemax="100">R</div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-12 align-self-center text-center" style="color: white;">
                                                    En rupture de Stock d`Essence</p>
                                                    <h4 style="color: white; font-size: 15px;"> <?php echo $essence->quantity?:0;?> <small>L</small></h4>
                                                </div>
                                            </div>
                                </div></a>
                    </div></div>
                        <?php else:?>
                    <div class="col-4 col-xl-2 d-flex" >
                    <div class="card flex-fill" style="background-color:#41D492;">
                                <?php if (($this->db->get_where('cd_sell_permission',array('station_id'=>$station->id,'country_id'=>$station->country_id,'service_id'=>1))->row()->is_active) == 1):?>
                                <a href="#" data-toggle="modal" data-target="#essence" style="text-decoration: none;">
                                    <?php else:?>
                                    <a href="#" data-toggle="modal" data-target="#sti">
                                        <?php endif;?>

                                    <div class="card-body py-3">
                                        <div class="row">
                                            <div class="col-12 col-sm-4 align-self-center text-center text-sm-left" >
                                                <div class="spinner-border spinner-border-sm text-white mr-2" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-8 align-self-center text-center text-sm-right text-white" >
                                                <p class="text-white mb-1"><i class="align-middle mr-2 fas fa-fw fa-gas-pump text-white"></i>  Essence Vendu </p>
                                                <h5 style="color: white;"><?php echo $this->item->vente_par_jour(1,$station->id)->row()->quantity_out?:0;?> <small>L</small></h5>
                                            </div>

                                        </div>
                                    </div>
                                </a>
                            </div>
                    </div>
                        <?php endif;?>


                    <!-----Gasoil----->
                        <?php if ($gasoil->quantity  <= ($this->db->get_where('cd_sell_permission',array('station_id'=>$station->id,'country_id'=>$station->country_id,'service_id'=>2))->row()->alert_limit)):?>
                    <div class="col-4 col-xl-2 d-flex" >
                    <div class="card flex-fill" style="background-color:red;">
                                <?php if (($this->db->get_where('cd_sell_permission',array('station_id'=>$station->id,'country_id'=>$station->country_id,'service_id'=>2))->row()->is_active) == 1):?>
                                <!-----<a href="#" data-toggle="modal" data-target="#gasoil">--->
                                    <?php else:?>
                                    <a href="#" data-toggle="modal" data-target="#sti">
                                        <?php endif;?>

                                        <div class="card-body py-3">
                                            <div class="row">
                                                <div class="col-12 col-sm-12 align-self-center text-center text-sm-left">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-warning" role="progressbar" style="width:<?php echo $gasoil->quantity.'%';?> " aria-valuenow="<?php echo $kerosene->quantity;?>" aria-valuemin="0" aria-valuemax="100">R</div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-12 align-self-center text-center" style="color: white;">
                                                    En rupture de Stock de Gazoil</p>
                                                    <h4 style="color: white; font-size: 15px;"> <?php echo $gasoil->quantity?:0;?> <small>L</small></h4>
                                                </div>
                                            </div>
                                        </div></a>
                    </div></div>
                        <?php else:?>
                    <div class="col-4 col-xl-2 d-flex" >
                    <div class="card flex-fill" style="background-color:#5C59ED;">
                                <?php if (($this->db->get_where('cd_sell_permission',array('station_id'=>$station->id,'country_id'=>$station->country_id,'service_id'=>2))->row()->is_active) == 1):?>
                                <a href="#" data-toggle="modal" data-target="#gasoil">
                                    <?php else:?>
                                    <a href="#" data-toggle="modal" data-target="#sti">
                                        <?php endif;?>
                                    <div class="card-body py-3">
                                        <div class="row">
                                            <div class="col-12 col-sm-4 align-self-center text-center text-sm-left">
                                                <div class="spinner-border spinner-border-sm text-white mr-2" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-8 align-self-center text-center text-sm-right">
                                                <p class="text-white mb-1"><i class="align-middle mr-2 fas fa-fw fa-gas-pump text-white"></i>  Gazoil Vendu</p>
                                                <h5 style="color: white;"><?php echo $this->item->vente_par_jour(2,$station->id)->row()->quantity_out?:0;?> <small>L</small></h5>
                                            </div>
                                        </div>
                                    </div></a>
                    </div></div>

                        <?php endif;?>


                    <!-----Petrole----->
                        <?php if ($petrole->quantity  <= ($this->db->get_where('cd_sell_permission',array('station_id'=>$station->id,'country_id'=>$station->country_id,'service_id'=>5))->row()->alert_limit)):?>
                    <div class="col-4 col-xl-2 d-flex" >
                    <div class="card flex-fill" style="background-color:red;">
                                <?php if (($this->db->get_where('cd_sell_permission',array('station_id'=>$station->id,'country_id'=>$station->country_id,'service_id'=>5))->row()->is_active) == 1):?>
                               <!---- <a href="#" data-toggle="modal" data-target="#petrole">--->
                                    <?php else:?>
                                    <a href="#" data-toggle="modal" data-target="#sti">
                                        <?php endif;?>

                                        <div class="card-body py-3">
                                            <div class="row">
                                                <div class="col-12 col-sm-12 align-self-center text-center text-sm-left">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-warning" role="progressbar" style="width:<?php echo $petrole->quantity.'%';?> " aria-valuenow="<?php echo $kerosene->quantity;?>" aria-valuemin="0" aria-valuemax="100">R</div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-12 align-self-center text-center" style="color: white;">
                                                    En rupture de Stock de Pétrole</p>
                                                    <h4 style="color: white; font-size: 15px;"> <?php echo $petrole->quantity?:0;?> <small>L</small></h4>
                                                </div>
                                            </div>
                                        </div></a>
                    </div></div>
                        <?php else:?>
                    <div class="col-4 col-xl-2 d-flex" >
                    <div class="card flex-fill" style="background-color: black;">
                                <a href="#" data-toggle="modal" data-target="#petrole">
                                    <div class="card-body py-3">
                                        <div class="row">
                                            <div class="col-12 col-sm-4 align-self-center text-center text-sm-left">
                                                <div class="spinner-border spinner-border-sm text-white mr-2" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </div>

                                            <div class="col-12 col-sm-8 align-self-center text-center text-sm-right">
                                                <p class="text-white mb-1"><i class="align-middle mr-2 fas fa-fw fa-gas-pump text-white"></i>  Pétrole vendu</p>
                                                <h4 style="color: white;"><?php echo $this->item->vente_par_jour(5,$station->id)->row()->quantity_out?:0;?> <small>L</small></h4>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                    </div></div>
                        <?php endif;?>



                    <!------Gaz----->
                    <?php if ($this->db->get_where('cd_sell_permission',array('station_id'=>$station->id,'country_id'=>$station->country_id,'service_id'=>6))->row()->is_active == 0):?>
                    <div class="col-4 col-xl-2 d-flex" >
                        <div class="card flex-fill" style="background-color: #0b51c5;">
                            <a href="#" data-toggle="modal" data-target="#sti">  <!----Stop using------>
                            <div class="card-body py-3">
                                    <div class="row">
                                        <div class="col-12 col-sm-4 align-self-center text-center text-sm-left">
                                            <div class="spinner-border spinner-border-sm text-white mr-2" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-8 align-self-center text-center text-sm-right">
                                            <p class="text-white mb-1"><i class="align-middle mr-2 fas fa-fw fa-gas-pump text-white"></i> Gaz vendu</p>
                                            <h4 style="color: white;">
                                                <?php echo $this->item->vente_par_jour(63,$station->id)->row()->quantity_out?:0;?>/
                                                <?php echo $this->item->vente_par_jour(65,$station->id)->row()->quantity_out?:0;?>/
                                                <?php echo $this->item->vente_par_jour(66,$station->id)->row()->quantity_out?:0;?>/
                                                <?php echo $this->item->vente_par_jour(612,$station->id)->row()->quantity_out?:0;?>/
                                                <?php echo $this->item->vente_par_jour(652,$station->id)->row()->quantity_out?:0;?> <small>Bt.</small></h4>
                                        </div>
                                    </div>
                                </div></a>
                        </div>
                    </div>
                    <?php elseif($this->db->get_where('cd_sell_permission',array('station_id'=>$station->id,'country_id'=>$station->country_id,'service_id'=>6))->row()->is_active == 1):?>
                        <div class="col-4 col-xl-2 d-flex" >
                            <div class="card flex-fill" style="background-color: #0b51c5;">
                                <a href="#" data-toggle="modal" data-target="#gaz"> <!----actif using------>
                                <div class="card-body py-3">
                                        <div class="row">
                                            <div class="col-12 col-sm-4 align-self-center text-center text-sm-left">
                                                <div class="spinner-border spinner-border-sm text-white mr-2" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </div>

                                            <div class="col-12 col-sm-8 align-self-center text-center text-sm-right">
                                                <p class="text-white mb-1"><i class="align-middle mr-2 fas fa-fw fa-gas-pump text-white"></i>Gaz vendu</p>
                                                <h4 style="color: white;">
                                                    <?php echo $this->item->vente_par_jour(63,$station->id)->row()->quantity_out?:0;?>/
                                                    <?php echo $this->item->vente_par_jour(65,$station->id)->row()->quantity_out?:0;?>/
                                                    <?php echo $this->item->vente_par_jour(66,$station->id)->row()->quantity_out?:0;?>/
                                                    <?php echo $this->item->vente_par_jour(612,$station->id)->row()->quantity_out?:0;?>/
                                                    <?php echo $this->item->vente_par_jour(652,$station->id)->row()->quantity_out?:0;?> <small>Bt.</small></h4>
                                            </div>
                                        </div>
                                    </div></a>
                            </div>
                        </div>
                    <?php elseif($this->db->get_where('cd_sell_permission',array('station_id'=>$station->id,'country_id'=>$station->country_id,'service_id'=>6))->row()->is_active == 2):?>
                    <!---- Hidden----->
                    <?php endif;?>

                    <!----Kerosene------>
                      <?php if ($kerosene->quantity  <= ($this->db->get_where('cd_sell_permission',array('station_id'=>$station->id,'country_id'=>$station->country_id,'service_id'=>3))->row()->alert_limit)):?>
                      <div class="col-4 col-xl-2 d-flex">
                        <div class="card flex-fill" style="background-color:red;">
                            <?php if (($this->db->get_where('cd_sell_permission',array('station_id'=>$station->id,'country_id'=>$station->country_id,'service_id'=>3))->row()->is_active) == 1):?>
                           <!----- <a href="#" data-toggle="modal" data-target="#kerosene">--->
                                <?php else:?>
                                <a href="#" data-toggle="modal" data-target="#sti">
                                    <?php endif;?>
                            <div class="card-body py-3">
                                        <div class="row">
                                            <div class="col-12 col-sm-12 align-self-center text-center text-sm-left">
                                                <div class="progress">
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width:<?php echo $kerosene->quantity.'%';?> " aria-valuenow="<?php echo $kerosene->quantity;?>" aria-valuemin="0" aria-valuemax="100">R</div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 align-self-center text-center" style="color: white;">
                                                En rupture de Stock de  kérosène</p>
                                                <h4 style="color: white; font-size: 15px;"> <?php echo $kerosene->quantity?:0;?> <small>L</small></h4>
                                            </div>
                                        </div>
                                    </div></a>
                        </div></div>
                      <?php elseif($this->db->get_where('cd_sell_permission',array('station_id'=>$station->id,'country_id'=>$station->country_id,'service_id'=>3))->row()->is_active == 1):?>
                    <div class="col-4 col-xl-2 d-flex">
                            <div class="card flex-fill" style="background-color: #FA6A4B;">
                                <a href="#" data-toggle="modal" data-target="#kerosene"> <!-----Active using---->
                                <div class="card-body py-3">
                                        <div class="row">
                                            <div class="col-12 col-sm-4 align-self-center text-center text-sm-left">
                                                <div class="spinner-border spinner-border-sm text-white mr-2" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-8 align-self-center text-center text-sm-right">
                                                <p class="text-white mb-1"><i class="align-middle mr-2 fas fa-fw fa-gas-pump text-white"></i> kérosène vendu</p>
                                                <h4 style="color: white;"><?php echo $this->item->vente_par_jour(3,$station->id)->row()->quantity_out?:0;?> <small>L</small></h4>
                                            </div>
                                        </div>
                                    </div></a>
                            </div></div>

                      <?php elseif($this->db->get_where('cd_sell_permission',array('station_id'=>$station->id,'country_id'=>$station->country_id,'service_id'=>3))->row()->is_active == 0):?>
                          <div class="col-4 col-xl-2 d-flex">
                              <div class="card flex-fill" style="background-color: #FA6A4B;">
                                  <a href="#" data-toggle="modal" data-target="#sti"> <!-----Stop using--->
                                      <div class="card-body py-3">
                                          <div class="row">
                                              <div class="col-12 col-sm-4 align-self-center text-center text-sm-left">
                                                  <div class="spinner-border spinner-border-sm text-white mr-2" role="status">
                                                      <span class="sr-only">Loading...</span>
                                                  </div>
                                              </div>
                                              <div class="col-12 col-sm-8 align-self-center text-center text-sm-right">
                                                  <p class="text-white mb-1"><i class="align-middle mr-2 fas fa-fw fa-gas-pump text-white"></i> kérosène vendu</p>
                                                  <h4 style="color: white;"><?php echo $this->item->vente_par_jour(3,$station->id)->row()->quantity_out?:0;?> <small>L</small></h4>
                                              </div>
                                          </div>
                                      </div></a>
                              </div></div>
                      <?php elseif($this->db->get_where('cd_sell_permission',array('station_id'=>$station->id,'country_id'=>$station->country_id,'service_id'=>3))->row()->is_active == 2):?>

                          <!---- Hidden----->
                      <?php endif;?>


                    <!---Oil---->
                    <?php if($this->db->get_where('cd_sell_permission',array('station_id'=>$station->id,'country_id'=>$station->country_id,'service_id'=>4))->row()->is_active == 1):?>
                        <div class="col-4 col-xl-2 d-flex" >
                            <div class="card flex-fill" style="background-color:#ffaa00;">
                                <a href="#" data-toggle="modal" data-target="#huile"> <!------Actif using-------->

                                    <div class="card-body py-3">
                                        <div class="row">
                                            <div class="col-12 col-sm-4 align-self-center text-center text-sm-left">
                                                <div class="spinner-border spinner-border-sm text-white mr-2" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-8 align-self-center text-center text-sm-right">
                                                <p class="text-white mb-1"><i class="align-middle mr-2 fas fa-fw fa-gas-pump text-white"></i>  Lubrifiant Vendu</p>
                                                <h4 style="color: white;"><?php echo $this->item->vente_par_jour(4,$stations->station_id)->row()->quantity_out?:0;?> <small>L</small></h4></div>
                                        </div>
                                    </div></a>
                            </div>
                        </div>

                    <?php elseif($this->db->get_where('cd_sell_permission',array('station_id'=>$station->id,'country_id'=>$station->country_id,'service_id'=>4))->row()->is_active == 0):?>
                        <div class="col-4 col-xl-2 d-flex" >
                            <div class="card flex-fill" style="background-color:#ffaa00;">
                                <a href="#" data-toggle="modal" data-target="#sti"> <!-----Stop using--->
                                    <div class="card-body py-3">
                                        <div class="row">
                                            <div class="col-12 col-sm-4 align-self-center text-center text-sm-left">
                                                <div class="spinner-border spinner-border-sm text-white mr-2" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-8 align-self-center text-center text-sm-right">
                                                <p class="text-white mb-1"><i class="align-middle mr-2 fas fa-fw fa-gas-pump text-white"></i>  Lubrifiant Vendu</p>
                                                <h4 style="color: white;"><?php echo $this->item->vente_par_jour(4,$stations->station_id)->row()->quantity_out?:0;?> <small>L</small></h4></div>
                                        </div>
                                    </div></a>
                            </div>
                        </div>
                    <?php elseif($this->db->get_where('cd_sell_permission',array('station_id'=>$station->id,'country_id'=>$station->country_id,'service_id'=>4))->row()->is_active == 2):?>

                        <!---- Hidden----->
                    <?php endif;?>




                </div> <!------END Services------->



                <div class="row">


                    <div class="col-12 col-lg-12 d-flex"><!-------Historic-------->
                        <div class="card flex-fill">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Historique de vente recente</h5>
                            </div>
                            <div class="card-body">
                              <table class="table table-striped DataTables " id="DataTables" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>ID </th>
                                        <th>Produits </th>
                                        <th class="d-none d-xl-table-cell text-center">P.U.</th>
                                        <th class="d-none d-xl-table-cell text-center">Stock initial</th>
                                        <th class="d-none d-xl-table-cell text-center">Quantité </th>
                                        <th class="d-none d-xl-table-cell text-center">Stock restant</th>
                                        <th class="d-none d-xl-table-cell text-center">Montant</th>
                                        <th class="d-none d-xl-table-cell text-center">Date</th>
                                        <th class="d-none d-xl-table-cell text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <?php
                                    if(!$count=$this->uri->segment(3))
                                        $count = 0;
                                    if(isset($selling) && count($selling->result())>0):

                                        foreach($selling->result() as $sell):
                                            $price = $this->db->get_where('cd_fluid' , array('type' =>$sell->type))->row()->prix;
                                            $nom = $this->db->get_where('cd_fluid' , array('type' =>$sell->type))->row()->name; ?>

                                            <tbody class="red">
                                            <td><?php echo ++$count;?></td>

                                            <td  class="d-none d-xl-table-cell text-center">
                                                <?php if ($sell->type == 1):?>
                                                    <span class="badge badge-primary"><?php echo $this->db->get_where('cd_fluid_log' , array('type' =>$sell->type))->row()->name; ?></span>
                                                <?php elseif($sell->type == 2):?>
                                                    <span class="badge badge-info"><?php echo $this->db->get_where('cd_fluid_log' , array('type' =>$sell->type))->row()->name; ?></span>
                                                <?php elseif($sell->type == 3):?>
                                                    <span class="badge badge-danger"><?php echo $this->db->get_where('cd_fluid_log' , array('type' =>$sell->type))->row()->name; ?></span>
                                                <?php elseif($sell->type == 4):?>
                                                    <span class="badge badge-warning"><?php echo $this->db->get_where('cd_fluid_log' , array('type' =>$sell->type))->row()->name; ?></span>
                                                <?php elseif($sell->type == 5):?>
                                                    <span class="badge badge-secondary"><?php echo $this->db->get_where('cd_fluid_log' , array('type' =>$sell->type))->row()->name; ?></span>
                                                <?php elseif($sell->type == 63):?>
                                                    <span class="badge badge-info"> <?php echo $this->db->get_where('gaz_list', array('type' =>$sell->type))->row()->name; ?></span>
                                                <?php elseif($sell->type == 65):?>
                                                    <span class="badge badge-info"> <?php echo $this->db->get_where('gaz_list', array('type' =>$sell->type))->row()->name; ?></span>
                                                <?php elseif($sell->type == 66):?>
                                                    <span class="badge badge-info">  <?php echo $this->db->get_where('gaz_list', array('type' =>$sell->type))->row()->name; ?></span>
                                                <?php elseif($sell->type == 612):?>
                                                    <span class="badge badge-info">  <?php echo $this->db->get_where('gaz_list', array('type' =>$sell->type))->row()->name; ?></span>
                                                <?php elseif($sell->type == 652):?>
                                                    <span class="badge badge-info">  <?php echo $this->db->get_where('gaz_list', array('type' =>$sell->type))->row()->name; ?></span>
                                                <?php endif;?>
                                            </td>

                                            <!------PU----->
                                            <td class="d-none d-xl-table-cell text-center">
                                                <?php if ($sell->type    == 1):?>
                                                <?php echo $this->db->get_where('cd_price', array('type' =>$sell->type))->row()->prix; ?> Fcfa/Litre
                                                <?php elseif($sell->type == 2):?>
                                                <?php echo $this->db->get_where('cd_price', array('type' =>$sell->type))->row()->prix; ?> Fcfa/Litre
                                                <?php elseif($sell->type == 3):?>
                                                <?php echo $this->db->get_where('cd_price', array('type' =>$sell->type))->row()->prix; ?> Fcfa/Litre
                                                <?php elseif($sell->type == 4):?>
                                                <?php echo $this->db->get_where('cd_price', array('type' =>$sell->type))->row()->prix; ?> Fcfa/Litre
                                                <?php elseif($sell->type == 5):?>
                                                <?php echo $this->db->get_where('cd_price', array('type' =>$sell->type))->row()->prix; ?> Fcfa/Litre
                                                <?php elseif($sell->type == 63):?>
                                                    <?php echo $this->db->get_where('gaz_list', array('type' =>$sell->type,'is_active'=>1))->row()->pu; ?> Fcfa/Kg
                                                <?php elseif($sell->type == 65):?>
                                                    <?php echo $this->db->get_where('gaz_list', array('type' =>$sell->type,'is_active'=>1))->row()->pu; ?> Fcfa/Kg
                                                <?php elseif($sell->type == 66):?>
                                                    <?php echo $this->db->get_where('gaz_list', array('type' =>$sell->type,'is_active'=>1))->row()->pu; ?> Fcfa/Kg
                                                <?php elseif($sell->type == 612):?>
                                                    <?php echo $this->db->get_where('gaz_list', array('type' =>$sell->type,'is_active'=>1))->row()->pu; ?> Fcfa/Kg
                                                <?php elseif($sell->type == 652):?>
                                                    <?php echo $this->db->get_where('gaz_list', array('type' =>$sell->type,'is_active'=>1))->row()->pu; ?> Fcfa/Kg
                                                <?php endif;?>
                                            </td>

                                            <!------Stock Initial----->
                                            <td  class="d-none d-xl-table-cell text-center">
                                                <?php if ($sell->type    == 1):?>
                                                    <?php echo $sell->initial_stock;?> Litres
                                                <?php elseif($sell->type == 2):?>
                                                    <?php echo $sell->initial_stock;?> Litres
                                                <?php elseif($sell->type == 3):?>
                                                    <?php echo $sell->initial_stock;?> Litres
                                                <?php elseif($sell->type == 4):?>
                                                    <?php echo $sell->initial_stock;?> Litres
                                                <?php elseif($sell->type == 5):?>
                                                    <?php echo $sell->initial_stock;?> Litres
                                                <?php elseif($sell->type == 63):?>
                                                    <?php echo $sell->initial_stock;?> Bt
                                                <?php elseif($sell->type == 65):?>
                                                    <?php echo $sell->initial_stock;?> Bt
                                                <?php elseif($sell->type == 66):?>
                                                    <?php echo $sell->initial_stock;?> Bt
                                                <?php elseif($sell->type == 612):?>
                                                    <?php echo $sell->initial_stock;?> Bt
                                                <?php else:?>
                                                    <?php echo $sell->initial_stock;?> Bt
                                                <?php endif;?>
                                            </td>

                                            <!------Quantite----->
                                            <td class="d-none d-xl-table-cell text-center">
                                                <?php if ($sell->type    == 1):?>
                                                    <?php echo $sell->quantity_out;?> Litres
                                                <?php elseif($sell->type == 2):?>
                                                    <?php echo $sell->quantity_out;?> Litres
                                                <?php elseif($sell->type == 3):?>
                                                    <?php echo $sell->quantity_out;?> Litres
                                                <?php elseif($sell->type == 4):?>
                                                    <?php echo $sell->quantity_out;?> Litres
                                                <?php elseif($sell->type == 5):?>
                                                    <?php echo $sell->quantity_out;?> Litres
                                                <?php elseif($sell->type == 63):?>
                                                    <?php echo $sell->quantity_out;?> Bt
                                                    <?php if($sell->new_bottle > 0):?>
                                                        <a class="btn btn-warning"  data-toggle="tooltip" data-placement="top" title="Prix Unitaire par Consignation: <?php echo $sell->new_bottle;?> Fcfa">C.</a>
                                                    <?php else:?>
                                                    <?php endif;?>
                                                <?php elseif($sell->type == 65):?>
                                                    <?php echo $sell->quantity_out;?> Bt
                                                    <?php if($sell->new_bottle > 0):?>
                                                        <a class="btn btn-warning"  data-toggle="tooltip" data-placement="top" title="Prix Unitaire par Consignation: <?php echo $sell->new_bottle;?> Fcfa">C.</a>
                                                    <?php else:?>
                                                    <?php endif;?>
                                                <?php elseif($sell->type == 66):?>
                                                    <?php echo $sell->quantity_out;?> Bt
                                                    <?php if($sell->new_bottle > 0):?>
                                                        <a class="btn btn-warning"  data-toggle="tooltip" data-placement="top" title="Prix Unitaire par Consignation: <?php echo $sell->new_bottle;?> Fcfa">C.</a>
                                                    <?php else:?>
                                                    <?php endif;?>

                                                <?php elseif($sell->type == 612):?>
                                                    <?php echo $sell->quantity_out;?> Bt
                                                    <?php if($sell->new_bottle > 0):?>
                                                        <a class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Prix Unitaire par Consignation: <?php echo $sell->new_bottle;?> Fcfa">C.</a>
                                                    <?php else:?>
                                                    <?php endif;?>
                                                <?php else:?>
                                                    <?php echo $sell->quantity_out;?> Bt
                                                    <?php if($sell->new_bottle > 0):?>
                                                        <a class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Prix Unitaire par Consignation: <?php echo $sell->new_bottle;?> Fcfa">C.</a>
                                                    <?php else:?>
                                                    <?php endif;?>
                                                <?php endif;?>
                                            </td>

                                            <!------Stock Restante----->
                                            <td  class="d-none d-xl-table-cell text-center" >
                                                <?php if ($sell->type    == 1):?>
                                                <?php if ($sell->stock_restant ==0):?>
  <button class="btn mb-1 btn-danger" type="button" title="Rupture de Stock" data-container="body" data-toggle="popover" data-placement="top" data-content="Le tank du réservoir d’essence est à zéro litres maintenant. Veillez le ravitailler.
Merci">Besoin de ravitaillement</button> <?php else:?>
                                                        <?php echo $sell->stock_restant;?> Litres
                                                    <?php endif;?>

                                                <?php elseif($sell->type == 2):?>
                                                    <?php if ($sell->stock_restant ==0):?>
                                                        <button class="btn mb-1 btn-danger" type="button" title="Rupture de Stock" data-container="body" data-toggle="popover" data-placement="top" data-content="Le tank du réservoir de Gasoil est à zéro litres maintenant. Veillez le ravitailler.
Merci">Besoin de ravitaillement</button> <?php else:?>
                                                        <?php echo $sell->stock_restant;?> Litres
                                                    <?php endif;?>
                                                <?php elseif($sell->type == 3):?>
                                                    <?php echo $sell->stock_restant;?> Litres
                                                <?php elseif($sell->type == 4):?>
                                                    <?php echo $sell->stock_restant;?> Litres
                                                <?php elseif($sell->type == 5):?>


                                                    <?php if ($sell->stock_restant ==0):?>
                                                        <button class="btn mb-1 btn-danger" type="button" title="Rupture de Stock" data-container="body" data-toggle="popover" data-placement="top" data-content="Le tank du réservoir de Pétrole est à zéro litres maintenant. Veillez le ravitailler.
Merci">Besoin de ravitaillement</button> <?php else:?>
                                                        <?php echo $sell->stock_restant;?> Litres
                                                    <?php endif;?>

                                                <?php elseif($sell->type == 63):?>
                                                    <?php echo $sell->stock_restant;?> Bt
                                                <?php elseif($sell->type == 65):?>
                                                    <?php echo $sell->stock_restant;?> Bt
                                                <?php elseif($sell->type == 66):?>
                                                    <?php echo $sell->stock_restant;?> Bt
                                                <?php elseif($sell->type == 612):?>
                                                    <?php echo $sell->stock_restant;?> Bt
                                                <?php elseif($sell->type == 652):?>
                                                    <?php echo $sell->stock_restant;?> Bt
                                                <?php else:?>
                                                    <?php echo $sell->stock_restant;?> Bt
                                                <?php endif;?>
                                            </td>


                                            <td class="d-none d-xl-table-cell text-center">
                                                <?php if ($sell->type    == 1):?>
                                                    <?php echo $this->db->get_where('cd_price' , array('type' =>$sell->type))->row()->prix * $sell->quantity_out;?> Fcfa
                                                <?php elseif($sell->type == 2):?>
                                                    <?php echo $this->db->get_where('cd_price' , array('type' =>$sell->type))->row()->prix * $sell->quantity_out;?> Fcfa
                                                <?php elseif($sell->type == 3):?>
                                                    <?php echo $this->db->get_where('cd_price' , array('type' =>$sell->type))->row()->prix * $sell->quantity_out;?> Fcfa
                                                <?php elseif($sell->type == 4):?>
                                                    <?php echo $this->db->get_where('cd_price' , array('type' =>$sell->type))->row()->prix * $sell->quantity_out;?> Fcfa
                                                <?php elseif($sell->type == 5):?>
                                                    <?php echo $this->db->get_where('cd_price' , array('type' =>$sell->type))->row()->prix * $sell->quantity_out;?> Fcfa
                                                <?php elseif($sell->type == 63):?>
                                                    <?php echo (($this->db->get_where('gaz_list' , array('type' =>$sell->type,'is_active'=>1))->row()->pu * 5))*$sell->quantity_out+($sell->new_bottle * $sell->quantity_out);?>  Fcfa
                                                <?php elseif($sell->type == 65):?>
                                                    <?php echo (($this->db->get_where('gaz_list' , array('type' =>$sell->type,'is_active'=>1))->row()->pu * 5))*$sell->quantity_out+($sell->new_bottle * $sell->quantity_out);?>  Fcfa
                                                <?php elseif($sell->type == 66):?>
                                                    <?php echo (($this->db->get_where('gaz_list' , array('type' =>$sell->type,'is_active'=>1))->row()->pu * 6))*$sell->quantity_out+($sell->new_bottle * $sell->quantity_out);?>  Fcfa
                                                <?php elseif($sell->type == 612):?>
                                                    <?php echo (($this->db->get_where('gaz_list' , array('type' =>$sell->type,'is_active'=>1))->row()->pu * 12.5))*$sell->quantity_out+($sell->new_bottle * $sell->quantity_out);?>  Fcfa
                                                <?php elseif($sell->type == 652):?>
                                                    <?php echo (($this->db->get_where('gaz_list' , array('type' =>$sell->type,'is_active'=>1))->row()->pu * 52))*$sell->quantity_out+($sell->new_bottle * $sell->quantity_out);?>  Fcfa
                                                <?php endif;?></td>
                                            <td class="d-none d-xl-table-cell text-center"> <a  data-toggle="tooltip" data-placement="top" title="<?php echo ($sell->time_out);?>"><?php echo time_ago($sell->time_out);?></a></td>

                                            <?php if ($sell->status == 1):?>
                                              <td class="d-none d-xl-table-cell text-center"><a class="text-dark" href="#" data-toggle="modal" data-target="#facture"><i class="align-middle mr-2" data-feather="printer"></i> <span class="align-middle">Facture</span></a></td>
                                          <?php else:?>
                                            <td class="d-none d-xl-table-cell text-center" ><button class="btn mb-1 btn-danger" type="button" title="Rupture de Stock" data-container="body" data-toggle="popover" data-placement="top" data-content="Cette vente n`a pas été validé car pas de stock disponible.
Veillez faire un ravitaillement.">Non validé</button></td>
                                          <?php endif;?>
                                            </tbody>
                                        <?php
                                        endforeach;
                                    else:
                                        ?>
                                        <tbody>
                                        <td colspan='7'>
                                            <div class="alert alert-danger alert-dismissible" role="alert">
                                                <div class="alert-icon"><i class="far fa-fw fa-bell"></i></div>
                                                <div class="alert-message col-sm-12">
                                                    <strong>Bonjour Mr <?php echo html_entity_decode($user->fullname);?>!</strong> Aucune vente encore effectuée  aujourd`hui !
                                                </div>
                                            </div>
                                        </td>
                                        </tbody>
                                    <?php endif; ?>
                                </table>
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <?php $this->pagination->initialize($pags);echo $this->pagination->create_links(); ?>
                                    </ul>
                                </nav>

                            </div>





                            <script>
                                document.addEventListener("DOMContentLoaded", function(event) {
                                    // Datatables basic
                                    $('#datatables-basic').DataTable({
                                        responsive: true
                                        "pagingType": "simple" // "simple" option for 'Previous' and 'Next' buttons only
                                    });
                                    // Datatables with Buttons
                                    var datatablesButtons = $('#datatables-buttons').DataTable({
                                        lengthChange: !1,
                                        pageLength: 6,
                                        buttons: ["copy", "print"],
                                        responsive: true
                                    });
                                    datatablesButtons.buttons().container().appendTo("#datatables-buttons_wrapper .col-md-6:eq(0)")


                                    // Datatables with Buttons
                                    var datatablesButtons = $('#datatables-but').DataTable({
                                        lengthChange: !1,
                                        pageLength: 6,
                                        buttons: ["copy", "print"],
                                        responsive: true
                                    });

                                });
                            </script>
                        </div>
                    </div><!-------Historic end-------->
                </div>


                <div class="row">
                    <div class="col-12 col-xl-12 d-flex">
                        <div class="card flex-fill w-100">

                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Ravitaillements Recents</h5>
                                </div>
                                <div class="card-body">
                                    <table id="datatables-buttons" class="table table-striped" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th class="d-none d-xl-table-cell text-center">Produit</th>
                                            <th class="d-none d-xl-table-cell text-center">Stock initial</th>
                                            <th class="d-none d-xl-table-cell text-center">Quantité</th>

                                            <th class="d-none d-xl-table-cell text-center">Stock actuel</th>
                                            <th class="d-none d-xl-table-cell text-center">Date</th>
                                            <th class="d-none d-xl-table-cell text-center">Fournisseur</th>
                                            <th class="d-none d-xl-table-cell text-center">Voiture</th>
                                            <th class="d-none d-xl-table-cell text-center">Chauffeur</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if(!$count=$this->uri->segment(3))
                                        $count = 0;
                                        if(isset($ravit_logs) && count($ravit_logs->result())>0):
                                        foreach($ravit_logs->result() as $logs):?>
                                        <tr>
                                            <td  class="d-none d-xl-table-cell text-center">
                                                <?php if ($logs->type == 1):?>
                                                    <span class="badge badge-primary">Essence</span>
                                                <?php elseif($logs->type == 2):?>
                                                    <span class="badge badge-info">Gasoil</span>
                                                <?php elseif($logs->type == 3):?>
                                                    <span class="badge badge-danger">Kérosène</span>
                                                <?php elseif($logs->type == 4):?>
                                                    <span class="badge badge-warning">Huile</span>
                                                <?php elseif($logs->type == 5):?>
                                                    <span class="badge badge-secondary">Petrole</span>
                                                <?php elseif($logs->type == 63):?>
                                                    <span class="badge badge-info"> <?php echo $this->db->get_where('gaz_list', array('type' =>$logs->type))->row()->name; ?></span>
                                                <?php elseif($logs->type == 65):?>
                                                    <span class="badge badge-info"> <?php echo $this->db->get_where('gaz_list', array('type' =>$logs->type))->row()->name; ?></span>
                                                <?php elseif($logs->type == 66):?>
                                                    <span class="badge badge-info"> <?php echo $this->db->get_where('gaz_list', array('type' =>$logs->type))->row()->name; ?></span>
                                                <?php elseif($logs->type == 612):?>
                                                    <span class="badge badge-info"> <?php echo $this->db->get_where('gaz_list', array('type' =>$logs->type))->row()->name; ?></span>
                                                    <?php elseif($logs->type == 652):?>
                                                    <span class="badge badge-info"> <?php echo $this->db->get_where('gaz_list', array('type' =>$logs->type))->row()->name; ?></span>
                                                    <?php else:?>
                                                    <span class="badge badge-info"> <?php echo $logs->name;?></span>
                                                <?php endif;?> </td>


                                            <!---------Stock initial---------->
                                            <td  class="d-none d-xl-table-cell text-center">
                                                <?php if ($logs->type    == 1):?>
                                                <span class="badge badge-primary"> <?php echo $logs->stock_initial;?> Litres</span>
                                                <?php elseif($logs->type == 2):?>
                                                    <span class="badge badge-primary">  <?php echo $logs->stock_initial;?> Litres</span>
                                                <?php elseif($logs->type == 3):?>
                                                   <span class="badge badge-primary"> <?php echo $logs->stock_initial;?> Litres</span>
                                                <?php elseif($logs->type == 4):?>
                                                    <span class="badge badge-primary"> <?php echo $logs->stock_initial;?> Litres</span>
                                                <?php elseif($logs->type == 5):?>
                                                    <span class="badge badge-primary"> <?php echo $logs->stock_initial;?> Litres</span>
                                                <?php elseif($logs->type == 63):?>
                                                    <span class="badge badge-primary"> <?php echo $logs->stock_initial;?> Bt</span>
                                                <?php elseif($logs->type == 65):?>
                                                       <span class="badge badge-primary"> <?php echo $logs->stock_initial;?> Bt</span>
                                                <?php elseif($logs->type == 66):?>
                                                      <span class="badge badge-primary"> <?php echo $logs->stock_initial;?> Bt</span>
                                                <?php elseif($logs->type == 612):?>
                                                   <span class="badge badge-primary"> <?php echo $logs->stock_initial;?> Bt</span>
                                                    <?php elseif($logs->type == 652):?>
                                                    <span class="badge badge-primary"> <?php echo $logs->stock_initial;?> Bt</span>
                                                    <?php else:?>
                                                   <span class="badge badge-primary">  <?php echo $logs->stock_initial;?> Bt</span>
                                                <?php endif;?>
                                            </td>

                                            <!---------Quantite Recu---------->
                                            <td class="d-none d-xl-table-cell text-center">
                                                <?php if ($logs->type    == 1):?>
                                                    <span class="badge badge-danger">  <?php echo $logs->quantity;?> Litres</span>
                                                <?php elseif($logs->type == 2):?>
                                                    <span class="badge badge-danger">  <?php echo $logs->quantity;?> Litres</span>
                                                <?php elseif($logs->type == 3):?>
                                                    <span class="badge badge-danger"> <?php echo $logs->quantity;?> Litres</span>
                                                <?php elseif($logs->type == 4):?>
                                                    <span class="badge badge-danger"> <?php echo $logs->quantity;?> Litres</span>
                                                <?php elseif($logs->type == 5):?>
                                                    <span class="badge badge-danger"> <?php echo $logs->quantity;?> Litres</span>
                                                <?php elseif($logs->type == 65):?>
                                                    <span class="badge badge-danger">   <?php echo $logs->quantity;?> Bt</span>
                                                <?php elseif($logs->type == 66):?>
                                                    <span class="badge badge-danger">   <?php echo $logs->quantity;?> Bt</span>
                                                <?php elseif($logs->type == 612):?>
                                                    <span class="badge badge-danger">   <?php echo $logs->quantity;?> Bt</span>
                                                <?php elseif($logs->type == 652):?>
                                                    <span class="badge badge-danger">   <?php echo $logs->quantity;?> Bt</span>
                                                <?php else:?>
                                                    <span class="badge badge-danger">   <?php echo $logs->quantity;?> Bt</span>
                                                <?php endif;?></td>

                                            <!---------Stock actuel---------->
                                            <td  class="d-none d-xl-table-cell text-center">
                                                <?php if ($logs->type    == 1):?>
                                                    <span class="badge badge-warning"> <?php echo $logs->stock_actuel;?> Litres</span>
                                                <?php elseif($logs->type == 2):?>
                                                    <span class="badge badge-warning">  <?php echo $logs->stock_actuel;?> Litres</span>
                                                <?php elseif($logs->type == 3):?>
                                                    <span class="badge badge-warning"> <?php echo $logs->stock_actuel;?> Litres</span>
                                                <?php elseif($logs->type == 4):?>
                                                    <span class="badge badge-warning"> <?php echo $logs->stock_actuel;?> Litres</span>
                                                <?php elseif($logs->type == 5):?>
                                                    <span class="badge badge-warning"> <?php echo $logs->stock_actuel;?> Litres</span>
                                                <?php elseif($logs->type == 63):?>
                                                    <span class="badge badge-warning"> <?php echo $logs->stock_actuel;?> Bt</span>
                                                <?php elseif($logs->type == 65):?>
                                                    <span class="badge badge-warning"> <?php echo $logs->stock_actuel;?> Bt</span>
                                                <?php elseif($logs->type == 66):?>
                                                    <span class="badge badge-warning"> <?php echo $logs->stock_actuel;?> Bt</span>
                                                <?php elseif($logs->type == 612):?>
                                                    <span class="badge badge-warning"> <?php echo $logs->stock_actuel;?> Bt</span>
                                                    <?php elseif($logs->type == 652):?>
                                                    <span class="badge badge-warning"> <?php echo $logs->stock_actuel;?> Bt</span>
                                                    <?php else:?>
                                                    <span class="badge badge-warning">  <?php echo $logs->stock_actuel;?> Bt</span>
                                                <?php endif;?>
                                            </td>



                                            <td class="d-none d-xl-table-cell text-center"> <a  data-toggle="tooltip" data-placement="top" title="<?php echo ($logs->date_stock);?>"><?php echo time_ago($logs->date_stock);?></a></td>
                                            <td class="d-none d-xl-table-cell text-center"><?php echo $logs->company_deliver;?></td>
                                            <td class="d-none d-xl-table-cell text-center"><?php echo $logs->camion_number;?></td>
                                            <td class="d-none d-xl-table-cell text-center" ><button class="btn" type="button" title="<?php echo $logs->driver_name;?>" data-container="body" data-toggle="popover" data-placement="top" data-content="Numero du chauffeur: <?php echo $logs->driver_phone;?>."><?php echo $logs->driver_name;?></button></td>
                                        </tr>

                                        <?php
                                        endforeach;
                                        else:
                                            ?>
                                            <tr colspan='7'>
                                                <div class="alert alert-danger alert-dismissible" role="alert">
                                                    <div class="alert-icon">
                                                        <i class="far fa-fw fa-bell"></i>
                                                    </div>
                                                    <div class="alert-message col-sm-12">
                                                        <strong>Bonjour Mr <?php echo html_entity_decode($user->fullname);?></strong>  Pas de ravitaillement effectué!
                                                    </div>
                                                </div>
                                            </tr>
                                        <?php
                                        endif;
                                        ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>


                        </div>

                    </div>

                </div>

                <div class="row">
                    <div class="col-12 col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Historique de vente d`huile</h5>
                            </div>
                            <table class="table" style="width:100%">
                                <thead>
                                <tr>
                                    <th class="d-none d-xl-table-cell text-center">Produits </th>
                                    <th class="d-none d-xl-table-cell text-center">P.U.</th>
                                    <th class="d-none d-xl-table-cell text-center">Quantité</th>
                                    <th class="d-none d-xl-table-cell text-center">Montant</th>
                                    <th class="d-none d-xl-table-cell text-center">Date</th>
                                    <th class="d-none d-xl-table-cell text-center">Action</th>
                                </tr>
                                </thead>

                                <?php
                                if(!$count=$this->uri->segment(3))
                                    $count = 0;
                                if(isset($sell_oil) && count($sell_oil->result())>0):
                                foreach($sell_oil->result() as $sell):
                                $price = $this->db->get_where('cd_fluid' , array('type' =>$sell->type))->row()->prix;
                                $nom = $this->db->get_where('cd_fluid' , array('type' =>$sell->type))->row()->name; ?>
                                <tbody>
                                <tr>
                                    <td class="d-none d-xl-table-cell text-center" ><?php echo $this->db->get_where('cd_format_fuel', array('type_id' =>$sell->type))->row()->name; ?> Litres(s)
                                        <br> <small><?php echo $this->db->get_where('cd_fuel_mark', array('id' =>$sell->mark))->row()->name; ?></small></td>
                                    <td class="d-none d-xl-table-cell text-center" ><?php echo $sell->prix;?> Fcfa/Litre</td>
                                    <td class="d-none d-xl-table-cell text-center" ><?php echo $sell->quantity_out;?> format</td>
                                    <td class="d-none d-xl-table-cell text-center" >
                                        <?php echo (($this->db->get_where('cd_format_fuel' , array('type_id' =>$sell->type))->row()->name * $sell->prix))*$sell->quantity_out;?> Fcfa</td>
                                    <td class="d-none d-md-table-cell text-center" ><?php echo time_ago($sell->time_out);?></td>
<!--                                    <td class="table-action d-none d-md-table-cell text-center">-->
                                        <?php if ($sell->status == 1):?>
                                    <td class="d-none d-xl-table-cell text-center"><a class="text-dark" href="#" data-toggle="modal" data-target="#facture"><i class="align-middle mr-2" data-feather="printer"></i> <span class="align-middle">Facture</span></a></td>
                                    <?php else:?>
                                        <td class="d-none d-xl-table-cell text-center"  style="font-size: 11px;"><button class="btn mb-1 btn-danger" type="button" title="Rupture de Stock" data-container="body" data-toggle="popover" data-placement="top" data-content="Cette vente n`a pas été validé car pas de stock disponible.
Veillez faire un ravitaillement.">Non validé</button></td>
                                    <?php endif;?>
                                    </td>
                                </tr>

                                <?php endforeach; else: ?>
                                    <tr colspan='7'>
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <div class="alert-icon">
                                                <i class="far fa-fw fa-bell"></i>
                                            </div>
                                            <div class="alert-message col-sm-12">
                                                <strong>Bonjour Mr <?php echo html_entity_decode($user->fullname);?>!</strong> Aucune vente d`huile disponible!
                                            </div>
                                        </div>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>




                <div class="row"> <!------Bas-------->

                    <div class="col-12 col-lg-4 d-flex">
                        <div class="card flex-fill w-100">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Stock Restant</h5>
                            </div>
                            <div class="card-body d-flex">
                                <div class="align-self-center w-100">
                                    <div class="py-3">
                                        <div class="chart chart-sm">
                                            <canvas id="chartjs-dashboard-pie"></canvas>
                                        </div>
                                    </div>

                                    <table class="table mb-0">
                                        <tbody>
                                        <tr>
                                            <td><i class="fas fa-square-full text-primary"></i> Essence</td>
                                            <td class="text-right"><?php echo number_format($essence->quantity)?:0 ;?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fas fa-square-full text-warning"></i> Gasoil</td>
                                            <td class="text-right"><?php echo number_format($gasoil->quantity)?:0 ;?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fas fa-square-full text-danger"></i> Kerosene</td>
                                            <td class="text-right"><?php echo number_format($kerosene->quantity)?:0 ;?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fas fa-square-full text-danger"></i> Petrole</td>
                                            <td class="text-right"><?php echo number_format($petrole->quantity)?:0 ;?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <script>
                            document.addEventListener("DOMContentLoaded", function(event) {
                                // Pie chart
                                new Chart(document.getElementById("chartjs-dashboard-pie"), {
                                    type: 'pie',
                                    data: {
                                        labels: ["Essence", "Gasoil", "Kérosène", "Pétrole", "Huile"],
                                        datasets: [{
                                            data: [<?php echo $essence->quantity.','.$gasoil->quantity.','.$kerosene->quantity.','.$petrole->quantity.','.$huile->quantity;?>],
                                            backgroundColor: ["#41D492", "#5C59ED", "#FA6A4B", "#010000","#0b51c5","#ffaa00"],
                                            borderColor: "transparent"
                                        }]
                                    },
                                    options: {
                                        responsive: !window.MSInputMethodContext,
                                        maintainAspectRatio: false,
                                        legend: {
                                            display: true
                                        },
                                        cutoutPercentage: 30
                                    }
                                });
                            });
                        </script>
                    </div>

                    <div class="col-12 col-xl-4 d-flex">
                        <div class="card flex-fill w-100"  style="max-height: 600px;">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Gaz Stock Restant</h5>
                            </div>
                            <div class="card-body d-flex">
                                <div class="align-self-center w-100">
                                    <div class="py-3">
                                        <div class="chart chart-sm">
                                            <canvas id="chartjs-dashboard-pies"></canvas>
                                        </div>
                                    </div>

                                    <table class="table mb-0">
                                        <tbody>
                                        <tr>
                                            <td><i class="fas fa-square-full text-primary"></i>  <?php echo $this->db->get_where('gaz_list', array('type' =>652))->row()->name; ?></td>
                                            <td class="text-right"><?php echo number_format($gaz652->quantity) ;?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fas fa-square-full text-primary"></i> <?php echo $this->db->get_where('gaz_list', array('type' =>612))->row()->name; ?></td>
                                            <td class="text-right"><?php echo number_format($gaz612->quantity) ;?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fas fa-square-full text-primary"></i>  <?php echo $this->db->get_where('gaz_list', array('type' =>66))->row()->name; ?></td>
                                            <td class="text-right"><?php echo number_format($gaz66->quantity) ;?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fas fa-square-full text-primary"></i>  <?php echo $this->db->get_where('gaz_list', array('type' =>65))->row()->name; ?></td>
                                            <td class="text-right"><?php echo number_format($gaz65->quantity) ;?></td>
                                        </tr>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <script>
                            document.addEventListener("DOMContentLoaded", function(event) {
                                // Pie chart
                                new Chart(document.getElementById("chartjs-dashboard-pies"), {
                                    type: 'pie',
                                    data: {
                                        labels: ["Gaz 52kg","Gaz 12,5kg","Gaz 6kg","Gaz 5kg"],
                                        datasets: [{
                                            data: [<?php echo $gaz652->quantity.','.$gaz612->quantity.','.$gaz66->quantity.','.$gaz65->quantity;?>],
                                            backgroundColor: ["#e10aee","#600595","#cfa3e8","#390556"],
                                            borderColor: "transparent"
                                        }]
                                    },
                                    options: {
                                        responsive: !window.MSInputMethodContext,
                                        maintainAspectRatio: false,
                                        legend: {
                                            display: true
                                        },
                                        cutoutPercentage: 30
                                    }
                                });
                            });
                        </script>
                    </div>

                    <div class="col-12 col-xl-4">
                        <div class="card flex-fill w-100">
                            <div class="card-header">
                                <div class="card-body">
                                    <!---here-->
                                </div>

                            </div>

                            <div class="card-body"  style="height: 400px;">
                                <div class="chart">
                                    <div id="morrisjs-line" ></div>
                                </div>
                            </div>

                        </div>
                        <script>
                            document.addEventListener("DOMContentLoaded", function(event) {
                                new Morris.Line({
                                    element: "morrisjs-line",
                                    data: <?php echo $data;?>,
                                    xkey: 'year',
                                    ykeys: ['purchase', 'sale', 'profit'],
                                    labels: ['Essence', 'Kerosene', 'Gasoil'],
                                    fillOpacity: ["0.1"],
                                    pointFillColors: ["#41D492"],
                                    pointStrokeColors: ["#999999"],
                                    behaveLikeLine: true,
                                    gridLineColor: "#eef0f2",
                                    hideHover: "auto",
                                    lineWidth: "3px",
                                    pointSize: 0,
                                    preUnits: "L ",
                                    resize: true,
                                    lineColors: ["#41D492", "#FA6A4B", "#5C59ED"]
                                });
                            });

                        </script>
                    </div><!-------Graph End-------->


                </div> <!--------End Bas--------->


            </div><!-------End containt------->


        </div>
    </div>
</main>





    <?php echo $this->load->view('desk/ravit_form'); ?>




    <script type="text/javascript" language="javascript" >
        $(document).ready(function(){

            $('.input-daterange').datepicker({
                todayBtn:'linked',
                format: "yyyy-mm-dd",
                autoclose: true
            });

            fetch_data('no');

            function fetch_data(is_date_search, start_date='', end_date='')
            {
                var dataTable = $('#order_data').DataTable({
                    "processing" : true,
                    "serverSide" : true,
                    "order" : [],
                    "ajax" : {
                        url:"fetch.php",
                        type:"POST",
                        data:{
                            is_date_search:is_date_search, start_date:start_date, end_date:end_date
                        }
                    }
                });
            }

            $('#search').click(function(){
                var start_date = $('#start_date').val();
                var end_date = $('#end_date').val();
                if(start_date != '' && end_date !='')
                {
                    $('#order_data').DataTable().destroy();
                    fetch_data('yes', start_date, end_date);
                }
                else
                {
                    alert("Both Date is Required");
                }
            });

        });
    </script>





    <script>
        var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $('#startDate').datepicker({
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
            minDate: today,
            maxDate: function () {
                return $('#startDate').val();
            }
        });
        $('#endDate').datepicker({
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
            minDate: function () {
                return $('#endDate').val();
            }
        });
    </script>

    <script>
        $(document).ready(function(){
            $('#item-form').validate({
                rules:{
                    name:{
                        required: true,
                        minlength: 4,
                        remote: {
                            url: '<?php echo site_url("items/exists");?>',
                            type: "GET",
                            data: {
                                name: function () {
                                    return $('#name').val();
                                },
                                sub_cat_id: function() {
                                    return $('#sub_cat_id').val();
                                }
                            }
                        }
                    },
                    unit_price: {
                        number: true
                    }
                },
                messages:{
                    name:{
                        required: "Nom obligatoire",
                        minlength: "The length of item Name must be greater than 4",
                        remote: "Item Name is already existed in the system"
                    },
                    unit_price: {
                        number: "Only number is allowed."
                    }
                }
            });

            $(function () { $("[data-toggle='tooltip']").tooltip(); });

        });


    </script>


    <script type="text/javascript">
        function get_format_fuel(mark) {

            $.ajax({
                url: '<?php echo site_url('reglage/get_format_fuel/');?>' + mark ,
                success: function(response)
                {
                    jQuery('#type').html(response);
                }
            });
        }
    </script>

