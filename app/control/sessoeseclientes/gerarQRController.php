<?php


class gerarQRController extends TPage
{
    public function __construct()
    {
        parent::__construct();




        $temporario = $_GET['id'];

        $teste = explode ('"', $temporario);
        $teste2 = $teste[0];
        $this->html = new THtmlRenderer('app/resources/side.html');
        parent::setTargetContainer('adianti_right_panel');

        TTransaction::open('wppmanagement');

        $dispositivo = new mdcDispositivos($teste2);

        $server = $dispositivo->servidores_id;

        $servidor = new servidoresWPP($server);

        TTransaction::close();

        $replaces = [];
        $replaces['token'] = "$dispositivo->token";
        $replaces['id'] = "$dispositivo->id";
        $replaces['sessao'] = "$dispositivo->numero";
        $replaces['chave'] = "$servidor->chavesecreta";
        $replaces['ip'] = "$servidor->ipoudominio";
        $replaces['porta'] = "$servidor->porta";
        $replaces['title']  = 'Scanear Telefone Celular';
        $replaces['footer'] = 'Tururuu';
        $replaces['name']   = 'Escaneando telefone: '.$dispositivo->numero;

        $this->html->enableSection('main', $replaces);

        parent::add($this->html);


    }

    public static function onClose($param)
    {
        TScript::create("Template.closeRightPanel()");
    }

  public function onGerarQR($param){


       }
}
