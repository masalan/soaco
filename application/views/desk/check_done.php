<div class="container">
    <div class="row">

        <div class="col-xl-2">

        </div>



        <div class="col-xl-8 ">
            <div class="mb-3">
                <div class="alert alert-info alert-dismissible" role="alert">
                    <div class="alert-message  text-center">
                        <h3 class="alert-heading text-center">Felicitation !</h3>
                        <h4 style="color: white;">Votre carte est valide et prète a l`utilisation !</h4>
                        <hr>
                        <div class="btn-list">
                            <a href="<?php echo base_url('code_card')?>" class="btn btn-light right-btn">Ok</a>

                        </div>
                    </div>



                </div>
            </div>

            <div class="card">
            <div class="card-header">
                <h5 class="card-title">Information de la carte</h5>
                <h6 class="card-subtitle text-muted">Faites attention a ce qui suit</h6>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-xl-8">

                    <?php if ($carte->type_cards_id== 1):?>

                        <p class="card-text"><strong> Type de Carte :</strong><span class="badge badge-info">Coupon</span></p>

                <?php elseif($carte->type_cards_id== 2):?>
                        <p class="card-text"><strong> Type de Carte :  </strong><span class="badge badge-info">Carte VIP</span></p>

                <?php elseif($carte->type_cards_id== 3):?>
                        <p class="card-text"><strong> Type de Carte :  </strong><span class="badge badge-info">Carte Privilege</span></p>

                <?php elseif($carte->type_cards_id== 4):?>
                        <p class="card-text"><strong> Type de Carte :  </strong><span class="badge badge-info">Ticket Valeur</span></p>
                <?php elseif($carte->type_cards_id== 4):?>
                        <p class="card-text"><strong> Type de Carte :  </strong><span class="badge badge-info">Carte de fidélité</span> </p>
                <?php else:?>
                        <p class="card-text"><strong> Type de Carte :  </strong><span class="badge badge-info">Carte Bancaire </span></p>
                <?php endif;?>

                <p class="card-text"><strong> Délivrée a :</strong> <?php echo $carte->username;?></p>
                <p class="card-text"><strong> Montant restant: </strong> <?php echo ($carte->initial_moeny-$carte->rest_moeny).$this->db->get_where('cd_currencies',array('id'=>$carte->currency_id))->row()->code;?></p>
                <p class="card-text"><strong> Fournisseur : </strong> <?php echo $this->db->get_where('be_users',array('user_id'=>$carte->company_id))->row()->fullname;?></p>

                    </div>
                    <div class="col-xl-4"></div>
                </div>
            </div>
            </div>



        </div>



        <div class="col-xl-2">

        </div>




    </div>
</div>
</div>