<?php
class MdcDispositivosFormController extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'wppmanagement';
    private static $activeRecord = 'wppmanagement';
    private static $primaryKey = 'id';
    private static $formName = 'form_MdcDispositivosFormController';

    //<classProperties>

    //</classProperties>

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("mdc_dispositivos");

        //<onBeginPageCreation>

        //</onBeginPageCreation>

        $id = new TEntry('id');
        $nome = new TEntry('nome');
        $numero = new TEntry('numero');
        $token = new TEntry('token');
        $descricao = new TText('descricao');
        $statusatual = new TEntry('statusatual');
        $servidores_id = new TDBCombo('servidores_id', 'wppmanagement', 'servidoresWPP', 'id', '{ipoudominio}', 'id asc');
        $system_user_id = new TDBCombo('system_user_id', 'permission', 'SystemUser', 'id', '{name}','id asc'  );

        $system_user_id->addValidation("System user id", new TRequiredValidator());

        $id->setEditable(false);
        $token->setEditable(false);
        $statusatual->setEditable(false);
        $system_user_id->enableSearch();
        $nome->setMaxLength(255);
        $numero->setMaxLength(50);
        $token->setMaxLength(255);
        $statusatual->setMaxLength(20);

        $id->setSize(100);
        $nome->setSize('100%');
        $token->setSize('100%');
        $numero->setSize('100%');
        $statusatual->setSize('100%');
        $descricao->setSize('100%', 70);
        $servidores_id->setSize('100%');
        $system_user_id->setSize('100%');



        //<onBeforeAddFieldsToForm>

        //</onBeforeAddFieldsToForm>
        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id],[new TLabel("Nome:", null, '14px', null, '100%'),$nome]);
        $row1->layout = ['col-sm-6','col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Numero de Celular (numero da sessão):", null, '14px', null, '100%'),$numero],[new TLabel("Token Gerado:", null, '14px', null, '100%'),$token]);
        $row2->layout = ['col-sm-6','col-sm-6'];

        $row3 = $this->form->addFields([new TLabel("Descrição", null, '14px', 'I', '100%'),$descricao],[new TLabel("Status:", null, '14px', null, '100%'),$statusatual]);
        $row3->layout = ['col-sm-6','col-sm-6'];

        $row4 = $this->form->addFields([new TLabel("Servidor Pertencente:", null, '14px', null, '100%'),$servidores_id],[new TLabel("Usuário Pertencente:", '#ff0000', '14px', null, '100%'),$system_user_id]);
        $row4->layout = ['col-sm-6','col-sm-6'];

        //<onAfterFieldsCreation>

        //</onAfterFieldsCreation>

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary');

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Básico","mdc_dispositivos"]));
        }
        $container->add($this->form);

        //<onAfterPageCreation>

        //</onAfterPageCreation>

        parent::add($container);

    }

//<generated-FormAction-onSave>
    public function onSave($param = null)
    {


        if (empty($param['id'])) {
            TTransaction::open(self::$database);
            $registros_bd = mdcDispositivos::where('numero', '=', $param['numero'])->load();
            if ($registros_bd) {
                throw new Exception('Dados repetidos');
                die();
            }
            TTransaction::close();
        }
            try {
                $servidor = $param['servidores_id'];
                TTransaction::open(self::$database);
                $servidor = new servidoresWPP($servidor);


                echo $servidor->porta;

                if ($servidor->porta == 443) {
                    $conectar = $servidor->ipoudominio;
                } else {
                    $conectar = $servidor->ipoudominio . ':' . $servidor->porta;
                }

                if (mb_strpos("$conectar", 'http') !== false) {
                    $conectar = $conectar;
                } else {
                    $conectar = "http://$conectar";
                }
                TTransaction::close();

                $sessao = $param['numero'];
                $request = new HTTP_Request2();
                $request->setUrl("$conectar/api/$sessao/$servidor->chavesecreta/generate-token");
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

                        $retorno = $response->getBody();
                        $decodificado = json_decode($retorno);


                        TTransaction::open(self::$database); // open a transaction

                        $messageAction = null;

                        $this->form->validate();

                        $object = new mdcDispositivos();

                        $data = $this->form->getData();
                        $object->fromArray((array)$data);

                        $object->token = $decodificado->token;
                        $object->statusatual = 0;

                        $object->store();

                        $data->id = $object->id; //</blockLine>

                        $this->form->setData($data); // fill form data
                        TTransaction::close(); // close the transaction

                        new TMessage('info', "Registro salvo", $messageAction);

                    } else {
                        $resposta = $response->getStatus();
                        $resposta2 = $response->getReasonPhrase();
                        TToast::show('warning', "Unexpected HTTP status: $resposta $resposta2", 'top right', 'far:check-circle');
                    }
                } catch (HTTP_Request2_Exception $e) {
                    $resposta = 'Error: ' . $e->getMessage();
                    TToast::show('error', "$resposta", 'top right', 'far:check-circle');

                }

            } catch (Exception $e) // in case of exception
            {
                //</catchAutoCode> //</blockLine>

                new TMessage('error', $e->getMessage()); // shows the exception error message
                $this->form->setData($this->form->getData()); // keep form data
                TTransaction::rollback(); // undo all pending operations
            }
        }

    public function onEdit( $param )//</ini>
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new mdcDispositivos($key); // instantiates the Active Record //</blockLine>

                //</beforeSetDataAutoCode> //</blockLine>

                $this->form->setData($object); // fill the form //</blockLine>

                //</afterSetDataAutoCode> //</blockLine>
                TTransaction::close(); // close the transaction
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(true);

        //<onFormClear>

        //</onFormClear>

    }

    public function onShow($param = null)
    {

        //<onShow>

        //</onShow>
    }
}