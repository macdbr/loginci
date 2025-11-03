
 <?php $this->load->view('dashboard/layout/navbar'); ?> 

 <div class="container-fluid">
  <div class="row">

    <?php $this->load->view('dashboard/layout/sidebar'); ?> 

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>

        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <a class="btn btn-sm btn-outline-primary" href="<?php echo base_url('dashboard/funcionarios');?>" role="button">Listar funcionários</a>                     
          </div>
        </div>
      </div>
    
      <div class="row">
        <div class="col-md-12 text-center mt-4">
          <h2>Seja Bem-vindo(a) ao Sistema de Cadastro de Funcionários(as)</h2>
          <i style="font-size: 15rem;" class="bi bi-person-vcard text-primary"></i>
        </div>        
      </div>

      <!-- card -->

     
      </div>
    </main>
  </div>
</div>

</body>
</html>