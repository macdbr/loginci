
<?php $this->load->view('dashboard/layout/navbar'); ?> 

<div class="container-fluid">
  <div class="row">

    <?php $this->load->view('dashboard/layout/sidebar'); ?> 

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

        <h1 class="h2">Funcionários</h1>

        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <a class="btn btn-sm btn-outline-primary" href="<?php echo base_url('dashboard/home');?>" role="button">Dashboard</a>
            <a class="btn btn-sm btn-outline-primary" href="<?php echo base_url('dashboard/funcionarios');?>" role="button">Listar funcionários</a> 
            <a class="btn btn-sm btn-outline-primary" href="<?php echo base_url('dashboard/funcionarios/cadastro');?>" role="button">Cadastrar</a>        
          </div>
        </div>
      </div>

      <?php if($funcionario_id > 0){ ?>

        <div class="row">
          <div class="col-md-6">        
            <div class="card shadow">              
              <form id="form_editar">
                <div class="card-header">
                  <h4>Editar funcionário</h4>
                </div>
                <div class="card-body">

                  <div style="display: none;" class="alert alert-primary alert-dismissible fade show" role="alert">
                    <strong class="mensagem"></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                  
                  <div class="form-group">
                    <label>ID:<?php echo $funcionario_id;?></label>
                  </div>

                  <div class="form-group">
                    <label>Nome</label>
                    <input type="text" name="name" class="form-control" placeholder="Nome" value="<?php echo (isset($funcionario) ? $funcionario->name : set_value('name'));?>">
                    <div class="name_error text-danger error-message"></div>
                  </div>

                  <div class="form-group ">
                    <label>Email</label>
                    <input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo (isset($funcionario) ? $funcionario->email : set_value('email'));?>">
                    <div class="email_error text-danger error-message"></div>
                  </div>

                  <div class="form-group">
                    <label>Cargo</label>
                    <input type="text" name="position" class="form-control" placeholder="Cargo" value="<?php echo (isset($funcionario) ? $funcionario->position : set_value('position'));?>">
                    <p class="position_error text-danger error-message"></p>
                  </div>

                  <div class="form-group">
                    <label>Salário</label>
                    <input type="text" placeholder="0,00" name="salary" class="form-control salary" placeholder="0,00" value="<?php echo (isset($funcionario) ? $funcionario->salary : set_value('salary'));?>">
                    <p class="salary_error text-danger error-message"></p>
                  </div>

                  <div class="form-group">
                    <label>Data admissão</label>
                    <input type="date" name="admission_date" class="form-control" value="<?php echo (isset($funcionario) ? $funcionario->admission_date : set_value('admission_date'));?>">
                    <p class="admission_date_error text-danger error-message"></p>
                  </div>

                </div>   

                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                <input type="hidden" name="id" value="<?php echo $funcionario_id;?>" />

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary mr-2">Salvar</button>
                </div>
              </form>             

            </div>
          </div>
          <div class="col-md-6 text-center mt-4"><i style="font-size: 10rem;" class="bi bi-person-fill-gear text-primary"></i></div>
        </div>

      <?php }else{ ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong class="mensagem"><?php echo $mensagem;?></strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php }?>          

    </main>
  </div>
</div>

<script src="<?php echo base_url('public/assets/jquery/jquery.mask.min.js');?>"></script>
<script src="<?php echo base_url('public/assets/js/custom.js');?>"></script>
<script>
  $(document).ready(function() {
    $('#form_editar').on('submit', function(e) {
      e.preventDefault(); // Evita o envio normal do form    
      let form = $(this);       

      $.ajax({
        url: '<?= site_url("dashboard/funcionarios/editar_submit") ?>', // URL do método no controller
          type: 'POST',
          dataType: 'json',
          data: $(this).serialize(), // Envia os dados do formulário
          success: function(response) {   
            $('.error-message').text(''); // Clear previous errors
            if (response.status === 'sucesso') {
              $('.mensagem').html('<p>' + response.mensagem + '</p>');
              $('.alert').show(100);
              $('#form_cadastro')[0].reset(); // limpa o formulário
            } else {
              $('.mensagem').html('<p style="color:red;">' + response.mensagem + '</p>');
              $('.alert').show(100);
              // Display field-specific errors
              $.each(response.errors, function(field, message) {
                $('.' + field + '_error').text(message);
              });

            }
            // atualiza o token CSRF, caso use vários envios)
            form.find('input[name="<?= $this->security->get_csrf_token_name(); ?>"]').val(response.csrf_token);
          },
          error: function() {
            $('.mensagem').html('<p style="color:red;">Erro ao enviar os dados!</p>');
            $('.alert').show(100);
          }
        });
      });
  });
</script>
</body>
</html>