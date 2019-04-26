
 <!------List message-------->
<div class="modal fade" id="messageNonLuModal" tabindex="-1" role="dialog" aria-labelledby="followingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 id="followingModalLabel" class="modal-title"> Messages </h6>
            </div>
            <div class="modal-body px-0">
                <div class="list-group list-group-flush list-group-divider">

                    <?php
                    if(!$count=$this->uri->segment(3))
                        $count = 0;
                    if(isset($msg) && count($msg->result())>0):
                        foreach($msg->result() as $ms):
                            ?>
                            <div class="list-group-item">
                                <div class="list-group-item-figure">
                                    <a href="user-profile.html#" class="user-avatar"><img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('be_users',array('user_id'=>$ms->user_id))->row()->profile_photo;?>" alt="Johnny Day"></a>
                                </div>
                                <div class="list-group-item-body">
                                    <h5 class="list-group-item-title">
                                        <a href="user-profile.html#" style="font-size: 12px;"><?php echo $this->db->get_where('be_users',array('user_id'=>$ms->user_id))->row()->fullname;?> (<?php echo $this->db->get_where('cd_items',array('id'=>$ms->station_id))->row()->name;?>)</a>
                                    </h5>
                                    <p class="text text-truncate" style="font-size: 10px;"> <?php echo $ms->message;?> </p><span class="date"><?php echo time_ago($ms->added);?></span>
                                </div>
                                <div class="list-group-item-figure">
                                    <?php if($ms->is_read == 1):?>
                                        <a class="btn btn-sm btn-primary" href="<?php echo base_url('socle/unread/').$ms->id.'/'.$city_id ;?>">Lu</a>
                                    <?php elseif($ms->is_read == 0):?>
                                        <a  class="btn btn-sm  btn-warning" href="<?php echo base_url('socle/read/').$ms->id.'/'.$city_id  ;?>">Non Lu</a>
                                    <?php endif;?>
                                </div>
                            </div>


                        <?php
                        endforeach;
                    else:?>
                        <div class="list-group-item">

                            <div class="list-group-item-body">
                                <p class="list-group-item-text">Aucun nouveau message </p>
                            </div>

                        </div>
                    <?php endif; ?>
                </div>
                <div class="text-center p-3">
                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Ferme</button>
            </div>
        </div>
    </div>
</div>




 <!------List station-------->

 <div class="modal fade" id="listStationModal" tabindex="-1" role="dialog" aria-labelledby="followersModalLabel" aria-hidden="true">
     <!-- .modal-dialog -->
     <div class="modal-dialog modal-dialog-scrollable" role="document">
         <!-- .modal-content -->
         <div class="modal-content">
             <!-- .modal-header -->
             <div class="modal-header">
                 <h6 id="followersModalLabel" class="modal-title"> Liste de Stations </h6>
             </div><!-- /.modal-header -->
             <!-- .modal-body -->
             <div class="modal-body px-0">
                 <!-- .list-group -->
                 <div class="list-group list-group-flush list-group-divider">

                     <?php
                     if(!$count=$this->uri->segment(3))
                         $count = 0;
                     if(isset($items) && count($items->result())>0):
                         foreach($items->result() as $item):?>
                             <div class="list-group-item">
                                 <div class="list-group-item-figure">
                                     <a href="user-profile.html#" class="user-avatar"><img src="<?php echo base_url('uploads/soaco.png');?>" alt=""></a>
                                 </div>
                                 <div class="list-group-item-body">
                                     <h4 class="list-group-item-title">
                                         <a href="#"><?php echo $item->name;?></a>
                                     </h4>
                                     <p class="list-group-item-text"><?php echo $this->category->get_info($this->sub_category->get_info($item->sub_cat_id)->cat_id)->name;?>/<?php echo $this->sub_category->get_info($item->sub_cat_id)->name;?>/<?php echo $this->sub_category->get_info_quartier($item->twon_id)->name;?> </p>
                                 </div>
                                 <div class="list-group-item-figure">
                                     <?php if($item->is_published == 1):?>
                                         <a class="btn btn-sm btn-primary" href="<?php echo base_url('socle/desactif/').$item->id.'/'.$city_id  ;?>">Desactive</a>
                                     <?php else:?>
                                         <a  class="btn btn-sm  btn-warning" href="<?php echo base_url('socle/actif/').$item->id.'/'.$city_id  ;?>">Actif</a>
                                     <?php endif;?>
                                 </div><!-- /.list-group-item-figure -->
                             </div><!-- /.list-group-item -->

                         <?php endforeach;
                     else:?>
                         <div class="list-group-item">
                             <td colspan='7'>  </td>
                             <div class="list-group-item-body">
                                 <h4 class="list-group-item-title">
                                     Aucune Stations disponible encore
                                 </h4>
                             </div>
                         </div>
                     <?php endif; ?>



                 </div><!-- /.list-group -->
                 <div class="text-center p-3">
                     <!-- .spinner -->
                     <div class="spinner-border spinner-border-sm text-primary" role="status">
                         <span class="sr-only">Loading...</span>
                     </div><!-- /.spinner -->
                 </div><!-- /.loading -->
             </div><!-- /.modal-body -->
             <!-- .modal-footer -->
             <div class="modal-footer">
                 <button type="button" class="btn btn-light" data-dismiss="modal">Ferme</button>
             </div><!-- /.modal-footer -->
         </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
 </div><!-- /.modal -->

