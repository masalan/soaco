


<link href="<?php echo base_url('st/css/paper.css');?>" rel="stylesheet">
<link href="<?php echo base_url('st/css/datatables.min.css');?>" rel="stylesheet">


<section class="sheet padding-10mm container">
        <div class="row">

            <div class="col-12 col-md-12 col-lg-12 col-xl-12 pl-lg-12 "> <!-------- Containt  http://ecolerecher:8888/Monebia/barcode/<?= $ebia->ecol_assur_number; ?>-------->

                <div class="row">

                    <div class="col-12 ">
                        <div class="card print_invoice"  id="print_invoice">

                            <div class="card-body m-sm-4 m-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="text-muted"><img  class="image-area rounded mr-4 mb-4"  src="<?php echo base_url();?>invoice/barcode/<?php echo html_entity_decode($invoice->invoice_number);?>"  width="200" height="60"></div>
                                        <strong><?php echo html_entity_decode($invoice->invoice_number);?></strong>
                                    </div>
                                    <div class="col-md-6 text-md-right">
                                        <div class="text-muted">Date de facturation</div>
                                        <strong><?php echo html_entity_decode($invoice->add_time);?></strong>
                                    </div>
                                </div>

                                <hr class="my-2" />

                                <div class="row mb-2">
                                    <!----Client--->

                                    <div class="col-md-6">
                                        <div class="text-muted">Client</div>
                                        <strong>
                                            <?php echo html_entity_decode($invoice->client_name);?>
                                        </strong>
                                        <p>
                                            <?php echo $invoice->client_phone.'<br>'.$this->db->get_where('cd_cities', array('id' => $invoice->city_id, 'status' => 1))->row()->name.' /'.$this->db->get_where('cd_categories', array('id' => $invoice->cat_id, 'is_published' => 1))->row()->name.'<br>'.$this->db->get_where('cd_countries', array('id' => $invoice->country_id, 'is_active' => 1))->row()->name;?>  <br>
<!--                                            <a href="pages-invoice.html#">-->
<!--                                                lida.miller@gmail.com-->
<!--                                            </a>-->
                                        </p>
                                    </div>
                                    <!------Company---->
                                    <div class="col-md-6 text-md-right">

                                        ​<picture>
                                            <source srcset="<?php echo base_url();?>uploads/<?php echo html_entity_decode($station->avatar );?>" type="image/svg+xml">
                                            <img class="rounded-circle rounded mr-2 mb-2" src="<?php echo base_url();?>uploads/<?php echo html_entity_decode($station->avatar );?>" alt="<?php echo html_entity_decode($societe->fullname );?>" width="60" height="60">
                                        </picture>


                                        <div class="text-muted"></div>
                                        <strong>
                                            <?php echo html_entity_decode($societe->fullname );?>
                                        </strong>
                                        <p>
                                            <?php echo html_entity_decode($station->name);?> <br> <?php echo  $societe->company_phone;?>
<!--                                            <br> 80202 <br> USA <br>-->
                                            <a href="pages-invoice.html#">
                                                <?php echo html_entity_decode($station->user_email);?>
                                            </a>
                                        </p>
                                    </div>
                                </div>


                                <table class="table table-sm">
                                    <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Quantité</th>
                                        <th class="text-right">Montant</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr>
                                        <td>Essence 92</td>
                                        <td>45 Litres</td>
                                        <td class="text-right">100.00</td>
                                    </tr>

                                    <tr>
                                        <th>&nbsp;</th>
                                        <th>Montant TTC </th>
                                        <th class="text-right">100.00</th>
                                    </tr>
                                    </tbody>
                                </table>

                                <div class="text-center">
                                    <p class="text-sm">
                                        <strong>Extra note:</strong> Please send all items at the same time to the shipping address. Thanks in advance.
                                    </p>
                                </div>
                            </div>


                        </div>

                        <div class="text-center">

                            <a onclick="print_invoice('print_invoice')" href="#" data-toggle="tooltip" data-placement="top"  class="btn btn-warning"">
                            <i class="fa fa-print"></i>
                            Imprimer ce reçu</a>
                        </div>
                    </div>


                </div>



            </div>
        </div>
    </section>
    <script type="text/javascript">
        $(document).ready(function () {
            init_items_sortable(true);
        });
        function print_invoice(print_invoice) {
            var printContents = document.getElementById(print_invoice).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
