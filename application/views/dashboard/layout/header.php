<?php $param = rand(0,999); ?>
  <!DOCTYPE html>
  <html lang="en"><head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $titulo;?></title>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('public/assets/bootstrap/bootstrap.min.css');?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Favicons -->
    <link rel="icon" href="<?php echo base_url('public/images/bootstrap-logo.png');?>">
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url('public/assets/css/dashboard.css?p='.$param);?>" rel="stylesheet">
    <script src="<?php echo base_url('public/assets/bootstrap/bootstrap.bundle.min.js');?>" ></script>
    <script src="<?php echo base_url('public/assets/jquery/jquery-3.7.1.min.js.js');?>" ></script>
    <script src="<?php echo base_url('public/assets/js/feather.min.js');?>" ></script>
    <script src="<?php echo base_url('public/assets/js/util.js?p='.$param);?>"></script>
    <script src="<?php echo base_url('public/assets/js/dashboard.js?p='.$param);?>"></script>

    </head>
    <body>