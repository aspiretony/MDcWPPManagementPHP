<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Dispositivo $dispositivo
 */
?>
<?php
$this->assign('title', __('Add Dispositivo'));
$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'Listar Dispositivos', 'url' => ['action' => 'index']],
    ['title' => 'Adicionar Novo'],
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
    <div class="ml-auto">
      <?= $this->Form->button(__('Salvar')) ?>
      <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
    </div>
  </div>

  <?= $this->Form->end() ?>
</div>

