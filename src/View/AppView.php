<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\View;

use Cake\View\View;
use CakeLte\View\CakeLteTrait;

/**
 * Application View
 *
 * Your application's default view class
 *
 * @link https://book.cakephp.org/4/en/views.html#the-app-view
 */
class AppView extends View
{
    use CakeLteTrait;
    public $layout = 'CakeLte.default';
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading helpers.
     *
     * e.g. `$this->loadHelper('Html');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->initializeCakeLte($options = [
            'app-name' => 'MDc<b> WPPConnect ON</b>',
            'app-logo' => 'CakeLte.cake.icon.svg',
            'small-text' => false,
            'dark-mode' => false,
            'layout-boxed' => false,
            'header.fixed' => false,
            'header.border' => true,
            'header.style' => \CakeLte\View\Styles\Header::STYLE_WHITE,
            'header.dropdown-legacy' => false,
            'sidebar.fixed' => true,
            'sidebar.collapsed' => false,
            'sidebar.mini' => true,
            'sidebar.mini-md' => false,
            'sidebar.mini-xs' => false,
            'sidebar.style' => \CakeLte\View\Styles\Sidebar::STYLE_DARK_PRIMARY,
            'sidebar.flat-style' => false,
            'sidebar.legacy-style' => false,
            'sidebar.compact' => false,
            'sidebar.child-indent' => false,
            'sidebar.child-hide-collapse' => false,
            'sidebar.disabled-auto-expand' => false,
            'footer.fixed' => false,
        ]);
    }
}
