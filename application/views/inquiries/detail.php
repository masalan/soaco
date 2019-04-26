			<?php
			$this->lang->load('ps', 'english');
			?>
			<ul class="breadcrumb">
				<li>
					<a href="<?php echo site_url(). "/dashboard";?>"><?php echo $this->lang->line('dashboard_label')?></a> 
					   / <span class="divider"><a href="<?php echo site_url('soaco_Liste_msg');?>">Liste Messages</a> </span>
				</li>
                <li>Message de : <small><?php echo $this->db->get_where('cd_items',array('id'=>$inquiry->station_id))->row()->name;?></small></li>
			</ul>
			<div class="wrapper wrapper-content animated fadeInRight">
				<div class="row">
					<div class="col-sm-12">

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title text-right"><small></small> <?php echo $inquiry->added;?></h5>

                                <h5 class="card-title"><small>De :</small> <?php echo $this->db->get_where('cd_items',array('id'=>$inquiry->station_id))->row()->name;?></h5>
                                <h5 class="card-subtitle text-muted"><small>Gerant :</small> <?php echo $this->db->get_where('be_users',array('user_id'=>$inquiry->user_id))->row()->fullname;?></h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <?php if ($inquiry->is_read == 0): ?>
                                    <div class="alert alert-info alert-dismissible" role="alert">
                                    <?php elseif ($inquiry->is_read == 1):?>
                                        <div class="alert alert-secondary alert-dismissible" role="alert">
                                            <?php else:?>
                                            <div class="alert alert-danger alert-dismissible" role="alert">
                                    <?php endif;?>

                                        <div class="alert-message">
                                            <h4 class="alert-heading"><?php echo $inquiry->titre_msg;?></h4>
                                            <p><?php echo $inquiry->message;?></p>
                                            <hr>
                                            <div class="btn-list">

                                                <?php
                                                $attributes = array('id' => 'item-form','enctype' => 'multipart/form-data');
                                                echo form_open(site_url('inquiries/is_read/'.$inquiry->id), $attributes);
                                                ?>
                                                <a class="btn btn-info" href="<?php echo site_url('inquiries');?>" class="btn">Retour</a>

                                                    <?php if ($inquiry->is_read == 0): ?>
                                                    <button class="btn btn-danger" type="submit">J`ai lu</button>
                                                <?php elseif ($inquiry->is_read == 1):?>
                                                    <button class="btn btn-warning" type="button">Lu!</button>
                                                <?php else:?>
                                                    <button class="btn btn-warning" type="button">Lu!</button>
                                                <?php endif;?>
                                                </form>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



<!--						<legend>--><?php //echo $this->lang->line('inquiry_info_label')?><!--</legend>-->
<!--						<table class="table table-striped table-bordered">-->
<!--							<tr>-->
<!--								<th>--><?php //echo $this->lang->line('item_name_label')?><!--</th>-->
<!--								<td>--><?php //echo $this->item->get_info($inquiry->item_id)->name;?><!--</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<th>--><?php //echo $this->lang->line('name_label')?><!--</th>-->
<!--								<td>--><?php //echo $inquiry->name;?><!--</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<th>--><?php //echo $this->lang->line('email_label')?><!--</th>-->
<!--								<td>--><?php //echo $inquiry->email;?><!--</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<th>--><?php //echo $this->lang->line('message_label')?><!--</th>-->
<!--								<td>--><?php //echo $inquiry->message;?><!--</td>-->
<!--							</tr>-->
<!--						</table>-->




					</div>
				</div>
					
			</div>