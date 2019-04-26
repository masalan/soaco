
<div class="row">
    <div class="col-xl-12">
        <div class="card card-fluid">
            <div class="card-header border-0">
                <div class="d-flex align-items-center">
                    <span class="mr-auto">Historique de vente recente</span> <!-- .card-header-control -->
                    <div class="card-header-control">

                        <div class="dropdown">
                            <button type="button" class="btn btn-icon btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-fw fa-ellipsis-v"></i></button>
                            <div class="dropdown-arrow"></div>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="<?php echo site_url('company/'.url_encode($this->user->get_logged_in_user_info()->user_id));?>" class="dropdown-item">Rrafraichir</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">

                    <thead>
                    <tr>
                        <th class="text-center">Produits </th>
                        <th class="text-center">P.U.</th>
                        <th class="text-center">Stock initial</th>
                        <th class="text-center">Stock restant</th>
                        <th class="text-center">Quantité</th>
                        <th class="text-center">Montant</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <?php
                    if(!$count=$this->uri->segment(3))
                        $count = 0;
                    if(isset($selling) && count($selling->result())>0):

                        foreach($selling->result() as $sell):
                            $price = $this->db->get_where('cd_fluid' , array('type' =>$sell->type))->row()->prix;
                            $nom = $this->db->get_where('cd_fluid' , array('type' =>$sell->type))->row()->name; ?>

                            <tbody>
                            <td class="align-middle text-center">
                                <?php if ($sell->type == 1):?>
                                    <a class="tile bg-green text-white mr-2">ES</a> <a ><?php echo $this->db->get_where('cd_fluid_log' , array('type' =>$sell->type))->row()->name; ?></a>
                                <?php elseif($sell->type == 2):?>
                                    <a class="tile bg-pink text-white mr-2">GS</a> <a ><?php echo $this->db->get_where('cd_fluid_log' , array('type' =>$sell->type))->row()->name; ?></a>
                                <?php elseif($sell->type == 3):?>
                                    <a class="tile bg-orange text-white mr-2">GS</a> <a ><?php echo $this->db->get_where('cd_fluid_log' , array('type' =>$sell->type))->row()->name; ?></a>
                                <?php elseif($sell->type == 4):?>
                                    <a class="tile bg-yellow text-white mr-2">oil</a> <a ><?php echo $this->db->get_where('cd_fluid_log' , array('type' =>$sell->type))->row()->name; ?></a>
                                <?php elseif($sell->type == 5):?>
                                    <a class="tile bg-blue text-white mr-2">Pt</a> <a ><?php echo $this->db->get_where('cd_fluid_log' , array('type' =>$sell->type))->row()->name; ?></a>
                                <?php elseif($sell->type == 63):?>
                                    <span class="badge badge-info"> <?php echo $this->db->get_where('gaz_list', array('type' =>$sell->type))->row()->name; ?></span>
                                <?php elseif($sell->type == 65):?>
                                    <span class="badge badge-info"> <?php echo $this->db->get_where('gaz_list', array('type' =>$sell->type))->row()->name; ?></span>
                                <?php elseif($sell->type == 66):?>
                                    <a class="tile bg-red text-white mr-2">Gaz</a> <a ><?php echo $this->db->get_where('cd_fluid_log' , array('type' =>$sell->type))->row()->name; ?></a>
                                <?php elseif($sell->type == 612):?>
                                    <a class="tile bg-red text-white mr-2">Gaz</a> <a ><?php echo $this->db->get_where('cd_fluid_log' , array('type' =>$sell->type))->row()->name; ?></a>
                                <?php elseif($sell->type == 652):?>
                                    <a class="tile bg-red text-white mr-2">Gaz</a> <a ><?php echo $this->db->get_where('cd_fluid_log' , array('type' =>$sell->type))->row()->name; ?></a>
                                <?php elseif($sell->type == $this->db->get_where('cd_format_fuel' , array('type_id' =>$sell->type,'company_id'=>$societe->user_id))->row()->type_id):?>
                                    <a class="tile bg-brown text-white mr-2">Hl</a> <a ><?php echo $this->db->get_where('cd_fluid_log' , array('type' =>$sell->type))->row()->name; ?></a>
                                <?php endif;?>

                            </td>
                            <td class="align-middle text-center">
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
                                <?php elseif($sell->type == $this->db->get_where('cd_format_fuel' , array('type_id' =>$sell->type,'company_id'=>$societe->user_id))->row()->type_id):?>
                                    <?php echo $sell->prix.'  Fcfa/Litre ';?>
                                <?php endif;?>
                            </td>

                            <td class="align-middle text-center">
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
                                <?php elseif($sell->type == 652):?>
                                    <?php echo $sell->initial_stock;?> Bt
                                <?php elseif($sell->type == $this->db->get_where('cd_format_fuel' , array('type_id' =>$sell->type,'company_id'=>$societe->user_id))->row()->type_id):?>
                                    <?php echo $sell->initial_stock.' Litres';?>
                                <?php endif;?>
                            </td>

                            <td class="align-middle text-center">
                                <?php if ($sell->type    == 1):?>
                                    <?php echo $sell->stock_restant;?> Litres
                                <?php elseif($sell->type == 2):?>
                                    <?php echo $sell->stock_restant;?> Litres
                                <?php elseif($sell->type == 3):?>
                                    <?php echo $sell->stock_restant;?> Litres
                                <?php elseif($sell->type == 4):?>
                                    <?php echo $sell->stock_restant;?> Litres
                                <?php elseif($sell->type == 5):?>
                                    <?php echo $sell->stock_restant;?> Litres
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
                                <?php elseif($sell->type == $this->db->get_where('cd_format_fuel' , array('type_id' =>$sell->type,'company_id'=>$societe->user_id))->row()->type_id):?>
                                    <?php echo $sell->stock_restant.' Litres';?>
                                <?php endif;?>
                            </td>
                            <td class="align-middle text-center">
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

                                <?php elseif($sell->type == 652):?>
                                    <?php echo $sell->quantity_out;?> Bt
                                    <?php if($sell->new_bottle > 0):?>
                                        <a class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Prix Unitaire par Consignation: <?php echo $sell->new_bottle;?> Fcfa">C.</a>
                                    <?php else:?>
                                    <?php endif;?>
                                <?php elseif($sell->type == $this->db->get_where('cd_format_fuel' , array('type_id' =>$sell->type,'company_id'=>$societe->user_id))->row()->type_id):?>
                                    <?php echo $sell->quantity_out.' Litres';?>
                                <?php endif;?>
                            </td>
                            <td class="align-middle text-center">
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
                                <?php elseif($sell->type == $this->db->get_where('cd_format_fuel' , array('type_id' =>$sell->type,'company_id'=>$societe->user_id))->row()->type_id):?>
                                    <?php echo ($this->db->get_where('cd_format_fuel' , array('type_id' =>$sell->type,'company_id'=>$societe->user_id))->row()->name * $sell->prix) * $sell->quantity_out ;?>  Fcfa
                                <?php endif;?>
                            </td>
                            <td class="align-middle text-center"><a  data-toggle="tooltip" data-placement="top" title="<?php echo ($sell->time_out);?>"><?php echo time_ago($sell->time_out);?></a></td>

                            <?php if ($sell->status == 1):?>
                                <td class="align-middle text-center">
                                    <a class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="<?php echo  $this->db->get_where('cd_items' , array('id' =>$sell->station_id,'company_id'=>$societe->user_id))->row()->name;?>"> station</a>
                                </td>
                            <?php else:?>
                                <td class="align-middle text-center">
                                    <button class="btn mb-1 btn-danger" type="button" title="Rupture de Stock" data-container="body" data-toggle="popover" data-placement="top" data-content="Cette vente n`a pas été validé car pas de stock disponible.
