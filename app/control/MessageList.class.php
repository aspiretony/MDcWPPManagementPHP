<?php
/**
 * MessageList
 *
 * @version    1.0
 * @package    control
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class MessageList extends TElement
{
    public function __construct($param)
    {
        try
        {
            TTransaction::open('communication');

            // load configs
            $ini = parse_ini_file('app/config/application.ini', true);
            
            $parametersRead = [];
            $parametersSend = [];

            if (! empty($ini['general']['use_tabs']) || ! empty($ini['general']['use_mdi_windows']))
            {
                $parametersRead['adianti_open_tab'] = '1';
                $parametersRead['adianti_tab_name'] = _t('Messages');

                //$parametersSend['adianti_open_tab'] = '1';
                //$parametersSend['adianti_tab_name'] = _t('Send message');
            }

            // load the messages to the logged user
            $system_messages = SystemMessage::where('checked', '=', 'N')->where('system_user_to_id', '=', TSession::getValue('userid'))->orderBy('id', 'desc')->load();
            
            if ($param['theme'] == 'theme3')
            {
                parent::__construct('ul');

                $this->class = 'dropdown-menu';
                
                $a = new TElement('a');
                $a->{'class'} = "dropdown-toggle";
                $a->{'data-toggle'}="dropdown";
                $a->{'href'} = "#";
                
                $a->add( TElement::tag('i',    '', array('class'=>"fa fa-envelope fa-fw")) );
                $a->add( TElement::tag('span', count($system_messages), array('class'=>"label label-success")) );
                $a->show();
                
                $li_master = new TElement('li');
                $ul_wrapper = new TElement('ul');
                $ul_wrapper->{'class'} = 'menu';
                $li_master->add($ul_wrapper);
                
                parent::add( TElement::tag('li', _t('Messages'), ['class'=>'header']));
                parent::add($li_master);
                
                TTransaction::open('permission');
                foreach ($system_messages as $system_message)
                {
                    $name    = SystemUser::find($system_message->system_user_id)->name;
                    $date    = $this->getShortPastTime($system_message->dt_message);
                    $subject = htmlspecialchars($system_message->subject, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    
                    $li  = new TElement('li');
                    $a   = new TElement('a');
                    $div = new TElement('div');
                    
                    $parameters = ['id' => $system_message->id];

                    if (! empty($ini['general']['use_tabs']) || ! empty($ini['general']['use_mdi_windows']))
                    {
                        $parameters['adianti_open_tab'] = '1';
                        $parameters['adianti_tab_name'] = _t('Message') . ' #' . $system_message->id;
                    }

                    $a->href = (new TAction(['SystemMessageFormView', 'onView'], $parameters))->serialize();
                    $a->generator = 'adianti';

                    $li->add($a);
                    
                    $div->{'class'} = 'pull-left';
                    $div->add( TElement::tag('i', '', array('class' => 'fa fa-user fa-2x') ) );
                    
                    $h4 = new TElement('h4');
                    $h4->add( $name );
                    $h4->add( TElement::tag('small', TElement::tag('i', $date, array('class' => 'far fa-clock') ) ) );
                    
                    $a->add($div);
                    $a->add($h4);
                    $a->add( TElement::tag('p', $subject) );
                    
                    $ul_wrapper->add($li);
                }
                
                TTransaction::close();
                
                parent::add(TElement::tag('li', TElement::tag('a', _t('Messages'),
                    ['href'=> (new TAction(['SystemMessageList', 'filterInbox'], $parametersRead))->serialize(),
                     'generator'=>'adianti'] ), ['class'=>'footer'] ));
                
                parent::add(TElement::tag('li', TElement::tag('a', _t('Send message'),
                    ['href'=> (new TAction(['SystemMessageForm', 'onClear'], $parametersSend))->serialize(),
                     'generator'=>'adianti'] ), ['class'=>'footer']));
            }
            else if ($param['theme'] == 'theme3-adminlte3')
            {
                parent::__construct('div');

                $a = new TElement('a');
                $a->{'class'} = "nav-link";
                $a->{'data-toggle'}="dropdown";
                $a->{'href'} = "#";

                $a->add( TElement::tag('i',    '', array('class'=>"far fa-comments")) );
                $a->add( TElement::tag('span', count($system_messages), array('class'=>"badge badge-danger navbar-badge")) );

                parent::add($a);

                $content = new TElement('div');
                $content->{'class'} = 'dropdown-menu dropdown-menu-lg dropdown-menu-right';

                $content->add( TElement::tag('span', _t('Messages'), ['class'=>'dropdown-item dropdown-header']));
                $content->add( TElement::tag('div', '', ['class'=>'dropdown-divider']));
                parent::add($content);

                TTransaction::open('permission');
                foreach ($system_messages as $system_message)
                {
                    $name    = SystemUser::find($system_message->system_user_id)->name;
                    $date    = $this->getShortPastTime($system_message->dt_message);
                    $subject = htmlspecialchars($system_message->subject, ENT_QUOTES | ENT_HTML5, 'UTF-8');

                    $a   = new TElement('a');
                    $div = new TElement('div');

                    $div->{'class'} = 'media';

                    $parameters = ['id' => $system_message->id];

                    if (! empty($ini['general']['use_tabs']) || ! empty($ini['general']['use_mdi_windows']))
                    {
                        $parameters['adianti_open_tab'] = '1';
                        $parameters['adianti_tab_name'] = _t('Message') . ' #' . $system_message->id;
                    }

                    $a->href = (new TAction(['SystemMessageFormView', 'onView'], $parameters))->serialize();

                    $a->{'class'}     = 'dropdown-item';
                    $a->{'generator'} = 'adianti';

                    $a->add($div);

                    $div->{'class'} = 'media';
                    $div->add( TElement::tag('i', '', array('class' => 'far fa-user img-size-50 img-circle mr-3 icon-user-notification') ) );

                    $body = new TElement('div');
                    $body->{'class'} = 'media-body';

                    $h3 = new TElement('h3');
                    $h3->{'class'} = 'dropdown-item-title';
                    $h3->add( $name );

                    $body->add($h3);
                    $body->add(TElement::tag('p', $subject,  array('class' => 'text-sm') ));

                    $time = new TElement('p');
                    $time->{'class'} = 'text-sm text-muted';
                    $time->add(TElement::tag('i', '', array('class' => 'far fa-clock mr-1')));
                    $time->add($date);

                    $body->add($time);

                    $div->add($body);
                    $content->add($a);

                    $content->add( TElement::tag('div', '', ['class'=>'dropdown-divider']));
                }

                TTransaction::close();

                $content->add(TElement::tag(
                    'a',
                     _t('Messages'),
                    [
                        'href'=> (new TAction(['SystemMessageList', 'filterInbox'], $parametersRead))->serialize(),
                        'generator'=>'adianti',
                        'class'=>'dropdown-item dropdown-footer'
                    ]
                ));

                $content->add(TElement::tag(
                    'a',
                    _t('Send message'),
                    [
                        'href'=> (new TAction(['SystemMessageForm', 'onClear'], $parametersSend))->serialize(),
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
                
                $a->add( TElement::tag('i',    'email', array('class'=>"material-icons")) );
                $a->add( TElement::tag('span', count($system_messages), array('class'=>"label-count")) );
                $a->show();
                
                $li_master = new TElement('li');
                $ul_wrapper = new TElement('ul');
                $ul_wrapper->{'class'} = 'menu';
                $ul_wrapper->{'style'} = 'list-style:none';
                $li_master->{'class'} = 'body';
                $li_master->add($ul_wrapper);
                
                parent::add( TElement::tag('li', _t('Messages'), ['class'=>'header']));
                parent::add($li_master);
                
                TTransaction::open('permission');
                foreach ($system_messages as $system_message)
                {
                    $name    = SystemUser::find($system_message->system_user_id)->name;
                    $date    = $this->getShortPastTime($system_message->dt_message);
                    $subject = htmlspecialchars($system_message->subject, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    
                    $li  = new TElement('li');
                    $a   = new TElement('a');
                    $div = new TElement('div');
                    $div2= new TElement('div');
                    
                    $parameters = ['id' => $system_message->id];

                    if (! empty($ini['general']['use_tabs']) || ! empty($ini['general']['use_mdi_windows']))
                    {
                        $parameters['adianti_open_tab'] = '1';
                        $parameters['adianti_tab_name'] = _t('Message') . ' #' . $system_message->id;
                    }

                    $a->href = (new TAction(['SystemMessageFormView', 'onView'], $parameters))->serialize();
                    $a->class = 'waves-effect waves-block';
                    $a->generator = 'adianti';
                    $li->add($a);
                    
                    $div->{'class'} = 'icon-circle bg-light-green';
                    $div2->{'class'} = 'menu-info';
                    
                    $div->add( TElement::tag('i', '', array('class' => 'fa fa-user fa-2x') ) );
                    
                    $h4 = new TElement('h4');
                    $h4->add( $name );
                    $h4->add( '&nbsp;' );
                    $h4->add( "<span style='font-weight:100'>$subject</span>" );
                    
                    $div2->add($h4);
                    $a->add($div);
                    $a->add($div2);
                    
                    $p = new TElement('p');
                    $p->add( TElement::tag('i', 'access_time', ['class' => 'material-icons']) );
                    $p->add( $date );
                    
                    $div2->add( $p );
                    $ul_wrapper->add($li);
                }
                
                TTransaction::close();
                
                parent::add(TElement::tag('li', TElement::tag('a', _t('Messages'),
                    ['href'=> (new TAction(['SystemMessageList', 'filterInbox'], $parametersRead))->serialize(),
                     'generator'=>'adianti'] ), ['class'=>'footer'] ));
                
                parent::add(TElement::tag('li', TElement::tag('a', _t('Send message'),
                    ['href'=> (new TAction(['SystemMessageForm', 'onClear'], $parametersSend))->serialize(),
                     'generator'=>'adianti'] ), ['class'=>'footer']));
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
