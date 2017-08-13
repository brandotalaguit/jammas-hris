<style type="text/css">
	.popover {
		max-width: 500px;
	}

</style>
<div class="panel panel-default">
	
<table class="table table-hover">
	<thead>
		<tr>
			<th width='2%'>NO.</th>
			<th width='8%'>ACCOUNT NO.</th>
			<th width='15%'>MEMBERS NAME</th>
			<th width='7%'>CONTACT NO.</th>
			<th width='5%'>DEPARTMENT</th>
			<th width='10%'>MEMBERSHIP</th>
			<th width='5%'>STATUS</th>
			<th width='9%'>ACTION</th>
		</tr>		
	</thead>
	<tbody>
		<?php if (count($members)): ?>
			<?php foreach ($members as $member): ?>
				<tr <?php echo $this->session->flashdata('id') === $member->member_id ? "class='success'" : ''; ?>>
					<td><?php echo ++$counter; ?></td>
					<td><?php echo $member->account_no; ?></td>
					<td class="popup-ajax" 
						data-accountnos="<?php echo $member->member_id;?>" 
						data-trigger="click" data-container="body" data-placement='bottom' 
						data-html='true' data-toggle="popover" 
						data-original-title="Member Id: <?php echo $member->member_id; ?>" >
						
						<?php echo $member->lastname . ', ' . $member->firstname . ' ' . substr($member->middlename, 0, 1); ?>
						
						<?php if ($member->no_of_outstanding_loans > 0): ?>
								<span class="badge" 
										style="cursor: default;"> 
									<?php echo $member->no_of_outstanding_loans ?>
								</span>
						<?php endif; ?>
						
						<br><span class="small muted">Member since: <em> <?php echo date('m/d/y', strtotime($member->created_at)); ?></em></span>
						
					</td>					
					<td><?php echo $member->contact_nos; ?></td>					
					<td><?php echo $member->office_code; ?></td>
					<td><?php echo $member->member_status; ?></td>
					<td>
						<?php 
						if (substr($member->employment_status, 0, 7) == 'Faculty') 
						{
							echo '<span class="label label-info"><i class="fa fa-graduation-cap"></i> ';
						}
						elseif (substr($member->employment_status, 0, 5) == 'Admin') 
						{
							echo '<span class="label label-primary"><i class="fa fa-institution"></i> ';
						}
						echo $member->employment_status;
						?>
					</td>
					<td>
						<div class="btn-group">
							<?php echo btn_edit('member/'. $member->member_id . '/edit');?>
							<?php echo btn_achor('loan_receivable/'. $member->member_id . '/member', '<i class="fa fa-bar-chart-o"></i>', 'class="btn btn-info" target="_blank"');?>
							<?php echo btn_delete('member/'. $member->member_id . '/delete');?>
						</div>
					</td>
				</tr>
			<?php endforeach ?>
		<?php else: ?>
				<tr>
					<td colspan="10" class="text-center">
						<span class="label label-danger">No record found!.</span>
					</td>
				</tr>
		<?php endif ?>
	</tbody>
	
</table>


<div class="panel-footer">
	
<?php 
	if (isset($pagination)) 
	echo $pagination;	
?>
</div>

</div>

<script>
	$(function(){
		$('.popup-ajax').popover({
		        "html": true,
		        "content": function(){
		            var div_id =  "div-id-" + $.now();
		            return details_in_popup("<?php echo base_url();?>member/" + $(this).data('accountnos') + "/info", div_id)
		        }});

		function details_in_popup(link, div_id){
		    $.ajax({
		        url: link,
		        success: function(response){
		            $('#'+div_id).html(response)}});
		    return '<div id="'+ div_id +'">Loading...</div>'
		}

		$('.number').number(true, <?php echo DECIMAL_PLACES; ?>);		
	});
</script>

