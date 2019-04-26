
<div class="container">
    <div class="row">
        <!---side bar-->
        <?php $this->load->view( 'layout/themes/sidebar.php' ); ?>
        <div class="col-12 col-md-12 col-lg-12 col-xl-12 pl-lg-12">



            <!---Services Station---->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Service de la station</h2>
                        </div>
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col"  style="width: 400px;">Niveau d’alerte</th>
                                    <th scope="col"  class="d-none d-xl-table-cell text-center" style="color: red;font-size: large; alignment: center;">Etat</th>
                                </tr>
                                </thead>
                                <?php
                                if(!$count=$this->uri->segment(3))
                                    $count = 0;
                                if(isset($serrvice_station) && count($serrvice_station->result())>0):

                                foreach($serrvice_station->result() as $ss):
                                ?>
                                <tbody>
                                <tr>
                                    <th scope="row"><?php echo ++$count;?></th>
                                    <td><span class="badge badge-info"><?php echo $ss->name;?> </span></td>
                                    <td  style="width: 400px;">
                                        <?php $attributes = array('id' => 'validation-form','enctype' => 'multipart/form-data');
                                        echo form_open(site_url('reglage/alert_fuel/'.$ss->id), $attributes); ?>
                                        <div class="input-group mb-3"  style="width: 400px;">
                                            <input type="text" class="form-control col-sm-2" data-mask="00000" value="<?php echo $ss->alert_limit;?>" name="alert_limit"  data-reverse="true" required>
                                            <input type="hidden" name="station_id" value="<?php echo $station->id;?>">
                                            <div class="input-group-append">
                                                <button class="btn btn-danger"  name="extraire">Litre(s)</button>
                                                <button class="btn btn-primary" type="submit" name="save" > Modifier</button>
                                            </div>
                                        </div>
                                        </form>

                                    </td>

                                    <td>

                                        <div class="card-body text-center">
                                            <div class="mb-3">

                                                <?php if($ss->is_active == 0):?>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn mb-1 btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            En arrêt
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="<?php echo base_url('reglage/actif_service/').$ss->id ;?>">Mettre en service</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item" href="<?php echo base_url('reglage/hidden_service/').$ss->id ;?>">Non Operationnel</a>
                                                        </div>
                                                    </div>
                                                <?php elseif($ss->is_active == 1):?>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn mb-1 btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            En service
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="<?php echo base_url('reglage/arret_service/').$ss->id ;?>">Mettre en arrêt</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item" href="<?php echo base_url('reglage/hidden_service/').$ss->id ;?>">Non Operationnel</a>
                                                        </div>
                                                    </div>
                                                <?php else:?>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn mb-1 btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Bloqué
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="<?php echo base_url('reglage/arret_service/').$ss->id ;?>">Mettre en arrêt</a>
                                                            <a class="dropdown-item" href="<?php echo base_url('reglage/actif_service/').$ss->id ;?>">Mettre en service</a>
                                                        </div>
                                                    </div>

                                                <?php endif;?>





                                            </div>
                                        </div>

                                    </td>

                                </tr>
                                <?php
                                endforeach;
                                else:?>
                                    <tbody>
                                    <td colspan='7'>
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <div class="alert-icon"><i class="far fa-fw fa-bell"></i></div>
                                            <div class="alert-message col-sm-12">
                                                Aucune marque d`huile disponible !
                                            </div>
                                        </div>
                                    </td>
                                    </tbody>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>

            </div>


            <!---Menu Oil----->
            <div class="row">


                <div class="col-12 col-lg-6 col-xxl-6 d-flex">
                    <div class="card flex-fill">
                        <div class="card-header">
                            <h5 class="card-title"><div class="spinner-border spinner-border-sm text-primary mr-2" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>Gestion de maqrque d`huile</h5>
                            <h6 class="card-subtitle text-muted"> </h6>

                        </div>

                        <div class="card-body">
                            <?php
                            $attributes = array('id' => 'validation-form','enctype' => 'multipart/form-data');
                            echo form_open(site_url('reglage/add_mark/'.$station->id), $attributes); ?>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Marque d`huile" name="name" required>
                                <input type="hidden" name="station_id" value="<?php echo $station->id?>">
                                <div class="input-group-append">
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
                            <h5 class="card-title">
                                <div class="spinner-border spinner-border-sm text-danger mr-2" role="status">
                                </div>Gestion de format d`huile
                            </h5>
                        </div>

                        <div class="card-body">

                            <?php
                            $attributes = array('id' => 'validation-form','enctype' => 'multipart/form-data');
                            echo form_open(site_url('reglage/add_format/'.$station->id), $attributes); ?>
                            <div class="mb-3">
                                    <select class="form-control select2" name="mark_id" data-toggle="select2" required>
                                    <option selected>Selectionnez de marque d`huile </option>

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
                            </div>

                            <div class="input-group mb-3">
                                <input type="text" class="form-control" data-mask="000" placeholder="Nombre de litre du format" name="name"  data-reverse="true" required>
                                <div class="input-group-append">
                                    <button class="btn btn-danger"  name="extraire">Litre(s)</button>

                                    <button class="btn btn-primary" type="submit" name="save" ><i class="align-middle mr-1 fas fa-fw fa-gas-pump"></i> Ajoutez</button>
                                </div>
                            </div>
                            <input type="hidden" class="form-control" name="type_id" value="<?php echo substr(md5(uniqid(rand(), true)), 0, 7); ?>" >
                                <input type="hidden" name="station_id" value="<?php echo $station->id;?>">
                            <input type="hidden" name="company_id" value="<?php echo $this->db->get_where('cd_items',array('id'=>$station->id))->row()->id; ?>">


                            </form>


                        </div>
                    </div>
                </div>
            </div>

            <!---Table Oil----->
            <div class="row">
                <div class="col-12 col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Maarques</h5>
                            <h6 class="card-subtitle text-muted">Liste de Marque d`huile </h6>
                        </div>
                        <table class="table">
                            <thead>
                            <tr>
                                <th style="width:40%;">Nom</th>
                                <th>Date de creation</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <?php
                            if(!$count=$this->uri->segment(3))
                                $count = 0;
                            if(isset($marks) && count($marks->result())>0):

                            foreach($marks->result() as $mk):
                            ?>
                            <tbody>
                            <tr>
                                <td><?php echo $mk->name;?></td>
                                <td class="d-none d-md-table-cell"><?php echo $mk->added;?></td>

                                <td class="table-action">
                                    <a href="#"><i class="align-middle fas fa-fw fa-trash"></i></a>
                                </td>
                            </tr>
                            </tbody>
                            <?php
                            endforeach;
                            else:?>
                                <tbody>
                                <td colspan='7'>
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <div class="alert-icon"><i class="far fa-fw fa-bell"></i></div>
                                        <div class="alert-message col-sm-12">
                                            Aucune marque d`huile disponible !
                                        </div>
                                    </div>
                                </td>
                                </tbody>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>

                <div class="col-12 col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Format d`huile (Litres)</h5>
                        </div>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th style="width:40%;">Nom</th>
                                <th>Date de creation</th>
                                <th>Actif</th>
                                <th>Supprime</th>
                            </tr>
                            </thead>
                            <?php
                            if(!$count=$this->uri->segment(3))
                                $count = 0;
                            if(isset($format) && count($format->result())>0):

                                foreach($format->result() as $mk):
                                    ?>
                                    <tbody>
                                    <tr>
                                        <td><?php echo $mk->name.' Litre(s) <br>
                                      <small>'.$this->db->get_where('cd_fuel_mark',array('id'=>$mk->mark_id))->row()->name.'<small>';?>
                                        </td>
                                        <td class="d-none d-md-table-cell"><?php echo $mk->added;?></td>

                                        <td class="table-action" style="text-align: center;">
                                            <?php if ($mk->is_active ==1):?>
                                                <a class='badge badge-warning' style="color: white;" href=" <?php echo site_url("reglage/format_unpublish/"). $mk->id;?>">OUI</a>

                                            <?php else:?>
                                                <a class='badge badge-danger'  style="color: white;" href=" <?php echo site_url("reglage/format_publish/"). $mk->id;?>">NON</a>

                                            <?php endif;?>
                                        </td>
                                        <td class="table-action" style="text-align: center;">
                                            <a class='btn-delete' href=" <?php echo site_url("reglage/delete/"). $mk->id;?>"><i class="align-middle fas fa-fw fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    </tbody>
                                <?php
                                endforeach;
                            else:?>
                                <tbody>
                                <td colspan='7'>
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <div class="alert-icon"><i class="far fa-fw fa-bell"></i></div>
                                        <div class="alert-message col-sm-12">
                                            Aucun format d`huile disponible !
                                        </div>
                                    </div>
                                </td>
                                </tbody>
                            <?php endif; ?>
                        </table>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <?php $this->pagination->initialize($pag_format);echo $this->pagination->create_links(); ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>








        </div>

    </div>
</div>
</main>




<!----Delete format oil----->
<script>
   // $(document).ready(function(){
        document.addEventListener("DOMContentLoadeds", function(event) {

            $('.btn-delete').click(function(){
            var id = $(this).attr('id');
            var btnYes = $('.btn-yes').attr('href');
            var btnNo = $('.btn-no').attr('href');
            $('.btn-yes').attr('href',btnYes+"/"+ id);
            $('.btn-no').attr('href',btnNo+"/"+ id);
        });

    });
</script>


<!-- BEGIN  modal Delete -->
<div class="modal fade" id="deleteFormat" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Suppression de Format d`huile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body">

                <p class="mb-0">Voudriez-vous supprimer tous les formats d`huile associe a votre station?</p>
                <p class="mb-0">Oui! Tous les huiles et toutes les achats seront supprimer de ce systeme</p>
                <p class="mb-0">Seulement ce format d`huile et achat associer seront supprimer de cette station</p>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">non</button>
                <a type="submit" class="btn btn-warning btn-no"  href='<?php echo site_url("reglage/delete/");?>'>OUI</a>

            </div>
        </div>
    </div>
