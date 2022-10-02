<!-- Add icons to the links using the .nav-icon class
     with font-awesome or any other icon font library -->
<li class="nav-item has-treeview menu-open">
  <a href="#" class="nav-link active">
    <i class="nav-icon fas fa-tachometer-alt"></i>
    <p>
      MENU ADMIN
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">

<!--        --><?php
/*        echo $this->Html->link(
            'CONFIGURAR SERVIDOR',
            ['controller' => 'Server', 'action' => 'index', '_full' => true],
            ['class' => 'nav-link'],
            ['escape' => false]
        );
        */?>
      <a href="<?= $this->Url->build('/configs', ['fullBase' => true])?>" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>CONFIGURAR SERVIDOR</p>
      </a>
    </li>
  </ul>
</li>

<li class="nav-item has-treeview menu-open">
    <a href="#" class="nav-link active">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
            MENU PRINCIPAL
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">

            <!--        --><?php
            /*        echo $this->Html->link(
                        'CONFIGURAR SERVIDOR',
                        ['controller' => 'Server', 'action' => 'index', '_full' => true],
                        ['class' => 'nav-link'],
                        ['escape' => false]
                    );
                    */?>
            <a href="<?= $this->Url->build('/dispositivos', ['fullBase' => true])?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>DISPOSITIVOS</p>
            </a>
        </li>
<!--        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Inactive Page</p>
            </a>
        </li>-->
        <li class="nav-item">
            <a href="<?= $this->Url->build('/webhooks/exemplos', ['fullBase' => true])?>" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                   EXEMPLOS DE API
                    <span class="right badge badge-danger">New</span>
                </p>
            </a>
        </li>
    </ul>
</li>

