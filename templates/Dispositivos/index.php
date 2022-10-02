<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Dispositivo[]|\Cake\Collection\CollectionInterface $dispositivos
 */
?>
<?php
$this->assign('title', __('Dispositivos'));
$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'Listar Dispositivos'],
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
            <?= $this->Html->link(__('Novo Dispositivo'), ['action' => 'add'], ['class' => 'btn btn-primary btn-sm']) ?>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('nome') ?></th>
                    <th><?= $this->Paginator->sort('sessão') ?></th>
                    <th><?= $this->Paginator->sort('número') ?></th>
                    <th class="actions"><?= __('Ação') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dispositivos as $dispositivo) : ?>
                    <tr>
                        <td><?= $this->Number->format($dispositivo->id) ?></td>
                        <td><?= h($dispositivo->nome) ?></td>
                        <td><?= h($dispositivo->sessao) ?></td>
                        <td><?= h($dispositivo->numero) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('Escanear'), ['action' => 'scanner', $dispositivo->id], ['class' => 'btn btn-xs btn-outline-primary', 'escape' => false]) ?>
                            <?= $this->Html->link(__('Abrir Cadastro'), ['action' => 'view', $dispositivo->id], ['class' => 'btn btn-xs btn-outline-primary', 'escape' => false]) ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $dispositivo->id], ['class' => 'btn btn-xs btn-outline-primary', 'escape' => false]) ?>
                            <?= $this->Form->postLink(__('Deletar'), ['action' => 'delete', $dispositivo->id], ['class' => 'btn btn-xs btn-outline-danger', 'escape' => false, 'confirm' => __('Certeza de deletar o dispositivo ID # {0}?', $dispositivo->id)]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->

    <div class="card-footer d-md-flex paginator">
        <div class="mr-auto" style="font-size:.8rem">
            <?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, Mostrando {{current}} Dispositivos Cadastrados de Um Total de {{count}}')) ?>
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
