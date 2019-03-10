


<div class="box">
<div class="box-header">
    <div class="row">
        <div class="col-sm-8">
            <h3 class="box-title">
                <?php #echo btn_achor('project_employee/'.$project->project_id.'/detail', '<strong><i class="fa fa-home"></i> Project</strong>', array('class' => 'btn btn-default')) ?>
                <?php #echo btn_new(site_url('projectBillingInfo/'.$project->project_id.'/new'), 'New Billing Period') ?>
            </h3>
            </div>
        <div class="col-sm-4"></div>
    </div>
</div>
<div class="box-body table-responsive">
<table class="table table-hover table-condensed">
	<thead>
		<tr>
            <th>Billing Title</th>
            <th>Billing Address</th>
			<th>Project</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>

    <?php if (count($combine_billings)): ?>
    			<?php foreach ($combine_billings as $cb): ?>
    				<tr>
                        <td><?php echo $cb->cb_title ?></td>
                        <td><?php echo $cb->cb_address ?></td>
    					<td>
                        <?php if (count($cb->projects)): ?>

                            <?php foreach ($cb->projects as $project): ?>
                                <strong><?php echo $project->title ?></strong> 
                                <?php 
                                    if (!empty($project->fields)) 
                                    {
                                        // echo str_replace(',', ', ', );
                                        $display_column = '';
                                        foreach (explode(',', $project->fields) as $key) 
                                        {
                                            $display_column .= $proj_rate_arr[$key] . ', ';
                                        }
                                        echo '<br>' . substr($display_column, 0, strlen($display_column) - 2) . '<br>';
                                    }
                                ?>
                                 (<small><span class="text-muted">Billing Period</span> <em><?php echo date('M d, Y', strtotime($project->date_start)) ?> to <?php echo date('M d, Y', strtotime($project->date_end)) ?></em></small>)
                                <br>
                            <?php endforeach ?>

                        <?php else: ?>
                            <span class="lead">No project selected</span>
                        <?php endif ?>

    					</td>


    					<td>
	    					<div class="btn-group btn-block">
	    					    <?php echo btn_edit('combine_billing/'. $cb->cb_id . '/edit');?>
	    					    <?php #echo anchor(site_url('projectBillingTrans/' . $project->project_id . '/'. $billing->project_bill_id . '/download'), '<i class="fa fa-paperclip"></i>', ['class' => 'btn btn-success', 'title' => 'Billing Attachment', 'target' => '_blank'])?>

	    					    <div class="btn-group" role="group" >
	    					       <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Billing Invoice">
	    					         <i class="fa fa-print"></i>
	    					       </button>
	    					       <ul class="dropdown-menu pull-right">
                                        <li><?php echo anchor(site_url('projectBillingTrans/' . $cb->cb_id . '/invoice_by_rate'), 'Invoice per Position', ['title' => 'Invoice per Position', 'target' => '_blank'])?></li>
	    					            <li><?php echo anchor(site_url('projectBillingTrans/' . $cb->cb_id . '/invoice_by_position'), 'Invoice Cost Summary', ['title' => 'Invoice Cost Summary', 'target' => '_blank'])?></li>
	    					       </ul>
	    					    </div>


	    					    <?php echo btn_delete('combine_billing/' . $cb->cb_id . '/delete');?>
	    					</div>
    					</td>
    				</tr>
    			<?php endforeach ?>
     
    <?php else: ?>
        <tr>
            <td colspan="6">
                <p class="label label-danger">No record found!. Please try again.</p>
            </td>
        </tr>
    <?php endif ?>
    </tbody>

</table>
</div>
<div class="box-footer">
    <?php
    if (isset($pagination))
        echo $pagination;
    ?>
</div>
</div>
<?php
/**
 * Created by PhpStorm.
 * User: Brando
 * Date: 8/31/14
 * Time: 9:32 PM
 */