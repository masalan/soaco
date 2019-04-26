
<div class="col-12 col-md-12 col-lg-12 col-xl-12 pl-lg-4">

    <div class="row">
        <div class="col-6 col-xl-3 d-flex">
            <div class="card flex-fill">
                <div class="card-body py-3">
                    <div class="row">
                        <div class="col-12 col-sm-4 align-self-center text-center text-sm-left">
                            <div class="icon icon-primary">
                                <i class="align-middle" data-feather="truck"></i>
                            </div>
                        </div>
                        <div class="col-12 col-sm-8 align-self-center text-center text-sm-right">
                            <p class="text-muted mb-1">Notes journalière</p>
                            <h2><i class="text-primary fas fa-caret-up"></i> <?php echo $this->db->where(array('type_msg'=>1,'station_id'=>$station_id))->from("cd_inquiries")->count_all_results();?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3 d-flex">
            <div class="card flex-fill">
                <div class="card-body py-3">
                    <div class="row">
                        <div class="col-12 col-sm-4 align-self-center text-center text-sm-left">
                            <div class="icon icon-danger">
                                <i class="align-middle" data-feather="users"></i>
                            </div>
                        </div>
                        <div class="col-12 col-sm-8 align-self-center text-center text-sm-right">
                            <p class="text-muted mb-1"><?php echo html_entity_decode($societe->fullname );?></p>
                            <h2><i class="text-primary fas fa-caret-up"></i> <?php echo $this->db->where(array('type_msg'=>2,'station_id'=>$station_id))->from("cd_inquiries")->count_all_results();?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3 d-flex">
            <div class="card flex-fill">
                <div class="card-body py-3">
                    <div class="row">
                        <div class="col-12 col-sm-4 align-self-center text-center text-sm-left">
                            <div class="icon icon-success">
                                <i class="align-middle" data-feather="dollar-sign"></i>
                            </div>
                        </div>
                        <div class="col-12 col-sm-8 align-self-center text-center text-sm-right">
                            <p class="text-muted mb-1">SOACO</p>
                            <h2><i class="text-primary fas fa-caret-up"></i> <?php echo $this->db->where(array('type_msg'=>3,'station_id'=>$station_id))->from("cd_inquiries")->count_all_results();?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3 d-flex">
            <div class="card flex-fill">
                <div class="card-body py-3">
                    <div class="row">
                        <div class="col-12 col-sm-4 align-self-center text-center text-sm-left">
                            <div class="icon icon-warning">
                                <i class="align-middle" data-feather="shopping-cart"></i>
                            </div>


                        </div>
                        <div class="col-12 col-sm-8 align-self-center text-center text-sm-right">
                            <p class="text-muted mb-1">Système Alerts</p>
                            <h2><i class="text-primary fas fa-caret-up"></i> <?php echo $this->db->where(array('type_msg'=>4,'station_id'=>$station_id))->from("cd_inquiries")->count_all_results();?> </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>











