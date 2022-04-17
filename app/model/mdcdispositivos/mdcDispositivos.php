<?php
class mdcDispositivos extends TRecord
{
    const TABLENAME = 'mdc_dispositivos';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}

    public function __construct($id = NULL)
    {
        parent::__construct($id);
        parent::addAttribute('nome');
        parent::addAttribute('numero');
        parent::addAttribute('token');
        parent::addAttribute('id');
        parent::addAttribute('descricao');
        parent::addAttribute('statusatual');
        parent::addAttribute('servidores_id');
        parent::addAttribute('system_user_id');

    }
}