<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DispUser $dispUser
 */
?>
<?php
$this->assign('title', __('Atrelar usuário ao dispositivo'));
$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'Listar Usuários Atrelados ao Dispositivo', 'url' => ['action' => 'index']],
    ['title' => 'Novo'],
]);
?>

<div class="card card-primary card-outline">
  <?= $this->Form->create($dispUser) ?>
  <div class="card-body">
    <?php
      echo $this->Form->control('user_id', ['options' => $users]);
      echo $this->Form->control('dispositivo_id', ['options' => $dispositivos]);
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

