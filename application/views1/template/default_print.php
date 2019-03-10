<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo config_item('site_title') ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        
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
    <body class="skin-blue print">

        <h1>
            <?php echo $page_title ?>
        </h1>
        <?php echo $this->load->view($content) ?>
        
    </body>
</html>

