<?php
/**
 * NotificationList
 *
 * @version    1.0
 * @package    control
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class NotificationList extends TElement
{
    public function __construct($param)
    {
        try
        {
            TTransaction::open('communication');
            // load the notifications to the logged user
            $system_notifications = SystemNotification::where('checked', '=', 'N')
                                                      ->where('dt_message', '<=', date('Y-m-d 23:59:59'))
                                                      ->where('system_user_to_id', '=', TSession::getValue('userid'))
                                                      ->orderBy('id', 'desc')
                                                      ->load();

            // load configs
            $ini = parse_ini_file('app/config/application.ini', true);

            $parametersViewAll = [];

            if (! empty($ini['general']['use_tabs']) || ! empty($ini['general']['use_mdi_windows']))
            {
                $parametersViewAll['adianti_open_tab'] = '1';
                $parametersViewAll['adianti_tab_name'] = _t('Notifications');
            }
            
            if ($param['theme'] == 'theme3')
            {
                parent::__construct('ul');

                $this->class = 'dropdown-menu';
                
                $a = new TElement('a');
                $a->{'class'} = "dropdown-toggle";
                $a->{'data-toggle'}="dropdown";
                $a->{'href'} = "#";
                
                $a->add( TElement::tag('i',    '', array('class'=>"far fa-bell fa-fw")) );
                $a->add( TElement::tag('span', count($system_notifications), array('class'=>"label label-warning")) );
                $a->show();
                
                $li_master = new TElement('li');
                $ul_wrapper = new TElement('ul');
                $ul_wrapper->{'class'} = 'menu';
                $li_master->add($ul_wrapper);
                
                parent::add( TElement::tag('li', _t('Notifications'), ['class'=>'header']));
                parent::add($li_master);
                
                foreach ($system_notifications as $system_notification)
                {
                    $date    = $this->getShortPastTime($system_notification->dt_message);
                    $subject = $system_notification->subject;
                    $icon    = $system_notification->icon ? $system_notification->icon : 'far fa-bell text-aqua';
                    $icon    = str_replace( 'fa:', 'fa fa-', $icon);
                    $icon    = str_replace( 'far:', 'far fa-', $icon);
                    $icon    = str_replace( 'fas:', 'fas fa-', $icon);
                    
                    $li  = new TElement('li');
                    $a   = new TElement('a');
                    $div = new TElement('div');
                    
                    $parameters = ['id' => $system_notification->id];

                    if (! empty($ini['general']['use_tabs']) || ! empty($ini['general']['use_mdi_windows']))
                    {
                        $parameters['adianti_open_tab'] = '1';
                        $parameters['adianti_tab_name'] = _t('Notification') . ' #' . $system_notification->id;
                    }

                    $a->href = (new TAction(['SystemNotificationFormView', 'onView'], $parameters))->serialize();
                    $a->generator = 'adianti';
                    $li->add($a);
                    
                    $i = new TElement('i');
                    $i->{'class'} = $icon;
                    $a->add($i);
                    $a->add($subject);
                    $a->add( TElement::tag('span', $date, array('class' => 'pull-right text-muted small') ) );
                    
                    $ul_wrapper->add($li);
                }
                
                parent::add(TElement::tag('li', TElement::tag('a', _t('View all'),
                    ['href'=> (new TAction(['SystemNotificationList', 'onReload'], $parametersViewAll))->serialize(),
                     'generator'=>'adianti'] ), ['class'=>'footer'] ));
            }
            else if ($param['theme'] == 'theme3-adminlte3')
            {
                parent::__construct('div');

                $a = new TElement('a');
                $a->{'class'} = "nav-link";
                $a->{'data-toggle'}="dropdown";
                $a->{'href'} = "#";

                $a->add( TElement::tag('i',    '', array('class'=>"far fa-bell")) );
                $a->add( TElement::tag('span', count($system_notifications), array('class'=>"badge badge-warning navbar-badge")) );

                parent::add($a);

                $content = new TElement('div');
                $content->{'class'} = 'dropdown-menu dropdown-menu-lg dropdown-menu-right';

                $content->add( TElement::tag('span', _t('Notifications'), ['class'=>'dropdown-item dropdown-header']));
                $content->add( TElement::tag('div', '', ['class'=>'dropdown-divider']));
                parent::add($content);

                foreach ($system_notifications as $system_notification)
                {
                    $date    = $this->getShortPastTime($system_notification->dt_message);
                    $subject = $system_notification->subject;
                    $icon    = $system_notification->icon ? $system_notification->icon : 'far fa-bell text-aqua';
                    $icon    = str_replace( 'fa:', 'fa fa-', $icon);
                    $icon    = str_replace( 'far:', 'far fa-', $icon);
                    $icon    = str_replace( 'fas:', 'fas fa-', $icon);

                    $a   = new TElement('a');
                    $div = new TElement('div');

                    $parameters = ['id' => $system_notification->id];

                    if (! empty($ini['general']['use_tabs']) || ! empty($ini['general']['use_mdi_windows']))
                    {
                        $parameters['adianti_open_tab'] = '1';
                        $parameters['adianti_tab_name'] = _t('Notification') . ' #' . $system_notification->id;
                    }

                    $a->href = (new TAction(['SystemNotificationFormView', 'onView'], $parameters))->serialize();
                    $a->generator = 'adianti';
                    $a->{'class'} = 'dropdown-item';

                    $i = new TElement('i');
                    $i->{'class'} = $icon . ' mr-2';

                    $a->add($i);
                    $a->add($subject);
                    $a->add(TElement::tag('span', $date, array('class' => 'float-right text-muted text-sm')));

                    $content->add($a);
                    $content->add( TElement::tag('div', '', ['class'=>'dropdown-divider']));
                }

                $content->add(TElement::tag(
                    'a',
                    _t('View all'),
                    [
                        'href'=> (new TAction(['SystemNotificationList', 'onReload'], $parametersViewAll))->serialize(),
                        'generator'=>'adianti',
                        'class'=>'dropdown-item dropdown-footer'
                    ]
                ));
            }
            else if ($param['theme'] == 'theme4')
            {
                parent::__construct('ul');

                $this->class = 'dropdown-menu';
                
                $a = new TElement('a');
                $a->{'class'} = "dropdown-toggle";
                $a->{'data-toggle'}="dropdown";
                $a->{'href'} = "#";
                
                $a->add( TElement::tag('i',    'notifications', array('class'=>"material-icons")) );
                $a->add( TElement::tag('span', count($system_notifications), array('class'=>"label-count")) );
                $a->show();
                
                $li_master = new TElement('li');
                $ul_wrapper = new TElement('ul');
                $ul_wrapper->{'class'} = 'menu';
                $ul_wrapper->{'style'} = 'list-style:none';
                $li_master->{'class'} = 'body';
                $li_master->add($ul_wrapper);
                
                parent::add( TElement::tag('li', _t('Notifications'), ['class'=>'header']));
                parent::add($li_master);
                
                foreach ($system_notifications as $system_notification)
                {
                    $date    = $this->getShortPastTime($system_notification->dt_message);
                    $subject = $system_notification->subject;
                    $icon    = $system_notification->icon ? $system_notification->icon : 'far fa-bell text-aqua';
                    $icon    = str_replace( 'fa:', 'fa fa-', $icon);
                    $icon    = str_replace( 'far:', 'far fa-', $icon);
                    $icon    = str_replace( 'fas:', 'fas fa-', $icon);
                    
                    $li  = new TElement('li');
                    $a   = new TElement('a');
                    $div = new TElement('div');
                    $div2= new TElement('div');
                    
                    $parameters = ['id' => $system_notification->id];

                    if (! empty($ini['general']['use_tabs']) || ! empty($ini['general']['use_mdi_windows']))
                    {
                        $parameters['adianti_open_tab'] = '1';
                        $parameters['adianti_tab_name'] = _t('Notification') . ' #' . $system_notification->id;
                    }

                    $a->href = (new TAction(['SystemNotificationFormView', 'onView'], $parameters))->serialize();
                    $a->class = 'waves-effect waves-block';
                    $a->generator = 'adianti';
                    $li->add($a);
                    
                    $div->{'class'} = 'icon-circle';
                    $div->{'style'} = 'background:whitesmoke';
                    $div2->{'class'} = 'menu-info';
                    
                    $div->add( TElement::tag('i', '', array('class' => $icon) ) );
                    
                    $h4 = new TElement('h4');
                    $h4->add( $subject );
                    
                    $div2->add($h4);
                    $a->add($div);
                    $a->add($div2);
                    
                    $p = new TElement('p');
                    $p->add( TElement::tag('i', 'access_time', ['class' => 'material-icons']) );
                    $p->add( $date );
                    
                    $div2->add( $p );
                    $ul_wrapper->add($li);
                }

                parent::add(TElement::tag('li', TElement::tag('a', _t('View all'),
                    ['href'=> (new TAction(['SystemNotificationList', 'onReload'], $parametersViewAll))->serialize(),
                     'generator'=>'adianti'] ), ['class'=>'footer'] ));
            }

            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
    
    public function getShortPastTime($from)
    {
        $to = date('Y-m-d H:i:s');
        $start_date = new DateTime($from);
        $since_start = $start_date->diff(new DateTime($to));
        if ($since_start->y > 0)
            return $since_start->y.' years ';
        if ($since_start->m > 0)
            return $since_start->m.' months ';
        if ($since_start->d > 0)
            return $since_start->d.' days ';
        if ($since_start->h > 0)
            return $since_start->h.' hours ';
        if ($since_start->i > 0)
            return $since_start->i.' minutes ';
        if ($since_start->s > 0)
            return $since_start->s.' seconds ';    
    }
}
