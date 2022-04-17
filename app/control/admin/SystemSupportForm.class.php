<?php
/**
 * SystemSupportForm
 *
 * @version    1.0
 * @package    control
 * @subpackage admin
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class SystemSupportForm extends TWindow
{
    protected $form; // form
    
    /**
     * Class constructor
     * Creates the page and the registration form
     */
    function __construct()
    {
        parent::__construct();
        parent::setSize(800, null);
        parent::setTitle( _t('Open ticket') );
        parent::setProperty('class', 'window_modal');
        
        // creates the form
        $this->form = new BootstrapFormWrapper(new TQuickForm('form_SystemMessage'));
        $this->form->style = 'display: table;width:100%'; // change style
        $this->form->setProperty('style', 'border:0');
        
        // define the form title
        $this->form->setFormTitle(_t('Ticket'));
        
        // create the form fields
        $subject = new TEntry('subject');
        $message = new TText('message');

        // add the fields
        $this->form->addQuickField(_t('Title'), $subject,  '90%', new TRequiredValidator );
        $this->form->addQuickField(_t('Message'), $message,  '90%', new TRequiredValidator );
        $message->setSize('90%', '100');
        
        if (!empty($id))
        {
            $id->setEditable(FALSE);
        }
        
        // create the form actions
        $btn = $this->form->addQuickAction(_t('Send'), new TAction(array($this, 'onSend')), 'far:envelope');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addQuickAction(_t('Clear form'),  new TAction(array($this, 'onClear')), 'fa:eraser red');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%; margin:40px';
        $container->add($this->form);
        
        parent::add($container);
    }
    
    public function onClear($param)
    {
    
    }
    
    public function onSend($param)
    {
        try
        {
            // get the form data
            $data = $this->form->getData();
            // validate data
            $this->form->validate();
            
            TTransaction::open('permission');
            $preferences = SystemPreference::getAllPreferences();
            TTransaction::close();
            
            MailService::send( trim($preferences['mail_support']), $data->subject, $data->message );
            
            // shows the success message
            new TMessage('info', _t('Message sent successfully'));
        }
        catch (Exception $e) // in case of exception
        {
            // get the form data
            $object = $this->form->getData();
            
            // fill the form with the active record data
            $this->form->setData($object);
            
            // shows the exception error message
            new TMessage('error', $e->getMessage());
            
            // undo all pending operations
            TTransaction::rollback();
        }
    }
}
