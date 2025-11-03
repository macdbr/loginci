<!DOCTYPE html>
<html lang="en" class="h-100"><head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <title><?php echo $titulo;?></title>
  <!-- Bootstrap core CSS -->
  <link href="<?php echo base_url('public/assets/bootstrap/bootstrap.min.css');?>" rel="stylesheet">
  <!-- Favicons -->
  <link rel="icon" href="<?php echo base_url('public/images/bootstrap-logo.png');?>">   
  <!-- Custom styles for this template -->
  <link href="<?php echo base_url('public/assets/css/sticky-footer-navbar.css');?>" rel="stylesheet">
  <link href="<?php echo base_url('public/assets/css/style.css');?>" rel="stylesheet">
  <script src="<?php echo base_url('public/assets/bootstrap/bootstrap.bundle.min.js');?>" ></script>
  </head>
  <body class="d-flex flex-column h-100">

    <header>
      <!-- Fixed navbar -->
      <nav class="navbar navbar-expand-md navbar-light fixed-top bg-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="<?php echo base_url();?>"><img src="<?php echo base_url('public/images/logo.png');?>" /></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarCollapse"></div>
        </div>
      </nav>
    </header>

 

<!-- Begin page content -->
<main class="flex-shrink-0">
  <div class="container text-center">
    <h1 class="mt-5">Bem-vindo ao Sistema de Cadastro de Funcionários</h1>

    <div class="row">
      <div class="col-md-3 ms-sm-auto"></div>
      <div class="col-md-6 ms-sm-auto form-signin">

        <?php 
          if(!empty($error)){
            echo '<div class="alert alert-danger alert-dismissible show fade">';
            echo '  <div class="alert-body">';
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            echo '    <strong>'.$error.'</strong>';
            echo '  </div>';
            echo '</div>';
          }
        ?>

        <div class="card mb-4 shadow" >
          <div class="card-body">
            <h4 class="card-title mb-3">Acesse sua conta</h4>
            
            <?php 
              $atributos = array(
                'class'=> 'needs-validation'
              );
            ?>

            <?php echo form_open('dashboard/login/autenticar', ['method' => 'post']); ?>

              <div class="form-floating">
                <input value="" required type="email" class="form-control" name="email" placeholder="name@example.com">
                <label for="email">Seu Email</label>
              </div>
              <div class="form-floating">
                <input value="" required type="password" class="form-control" name="password" placeholder="Password">
                <label for="password">Senha</label>
              </div>
              <button class="w-100 btn btn-lg btn-primary" type="submit">Entrar</button>

            <?php echo form_close(); ?>

          </div>
        </div>       
        

      </div>
      <div class="col-md-3 ms-sm-auto"></div>
    </div>

    <p class="lead">
      Este sistema foi desenvolvido para simplificar o processo de cadastro e administração de funcionários da empresa.
      Aqui, você pode registrar novos colaboradores, atualizar informações e manter os dados sempre organizados e seguros.
    </p>
    
    </div>
  </main>

  <footer class="footer mt-auto py-3t">
    <div class="container">
      <small class="text-muted"><i><?php echo date('Y');?>&nbsp;LOGINCI - Sistema de Cadastro de Funcionários :: 
      Teste Técnico - Desenvolvedor (CodeIgniter 3)</i></small>



    </div>
  </footer>  

</body></html>