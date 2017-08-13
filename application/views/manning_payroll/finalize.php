<div class="row">
	<div class="col-xs-12">
		<!-- Info box -->
		<div class="box box-success">
		    <div class="box-header">
		        <h3 class="box-title">Finalization Success</h3>
		        <h3 class="box-title">
		        	<b><?= $payroll->title ?></b> Payroll has been successfully finalized. <br>To print payroll or pay slip click the button below this box:
		        </h3>
		    </div>
		    <div class="box-body table-responsive no-padding">
			    <table class="table table-hover">
			    	<tbody>
			    		<tr>
			    			<th colspan="1">Project</th>
			    			<td colspan="3"><?= $payroll->title ?></td>
			    		</tr>
			    		<tr>
			    			<th>Pay Period</th>
			    			<td><?= payroll_date($payroll->date_start) ?> To: <?= payroll_date($payroll->date_end) ?></td>
			    			<th>Date Finalized</th>
			    			<td><?= payroll_date($payroll->DateFinalized, 'F j, Y H:iA') ?></td>
			    		</tr>
			    	</tbody>
			    </table>
		    </div><!-- /.box-body -->
		    <div class="box-footer text-right">
		        <?php echo anchor('manning_payroll/print_payroll/' . $payroll->payroll_id, '<i class="fa fa-print"></i> Print Payroll', ['class' => 'btn btn-warning', 'target' => '_blank', 'title' => 'Print Payroll'])?>
		        <?php echo anchor('manning_payroll/print_payslip/' . $payroll->payroll_id, '<i class="fa fa-print"></i> Print Payslip', ['class' => 'btn btn-success', 'title' => 'Print Payslip', 'target' => '_blank'])?>
		    </div><!-- /.box-footer-->
		</div><!-- /.box -->
	</div>
</div>