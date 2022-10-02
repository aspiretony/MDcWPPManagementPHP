<div class="user-panel mt-3 pb-3 mb-3 d-flex">
  <div class="image">
    <?= $this->Html->image('https://faculdadesantaluzia.edu.br/wp-content/uploads/2019/04/sem-imagem-avatar.png', ['class'=>'img-circle elevation-2', 'alt'=>'User Image']) ?>
  </div>
  <div class="info">
    <a href="#" class="d-block">

    <?php
  echo $this->getRequest()->getAttribute('identity')['first_name'] ?? null;

    ?>
    </a>
  </div>
</div>
