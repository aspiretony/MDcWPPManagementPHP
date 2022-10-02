<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Dispositivo $dispositivo
 */
?>
<?php
$this->assign('title', __('Editar Dispositivo'));
$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'Listar Dispositivos', 'url' => ['action' => 'index']],
    ['title' => 'Ver Dispositivo', 'url' => ['action' => 'view', $dispositivo->id]],
    ['title' => 'Editar'],
]);
?>

<div class="card card-primary card-outline">
  <?= $this->Form->create($dispositivo) ?>
  <div class="card-body">
    <?php
      echo $this->Form->control('nome');
      echo $this->Form->control('numero');
      echo $this->Form->control('descricao');
    ?>
  </div>

  <div class="card-footer d-flex">
    <div class="">
      <?= $this->Form->postLink(
          __('Deletar Dispositivo'),
          ['action' => 'delete', $dispositivo->id],
          ['confirm' => __('Certeza que quer deletar o dispositivo # {0}?', $dispositivo->nome), 'class' => 'btn btn-danger']
      ) ?>
    </div>
    <div class="ml-auto">
      <?= $this->Form->button(__('Salvar')) ?>
      <?= $this->Html->link(__('Voltar'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
    </div>
  </div>

  <?= $this->Form->end() ?>
</div>

