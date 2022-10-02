<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DispUser $dispUser
 */
?>

<?php
$this->assign('title', __('Disp User'));
$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'List Disp Users', 'url' => ['action' => 'index']],
    ['title' => 'View'],
]);
?>

<div class="view card card-primary card-outline">
  <div class="card-header d-sm-flex">
    <h2 class="card-title"><?= h($dispUser->id) ?></h2>
  </div>
  <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $dispUser->has('user') ? $this->Html->link($dispUser->user->id, ['controller' => 'Users', 'action' => 'view', $dispUser->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Dispositivo') ?></th>
            <td><?= $dispUser->has('dispositivo') ? $this->Html->link($dispUser->dispositivo->id, ['controller' => 'Dispositivos', 'action' => 'view', $dispUser->dispositivo->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($dispUser->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($dispUser->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($dispUser->modified) ?></td>
        </tr>
    </table>
  </div>
  <div class="card-footer d-flex">
    <div class="">
      <?= $this->Form->postLink(
          __('Delete'),
          ['action' => 'delete', $dispUser->id],
          ['confirm' => __('Are you sure you want to delete # {0}?', $dispUser->id), 'class' => 'btn btn-danger']
      ) ?>
    </div>
    <div class="ml-auto">
      <?= $this->Html->link(__('Edit'), ['action' => 'edit', $dispUser->id], ['class' => 'btn btn-secondary']) ?>
      <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
    </div>
  </div>
</div>


