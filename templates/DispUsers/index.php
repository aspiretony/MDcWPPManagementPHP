<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DispUser[]|\Cake\Collection\CollectionInterface $dispUsers
 */
?>
<?php
$this->assign('title', __('Usuários do Dispositivo'));
$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'Listar Usuários Atrelados ao Dispositivo'],
]);
?>

<div class="card card-primary card-outline">
    <div class="card-header d-sm-flex">
        <h2 class="card-title">
            <!-- -->
        </h2>
        <div class="card-toolbox">
            <?= $this->Paginator->limitControl([], null, [
                'label' => false,
                'class' => 'form-control-sm',
            ]); ?>
            <?= $this->Html->link(__('Atrelar novo usuário ao dispositivo'), ['action' => 'add'], ['class' => 'btn btn-primary btn-sm']) ?>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('dispositivo_id') ?></th>
                    <th><?= $this->Paginator->sort('Adicionado') ?></th>
                    <th><?= $this->Paginator->sort('Modificado') ?></th>
                    <th class="actions"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dispUsers as $dispUser) : ?>
                    <tr>
                        <td><?= $this->Number->format($dispUser->id) ?></td>
                        <td><?= $dispUser->has('user') ? $this->Html->link($dispUser->user->email, ['controller' => 'Users', 'action' => 'view', $dispUser->user->id]) : '' ?></td>
                        <td><?= $dispUser->has('dispositivo') ? $this->Html->link($dispUser->dispositivo->nome, ['controller' => 'Dispositivos', 'action' => 'view', $dispUser->dispositivo->id]) : '' ?></td>
                        <td><?= h($dispUser->created) ?></td>
                        <td><?= h($dispUser->modified) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $dispUser->id], ['class' => 'btn btn-xs btn-outline-primary', 'escape' => false]) ?>
                            <?= $this->Form->postLink(__('Deletar'), ['action' => 'delete', $dispUser->id], ['class' => 'btn btn-xs btn-outline-danger', 'escape' => false, 'confirm' => __('Certeza de deletar a integração ID # {0}?', $dispUser->id)]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->

    <div class="card-footer d-md-flex paginator">
        <div class="mr-auto" style="font-size:.8rem">
            <?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, Mostrando {{current}} Resultados de um Total de {{count}}')) ?>
        </div>
        <ul class="pagination pagination-sm">
            <?= $this->Paginator->first('<i class="fas fa-angle-double-left"></i>', ['escape' => false]) ?>
            <?= $this->Paginator->prev('<i class="fas fa-angle-left"></i>', ['escape' => false]) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('<i class="fas fa-angle-right"></i>', ['escape' => false]) ?>
            <?= $this->Paginator->last('<i class="fas fa-angle-double-right"></i>', ['escape' => false]) ?>
        </ul>
    </div>
    <!-- /.card-footer -->
</div>
