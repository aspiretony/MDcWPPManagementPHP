<?php

class servidoresWPP extends TRecord
{
    const TABLENAME = 'servidores';
    const PRIMARYKEY = 'id';
    const IDPOLICY = 'max'; // {max, serial}

    public function __construct($id = NULL)
    {
        parent::__construct($id);
        parent::addAttribute('ipoudominio');
        parent::addAttribute('porta');
        parent::addAttribute('chavesecreta');
        parent::addAttribute('descricao');
        parent::addAttribute('interno');

    }
    static public function newFromSessao($sessao)
    {
        return servidoresWPP::where('numero', '=', $sessao)->first();
    }
}