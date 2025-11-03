
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
            <a class="btn btn-sm btn-outline-primary" href="<?php echo base_url('dashboard/funcionarios/cadastro');?>" role="button">Cadastrar</a>        
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card shadow">
            <div class="card-header d-block">
              <h4>Lista de funcionários cadastrados</h4>
            </div>
            <div class="card-body">

              <!-- MELHORAR ISSO!!!!! -->
              <?php if($message = $this->session->flashdata('sucesso')){?>
                <div class="alert alert-success alert-dismissible show fade">
                  <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                      <span>&times;</span>
                    </button>
                    <?php echo $message;?>
                  </div>
                </div>
              <?php } ?>  
              <!-- MELHORAR ISSO!!!!! -->

              <?php if($message = $this->session->flashdata('erro')){?>
                <div class="alert alert-danger alert-dismissible show fade">
                  <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                      <span>&times;</span>
                    </button>
                    <?php echo $message;?>
                  </div>
                </div>
              <?php } ?>        


              <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm">
                  <thead>
                    <tr>
                      <th class="nosort">Ação</th>
                      <th>ID</th>
                      <th>Nome</th>
                      <th>Email</th>
                      <th>Data admissão</th>                      
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    foreach($funcionarios as $funcionario){
                      echo '<tr id="lnf'.$funcionario->id.'">';
                      echo '  <td data-label="Ação"><a title="Editar" href="'.base_url('dashboard/funcionarios/editar/'.$funcionario->id).'" class="btn btn-icon btn-outline-primary"><i class="bi bi-pencil-square"></i></a>&nbsp';
                      echo '  <button type="button" class="btn btn-outline-danger btn-excluir" data-bs-toggle="modal" data-bs-target="#modalExcluir" data-id="'.$funcionario->id.'"><i class="bi bi-trash3"></i></button></td>';
                      echo '  <td data-label="ID">'.$funcionario->id.'</td>';
                      echo '  <td data-label="Nome">'.$funcionario->name.'</td>';
                      echo '  <td data-label="Email">'.$funcionario->email.'</td>';
                      echo '  <td data-label="Data admissão">'.date("d/m/Y", strtotime($funcionario->admission_date)).'</td>';   
                      echo "</tr>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              
              <!-- Token CSRF escondido -->
              <input type="hidden" id="csrf_token_name" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
 

              <!-- Modal Confirmar -->
              <div class="modal fade" id="modalExcluir" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Confirmar exclusão</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                      Deseja realmente excluir este(a) funcionário(a)?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                      <button type="button" class="btn btn-danger" id="btnConfirmarExcluir">Excluir</button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Modal simples -->
              <div class="modal fade" id="meuModal" tabindex="-1" aria-labelledby="tituloModal" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="tituloModal">Aviso de exclusão</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                      <p>Funcionário(a) excluído(a) com sucesso.</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" id="btnOk" class="btn btn-success">OK</button>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>

      </div>
    </main>
  </div>
</div>



<script>


$(document).ready(function() {
  let usuarioID = null;

  // Instancia o modal via Bootstrap
  var meuModal = new bootstrap.Modal(document.getElementById('meuModal'));

  
  // Quando clica no botão de excluir
  $('.btn-excluir').on('click', function() {
    usuarioID = $(this).data('id');
  });

  // Quando confirma exclusão
  $('#btnConfirmarExcluir').on('click', function() {
    const csrfName = $('#csrf_token_name').attr('name'); // nome do token
    const csrfHash = $('#csrf_token_name').val();        // valor do token

    //alert(usuarioID+" "+csrfHash);

    $('#modalExcluir').modal('hide');

    $.ajax({
      url: '<?= site_url("dashboard/funcionarios/excluir") ?>',
      type: 'POST',
      data: {
        id: usuarioID,
        [csrfName]: csrfHash // adiciona o token CSRF
      },
      dataType: 'json',
      success: function(response) {
        if (response.status === 'ok') { 
          $("#lnf"+usuarioID).remove();       
          meuModal.show();

          // Quando clicar em OK
          $('#btnOk').on('click', function() {  
            meuModal.hide();
            //window.location = BASE_URL+'dashboard/funcionarios';
          });          

        } else {
          alert('Erro ao excluir o usuário.');
        }
        
        $('#csrf_token_name').val(response.csrf_hash); // Atualiza o token CSRF
      },
      error: function() {
        alert('Ocorreu um erro na requisição.');
      }
    });


  });
});









/*$(document).ready(function() {
  let idUsuarioSelecionado = null;

  // Quando o botão "Excluir" é clicado
  $('.btn-excluir').on('click', function() {
    idUsuarioSelecionado = $(this).data('id'); // pega o ID do botão clicado
    //console.log('ID selecionado:', idUsuarioSelecionado);
  });

  // Quando o usuário confirma a exclusão
  $('#btnConfirmarExclusao').on('click', function() {
    if (idUsuarioSelecionado) {
      //alert("ID:"+idUsuarioSelecionado);    
      
      var csrf_token = $("#csrf_test_name").val();
      var form_data = new FormData();
      form_data.append('id', idUsuarioSelecionado);
      form_data.append('csrf_token', csrf_token);


      $.ajax({
        url: '<?= site_url("dashboard/funcionarios/excluir") ?>', // URL do método no controller
          type: 'POST',
          dataType: 'text',
          data: form_data, // Envia os dados do formulário
          processData: false, // Prevents jQuery from processing the data
          contentType: false,
          success: function(response) {   
            if (response.status === 'sucesso') {

              alert("FOI: "+response.mensagem);

            } else {             
              // Display field-specific errors              
            }
            // atualiza o token CSRF, caso use vários envios)
            $("#<?= $this->security->get_csrf_token_name(); ?>").val(response.csrf_token);
          },
          error: function() {
            //$('.mensagem').html('<p style="color:red;">Erro ao enviar os dados!</p>');
            //$('.alert').show(100);
          }
        });





Vamos ao contexto, usando codeigniter 3 dado uma lista de usuários em uma tabela e usando bootstrap 5 e um modal com confirmação para 
excluir como fazer para cada botão da lista passar a id do usuário para um jquery e nesse jquery recuperar o ID pelo botão clicado.
Obtenho o seguinte erro:

An Error Was Encountered

The action you have requested is not allowed.












    }
  });
});*/
</script>

</body>
</html>

