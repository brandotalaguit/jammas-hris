<?php $this->load->view('include/header'); ?>

<style type="text/css">
	body {
		background: url("../assets/img/low_contrast_linen.png") repeat 0 0;
	}
</style>

<div class="modal show">
  <div class="modal-dialog">
    <div class="modal-content">
      <?php $this->load->view($subview); ?>
      <div class="modal-footer">
        <p class="footer">University Of Makati Employees Multi Purpose Cooperative &copy; <?php echo date('Y'); ?></p>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('include/footer'); ?>