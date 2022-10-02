<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Dispositivo $dispositivo
 */
?>

<?php
$this->assign('title', __('Dispositivo'));
$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'Listar Dispositivos', 'url' => ['action' => 'index']],
    ['title' => 'Ver Dispositivos'],
]);
?>

<div class="view card card-primary card-outline">
  <div class="card-header d-sm-flex">
    <h2 class="card-title">ID #<?= h($dispositivo->id) ?></h2>
  </div>
  <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
        <tr>
            <th><?= __('API de Uso Externo') ?></th>
            <td><?php
                echo base64_encode($dispositivo->id.'|'.$dispositivo->sessao.'|'.$dispositivo->token);
                ?></td>
        </tr>
        <tr>
            <th><?= __('Nome') ?></th>
            <td><?= h($dispositivo->nome) ?></td>
        </tr>
        <tr>
            <th><?= __('Token') ?></th>
            <td><?= h($dispositivo->token) ?></td>
        </tr>
        <tr>
            <th><?= __('Sessão') ?></th>
            <td><?= h($dispositivo->sessao) ?></td>
        </tr>
        <tr>
            <th><?= __('Número') ?></th>
            <td><?= h($dispositivo->numero) ?></td>
        </tr>
        <tr>
            <th><?= __('Criado') ?></th>
            <td><?= h($dispositivo->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modificado') ?></th>
            <td><?= h($dispositivo->modified) ?></td>
        </tr>
        <tr>
            <th><?= __('Status Atual') ?></th>
            <td><?= 'Retorno: '.$response->status.'<br>
                     Mensagem do Servidor: '. PHP_EOL;
                if ($response->message == 'Connected'){
                    echo '<span class="badge bg-success">CONECTADO</span>';
                }else{
                    '<span class="badge bg-danger">DESCONECTADO</span>';
                }
                $response->message;
                ?></td>
        </tr>
    </table>
  </div>
  <div class="card-footer d-flex">
    <div class="">
      <?= $this->Form->postLink(
          __('Deletar Dispositivo'),
          ['action' => 'delete', $dispositivo->id],
          ['confirm' => __('Tem certeza que quer deletar o dispositivo id # {0}?', $dispositivo->id), 'class' => 'btn btn-danger']
      ) ?>
    </div>
    <div class="ml-auto">
      <?= $this->Html->link(__('Editar Dispositivo'), ['action' => 'edit', $dispositivo->id], ['class' => 'btn btn-secondary']) ?>
      <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
    </div>
  </div>
</div>

<div class="view text card">
  <div class="card-header">
    <h3 class="card-title"><?= __('Descrição') ?></h3>
  </div>
  <div class="card-body">
    <?= $this->Text->autoParagraph(h($dispositivo->descricao)); ?>
  </div>
</div>

<div class="related related-dispUsers view card">
  <div class="card-header d-sm-flex">
    <h3 class="card-title"><?= __('Usuários do Dispositivo (Permissões de Acesso)') ?></h3>
    <div class="card-toolbox">
      <?= $this->Html->link(__('Adicionar Novo Usuário ao Dispositivo'), ['controller' => 'DispUsers' , 'action' => 'add'], ['class' => 'btn btn-primary btn-sm']) ?>
      <?= $this->Html->link(__('Listar Completa'), ['controller' => 'DispUsers' , 'action' => 'index'], ['class' => 'btn btn-secondary btn-sm']) ?>
    </div>
  </div>
  <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
      <tr>
          <th><?= __('Id') ?></th>
          <th><?= __('UUID do Usuário') ?></th>
          <th><?= __('ID do Dispositivo') ?></th>
          <th><?= __('Adionado') ?></th>
          <th><?= __('Modificado') ?></th>
          <th class="actions"><?= __('Ações') ?></th>
      </tr>
      <?php if (empty($dispositivo->disp_users)) { ?>
        <tr>
            <td colspan="6" class="text-muted">
            Não foi possivel encontrar nenhum usuário atrelado a este dispositivo
            </td>
        </tr>
      <?php }else{ ?>
        <?php foreach ($dispositivo->disp_users as $dispUsers) : ?>
        <tr>
            <td><?= h($dispUsers->id) ?></td>
            <td><?= h($dispUsers->user_id) ?></td>
            <td><?= h($dispUsers->dispositivo_id) ?></td>
            <td><?= h($dispUsers->created) ?></td>
            <td><?= h($dispUsers->modified) ?></td>
            <td class="actions">
              <?= $this->Html->link(__('Visualizar'), ['controller' => 'DispUsers', 'action' => 'view', $dispUsers->id], ['class'=>'btn btn-xs btn-outline-primary']) ?>
              <?= $this->Html->link(__('Editar'), ['controller' => 'DispUsers', 'action' => 'edit', $dispUsers->id], ['class'=>'btn btn-xs btn-outline-primary']) ?>
              <?= $this->Form->postLink(__('Deletar'), ['controller' => 'DispUsers', 'action' => 'delete', $dispUsers->id], ['class'=>'btn btn-xs btn-outline-danger', 'confirm' => __('Are you sure you want to delete # {0}?', $dispUsers->id)]) ?>
            </td>
        </tr>
        <?php endforeach; ?>
      <?php } ?>
    </table>
  </div>
</div>

