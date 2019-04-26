
<div class="container">
        <div class="row">
            <!---side bar-->
            <?php $this->load->view( 'layout/themes/sidebar.php' ); ?>
            <div class="col-12 col-md-12 col-lg-12 col-xl-12 pl-lg-12">
                <div class="row">







                    <div class="col-12 col-lg-6 col-xxl-6 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header">
                                <h5 class="card-title"><div class="spinner-border spinner-border-sm text-primary mr-2" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>  <?php echo html_entity_decode($station->station_name);?></h5>
                                <h6 class="card-subtitle text-muted">Ravitaillement de services </h6>

                            </div>

                            <div class="card-body">
                                <?php
                                $attributes = array('id' => 'item-form','enctype' => 'multipart/form-data');
                                echo form_open(site_url('reglage/add/'.$station->id), $attributes); ?>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Quantité d’Essence" name="quantity">
                                    <input type="hidden" name="name" value="Pétrole">
                                    <input type="hidden" name="departement_id" value="<?php echo $station->city_id?>">
                                    <input type="hidden" name="commune_id" value="<?php echo $station->cat_id?>">
                                    <input type="hidden" name="user_id" value="<?php echo $this->user->get_logged_in_user_info()->user_id?>">
                                    <input type="hidden" name="prix" value="430">
                                    <input type="hidden" name="type" value="1">
                                    <input type="hidden" name="name" value="Essence">

                                    <div class="input-group-append">
                                        <button class="btn btn-warning" type="submit" name="extraire">Modifier</button>
                                        <button class="btn btn-primary" type="submit" name="save" ><i class="align-middle mr-1 fas fa-fw fa-gas-pump"></i> Ajoutez</button>
                                    </div>
                                </div>
                                </form>

                                <?php
                                $attributes = array('id' => 'item-form','enctype' => 'multipart/form-data');
                                echo form_open(site_url('reglage/add/'.$station->id), $attributes); ?>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Quantité de Gasoil reçu" name="quantity">
                                    <input type="hidden" name="name" value="Pétrole">
                                    <input type="hidden" name="departement_id" value="<?php echo $station->city_id?>">
                                    <input type="hidden" name="commune_id" value="<?php echo $station->cat_id?>">
                                    <input type="hidden" name="user_id" value="<?php echo $this->user->get_logged_in_user_info()->user_id?>">
                                    <input type="hidden" name="prix" value="430">
                                    <input type="hidden" name="type" value="2">
                                    <input type="hidden" name="name" value="Pétrole">

                                    <div class="input-group-append">
                                        <button class="btn btn-warning" type="submit" name="extraire">Modifier</button>
                                        <button class="btn btn-primary" type="submit" name="save" ><i class="align-middle mr-1 fas fa-fw fa-gas-pump"></i> Ajoutez</button>
                                    </div>
                                </div>
                                </form>

                                <?php
                                $attributes = array('id' => 'item-form','enctype' => 'multipart/form-data');
                                echo form_open(site_url('reglage/add/'.$station->id), $attributes); ?>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Quantité de Pétrole" name="quantity">
                                    <input type="hidden" name="name" value="Pétrole">
                                    <input type="hidden" name="departement_id" value="<?php echo $station->city_id?>">
                                    <input type="hidden" name="commune_id" value="<?php echo $station->cat_id?>">
                                    <input type="hidden" name="user_id" value="<?php echo $this->user->get_logged_in_user_info()->user_id?>">
                                    <input type="hidden" name="prix" value="430">
                                    <input type="hidden" name="type" value="5">
                                    <input type="hidden" name="name" value="Pétrole">
                                    <div class="input-group-append">
                                        <button class="btn btn-warning" type="submit" name="extraire">Modifier</button>
                                        <button class="btn btn-primary" type="submit" name="save" ><i class="align-middle mr-1 fas fa-fw fa-gas-pump"></i> Ajoutez</button>
                                    </div>
                                </div>
                                </form>
                            </div>

                        </div>
                    </div>




                    <div class="col-12 col-lg-6 col-xxl-6 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header">
                                <h5 class="card-title"><div class="spinner-border spinner-border-sm text-danger mr-2" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>  <?php echo html_entity_decode($station->station_name);?></h5>
                            </div>

                            <div class="card-body">
                                <?php
                                $attributes = array('id' => 'item-form','enctype' => 'multipart/form-data');
                                echo form_open(site_url('reglage/add/'.$station->id), $attributes); ?>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Quantité de Fuel Oil" name="quantity">

                                    <input type="hidden" name="name" value="Pétrole">
                                    <input type="hidden" name="departement_id" value="<?php echo $station->city_id?>">
                                    <input type="hidden" name="commune_id" value="<?php echo $station->cat_id?>">
                                    <input type="hidden" name="user_id" value="<?php echo $this->user->get_logged_in_user_info()->user_id?>">
                                    <input type="hidden" name="prix" value="430">
                                    <input type="hidden" name="type" value="4">
                                    <input type="hidden" name="name" value="Fuel Oil">

                                    <div class="input-group-append" >
                                        <button class="btn btn-warning" type="submit" name="extraire">Modifier</button>
                                        <button class="btn btn-primary" type="submit" name="save" ><i class="align-middle mr-1 fas fa-fw fa-gas-pump"></i> Ajoutez</button>
                                    </div>

                                </div>
                                </form>
                                <?php
                                $attributes = array('id' => 'item-form','enctype' => 'multipart/form-data');
                                echo form_open(site_url('reglage/add/'.$station->id), $attributes); ?>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Quantité de Kerosene" name="quantity">
                                    <input type="hidden" name="name" value="Pétrole">
                                    <input type="hidden" name="departement_id" value="<?php echo $station->city_id?>">
                                    <input type="hidden" name="commune_id" value="<?php echo $station->cat_id?>">
                                    <input type="hidden" name="user_id" value="<?php echo $this->user->get_logged_in_user_info()->user_id?>">
                                    <input type="hidden" name="prix" value="430">
                                    <input type="hidden" name="type" value="3">
                                    <input type="hidden" name="name" value="Pétrole">

                                    <div class="input-group-append">
                                        <button class="btn btn-warning" type="submit" name="extraire">Modifier</button>
                                        <button class="btn btn-primary" type="submit" name="save" ><i class="align-middle mr-1 fas fa-fw fa-gas-pump"></i> Ajoutez</button>
                                    </div>
                                </div>
                                </form>
                                <?php
                                $attributes = array('id' => 'item-form','enctype' => 'multipart/form-data');
                                echo form_open(site_url('reglage/add/'.$station->id), $attributes); ?>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Quantité de Lubrifiants" name="quantity">
                                    <input type="hidden" name="name" value="Pétrole">
                                    <input type="hidden" name="departement_id" value="<?php echo $station->city_id?>">
                                    <input type="hidden" name="commune_id" value="<?php echo $station->cat_id?>">
                                    <input type="hidden" name="user_id" value="<?php echo $this->user->get_logged_in_user_info()->user_id?>">
                                    <input type="hidden" name="prix" value="430">
                                    <input type="hidden" name="type" value="7">
                                    <input type="hidden" name="name" value="Pétrole">
                                    <div class="input-group-append">
                                        <button class="btn btn-warning" type="submit" name="extraire">Modifier</button>
                                        <button class="btn btn-primary" type="submit" name="save" ><i class="align-middle mr-1 fas fa-fw fa-gas-pump"></i> Ajoutez</button>
                                    </div>
                                </div>
                                </form>




                                <?php
                                $attributes = array('id' => 'item-form','enctype' => 'multipart/form-data');
                                echo form_open(site_url('reglage/add/'.$station->id), $attributes); ?>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Quantité de Gaz" name="quantity">
                                    <input type="hidden" name="name" value="Pétrole">
                                    <input type="hidden" name="departement_id" value="<?php echo $station->city_id?>">
                                    <input type="hidden" name="commune_id" value="<?php echo $station->cat_id?>">
                                    <input type="hidden" name="user_id" value="<?php echo $this->user->get_logged_in_user_info()->user_id?>">
                                    <input type="hidden" name="prix" value="430">
                                    <input type="hidden" name="type" value="g">
                                    <input type="hidden" name="name" value="Lubrifiants">
                                    <div class="input-group-append">
                                        <button class="btn btn-warning" type="submit" name="extraire">Modifier</button>
                                        <button class="btn btn-primary" type="submit" name="save" ><i class="align-middle mr-1 fas fa-fw fa-gas-pump"></i> Ajoutez</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                    <h5 class="card-title">Historique de ventees</h5>
                                    <h6 class="card-subtitle text-muted"> </h6>


                            </div>
                            <div class="card-body">
                                <table id="datatables-basic" class="table table-striped" style="width:100%">
                                    <thead style="background-color: grey; color: white;">
                                    <tr>
                                        <th class="text-center">Produit</th>
                                        <th class="text-center">Date d`achat</th>
                                        <th class="text-center">Quantité</th>
                                        <th class="text-center">Prix Unitaire</th>
<!--                                        <th class="text-center">Start date</th>-->
                                        <th class="text-center">Prix Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if(!$count=$this->uri->segment(3))
                                        $count = 0;
                                    if(isset($fluid_logs) && count($fluid_logs->result())>0):
                                    foreach($fluid_logs->result() as $logs):
                                    ?>

                                    <tr>
                                        <td class="text-center">
                                            <?php if ($logs->type == 1):?>
                                                <span class="badge badge-primary"><?php echo $logs->name; ?></span>
                                            <?php elseif($logs->type == 2):?>
                                                <span class="badge badge-info"><?php echo $logs->name; ?></span>
                                            <?php elseif($logs->type == 3):?>
                                                <span class="badge badge-danger"><?php echo $logs->name; ?></span>
                                            <?php elseif($logs->type == 4):?>
                                                <span class="badge badge-warning"><?php echo $logs->name; ?></span>
                                            <?php elseif($logs->type == 5):?>
                                                <span class="badge badge-secondary"><?php echo $logs->name; ?></span>
                                            <?php else:?>
                                                <span class="badge " style="background-color: #0b51c5;"><?php echo $logs->name; ?></span>
                                            <?php endif;?>

                                        </td>
                                        <td class="text-center"><?php echo $logs->time_out; ?> </td>
                                        <td class="text-center"> <?php echo $logs->quantity_out;?> <?php if ($logs->type == 6): ?>Bt<?php else:?>Litres<?php endif;?> </td>
                                        <td class="text-center">

                                            <?php if ($logs->type == 1):?>
                                                <?php echo  $this->db->get_where('cd_fluid',array('station_id'=>$this->session->userdata('station_id'),'type'=>1))->row()->prix;?> Fcfa
                                            <?php elseif($logs->type == 2):?>
                                                <?php echo  $this->db->get_where('cd_fluid',array('station_id'=>$this->session->userdata('station_id'),'type'=>2))->row()->prix;?> Fcfa
                                            <?php elseif($logs->type == 3):?>
                                                <?php echo  $this->db->get_where('cd_fluid',array('station_id'=>$this->session->userdata('station_id'),'type'=>3))->row()->prix ;?> Fcfa
                                            <?php elseif($logs->type == 4):?>
                                                <?php echo  $this->db->get_where('cd_fluid',array('station_id'=>$this->session->userdata('station_id'),'type'=>4))->row()->prix;?> Fcfa
                                            <?php elseif($logs->type == 5):?>
                                                <?php echo  $this->db->get_where('cd_fluid',array('station_id'=>$this->session->userdata('station_id'),'type'=>5))->row()->prix;?> Fcfa
                                            <?php else:?>
                                                <?php echo  $this->db->get_where('cd_fluid',array('station_id'=>$this->session->userdata('station_id'),'type'=>6))->row()->prix;?> Fcfa
                                            <?php endif;?>


                                        </td>
<!--                                        <td class="text-center"></td>-->
                                        <td class="text-center">
                                            <?php if ($logs->type == 1):?>
                                            <?php echo  $this->db->get_where('cd_fluid',array('station_id'=>$this->session->userdata('station_id'),'type'=>1))->row()->prix * $logs->quantity_out?> Fcfa
                                            <?php elseif($logs->type == 2):?>
                                                <?php echo  $this->db->get_where('cd_fluid',array('station_id'=>$this->session->userdata('station_id'),'type'=>2))->row()->prix * $logs->quantity_out?> Fcfa
                                            <?php elseif($logs->type == 3):?>
                                                <?php echo  $this->db->get_where('cd_fluid',array('station_id'=>$this->session->userdata('station_id'),'type'=>3))->row()->prix * $logs->quantity_out?> Fcfa
                                            <?php elseif($logs->type == 4):?>
                                                <?php echo  $this->db->get_where('cd_fluid',array('station_id'=>$this->session->userdata('station_id'),'type'=>4))->row()->prix * $logs->quantity_out?> Fcfa
                                            <?php elseif($logs->type == 5):?>
                                                <?php echo  $this->db->get_where('cd_fluid',array('station_id'=>$this->session->userdata('station_id'),'type'=>5))->row()->prix * $logs->quantity_out?> Fcfa
                                            <?php else:?>
                                                <?php echo  $this->db->get_where('cd_fluid',array('station_id'=>$this->session->userdata('station_id'),'type'=>6))->row()->prix * $logs->quantity_out?> Fcfa
                                            <?php endif;?>
                                        </td>
                                    </tr>



                                    <?php
                                    endforeach;
                                    else:
                                        ?>
                                        <tr>
                                            <td colspan='7'>  Aucune Stations disponible encore</td>
                                        </tr>
                                    <?php
                                    endif;
                                    ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Buttons</h5>
                                <h6 class="card-subtitle text-muted">This extension provides a framework with common options that can be used with DataTables.</h6>

                                <div class="clearfix"></div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="text" name="startDate" id="startDate" placeholder="date anterieur" class="form-control" />
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="endDate" id="endDate" placeholder="date du jour" class="form-control" />
                                        </div>
                                        <div class="col-md-4">
                                            <input type="button" name="search" id="search" value="Recherche" class="btn btn-info" />
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="card-body">
                                <table id="datatables-buttons" class="table table-striped" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>Jauge T0 </th>
                                        <th>Jauge T1 </th>
                                        <th>Quantité Restante</th>
                                        <th>Quantité Sortie</th>
                                        <th>Totalisateur T0</th>
                                        <th>Totalisateur T1</th>
                                        <th>Quantité Vendu</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if(!$count=$this->uri->segment(3))
                                        $count = 0;
                                    if(isset($jauge) && count($fluid_logs->result())>0):
                                    foreach($jauge->result() as $jg):
                                    ?>
                                    <tr>

                                        <td>	<button class="btn btn-warning" onclick="edit_jauge_one(<?php echo $jg->id;?>)"><i class="glyphicon glyphicon-pencil"></i>
                                                <?php echo $jg->jauge_to;?></button></td>


                                        <td> <?php echo $jg->jauge_t1;?></td>
                                        <td> <?php echo $jg->quantity_rest;?></td>
                                        <td> <?php echo $jg->quantity_out;?></td>
                                        <td> <?php echo $jg->totalisateur_to;?></td>
                                        <td> <?php echo $jg->totalisateur_t1;?></td>
                                        <td> <?php echo $jg->quantity_sel;?></td>
                                    </tr>

                                    <?php
                                    endforeach;
                                    else:
                                        ?>
                                        <tr>
                                            <td colspan='7'>  Aucune information</td>
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

                <script>
                    document.addEventListener("DOMContentLoaded", function(event) {
                        // Datatables basic
                        $('#datatables-basic').DataTable({
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



                <script>
                    document.addEventListener("DOMContentLoaded", function(event) {
                        // Select2
                        $('.select2').each(function() {
                            $(this)
                                .wrap('<div class="position-relative"></div>')
                                .select2({
                                    placeholder: 'Select value',
                                    dropdownParent: $(this).parent()
                                });
                        })
                        // Daterangepicker
                        $('input[name="daterange"]').daterangepicker({
                            opens: 'left'
                        });
                        $('input[name="datetimes"]').daterangepicker({
                            timePicker: true,
                            opens: 'left',
                            startDate: moment().startOf('hour'),
                            endDate: moment().startOf('hour').add(32, 'hour'),
                            locale: {
                                format: 'hh:mm A'
                            }
                        });
                        $('input[name="datesingle"]').daterangepicker({
                            singleDatePicker: true,
                            showDropdowns: true
                        });
                        var start = moment().subtract(29, 'days');
                        var end = moment();

                        function cb(start, end) {
                            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                        }
                        $('#reportrange').daterangepicker({
                            startDate: start,
                            endDate: end,
                            ranges: {
                                'Today': [moment(), moment()],
                                'Yesterday': [moment().subtract(1, 'jours'), moment().subtract(1, 'jours')],
                                'Last 7 Days': [moment().subtract(6, 'jours'), moment()],
                                'Last 30 Days': [moment().subtract(29, 'jours'), moment()],
                                'This Month': [moment().startOf('month'), moment().endOf('month')],
                                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                            }
                        }, cb);
                        cb(start, end);
                    });



                    // Arrondissement
                    $('#cat_id').change(function(){
                        var catId = $(this).val();
                        $.ajax({
                            url: '<?php echo site_url('items/get_sub_cats');?>/'+catId,
                            method: 'GET',
                            dataType: 'JSON',
                            success:function(data){
                                $('#sub_cat_id').html("");
                                $.each(data, function(i, obj){
                                    $('#sub_cat_id').append('<option value="'+ obj.id +'">' + obj.name + '</option>');
                                });
                                $('#name').val($('#name').val() + " ").blur();
                            }
                        });
                    });

                    $('#sub_cat_id').on('change', function(){
                        $('#name').val($('#name').val() + " ").blur();
                    });

                    // Selecte Quartier

                    $('#sub_cat_id').change(function(){
                        var catId = $(this).val();
                        $.ajax({
                            url: '<?php echo site_url('items/get_quartier_station');?>/'+catId,
                            method: 'GET',
                            dataType: 'JSON',
                            success:function(data){
                                $('#twon_id').html("");
                                $.each(data, function(i, obj){
                                    $('#twon_id').append('<option value="'+ obj.id +'">' + obj.name + '</option>');
                                });
                                $('#name').val($('#name').val() + " ").blur();
                            }
                        });
                    });

                    $('#twon_id').on('change', function(){
                        $('#name').val($('#name').val() + " ").blur();
                    });


                </script>




                <script>
                    var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());

                    $('#startDate').datepicker({
                        uiLibrary: 'bootstrap4',
                        iconsLibrary: 'fontawesome',
                        minDate: function () {
                            return $('#startDate').val();
                        }
                    });
                    $('#endDate').datepicker({
                        uiLibrary: 'bootstrap4',
                        iconsLibrary: 'fontawesome',
                        minDate: today,
                        maxDate: function () {
                            return $('#endDate').val();
                        }
                    });
                </script>



            </div>

        </div>
    </div>
</main>




<!-- BEGIN  modal -->

<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Jauge a T0</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="form" class="form-horizontal">
            <div class="card-body">
                <input  class="form-control form-control-lg mb-3" name="jauge_to" id="jauge_to" type="number" placeholder="Entrez le niveau de la Jauge">
                <input type="hidden" value="" name="id" id="id"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ferme</button>
<!--                <button type="button" type="submit" id="btnSave" onclick="save_jauge_one()" class="btn btn-primary">OK</button>-->
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">ok</button>

            </div>
            </form>


        </div>
    </div>
</div>
<!-- END  modal -->


<script type="text/javascript">
    $(document).ready( function () {
        $('#datatables-buttons').DataTable();
    } );
    var save_method; //for save method string
    var table;


    function edit_jauge_one(id)
    {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo base_url('reglage/ajax_edit/')?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id"]').val(data.id);
                $('[name="jauge_to"]').val(data.jauge_to);

                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Jauge T0'); // Set title to Bootstrap modal title
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Erreur d`affichage de donnees');
            }
        });
    }



    function save()
    {
        var url;
        if(save_method == 'add')
        {
            url = "<?php echo base_url('reglage/jauge_to_update')?>";
        }
        else
        {
            url = "<?php echo base_url('reglage/jauge_to_update')?>";
        }
        // ajax adding data to database
        $.ajax({
            url : url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data)
            {
                //if success close modal and reload ajax table
                $('#modal_form').modal('hide');
                location.reload();// for reload a page
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Erreur de modification de la jauge T0');
            }
        });
    }


</script>
