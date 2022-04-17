<?php
class editinternoController extends TPage
{
    /**
     * Constructor method
     */
    public function __construct()
    {
        parent::__construct();
        parent::setTargetContainer('adianti_right_panel');

        $this->form = new BootstrapFormBuilder;
        $this->form->setFormTitle("EDITAR CONFIGURAÇÕES DO SERVIDOR PRIMÁRIO");

        $obs     = new TText('jsonfile');
        $this->form->addFields( [ new TLabel('Arquivo de Configuração') ],       [ $obs ] );
        $obs->setSize('90%', '800');


        $file_handle = fopen('nodeserver/src/config.json', 'r');
        $contents = fread($file_handle, filesize('nodeserver/src/config.json'));
        fclose($file_handle);

        $obs->setValue("$contents");

        $this->form->addAction('Send', new TAction(array($this, 'onSend')), 'far:check-circle green');

        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        $vbox->add($this->form);
        parent::add($vbox);


        echo  "<div class='header-actions'>";
        echo  "<a class='btn btn-default' generator='adianti' href='index.php?class=editinternoController&amp;method=onClose&amp;static=1' style='float:right'>";
        echo  "<i class='fa fa-times red' aria-hidden='true'></i>";
        echo "Close";
        echo  "</a>";
        echo "</div>";

    }

        /**
     * on close
     */
    public static function onClose($param)
    {
        TScript::create("Template.closeRightPanel()");
    }
    function onShow($param){

    }
    function onSend($param){

        $fp = fopen("nodeserver/src/config.json","wb");
        if (fwrite($fp,$param['jsonfile'])) {
            TScript::create("Template.closeRightPanel()");
            fclose($fp);
            TToast::show('success', "Sucesso ao Salvar", 'top right', 'far:check-circle' );
        }else{
            echo "Houve um algum erro";
        }
    }
}
