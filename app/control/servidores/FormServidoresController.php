<?php

/**
 * StandardFormDataGridView
 *
 * @version    1.0
 * @package    samples
 * @subpackage tutor
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class FormServidoresController extends TPage
{
    protected $form;      // form
    protected $datagrid;  // datagrid
    protected $loaded;
    protected $pageNavigation;  // pagination component

    // trait with onSave, onEdit, onDelete, onReload, onSearch...
    use Adianti\Base\AdiantiStandardFormListTrait;

    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct()
    {
        parent::__construct();

        $this->setDatabase('wppmanagement'); // define the database
        $this->setActiveRecord('servidoresWPP'); // define the Active Record
        $this->setDefaultOrder('id', 'asc'); // define the default order
        $this->setLimit(-1); // turn off limit for datagrid

        // create the form
        $this->form = new BootstrapFormBuilder('form_categories');
        $this->form->setFormTitle(_t('Standard Form/DataGrid'));

        // create the form fields
        $id = new TEntry('id');
        $ipoudominio = new TEntry('ipoudominio');
        $porta = new TEntry('porta');
        $chavesecreta = new TEntry('chavesecreta');
        $descricao = new TEntry('descricao');
        $radio_enable = new TRadioGroup('interno');
        $radio_enable->addItems(array('1'=>'Servidor Interno Primário', '0'=>'Outros Servidores'));
        $radio_enable->setLayout('horizontal');
        $radio_enable->setValue(0);
        // add the form fields
        $this->form->addFields([new TLabel('ID:')], [$id]);
        $this->form->addFields([new TLabel('IP OU DOMINIO:', 'red')], [$ipoudominio]);
        $this->form->addFields([new TLabel('PORTA:', 'red')], [$porta]);
        $this->form->addFields([new TLabel('CHAVE SECRETA:', 'red')], [$chavesecreta]);
        $this->form->addFields([new TLabel('DESCRIÇÃO:', 'red')], [$descricao]);
        $this->form->addFields([],                       [$radio_enable] );
        $ipoudominio->addValidation('IP OU DOMINIO', new TRequiredValidator);
        $chavesecreta->addValidation('chave secreta', new TRequiredValidator);
        $descricao->addValidation('descricao', new TRequiredValidator);
        // define the form actions
        $this->form->addAction('Salvar', new TAction([$this, 'onSave']), 'fa:save green');
        $this->form->addActionLink('Limpar', new TAction([$this, 'onClear']), 'fa:eraser red');

        // make id not editable
        $id->setEditable(FALSE);

        // create the datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->width = '100%';

        // add the columns
        $col_id = new TDataGridColumn('id', 'Id', 'right', '10%');
        $col_ip = new TDataGridColumn('ipoudominio', 'IP', 'left', '90%');
        $col_porta = new TDataGridColumn('porta', 'Porta', 'right', '90%');
        $col_chave = new TDataGridColumn('chavesecreta', 'Chave de Conexão', 'left', '90%');
        $col_descricao = new TDataGridColumn('descricao', 'Descrição', 'left', '90%');



        $this->datagrid->addColumn($col_id);
        $this->datagrid->addColumn($col_ip);
        $this->datagrid->addColumn($col_porta);
        $this->datagrid->addColumn($col_chave);
        $this->datagrid->addColumn($col_descricao);

        $col_id->setAction(new TAction([$this, 'onReload']), ['order' => 'id']);
        $col_ip->setAction(new TAction([$this, 'onReload']), ['order' => 'ipoudominio']);



        // define row actions
        $action1 = new TDataGridAction([$this, 'onEdit'], ['key' => '{id}']);
        $action2 = new TDataGridAction([$this, 'onDelete'], ['key' => '{id}']);
        $action3 = new TDataGridAction([$this, 'onTestConn'], ['key' => '{id}', 'ip' => '{ipoudominio}','porta' => '{porta}', 'chave' => '{chavesecreta}']);
        $action4 = new TDataGridAction(['editinternoController', 'onShow'], ['key' => '{id}']);

        $this->datagrid->addAction($action1, 'Editar Conexão', 'far:edit blue');
        $this->datagrid->addAction($action2, 'Deletar', 'far:trash-alt red');
        $this->datagrid->addAction($action3, 'Testar Conexão', 'fas:wifi green');
        $this->datagrid->addAction($action4, 'Editar Configuração', 'far:edit green');



        // create the datagrid model
        $this->datagrid->createModel();

        // wrap objects inside a table
        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        $vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $vbox->add($this->form);
        $vbox->add(TPanelGroup::pack('', $this->datagrid));

        // pack the table inside the page
        parent::add($vbox);
    }


    function onTestConn($param){

        if ($param['porta'] == 443){
            $conectar = $param['ipoudominio'];
        }else{
            $conectar = $param['ipoudominio'].':'.$param['porta'];
        }

        $chave = $param['chave'];


        if (mb_strpos("$conectar", 'http') !== false) {
            $conectar = $conectar;
        }else{
            $conectar = "http://$conectar";
        }


        $request = new HTTP_Request2();
        $request->setUrl("$conectar/api/testedeconexaonaousar/$chave/generate-token");
        $request->setMethod(HTTP_Request2::METHOD_POST);
        $request->setConfig(array(
            'follow_redirects' => TRUE
        ));
        $request->setHeader(array(
            'Authorization' => 'Bearer $2b$10$BBrKGG76Hv8AQGtE3sY9He4m5yk.ndRf.SQ67wzAuNOROXKXR50oS'
        ));
        try {
            $response = $request->send();
            if ($response->getStatus() == 201) {
                TToast::show('show', 'Foi Capaz de se Conectar ao servidor', 'top right', 'far:check-circle' );
            }
            else {
                $resposta = $response->getStatus();
                $resposta2 = $response->getReasonPhrase();
                TToast::show('warning', "Unexpected HTTP status: $resposta $resposta2", 'top right', 'far:check-circle' );
            }
        }
        catch(HTTP_Request2_Exception $e) {
            $resposta = 'Error: ' . $e->getMessage();
            TToast::show('error', "$resposta", 'top right', 'far:check-circle' );

        }


    }
}
