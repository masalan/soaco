

<!-- BEGIN  modal Essence -->
<div class="modal fade" id="essence" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Saisissez La quantité d’Essence  </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php $attributes = array('id' => 'validation-form','enctype' => 'multipart/form-data');
            echo form_open(site_url("pay_essence/".url_encode($station->id)), $attributes); ?>
            <div class="card-body">
                <input  class="form-control form-control-lg mb-3" id="quantity_in" name="quantity_in"  data-mask="0000000000" data-reverse="true"   type="text" placeholder="Entrez le nombre de litre d`Essence " required>
                <input type="hidden" name="cd_fluid_id" value="1">
                <input type="hidden" name="city_id" value="<?php echo $this->city->get_current_city()->id?>">
                <input type="hidden" name="station_id" value="<?php echo $station->id?>">
                <input type="hidden" name="type" value="1">
                <input type="hidden" name="departement_id" value="<?php echo $station->city_id?>">
                <input type="hidden" name="commune_id" value="<?php echo $station->cat_id?>">
                <input type="hidden" name="user_id" value="<?php echo $this->user->get_logged_in_user_info()->user_id?>">
                <input type="hidden" name="prix" value="<?php echo $this->db->get_where('cd_price', array('type' =>1,'status'=>1))->row()->prix; ?> ">
                <input type="hidden" name="name" value="Essence">
                <input type="hidden" name="company_id" value="<?php echo html_entity_decode($societe->user_id );?>">
                <input type="hidden" name="initial_stock" value="<?php echo $this->db->get_where('cd_fluid', array('type' =>1,'company_id'=>$societe->user_id ,'station_id'=>$station->id))->row()->quantity; ?> ">

                <?php echo $this->load->view('desk/paiment_code'); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ferme</button>
                <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('save_button')?></button>

            </div>
            </form>
        </div>
    </div>
</div>
<!-- END  modal -->

<script type="text/javascript">

</script>




<!-- BEGIN  modal Gasoil -->
<div class="modal fade" id="gasoil" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Saisissez La quantité de Gasoil  </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php $attributes = array('id' => 'validation-form','enctype' => 'multipart/form-data');
            echo form_open(site_url("pay_essence/".url_encode($station->id)), $attributes); ?>
            <div class="card-body">
                <input  class="form-control form-control-lg mb-3" id="quantity_in"  name="quantity_in"  data-mask="0000000000" data-reverse="true"   type="text" placeholder="Entrez le nombre de litre de Gasoil " required>
                <input type="hidden" name="cd_fluid_id" value="2">
                <input type="hidden" name="city_id" value="<?php echo $this->city->get_current_city()->id?>">
                <input type="hidden" name="station_id" value="<?php echo $station->id?>">
                <input type="hidden" name="type" value="2">
                <input type="hidden" name="departement_id" value="<?php echo $station->city_id?>">
                <input type="hidden" name="commune_id" value="<?php echo $station->cat_id?>">
                <input type="hidden" name="user_id" value="<?php echo $this->user->get_logged_in_user_info()->user_id?>">
                <input type="hidden" name="prix" value="<?php echo $this->db->get_where('cd_price', array('type' =>2,'status'=>1))->row()->prix; ?> ">
                <input type="hidden" name="company_id" value="<?php echo html_entity_decode($societe->user_id );?>">
                <input type="hidden" name="name" value="Gasoil">
                <input type="hidden" name="initial_stock" value="<?php echo $this->db->get_where('cd_fluid', array('type' =>2,'company_id'=>$societe->user_id ,'station_id'=>$station->id))->row()->quantity; ?> ">

                <?php echo $this->load->view('desk/paiment_code'); ?>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ferme</button>
                <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('save_button')?></button>

            </div>
            </form>
        </div>
    </div>
</div>
<!-- END  modal -->



<!-- BEGIN  modal Kerosene -->
<div class="modal fade" id="kerosene" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Saisissez La quantité de kérosène  </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php $attributes = array('id' => 'validation-form','enctype' => 'multipart/form-data');
            echo form_open(site_url("pay_essence/".url_encode($station->id)), $attributes); ?>
            <div class="card-body">
                <input  class="form-control form-control-lg mb-3" id="quantity_in"  name="quantity_in" data-mask="0000000000" data-reverse="true"    type="text" placeholder="Entrez le nombre de litre " required>
                <input type="hidden" name="cd_fluid_id" value="3">
                <input type="hidden" name="city_id" value="<?php echo $this->city->get_current_city()->id?>">
                <input type="hidden" name="station_id" value="<?php echo $station->id?>">
                <input type="hidden" name="type" value="3">
                <input type="hidden" name="company_id" value="<?php echo html_entity_decode($societe->user_id );?>">
                <input type="hidden" name="departement_id" value="<?php echo $station->city_id?>">
                <input type="hidden" name="commune_id" value="<?php echo $station->cat_id?>">
                <input type="hidden" name="user_id" value="<?php echo $this->user->get_logged_in_user_info()->user_id?>">
                <input type="hidden" name="prix" value="<?php echo $this->db->get_where('cd_price', array('type' =>3,'status'=>1))->row()->prix; ?> ">
                <input type="hidden" name="name" value="kerosene">
                <input type="hidden" name="initial_stock" value="<?php echo $this->db->get_where('cd_fluid', array('type' =>3,'company_id'=>$societe->user_id ,'station_id'=>$station->id))->row()->quantity; ?> ">
                <?php echo $this->load->view('desk/paiment_code'); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ferme</button>
                <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('save_button')?></button>

            </div>
            </form>
        </div>
    </div>
