<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<?php
$this->assign('title', __('User'));
$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'List Users', 'url' => ['action' => 'index']],
    ['title' => 'View'],
]);
?>

<div class="view card card-primary card-outline">
  <div class="card-header d-sm-flex">
    <h2 class="card-title"><?= h($user->username) ?></h2>
  </div>
  <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= h($user->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Username') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th><?= __('Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th><?= __('First Name') ?></th>
            <td><?= h($user->first_name) ?></td>
        </tr>
        <tr>
            <th><?= __('Last Name') ?></th>
            <td><?= h($user->last_name) ?></td>
        </tr>
        <tr>
            <th><?= __('Api Token') ?></th>
            <td><?= h($user->api_token) ?></td>
        </tr>
        <tr>
            <th><?= __('Secret') ?></th>
            <td><?= h($user->secret) ?></td>
        </tr>
        <tr>
            <th><?= __('Role') ?></th>
            <td><?= h($user->role) ?></td>
        </tr>
        <tr>
            <th><?= __('Token Expires') ?></th>
            <td><?= h($user->token_expires) ?></td>
        </tr>
        <tr>
            <th><?= __('Activation Date') ?></th>
            <td><?= h($user->activation_date) ?></td>
        </tr>
        <tr>
            <th><?= __('Tos Date') ?></th>
            <td><?= h($user->tos_date) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($user->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($user->modified) ?></td>
        </tr>
        <tr>
            <th><?= __('Last Login') ?></th>
            <td><?= h($user->last_login) ?></td>
        </tr>
        <tr>
            <th><?= __('Secret Verified') ?></th>
            <td><?= $user->secret_verified ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th><?= __('Active') ?></th>
            <td><?= $user->active ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th><?= __('Is Superuser') ?></th>
            <td><?= $user->is_superuser ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
  </div>
  <div class="card-footer d-flex">
    <div class="">
      <?= $this->Form->postLink(
          __('Delete'),
          ['action' => 'delete', $user->id],
          ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'btn btn-danger']
      ) ?>
    </div>
    <div class="ml-auto">
      <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id], ['class' => 'btn btn-secondary']) ?>
      <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
    </div>
  </div>
</div>

<div class="view text card">
  <div class="card-header">
    <h3 class="card-title"><?= __('Additional Data') ?></h3>
  </div>
  <div class="card-body">
    <?= $this->Text->autoParagraph(h($user->additional_data)); ?>
  </div>
</div>