<div class="col-12 col-md-12 col-lg-12 col-xl-12 pl-lg-12">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Messages reçu <span class="badge badge-success"><?php echo $this->db->where(array('is_sending_by_station'=>0,'station_id'=>$station_id))->from("cd_inquiries")->count_all_results();?></span></h5>
                    <h6 class="card-subtitle text-muted"></h6>
                </div>
                <div class="card-body">
                    <table id="datatables-basic" class="table table-striped" style="width:100%">
                        <thead>
                        <tr>
                            <th>Type</th>
                            <th>Titre</th>
                            <th>Contenue</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <?php if(isset($email) && count($email->result())>0):
                            foreach($email->result() as $msg): ?>

                                <tbody>
                                <tr>
                                    <?php if ($msg->type_msg==1):?>
                                        <td><span class="badge badge-success">Notes</span></td>
                                    <?php elseif($msg->type_msg == 2):?>
                                        <td><span class="badge badge-warning"><?php echo html_entity_decode($societe->fullname );?></span></td>
                                    <?php elseif($msg->type_msg == 3):?>
                                        <td><span class="badge badge-info">SOACO e-Station</span></td>
                                    <?php else:?>
                                        <td><span class="badge badge-danger">Systeme</span></td>
                                    <?php endif;?>

                                    <td style="font-size: 10px;"> <?php echo $msg->titre_msg;?></td>
                                    <td style="font-size: 10px;"> <?php echo $msg->message;?></td>
                                    <td style="font-size: 10px;"><?php echo time_ago($msg->added);?></td>

                                    <td class="d-none d-xl-table-cell text-center">
                                        <?php if($msg->is_read == 1):?>
                                            <span class="badge badge-info"> <a style="color: white;"  href=" <?php echo site_url("mail/unread/".$msg->id);?>">lu</a></span>
                                        <?php else:?>
                                            <span class="badge badge-danger"> <a style="color: white;" href=" <?php echo site_url("mail/read/".$msg->id);?>">Non lu</a></span>
                                        <?php endif;?>
                                    </td>

                                </tr>
                                </tbody>
                            <?php endforeach;else: ?>
                            <tbody>
                            <td colspan='7'>
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <div class="alert-icon">
                                        <i class="far fa-fw fa-bell"></i>
                                    </div>
                                    <div class="alert-message">
                                        <strong>Bonjour Mr <?php echo html_entity_decode($user->fullname)?:0;?>!</strong> Aucune message encore recu!
                                    </div>
                                </div>
                            </td>
                            </tbody>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Messages envoyé <span class="badge badge-success"><?php echo $this->db->where(array('is_sending_by_station'=>1,'station_id'=>$station_id))->from("cd_inquiries")->count_all_results()?:0;?></span></h5>
                    <h6 class="card-subtitle text-muted"></h6>
                </div>
                <div class="card-body">
                    <table id="datatables-buttons" class="table table-striped" style="width:100%">
                        <thead>
                        <tr>
                            <th>Type</th>
                            <th>Titre</th>
                            <th>Contenue</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <?php if(isset($sent) && count($sent->result())>0):
                            foreach($sent->result() as $msg): ?>

                                <tbody>
                                <tr>
                                    <?php if ($msg->type_msg==1):?>
                                        <td><span class="badge badge-success">Notes</span></td>
                                    <?php elseif($msg->type_msg == 2):?>
                                        <td><span class="badge badge-warning"><?php echo html_entity_decode($societe->fullname );?></span></td>
                                    <?php elseif($msg->type_msg == 3):?>
                                        <td><span class="badge badge-info">SOACO e-Station</span></td>
                                    <?php else:?>
                                        <td><span class="badge badge-danger">Systeme</span></td>
                                    <?php endif;?>

                                    <td style="font-size: 10px;"> <?php echo $msg->titre_msg;?></td>
                                    <td style="font-size: 10px;"> <?php echo $msg->message;?></td>
                                    <td style="font-size: 10px;"><?php echo time_ago($msg->added);?></td>


                                    <td class="d-none d-xl-table-cell text-center">
                                        <?php if($msg->is_read == 1):?>
                                            <span class="badge badge-info"> <a style="color: white;"  >lu</a></span>
                                        <?php else:?>
                                            <span class="badge badge-danger"> <a style="color: white;" >Non lu</a></span>
                                        <?php endif;?>
                                    </td>



                                </tr>
                                </tbody>
                            <?php endforeach;else: ?>
                            <tbody>
                            <td colspan='7'>
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <div class="alert-icon">
                                        <i class="far fa-fw fa-bell"></i>
                                    </div>
                                    <div class="alert-message">
                                        <strong>Bonjour Mr <?php echo html_entity_decode($user->fullname);?>!</strong> Aucune message encore recu!
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

    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            // Datatables basic
            $('#datatables-basic').DataTable({
                responsive: true,
                pageLength: 3

            });
            // Datatables with Buttons
            var datatablesButtons = $('#datatables-buttons').DataTable({
                lengthChange: !1,
                pageLength: 6,
                responsive: true
            });
            datatablesButtons.buttons().container().appendTo("#datatables-buttons_wrapper .col-md-6:eq(0)")
        });
    </script>



    <script>
        $(document).ready(function(){
            $(document).delegate('.publish','click',function(){
                var btn = $(this);
                var id = $(this).attr('catid');
                $.ajax({
                    url: '<?php echo site_url('mail/publish');?>/'+id,
                    method:'GET',
                    success:function(msg){
                        if(msg == 'true')
                            btn.addClass('unpublish').addClass('btn-primary')
                                .removeClass('publish').removeClass('btn-danger')
                                .html('OUI');
                        else
                            alert('System error occured. Please contact your system administrator.');
                    }
                });
            });

            $(document).delegate('.unpublish','click',function(){
                var btn = $(this);
                var id = $(this).attr('catid');
                $.ajax({
                    url: '<?php echo site_url('mail/unpublish');?>/'+id,
                    method:'GET',
                    success:function(msg){
                        if(msg == 'true')
                            btn.addClass('publish').addClass('btn-danger')
                                .removeClass('unpublish').removeClass('btn-primary')
                                .html('NON');
                        else
                            alert('System error occured. Please contact your system administrator.');
                    }
                });
            });

        });

    </script>

</div>