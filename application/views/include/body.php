
<div id="page-wrapper">

  <div class="row">

    <div class="col-lg-12 table-responsive">
      <div class="row">

        <?php if (isset($search_form)): ?>
          
              <div class="col-sm-6">
                <h2>
                  <?php echo $icon . ' ' . ucwords($title); ?> 
                </h2>
              </div>
              <div class="col-sm-4 col-sm-offset-2">
                <?php
                  if (isset($search_form)) 
                  {
                    echo $search_form;
                  }
                 ?>
              </div>

        <?php else: ?>

              <div class="col-sm-12">
                <h2>
                  <?php echo $icon . ' ' . ucwords($title); ?> <!-- <small class='pull-right'><?php echo $subtitle; ?></small> -->
                </h2>
              </div>

        <?php endif ?>
      </div>


      <ol class="breadcrumb">
        <li>UMCAS</li>
        <li><a href="<?php echo base_url().strtolower($controller);?>"><?php echo $icon . ' ' . ucwords( $this->router->fetch_class() );?></a></li>
        <li><a href="#" class="active"><?php echo $icon . ' ' . ucwords( $this->router->fetch_method() );?></a></li>
      </ol>
      <?php if ($this->session->flashdata('error')): ?>
        
      <div class="alert alert-info alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <p>
          <?php echo $this->session->flashdata('error'); ?>            
        </p>
      </div>
      
      <?php endif ?>

      <?php $this->load->view($content); ?>

      <?php /*$this->output->enable_profiler(config_item('left_nav'));*/ ?>
    </div>

  </div><!-- /.row -->

</div><!-- /#page-wrapper -->