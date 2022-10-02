<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.10.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception\NotFoundException;

$checkConnection = function (string $name) {
    $error = null;
    $connected = false;
    try {
        $connection = ConnectionManager::get($name);
        $connected = $connection->connect();
    } catch (Exception $connectionError) {
        $error = $connectionError->getMessage();
        if (method_exists($connectionError, 'getAttributes')) {
            $attributes = $connectionError->getAttributes();
            if (isset($attributes['message'])) {
                $error .= '<br />' . $attributes['message'];
            }
        }
    }

    return compact('connected', 'error');
};

if (!Configure::read('debug')) :
    throw new NotFoundException(
        'Please replace templates/Pages/home.php with your own version or re-enable debug mode.'
    );
endif;

$cakeDescription = 'CakePHP: the rapid development PHP framework';

$this->assign('title', __('Debug'));
$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'Debug'],
]);
?>

<header>
    <div class="container text-center">
        <a href="https://github.com/aspiretony/" target="_blank" rel="noopener">
            <img alt="Logo" src="https://mdbr.tech/logo-01.png" width="350" />
        </a>
        <h1>
            Bem Vindo ao MDc WPPManagement Free(🍓)
        </h1>
    </div>
</header>

<div class="row">
    <div class="col-12">
        <div class="alert alert-info">
            <small>
                LICENÇA MIT PARA VERSÃO FREE
                É concedida permissão, gratuitamente, a qualquer pessoa que obtenha uma cópia deste software e dos arquivos de documentação associados (o "Software"), para lidar com o Software sem restrições, incluindo, sem limitação, os direitos de usar, copiar, modificar, mesclar , publicar, distribuir, sublicenciar e/ou vender cópias do Software e permitir que as pessoas a quem o Software é fornecido o façam, sujeito às seguintes condições:
                O aviso de direitos autorais acima e este aviso de permissão devem ser incluídos em todas as cópias, e Manter a mensagem no rodapé da página: Copyright © MadCrowlyn Developers - GitHub SirTonhão. All rights reserved,
            </small>
        </div>
        <div id="url-rewriting-warning" style="padding: 1rem; background: #fcebea; color: #cc1f1a; border-color: #ef5753; margin-bottom: 1rem;">
            <ul>
                <li class="bullet problem">
                    O Modo URL rewriting do apache não está funcionando. Ative o mesmo para não haver erros de roteamento.<br />
                    1) <a target="_blank" rel="noopener" href="https://book.cakephp.org/4/en/installation.html#url-rewriting">Help me configure it</a><br />
                    2) <a target="_blank" rel="noopener" href="https://book.cakephp.org/4/en/development/configuration.html#general-configuration">I don't / can't use URL rewriting</a>
                </li>
            </ul>
        </div>
        <?php Debugger::checkSecurityKeys(); ?>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h4>Environment</h4>
                <ul>
                    <?php if (version_compare(PHP_VERSION, '7.2.0', '>=')) : ?>
                        <li class="bullet success">Versão do PHP superior a 7.2.0 (detected <?= PHP_VERSION ?>).</li>
                    <?php else : ?>
                        <li class="bullet problem">Sua versão não é no minimo a 7.2.0, altere a versão do php para está ou superior (detected <?= PHP_VERSION ?>).</li>
                    <?php endif; ?>

                    <?php if (extension_loaded('mbstring')) : ?>
                        <li class="bullet success">Extensão do PHP mbstring Carregado com sucesso!.</li>
                    <?php else : ?>
                        <li class="bullet problem">Ative a extensção mbstring no PHP.</li>
                    <?php endif; ?>

                    <?php if (extension_loaded('openssl')) : ?>
                        <li class="bullet success">Extensão do PHP openssl Carregada.</li>
                    <?php elseif (extension_loaded('mcrypt')) : ?>
                        <li class="bullet success">Extensão do PHP mcrypt Carregada.</li>
                    <?php else : ?>
                        <li class="bullet problem">Ative o openssl ou mcrypt do seu PHP.</li>
                    <?php endif; ?>

                    <?php if (extension_loaded('intl')) : ?>
                        <li class="bullet success">Extensão intl Carregada com sucesso.</li>
                    <?php else : ?>
                        <li class="bullet problem">Ative a extensão intl do seu PHP.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h4>Arquivos do sistema</h4>
                <ul>
                    <?php if (is_writable(TMP)) : ?>
                        <li class="bullet success">Your tmp directory is writable.</li>
                    <?php else : ?>
                        <li class="bullet problem">Your tmp directory is NOT writable.</li>
                    <?php endif; ?>

                    <?php if (is_writable(LOGS)) : ?>
                        <li class="bullet success">Your logs directory is writable.</li>
                    <?php else : ?>
                        <li class="bullet problem">Your logs directory is NOT writable.</li>
                    <?php endif; ?>

                    <?php $settings = Cache::getConfig('_cake_core_'); ?>
                    <?php if (!empty($settings)) : ?>
                        <li class="bullet success">The <em><?= $settings['className'] ?>Engine</em> is being used for core caching. To change the config edit config/app.php</li>
                    <?php else : ?>
                        <li class="bullet problem">Your cache is NOT working. Please check the settings in config/app.php</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h4>Database</h4>
                <?php
                $result = $checkConnection('default');
                ?>
                <ul>
                    <?php if ($result['connected']) : ?>
                        <li class="bullet success">Daa base conectada.</li>
                    <?php else : ?>
                        <li class="bullet problem">DataBase não está conectada.<br /><?= $result['error'] ?></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h4>DebugKit</h4>
                <ul>
                    <?php if (Plugin::isLoaded('DebugKit')) : ?>
                        <li class="bullet success">DebugKit is loaded.</li>
                        <?php
                        $result = $checkConnection('debug_kit');
                        ?>
                        <?php if ($result['connected']) : ?>
                            <li class="bullet success">DebugKit can connect to the database.</li>
                        <?php else : ?>
                            <li class="bullet problem">DebugKit is <strong>not</strong> able to connect to the database.<br /><?= $result['error'] ?></li>
                        <?php endif; ?>
                    <?php else : ?>
                        <li class="bullet problem">DebugKit is <strong>not</strong> loaded.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col">
                <h3>Começando</h3>
                <a class="btn btn-link" target="_blank" rel="noopener" href="https://github.com/aspiretony/">GIT HUB CRIADOR</a>
            </div>
        </div>
        <hr>
        <hr>
    </div>
</div>

<style media="screen">
    ul {
        list-style-type: none;
    }

    .bullet::before {
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        font-size: 18px;
        display: inline-block;
        margin-left: -1.3em;
        width: 1.2em;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        vertical-align: -1px;
    }

    .success::before {
        color: #88c671;
        content: "\f058";
    }

    .problem::before {
        color: #d33d44;
        content: "\f057";
    }
</style>