Veillez faire un ravitaillement.">Non validé</button></td>
                            <?php endif;?>
                            </tbody>
                        <?php
                        endforeach;
                    else:
                        ?>
                        <tbody>
                        <td class="align-middle text-center">
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <div class="alert-icon"><i class="far fa-fw fa-bell"></i></div>
                                <div class="alert-message col-sm-12"><strong>Bonjour Mr <?php echo html_entity_decode($user->fullname);?>!</strong> Aucune vente encore effectuée  aujourd`hui !</div>
                            </div>
                        </td>
                        </tbody>
                    <?php endif; ?>
                </table>



            </div>
            <div class="card-footer">
                <a  class="card-footer-item">Tous voir <i class="fa fa-fw fa-angle-right"></i></a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card card-fluid">
            <div class="card-header border-0">
                <div class="d-flex align-items-center">
                    <span class="mr-auto">Etat journalier de Ravitaillements</span>
                    <div class="card-header-control">
                        <div class="dropdown">
                            <button type="button" class="btn btn-icon btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-fw fa-ellipsis-v"></i></button>
                            <div class="dropdown-arrow"></div>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="<?php echo site_url('company/'.url_encode($this->user->get_logged_in_user_info()->user_id));?>" class="dropdown-item">Rrafraichir</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
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
                                    <strong>Bonjour Mr <?php echo html_entity_decode($user->fullname);?>!</strong> Aucun ravitaillement disponible encore!
                                </div>
                            </div>
                        </tr>
                    <?php
                    endif;
                    ?>
                    </tbody>

                </table>

            </div>
            <div class="card-footer">
                <a  class="card-footer-item">Tous voir <i class="fa fa-fw fa-angle-right"></i></a>
            </div>
        </div>
    </div>

</div>