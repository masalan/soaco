<!-- .page-section -->
<div class="page-section">
    <div class="section-block">
        <div class="metric-row">
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card-metric">
                    <div class="metric">
                        <p class="metric-value h4">
                            <span class="value"> <?php echo ($this->item->fuel_sell_today(1,$societe->user_id)->row()->quantity_out?:0)* $this->db->get_where('cd_price',array('country_id'=>$this->session->userdata('country_id'),'type'=>1))->row()->prix;?></span> <a data-toggle="tooltip" data-placement="top" title="Prix Unitaire: <?php echo $this->db->get_where('cd_price',array('company_id'=>$societe->user_id,'type'=>1))->row()->prix;?> Fcfa"> <sup style="font-size: 10px;">Fcfa</sup></a>
                        </p>
                        <h2 class="metric-label"> Essence </h2>

                    </div>
                    <div class="card-footer">
                        <div class="card-footer-item">
                            <i class="fa fa-fw fa-circle text-indigo"></i> <?php echo $this->item->fuel_sell_today(1,$societe->user_id)->row()->quantity_out?:0;?> L<div class="text-muted small">Quantité vendu </div>
                        </div>
                        <div class="card-footer-item"><i class="fa fa-fw fa-circle text-purple"></i><?php echo $this->item->all_fuel(1,$societe->user_id)->row()->quantity?:0;?> L<div class="text-muted small">Stock restant</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">

                <div class="card-metric">
                    <div class="metric">
                        <p class="metric-value h4">
                            <span class="value"> <?php echo ($this->item->fuel_sell_today(2,$societe->user_id)->row()->quantity_out?:0)* $this->db->get_where('cd_price',array('country_id'=>$this->session->userdata('country_id'),'type'=>2))->row()->prix;?></span> <a data-toggle="tooltip" data-placement="top" title="Prix Unitaire: <?php echo $this->db->get_where('cd_price',array('company_id'=>$societe->user_id,'type'=>2))->row()->prix;?> Fcfa"> <sup style="font-size: 10px;">Fcfa</sup></a>
                        </p>
                        <h2 class="metric-label"> Gasoil </h2>
                    </div>
                    <div class="card-footer">
                        <div class="card-footer-item">
                            <i class="fa fa-fw fa-circle text-indigo"></i> <?php echo $this->item->fuel_sell_today(2,$societe->user_id)->row()->quantity_out?:0;?> L<div class="text-muted small">Quantité vendu </div>
                        </div>
                        <div class="card-footer-item"><i class="fa fa-fw fa-circle text-purple"></i><?php echo $this->item->all_fuel(2,$societe->user_id)->row()->quantity?:0;?> L<div class="text-muted small">Stock restant</div>
                        </div>
                    </div>


                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card-metric">
                    <div class="metric">
                        <p class="metric-value h4">
                            <span class="value"> <?php echo ($this->item->fuel_sell_today(5,$societe->user_id)->row()->quantity_out?:0)* $this->db->get_where('cd_price',array('country_id'=>$this->session->userdata('country_id'),'type'=>5))->row()->prix;?></span> <a data-toggle="tooltip" data-placement="top" title="Prix Unitaire: <?php echo $this->db->get_where('cd_price',array('company_id'=>$societe->user_id,'type'=>5))->row()->prix;?> Fcfa"> <sup style="font-size: 10px;">Fcfa</sup></a>
                        </p>
                        <h2 class="metric-label">Petrole</h2>
                    </div>
                    <div class="card-footer">
                        <div class="card-footer-item">
                            <i class="fa fa-fw fa-circle text-indigo"></i> <?php echo $this->item->fuel_sell_today(5,$societe->user_id)->row()->quantity_out?:0;?> L<div class="text-muted small">Quantité vendu </div>
                        </div>
                        <div class="card-footer-item"><i class="fa fa-fw fa-circle text-purple"></i><?php echo $this->item->all_fuel(5,$societe->user_id)->row()->quantity?:0;?> L<div class="text-muted small">Stock restant</div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card-metric">
                    <div class="metric">
                        <p class="metric-value h4">
                            <span class="value"> <?php echo ($this->item->fuel_sell_today(3,$societe->user_id)->row()->quantity_out?:0)* $this->db->get_where('cd_price',array('country_id'=>$this->session->userdata('country_id'),'type'=>3))->row()->prix;?></span> <a data-toggle="tooltip" data-placement="top" title="Prix Unitaire: <?php echo $this->db->get_where('cd_price',array('company_id'=>$societe->user_id,'type'=>5))->row()->prix;?> Fcfa"> <sup style="font-size: 10px;">Fcfa</sup></a>
                        </p>
                        <h2 class="metric-label">Kerosene</h2>
                    </div>
                    <div class="card-footer">
                        <div class="card-footer-item">
                            <i class="fa fa-fw fa-circle text-indigo"></i> <?php echo $this->item->fuel_sell_today(3,$societe->user_id)->row()->quantity_out?:0;?> L<div class="text-muted small">Quantité vendu </div>
                        </div>

                        <div class="card-footer-item"><i class="fa fa-fw fa-circle text-purple"></i><?php echo $this->item->all_fuel(3,$societe->user_id)->row()->quantity?:0;?> <div class="text-muted small">Stock restant</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <h1 class="section-title mb-0"> Achievement </h1><!-- .dropdown -->
            <div class="dropdown">
                <button class="btn btn-secondary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span>Ce mois</span> <i class="fa fa-fw fa-caret-down"></i></button>
                <div class="dropdown-arrow dropdown-arrow-right"></div><!-- .dropdown-menu -->
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-md stop-propagation">
                    <!-- .custom-control -->
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="dpToday" name="dpFilter" value="0"> <label class="custom-control-label d-flex justify-content-between" for="dpToday"><span>Aujourd`hui</span> <span class="text-muted"><?php echo mdate('%d-%m-%Y', now());?></span></label>
                    </div><!-- /.custom-control -->
                    <!-- .custom-control -->
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="dpYesterday" name="dpFilter" value="1"> <label class="custom-control-label d-flex justify-content-between" for="dpYesterday"><span>Hier</span> <span class="text-muted"><?php echo date('d-m-y: D', mktime(0,0,0,(date("d")-1),date("m"),date("Y")));?></span></label>
                    </div><!-- /.custom-control -->
                    <!-- .custom-control -->
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="dpWeek" name="dpFilter" value="2"> <label class="custom-control-label d-flex justify-content-between" for="dpWeek"><span>Cette semaine</span> <span class="text-muted">Mar 21-27</span></label>
                    </div><!-- /.custom-control -->
                    <!-- .custom-control -->
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="dpMonth" name="dpFilter" value="3" checked> <label class="custom-control-label d-flex justify-content-between" for="dpMonth"><span>Ce mois</span> <span class="text-muted">Mar 1-31</span></label>
                    </div><!-- /.custom-control -->
                    <!-- .custom-control -->
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="dpYear" name="dpFilter" value="4"> <label class="custom-control-label d-flex justify-content-between" for="dpYear"><span>Cette année</span> <span class="text-muted">2018</span></label>
                    </div><!-- /.custom-control -->
                    <!-- .custom-control -->
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="dpCustom" name="dpFilter" value="5"> <label class="custom-control-label" for="dpCustom">Custom</label>
                        <div class="custom-control-hint my-1">
                            <!-- datepicker:range -->
                            <input type="text" class="form-control" data-toggle="flatpickr" data-mode="range" data-date-format="Y-m-d"> <!-- /datepicker:range -->
                        </div>
                    </div><!-- /.custom-control -->
                </div><!-- /.dropdown-menu -->
            </div><!-- /.dropdown -->
        </div>
    </div><!-- /.section-block -->
    <!-- grid row -->

    <!-- stat-->
    <?php echo $this->load->view('company/home_graph_list'); ?>
    <!-- Liste recent achat & ravitaillement -->
    <?php echo $this->load->view('company/home_table_list'); ?>
</div>