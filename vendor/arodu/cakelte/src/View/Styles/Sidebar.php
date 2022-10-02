<?php

declare(strict_types=1);

namespace CakeLte\View\Styles;

use Cake\View\Helper;
use CakeLte\View\Styles\StylesTrait;

class Sidebar
{
    use StylesTrait;

    public const STYLE_DARK_PRIMARY = 'dark-primary';
    public const STYLE_DARK_SECONDARY = 'dark-secondary';
    public const STYLE_DARK_INFO = 'dark-info';
    public const STYLE_DARK_SUCCESS = 'dark-success';
    public const STYLE_DARK_DANGER = 'dark-danger';
    public const STYLE_DARK_WARNING = 'dark-warning';
    public const STYLE_DARK_WHITE = 'dark-white';
    public const STYLE_DARK_BLACK = 'dark-black';

    public const STYLE_LIGHT_PRIMARY = 'light-primary';
    public const STYLE_LIGHT_SECONDARY = 'light-secondary';
    public const STYLE_LIGHT_INFO = 'light-info';
    public const STYLE_LIGHT_SUCCESS = 'light-success';
    public const STYLE_LIGHT_DANGER = 'light-danger';
    public const STYLE_LIGHT_WARNING = 'light-warning';
    public const STYLE_LIGHT_WHITE = 'light-white';
    public const STYLE_LIGHT_BLACK = 'light-black';

    protected $_styles= [
        self::STYLE_DARK_PRIMARY => 'sidebar-dark-primary',
        self::STYLE_DARK_SECONDARY => 'sidebar-dark-secondary',
        self::STYLE_DARK_INFO => 'sidebar-dark-info',
        self::STYLE_DARK_SUCCESS => 'sidebar-dark-success',
        self::STYLE_DARK_DANGER => 'sidebar-dark-danger',
        self::STYLE_DARK_WARNING => 'sidebar-dark-warning',
        self::STYLE_DARK_WHITE => 'sidebar-dark-white',
        self::STYLE_DARK_BLACK => 'sidebar-dark-black',

        self::STYLE_LIGHT_PRIMARY => 'sidebar-light-primary',
        self::STYLE_LIGHT_SECONDARY => 'sidebar-light-secondary',
        self::STYLE_LIGHT_INFO => 'sidebar-light-info',
        self::STYLE_LIGHT_SUCCESS => 'sidebar-light-success',
        self::STYLE_LIGHT_DANGER => 'sidebar-light-danger',
        self::STYLE_LIGHT_WARNING => 'sidebar-light-warning',
        self::STYLE_LIGHT_WHITE => 'sidebar-light-white',
        self::STYLE_LIGHT_BLACK => 'sidebar-light-black',
    ];

    private $_helper;
    private $_name;

    /**
     * @param Helper $helper
     */
    public function __construct($helper)
    {
        $this->_helper = $helper;
        $this->_name = 'sidebar';
    }
}