</div>
<!-- END  modal -->










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
                format: 'M/DD hh:mm A'
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
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);
        cb(start, end);
    });
</script>





<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        // Initialize Select2 select box
        $('select[name="mark_id"]').select2({
            allowClear: true,
            placeholder: 'Select gear...',
        }).change(function() {
            $(this).valid();
        });
        // Initialize Select2 multiselect box
        $('select[name="validation-select2-multi"]').select2({
            placeholder: 'Select gear...',
        }).change(function() {
            $(this).valid();
        });
        // Trigger validation on tagsinput change
        $('input[name="validation-bs-tagsinput"]').on('itemAdded itemRemoved', function() {
            $(this).valid();
        });
        // Initialize validation
        $('#validation-form').validate({
            ignore: '.ignore, .select2-input',
            focusInvalid: false,
            rules: {
                'name': {
                    required: true,
                },
                'validation-password': {
                    required: true,
                    minlength: 6,
                    maxlength: 20
                },
                'validation-password-confirmation': {
                    required: true,
                    minlength: 6,
                    equalTo: 'input[name="validation-password"]'
                },
                'validation-required': {
                    required: true
                },
                'validation-url': {
                    required: true,
                    url: true
                },
                'mark_id': {
                    required: true
                },
                'validation-multiselect': {
                    required: true,
                    minlength: 2
                },
                'mark_id': {
                    required: true
                },
                'validation-select2-multi': {
                    required: true,
                    minlength: 2
                },
                'validation-text': {
                    required: true
                },
                'validation-file': {
                    required: true
                },
                'validation-radios': {
                    required: true
                },
                'validation-radios-custom': {
                    required: true
                },
                'validation-checkbox': {
                    required: true
                },
                'validation-checkbox-custom': {
                    required: true
                },
                'validation-checkbox-group-1': {
                    require_from_group: [1, 'input[name="validation-checkbox-group-1"], input[name="validation-checkbox-group-2"]']
                },
                'validation-checkbox-group-2': {
                    require_from_group: [1, 'input[name="validation-checkbox-group-1"], input[name="validation-checkbox-group-2"]']
                },
                'validation-checkbox-custom-group-1': {
                    require_from_group: [1, 'input[name="validation-checkbox-custom-group-1"], input[name="validation-checkbox-custom-group-2"]']
                },
                'validation-checkbox-custom-group-2': {
                    require_from_group: [1, 'input[name="validation-checkbox-custom-group-1"], input[name="validation-checkbox-custom-group-2"]']
                }
            },
            // Errors
            errorPlacement: function errorPlacement(error, element) {
                var $parent = $(element).parents('.form-group');
                // Do not duplicate errors
                if ($parent.find('.jquery-validation-error').length) {
                    return;
                }
                $parent.append(
                    error.addClass('jquery-validation-error small form-text invalid-feedback')
                );
            },
            highlight: function(element) {
                var $el = $(element);
                var $parent = $el.parents('.form-group');
                $el.addClass('is-invalid');
                // Select2 and Tagsinput
                if ($el.hasClass('select2-hidden-accessible') || $el.attr('data-role') === 'tagsinput') {
                    $el.parent().addClass('is-invalid');
                }
            },
            unhighlight: function(element) {
                $(element).parents('.form-group').find('.is-invalid').removeClass('is-invalid');
            }
        });
    });
</script>

