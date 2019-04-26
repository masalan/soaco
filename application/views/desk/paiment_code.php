
<!---
<div class="form-group">
    <label class="d-block">Mode paiement</label>
    <span class="group">
                   <input id="id_radio1" type="radio" name="group1" value="value_radio1"  checked="checked"/>
                   <span class="form-check-label">Cash</span>
                   <input id="id_radio2" type="radio" name="group1" value="value_radio2" />
                     <span class="form-check-label">Ticket</span>
                   <input id="id_radio3" type="radio" name="group1" value="value_radio3" />
                     <span class="form-check-label">TPA</span>
                   <input id="id_radio4" type="radio" name="group1" value="value_radio4" />
                     <span class="form-check-label">Mobile Pay</span>
                   <input id="id_radio5" type="radio" name="group1" value="value_radio5" />
                      <span class="form-check-label">Carte de credit</span>
                    </span>
</div>

<div id="divsGroup2" class="group">

<div class="form-group group" id="div1">
        <input type="text" class="form-control form-control-lg mb-3" name="cash" placeholder="Recevoir le cash chez le client" disabled>
        <small class="form-text text-muted">Vous recevrez l`argent de mains du cient </small>
    </div>
    <div class="form-group hide" id="div2">
        <input type="text" class="form-control form-control-lg mb-3" name="code" placeholder="Saisissez le numero du Ticket valeur" >
        <small class="form-text text-muted">Vous recevrez l`argent du client via un coupon ou ticket valeur, entrez son  numero unique </small>
    </div>
    <div class="form-group hide" id="div3">
        <input type="text" class="form-control form-control-lg mb-3" name="tpa" placeholder="Saisissez le Numero de telephone de la carte de bancaire" >
        <small class="form-text text-muted">Vous recevrez l`argent du client via un terminal de paiement automatique (TPA) , veillez saisir son numero de telephone </small>
    </div>
    <div class="form-group hide" id="div4">
        <input type="text" class="form-control form-control-lg mb-3" name="mobil_pay" placeholder="Saisissez le Numero de telephone mobile pay" >
        <small class="form-text text-muted">Vous recevrez l`argent du client via un systeme de paiement GSM Mobile, veillez saisir son numero de telephone </small>

    </div>
    <div class="form-group hide" id="div5">
        <input type="text" class="form-control form-control-lg mb-3" name="card_credit" placeholder="Saisissez le Numero de telephone de la carte de credit" >
        <small class="form-text text-muted">Vous recevrez l`argent via de carte de credit (Bancaire) du client, veillez saisir son numero de telephone </small>

    </div>
</div>

---->


    <div class="row">
        <div class="col-12 col-xl-6">
            <div class="form-group">
                <label class="form-label">Mode de paiement</label>
                <select class="form-control" name="pay_id">
                    <option>Mode de paiement</option>
                    <?php
                    $service_list   = $this->item->get_list_pay_service();
                    if(isset($service_list) && count($service_list->result())>0):
                        foreach($service_list->result() as $mk):?>
                            <option  value="<?php echo $mk->id;?>"><?php echo $mk->description;?></option>
                        <?php
                        endforeach;
                    else:?>
                        <a href="ensemble.php" target="_self"> Aucun produit dispo! Créez-en dans la plateforme Adminstrateur</a>
                    <?php endif; ?>
                </select>
            </div>
        </div>

        <div class="col-12 col-xl-6">
            <div class="form-group">
                <label class="form-label">Numéro Ticket/Telephone </label>
                <input type="text" class="form-control" name="code" placeholder="">
            </div>
        </div>

    </div>

