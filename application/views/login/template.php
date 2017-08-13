<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>Jammas Inc. | Log in</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        
        <!-- bootstrap 3.0.2 -->
        <?php echo link_tag('public/css/bootstrap.min.css'); ?>
        
        <!-- font Awesome -->
        <?php echo link_tag('public/css/font-awesome.min.css'); ?>
        
        <!-- Theme style -->
        <?php echo link_tag('public/css/AdminLTE.css'); ?>
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-black">

        
        <?php echo $this->load->view($content) ?>


        <!-- jQuery 2.0.2 -->
        <script type="text/javascript" src="<?php echo base_url();?>public/js/jquery.min.js" ></script>
        
        <!-- Bootstrap -->
        <script type="text/javascript" src="<?php echo base_url();?>public/js/bootstrap.min.js" ></script>

    </body>
</html>