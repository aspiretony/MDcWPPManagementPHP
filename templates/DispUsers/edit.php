<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DispUser $dispUser
 */
?>
<?php
$this->assign('title', __('Edit Disp User'));
$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'List Disp Users', 'url' => ['action' => 'index']],
    ['title' => 'View', 'url' => ['action' => 'view', $dispUser->id]],
    ['title' => 'Edit'],
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
    <div class="">
      <?= $this->Form->postLink(
          __('Delete'),
          ['action' => 'delete', $dispUser->id],
          ['confirm' => __('Are you sure you want to delete # {0}?', $dispUser->id), 'class' => 'btn btn-danger']
      ) ?>
    </div>
    <div class="ml-auto">
      <?= $this->Form->button(__('Save')) ?>
      <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
    </div>
  </div>

  <?= $this->Form->end() ?>
</div>

