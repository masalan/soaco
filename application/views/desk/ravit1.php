<div class="container">
    <div class="row">

        <div class="col-xl-2">

        </div>



        <div class="col-xl-8 ">
            <div class="card">

                <div class="card-header">
                    <h5 class="card-title">Attention</h5>
                    <h6 class="card-subtitle text-muted">Veuillez remplir les champs en dessous</h6>
                </div>

                <div class="card-body">
                    <p class="card-text">Vous êtes sur une page strictement réservée aux  ravitaillements de stock. C`est une  page sous haute surveillance et très protégée </p>
                            <?php $attributes = array('id' => 'validation-form','enctype' => 'multipart/form-data');
                            echo form_open(site_url("soaco_e-data_store"), $attributes); ?>


                    <div class="form-group">
                        <select class="form-control" name="type" style="width: 100%">
                        <option value>Selectionne un produit...</option>
                            <?php
                            $service_list   = $this->item->get_list_service_live_station($station->id);
                            if(isset($service_list) && count($service_list->result())>0):
                                foreach($service_list->result() as $mk):?>
                                    <option  value="<?php echo $mk->service_id;?>"><?php echo $mk->name;?></option>
                                <?php
                                endforeach;
                            else:?>
                                <a href="ensemble.php" target="_self"> Aucun produit dispo! Créez-en dans la plateforme Adminstrateur</a>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Nom du fournisseur </span>
                        </div>
                        <input type="text" class="form-control" name="company_deliver" placeholder="Nom complet du fournisseur" required autofocus>
                    </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Numero du camion </span>
                            </div>
                            <input type="text" class="form-control" name="camion_number" placeholder="Numero de la plaque d`immatriculation" required autofocus>
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Nom du chauffeur </span>
                            </div>
                            <input type="text" class="form-control" name="driver_name" placeholder="Nom du chauffeur du camion" required autofocus>
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Telephone chauffeur</span>
                            </div>
                            <input type="text" class="form-control" name="driver_phone" placeholder="Numero de Telephone du chauffeur" required autofocus>
                        </div>


                            <input type="hidden" name="station_id" value="<?php echo $station->id?>">
                            <input type="hidden" name="company_id" value="<?php echo $societe->user_id?>">
                            <input type="hidden" name="user_id" value="<?php echo $this->user->get_logged_in_user_info()->user_id?>">
                    <a href="<?php echo base_url('/stock/').url_encode($station->id);?>" class="btn btn-danger right-btn">Retour</a>
                        <button type="submit" class="btn btn-primary">Suivant</button>
                    </form>

                </div>
            </div>
        </div>



        <div class="col-xl-2 ">

        </div>




    </div>
</div>
</div>

