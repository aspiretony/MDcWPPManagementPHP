<?php
/*var_dump($conteudo);
*/?>
<!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
<?= $this->Flash->render() ?>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">

                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Edição do servidor</h3>
                        </div>

                        <div class="card-body">
                                <?php
                                echo $this->Form->create(null, [
                                    'url' => [
                                        'controller' => 'Server',
                                        'action' => 'update'
                                    ]
                                ]);
                                ?>
                                <div class="card-body">
                                    <h6 class="card-title">Configurações Iniciais:</h6>
                                    <p class="card-text">Configuração Inicial do servidor WPPConnect.<b> Geralmente só é necessário alterar a Chave Secreta </b></p>
                                </div>
<!--                                <div class="row">
                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <label>Chave Secreta</label>
                                            <input type="text" name="secretKey" class="form-control" value="<?/*= $conteudo->secretKey */?>" placeholder="Enter ...">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Host</label>
                                            <input type="text" name="host" class="form-control" value="<?/*= $conteudo->host */?>" placeholder="Enter ...">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <label>Porta</label>
                                            <input type="text" name="port" class="form-control" value="<?/*= $conteudo->port */?>" placeholder="Enter ...">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Nome Browser</label>
                                            <input type="text" name="deviceName" class="form-control" value="<?/*= $conteudo->deviceName */?>" placeholder="Enter ...">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <label>poweredBy</label>
                                            <input type="text" name="poweredBy" class="form-control" value="<?/*= $conteudo->poweredBy */?>" placeholder="Enter ...">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Armazenamento de Tokens (não mexer se não souber)</label>
                                            <input type="text" name="tokenStoreType" class="form-control" value="<?/*= $conteudo->tokenStoreType */?>" placeholder="Enter ...">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <label>Conexões Máximas</label>
                                            <input type="text" name="maxListeners" class="form-control" value="<?/*= $conteudo->maxListeners */?>" placeholder="Enter ...">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>UserData > MD WPP</label>
                                            <input type="text" name="customUserDataDir" class="form-control" value="<?/*= $conteudo->customUserDataDir */?>" placeholder="Enter ...">
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <div class="form-check">
                                                <input name="startAllSession" class="form-check-input" type="checkbox" <?php
/*                                                switch ($conteudo->startAllSession){
                                                    case true:
                                                       echo 'checked';
                                                }
                                                */?>>
                                                <label class="form-check-label">Iniciar todas as Sesssões juntas?</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <label>WebHook</label>
                                            <input type="text" name="WebhookUrl" class="form-control"
                                                   value="<?/*= $conteudo->webhook->url */?>" placeholder="Endereço do WebHook">
                                        </div>
                                    </div>
                                </div>-->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Configs</label>
                                    <textarea class="form-control" rows="15" placeholder="Enter ..." name="json"><?= $conteudo ?></textarea>
                                </div>
                            </div>
                            <?php
                            echo $this->Form->button('Salvar',['class' => 'btn btn-primary']);
                            echo $this->Form->end();
                            ?>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.col-md-6 -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="m-0">Gerenciar Servidor (Módulo em Construção)</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title">LIGAR O SERVIDOR</h6>

                            <p class="card-text">Caso não funcione, verifique as configurações .ini do seu PHP.</p>
                            <a href="#" class="btn btn-success">Ligar</a>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title">DESLIGAR O SERVIDOR</h6>

                            <p class="card-text">Caso não funcione, verifique as configurações .ini do seu PHP.</p>
                            <a href="#" class="btn btn-danger" disabled>Desligar</a>
                        </div>
                    </div>


                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->


<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
    </div>
</aside>
<!-- /.control-sidebar -->

