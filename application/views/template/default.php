<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo config_item('site_title') ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        
        <!-- bootstrap 3.0.2 -->
        <?php echo link_tag('public/css/bootstrap.min.css'); ?>
        
        <!-- font Awesome -->
        <?php echo link_tag('public/css/font-awesome.min.css'); ?>
        
        <!-- Ionicons -->
        <?php echo link_tag('public/css/ionicons.min.css'); ?>
        
        <!-- Theme style -->
        <?php echo link_tag('public/css/AdminLTE.css'); ?>

        <?php echo link_tag('public/css/override.css'); ?>
        

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
         <script type="text/javascript" src="<?php echo base_url();?>public/js/jquery.min.js" ></script>
        <style type="text/css">
        span.deci { font-weight: bold;}
        </style>
    </head>
    <body class="skin-black">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="<?php echo base_url('dashboard') ?>" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <?php echo config_item('site_name') ?>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $this->session->userdata('FirstName') ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="<?php echo site_url('public/img') ?>/avatar3.png" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php echo $this->session->userdata('FirstName') ?>
                                        <?php echo $this->session->userdata('MiddleName') ?>
                                        <?php echo $this->session->userdata('LastName') ?>
                                        <small>Date of Birth <?php echo date("M d, Y", strtotime($this->session->userdata('Birthday'))) ?></small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <!-- 
                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>
                                 -->
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <?php 
                                        // Filter user account per user
                                        if ($this->session->userdata('AccountType') === 'S') 
                                        {
                                     ?>
                                        <div class="pull-left">
                                            <a href="<?php echo base_url("user/" . $this->session->userdata('Id') . "/edit" ) ?>" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                    <?php 
                                        }
                                     ?>

                                    <div class="pull-right">
                                        <a href="<?php echo site_url('site/logout') ?>" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        
        <div class="wrapper row-offcanvas row-offcanvas-left">
            
            <?php echo $this->load->view('template\sidebar') ?>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1 title="<?php echo isset($page_subtitle) ? $page_subtitle : ""; ?>">
                        <?php echo $page_title ?>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo site_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
                        <li><a href="<?php echo site_url( $this->router->fetch_class() ) ?>"><?php echo ucwords( str_replace('_', ' ', $this->router->fetch_class()) ) ?></a></li>
                        <li class="active" title="<?php echo $page_title; ?>"><?php echo ellipsize($page_title, 20, .5);  ?></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content <?= ! isset($invoice) || print("invoice ") ?>">

                <?php if (validation_errors()): ?>
                    
                    <div class="alert alert-danger alert-dismissable no-print">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>The following errors have occurred.</strong>
                        <ul>            
                            <?php echo validation_errors(); ?>
                        </ul>
                    </div>

                <?php endif ?>


                <?php if ($this->session->flashdata('error')): ?>
                    
                    <div class="alert alert-danger alert-dismissable no-print">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>
                            <?php echo $this->session->flashdata('error'); ?>
                        </strong>
                    </div>

                <?php endif ?>

                <?php if ($this->session->flashdata('success')): ?>

                    <div class="alert alert-success alert-dismissable no-print">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>
                            <?php echo $this->session->flashdata('success'); ?>
                        </strong>
                    </div>

                <?php endif ?>

                <?php if ($this->session->flashdata('message')): ?>
                    
                    <div class="alert alert-info alert-dismissable no-print">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>
                            <?php echo $this->session->flashdata('message'); ?>
                        </strong>
                    </div>

                <?php endif ?>
                
                <?php 
                    if ($this->session->flashdata('dialog_box'))
                    echo $this->session->flashdata('dialog_box');
                ?>

                <?php echo $this->load->view($content) ?>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->


        <!-- jQuery 2.0.2 -->
        <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script> -->
      

        <!-- Bootstrap -->
       <link href="<?php echo base_url('/assets') ?>/bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet">
       <link rel="stylesheet" href="<?php echo base_url()?>assets/datepicker/css/datepicker3.css">
       
       <script type="text/javascript" src="<?php echo base_url();?>public/js/bootstrap.min.js" ></script>
       <script src="<?php echo base_url('/assets') ?>/bootstrap-editable/js/bootstrap-editable.js"></script>
        
        <!-- AdminLTE App -->
       <script type="text/javascript" src="<?php echo base_url();?>public/js/AdminLTE/app.js" ></script>


       <script src="<?php echo base_url()?>assets/js/autoNumeric.js"></script>
       <script src="<?php echo base_url()?>assets/js/jquery.number.js"></script>
       <script src="<?php echo base_url()?>public/js/plugins/input-mask/jquery.inputmask.js"></script>
       
       <!-- bootstrap datepicker -->
       <script src="<?php echo base_url()?>assets/datepicker/js/bootstrap-datepicker.js"></script>


       <script src="<?php echo base_url()?>assets/js/jquery-ui.min.js"></script>
       <?php echo link_tag('assets/css/jquery-ui.structure.min.css'); ?>
       <?php echo link_tag('assets/css/jquery-ui.min.css'); ?>
       
       <script src="<?php echo base_url()?>assets/js/selectize.js"></script>
       <?php echo link_tag('assets/css/selectize.bootstrap3.css'); ?>
       <!-- select2 -->
       <?php echo link_tag('assets/css/select2.min.css'); ?>
       <script src="<?php echo base_url()?>assets/js/select2.min.js"></script>

       <!-- custom-style -->
       <?php echo link_tag('assets/css/custom-style.css'); ?>
       <script>
       $(function(){

         $("#inputproject").on("change", function(e) {
            //get a reference to the select element
            $select = $('#project_bill_id');
            //request the JSON data and parse into the select element
            

            $select.select2();

            $.getJSON('<?php echo base_url('combine_billing/get_billing_period') ?>/' + this.value, function(data) {
                var output = "";
                $.each(data, function(key, val) {
                    output += '<option value="' + key + '" data-foo="">' + val + '</option>';
                });
                $select.html(output);

            });
            
            $select.val(0).trigger("change");

         });

       });
       </script>

       
       <!-- Custom JS -->
       <script type="text/javascript" src="<?php echo base_url();?>assets/js/scripts.js" ></script>

       <script>
        $(document).ready(function() {


            //toggle `popup` / `inline` mode
            $.fn.editable.defaults.mode = 'popup';
            $.fn.editableform.buttons = '<div class="editable-buttons"><div class="btn-group" style="display:inline-flex"><button type="submit" class="btn btn-primary btn-sm editable-submit" title="Save Changes"><i class="glyphicon glyphicon-ok"></i></button><button type="button" class="btn btn-default btn-sm editable-cancel" title="Cancel"><i class="glyphicon glyphicon-remove"></i></button></div></div>';

            
            //make editable
            $('#billing a.editable').editable({
                tpl: '<input style="width:60px;">',
                validate: function (value) {
                    var intRegex = /^\d+(?:\.\d\d?)?$/;
                    if (!intRegex.test(value)) {
                        return 'Invalid entry Digits Only';
                    }
                },
                display: function (value, sourceData) {
                    $('.deci').number(true, 2)
                },
                success: function (data, newValue) {
                    // if ( ! data.errors) 
                    if ( data.success == true) 
                    {
                        console.log(data.newValue)
                        console.log(data)
                        console.log(data.rate_name)
                        console.log("subtotal = " + data.subtotal)

                        if ($.trim(data.cola))
                        {
                            $(this).closest('tr').find('td.cola>code.cola').html(data.cola)
                            $('#total_cola').html(data.total_cola)
                        }

                        if ($.trim(data.allowance))
                        {
                            $(this).closest('tr').find('td.allowance>code.allowance').html(data.allowance)
                            $('#total_allowance').html(data.total_allowance)
                        }
                        
                        $('#spanValue,span.deci,code.deci').number(true, 2)
                        
                        var msg = 'Record <span class="deci">' + newValue + '</span> has been successfully updated!'
                        // var total_amt = '<span class="deci">' + (newValue * data.rate)  + '</span>'
                        var total_amt = '<span class="deci">' + data.total_amt  + '</span>'
                        $(this).html('<span class="deci">' + newValue + '</span>').closest('td').next('td').html(total_amt)

                        $(this).closest('tr').find('th:last').html('<span class="deci">' + data.subtotal + '</span>')
                        $(this).closest('table').find('th:last').html('<span class="deci">' + data.grandtotal + '</span>')
                        
                        $(this).closest('table').find('th' + data.rate_name).html('<span class="deci">' + data.column1total + '</span>')
                        $(this).closest('table').find('th' + data.rate_name + '_amount').html('<span class="deci">' + data.column2total + '</span>')

                        $('#msg').addClass('alert-success').removeClass('alert-danger').html(msg).show()
                        $(this).closest('a.editable').focus()
                        $(this).closest('tr').addClass('success')
                    } 
                    else if(data.errors) 
                    {
                        $('#msg').addClass('alert-danger').removeClass('alert-success').html('<strong>' + data.errors + '</strong>').show()
                    }
                    else
                    {
                        $('#msg').addClass('alert-danger').removeClass('alert-success').html(data).show()
                        // location.reload()
                    }
                }
            });

            $('#billing a').on('shown', function(e, editable) {
                // editable.input.$input.number( true, 2 );
                editable.input.$input.autoNumeric( 'init', {'mDec': 2} );
                $this = $(this);
                if(arguments.length == 2 ) {
                    setTimeout(function() { $this.data('editable').input.$input.select(); }, 50);
                }
            });

            $('#billing a').on('hidden', function(e, reason) {
                console.log(reason)
                //auto-open next editable
                if(reason === 'save' || reason === 'nochange') {
                    var td = $(this).closest('td');
                    if (td.is(':nth-last-child(3)')) {
                        $(this).closest('tr').next().find('td:nth-child(4) .editable').editable('show');
                    } else {
                        $(this).closest('td').next('td').next('td').find('.editable').editable('show');
                    }
                } 
            });


            $('input').on('click', function(){this.select();})
            $('#msg').hide();

            <?php 
            if ($this->router->fetch_class() == 'Project_billing_info') 
            {
                echo "$('multiple-select2').selectize({ plugins: ['remove_button', 'drag_drop']});";
            }
            ?>
            // $('.multiple-select2').select2();

            window.setTimeout(function() { 
                $(".alert").fadeTo(500, 0).slideUp(500, function(){
                      $(this).remove();
                  });
            }, 10000);
        });
       </script>
       
    </body>
</html>