<div class="related related-dispUsers view card">
  <div class="card-header d-sm-flex">
    <h3 class="card-title"><?= __('Related Disp Users') ?></h3>
    <div class="card-toolbox">
      <?= $this->Html->link(__('New'), ['controller' => 'DispUsers' , 'action' => 'add'], ['class' => 'btn btn-primary btn-sm']) ?>
      <?= $this->Html->link(__('List '), ['controller' => 'DispUsers' , 'action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
    </div>
  </div>
  <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
      <tr>
          <th><?= __('User Id') ?></th>
          <th><?= __('Dispositivo Id') ?></th>
          <th><?= __('Id') ?></th>
          <th><?= __('Created') ?></th>
          <th><?= __('Modified') ?></th>
          <th class="actions"><?= __('Actions') ?></th>
      </tr>
      <?php if (empty($user->disp_users)) { ?>
        <tr>
            <td colspan="6" class="text-muted">
              Disp Users record not found!
            </td>
        </tr>
      <?php }else{ ?>
        <?php foreach ($user->disp_users as $dispUsers) : ?>
        <tr>
            <td><?= h($dispUsers->user_id) ?></td>
            <td><?= h($dispUsers->dispositivo_id) ?></td>
            <td><?= h($dispUsers->id) ?></td>
            <td><?= h($dispUsers->created) ?></td>
            <td><?= h($dispUsers->modified) ?></td>
            <td class="actions">
              <?= $this->Html->link(__('View'), ['controller' => 'DispUsers', 'action' => 'view', $dispUsers->id], ['class'=>'btn btn-xs btn-outline-primary']) ?>
              <?= $this->Html->link(__('Edit'), ['controller' => 'DispUsers', 'action' => 'edit', $dispUsers->id], ['class'=>'btn btn-xs btn-outline-primary']) ?>
              <?= $this->Form->postLink(__('Delete'), ['controller' => 'DispUsers', 'action' => 'delete', $dispUsers->id], ['class'=>'btn btn-xs btn-outline-danger', 'confirm' => __('Are you sure you want to delete # {0}?', $dispUsers->id)]) ?>
            </td>
        </tr>
        <?php endforeach; ?>
      <?php } ?>
    </table>
  </div>
</div>

<div class="related related-socialAccounts view card">
  <div class="card-header d-sm-flex">
    <h3 class="card-title"><?= __('Related Social Accounts') ?></h3>
    <div class="card-toolbox">
      <?= $this->Html->link(__('New'), ['controller' => 'SocialAccounts' , 'action' => 'add'], ['class' => 'btn btn-primary btn-sm']) ?>
      <?= $this->Html->link(__('List '), ['controller' => 'SocialAccounts' , 'action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
    </div>
  </div>
  <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
      <tr>
          <th><?= __('Id') ?></th>
          <th><?= __('User Id') ?></th>
          <th><?= __('Provider') ?></th>
          <th><?= __('Username') ?></th>
          <th><?= __('Reference') ?></th>
          <th><?= __('Avatar') ?></th>
          <th><?= __('Description') ?></th>
          <th><?= __('Link') ?></th>
          <th><?= __('Token') ?></th>
          <th><?= __('Token Secret') ?></th>
          <th><?= __('Token Expires') ?></th>
          <th><?= __('Active') ?></th>
          <th><?= __('Data') ?></th>
          <th><?= __('Created') ?></th>
          <th><?= __('Modified') ?></th>
          <th class="actions"><?= __('Actions') ?></th>
      </tr>
      <?php if (empty($user->social_accounts)) { ?>
        <tr>
            <td colspan="16" class="text-muted">
              Social Accounts record not found!
            </td>
        </tr>
      <?php }else{ ?>
        <?php foreach ($user->social_accounts as $socialAccounts) : ?>
        <tr>
            <td><?= h($socialAccounts->id) ?></td>
            <td><?= h($socialAccounts->user_id) ?></td>
            <td><?= h($socialAccounts->provider) ?></td>
            <td><?= h($socialAccounts->username) ?></td>
            <td><?= h($socialAccounts->reference) ?></td>
            <td><?= h($socialAccounts->avatar) ?></td>
            <td><?= h($socialAccounts->description) ?></td>
            <td><?= h($socialAccounts->link) ?></td>
            <td><?= h($socialAccounts->token) ?></td>
            <td><?= h($socialAccounts->token_secret) ?></td>
            <td><?= h($socialAccounts->token_expires) ?></td>
            <td><?= h($socialAccounts->active) ?></td>
            <td><?= h($socialAccounts->data) ?></td>
            <td><?= h($socialAccounts->created) ?></td>
            <td><?= h($socialAccounts->modified) ?></td>
            <td class="actions">
              <?= $this->Html->link(__('View'), ['controller' => 'SocialAccounts', 'action' => 'view', $socialAccounts->id], ['class'=>'btn btn-xs btn-outline-primary']) ?>
              <?= $this->Html->link(__('Edit'), ['controller' => 'SocialAccounts', 'action' => 'edit', $socialAccounts->id], ['class'=>'btn btn-xs btn-outline-primary']) ?>
              <?= $this->Form->postLink(__('Delete'), ['controller' => 'SocialAccounts', 'action' => 'delete', $socialAccounts->id], ['class'=>'btn btn-xs btn-outline-danger', 'confirm' => __('Are you sure you want to delete # {0}?', $socialAccounts->id)]) ?>
            </td>
        </tr>
        <?php endforeach; ?>
      <?php } ?>
    </table>
  </div>
</div>