</div>
<!-- END  modal -->



<!-- BEGIN  modal Lubrifiant -->
<div class="modal fade" id="huile" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Saisissez La quantité de Lubrifiants  </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php $attributes = array('id' => 'validation-form','enctype' => 'multipart/form-data');
            echo form_open(site_url("desk/add_fuel/".url_encode($station->id)), $attributes); ?> <!--pay_essence/-->
            <div class="card-body">
                <select name="mark" class="form-control mb-3" data-validate="required" id="mark"
                        data-message-required="Selection obligatoire"
                        onchange="return get_format_fuel(this.value)">
                    <option selected>Selectionnez marque d`huile </option>

                    <?php
                    $mark_list   = $this->item->mark_oil_list($station->id);
                    if(isset($mark_list) && count($mark_list->result())>0):
                        foreach($mark_list->result() as $mk):?>
                            <option  value="<?php echo $mk->id;?>"><?php echo $mk->name;?></option>
                        <?php
                        endforeach;
                    else:?>
                        <option selected> Aucune marque d`huile dispo! Créez-en dans la plateforme Adminstrateur</option>
                    <?php endif; ?>


                </select>

                <select class="custom-select mb-3" name="type" id="type"  data-validate="required">
                    <option selected>Selectionnez format d`huile </option>
                </select>
                <input  class="form-control form-control-lg mb-3"  id="quantity_in"   name="quantity_in" type="text" placeholder="Entrez le nombre de format" required>
                <input  class="form-control form-control-lg mb-3"  name="prix" type="text" placeholder="Entrez le prix unitaire par litre" required>
                <input type="hidden" name="company_id" value="<?php echo html_entity_decode($societe->user_id );?>">
                <input type="hidden" name="city_id" value="<?php echo $this->city->get_current_city()->id?>">
                <input type="hidden" name="station_id" value="<?php echo $station->id?>">
                <input type="hidden" name="departement_id" value="<?php echo $station->city_id?>">
                <input type="hidden" name="commune_id" value="<?php echo $station->cat_id?>">
                <input type="hidden" name="user_id" value="<?php echo $this->user->get_logged_in_user_info()->user_id?>">
                <input type="hidden" name="name" value="Lubrifiant">
                <?php echo $this->load->view('desk/paiment_code'); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ferme</button>
                <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('save_button')?></button>

            </div>
            </form>
        </div>
    </div>
</div>
<!-- END  modal -->


<!-- BEGIN  modal Pétrole -->
<div class="modal fade" id="petrole" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Saisissez La quantité de Pétrole  </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php $attributes = array('id' => 'validation-form','enctype' => 'multipart/form-data');
            echo form_open(site_url("pay_essence/".url_encode($station->id)), $attributes); ?>
            <div class="card-body">
                <input  class="form-control form-control-lg mb-3" id="quantity_in"  name="quantity_in"  data-mask="0000000000" data-reverse="true"   type="text" placeholder="Entrez le nombre de litre de Pétrole " required>
                <input type="hidden" name="cd_fluid_id" value="2">
                <input type="hidden" name="city_id" value="<?php echo $this->city->get_current_city()->id?>">
                <input type="hidden" name="station_id" value="<?php echo $station->id?>">
                <input type="hidden" name="type" value="5">
                <input type="hidden" name="departement_id" value="<?php echo $station->city_id?>">
                <input type="hidden" name="commune_id" value="<?php echo $station->cat_id?>">
                <input type="hidden" name="user_id" value="<?php echo $this->user->get_logged_in_user_info()->user_id?>">
                <input type="hidden" name="prix" value="<?php echo $this->db->get_where('cd_price', array('type' =>5,'status'=>1))->row()->prix; ?> ">
                <input type="hidden" name="name" value="Pétrole">
                <input type="hidden" name="company_id" value="<?php echo html_entity_decode($societe->user_id );?>">
                <?php echo $this->load->view('desk/paiment_code'); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ferme</button>
                <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('save_button')?></button>

            </div>
            </form>
        </div>
    </div>
</div>
<!-- END  modal -->


<!-- BEGIN  modal Gaz -->
<div class="modal fade" id="gaz" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title centered"><span class="badge badge-danger"> Prix Unitaire:  <?php echo $this->db->get_where('gaz_list', array('type' =>63,'is_active'=>1))->row()->pu; ?>Fcfa/kg</span> </h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php $attributes = array('id' => 'validation-form','enctype' => 'multipart/form-data');
            echo form_open(site_url("pay_essence/".url_encode($station->id)), $attributes); ?>
            <div class="card-body">

                <select class="custom-select mb-3" name="type">
                    <option selected>Selectionnez le format</option>
                    <?php
                    $gz = $this->db->get_where('gaz_list',array('is_active'=>1));
                    foreach($gz->result() as $cat)
                        echo "<option value='".$cat->type."'>".$cat->name."</option>"; ?>
                </select>
                <input  class="form-control form-control-lg mb-3" id="quantity_in"  name="quantity_in"  data-mask="0000000000" data-reverse="true"   type="text" placeholder="Entrez la quantité de format" required>
                <input  class="form-control form-control-lg mb-3" name="new_bottle"  type="text" placeholder="Prix unitaire de la consignation  (Facultative)" >
                <input type="hidden" name="city_id" value="<?php echo $this->city->get_current_city()->id?>">
                <input type="hidden" name="station_id" value="<?php echo $station->id?>">
                <input type="hidden" name="company_id" value="<?php echo html_entity_decode($societe->user_id );?>">
                <input type="hidden" name="departement_id" value="<?php echo $station->city_id?>">
                <input type="hidden" name="commune_id" value="<?php echo $station->cat_id?>">
                <input type="hidden" name="user_id" value="<?php echo $this->user->get_logged_in_user_info()->user_id?>">
                <input type="hidden" name="name" value="Bt. de Gaz">
                <?php echo $this->load->view('desk/paiment_code'); ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ferme</button>
                <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('save_button')?></button>

            </div>
            </form>
        </div>
    </div>
</div>
<!-- END  modal -->


<!-- BEGIN  modal Pétrole -->
<div class="modal fade" id="lubrifiants" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Saisissez La quantité de Lubrifiants  </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php $attributes = array('id' => 'validation-form','enctype' => 'multipart/form-data');
            echo form_open(site_url("pay_essence/".url_encode($station->id)), $attributes); ?>
            <div class="card-body">
                <input  class="form-control form-control-lg mb-3"  id="quantity_in"  name="quantity_in" data-mask="0000000000" data-reverse="true"    type="text" placeholder="Entrez le nombre de litre ">
                <input type="hidden" name="cd_fluid_id" value="7">
                <input type="hidden" name="city_id" value="<?php echo $this->city->get_current_city()->id?>">
                <input type="hidden" name="station_id" value="<?php echo $station->id?>">
                <input type="hidden" name="company_id" value="<?php echo html_entity_decode($societe->user_id );?>">
                <input type="hidden" name="type" value="7">
                <input type="hidden" name="departement_id" value="<?php echo $station->city_id?>">
                <input type="hidden" name="commune_id" value="<?php echo $station->cat_id?>">
                <input type="hidden" name="user_id" value="<?php echo $this->user->get_logged_in_user_info()->user_id?>">
                <input type="hidden" name="prix" value="430">
                <input type="hidden" name="name" value="Essence">
                <input type="hidden" name="initial_stock" value="<?php echo $this->db->get_where('cd_fluid', array('type' =>7,'company_id'=>$societe->user_id ,'station_id'=>$station->id))->row()->quantity; ?> ">
                <?php echo $this->load->view('desk/paiment_code'); ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ferme</button>
                <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('save_button')?></button>

            </div>
            </form>
        </div>
    </div>
</div>
<!-- END  modal -->




<!-- invoice form-->
<div class="modal fade" id="facture" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Saisissez les informations nominatif de facture </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php $attributes = array('id' => 'validation-form','enctype' => 'multipart/form-data');
            echo form_open(site_url("invoice/add_invoice"), $attributes); ?>
            <div class="card-body">
                <input  class="form-control form-control-lg mb-3" name="client_name"  type="text" placeholder="Entrez le nom du client ou de la societe" required>
                <input  class="form-control form-control-lg mb-3" name="client_phone" type="text" placeholder="Numero de telephonne du cleint ou de la societe (Facultative)">
                <input  class="form-control form-control-lg mb-3" name="client_car"   type="text" placeholder="Numero de la voiture (Facultative)">
                <input type="hidden" name="invoice_number" value="<?php
                $this->load->helper('string');
                echo random_string('nozero', 8);?>">
                <input type="hidden" name="station_id" value="<?php echo $station->id;?>">
                <input type="hidden" name="company_id" value="<?php echo $societe->user_id;?>">
                <input type="hidden" name="user_id" value="<?php echo $this->user->get_logged_in_user_info()->user_id;?>">
                <input type="hidden" name="company_id" value="<?php echo html_entity_decode($societe->user_id );?>">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ferme</button>
                <button type="submit" class="btn btn-primary">Creer une facture</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- END  modal -->

