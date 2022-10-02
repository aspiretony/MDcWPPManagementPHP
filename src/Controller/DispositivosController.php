<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use DateTime;
use WPPConnect\Helpers\Util;
use WPPConnect\Http\Request;

/**
 * Dispositivos Controller
 *
 * @property \App\Model\Table\DispositivosTable $Dispositivos
 * @method \App\Model\Entity\Dispositivo[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DispositivosController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Conexaowpp');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $base = $_SERVER['DOCUMENT_ROOT'];
        $app = basename(dirname(APP));
        $dir = new Folder($base.'/'.$app.'/nodeserver/src');

        $files = $dir->find('config.json');
        foreach ($files as $file) {
            $file = new File($dir->pwd() . DS . $file);
            $contents = $file->read();
            // $file->write('I am overwriting the contents of this file');
            // $file->append('I am adding to the bottom of this file.');
            // $file->delete(); // I am deleting this file
            $file->close(); // Be sure to close the file when you're done
        }
        $dispositivos = $this->paginate($this->Dispositivos);

        $this->set(compact('dispositivos','contents'));
    }

    /**
     * View method
     *
     * @param string|null $id Dispositivo id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function scanner($id = null)
    {
        $dispositivo = $this->Dispositivos->get($id);


        $configs = $this->Conexaowpp->lerConfig();
        $wppconnect = new Request([
            'base_url' => "$configs->host:$configs->port",
            'secret_key' => "$configs->secretKey",
            'session' => "$dispositivo->sessao",
            'token' => "$dispositivo->token"
        ]);
        $util = new Util();

        $response = $wppconnect->statusSession();

      //  $response2 = $wppconnect->checkConnectionSession();
        $response = json_decode($response);

        $img = null;

        $msg = 'Carregando..';

        switch ($response->status){
            case "CLOSED":
                $wppconnect->startSession([
                    'webhook' => null,
                    'waitQrCode' => false
                ]);
                echo '
                <script>
    function autoRefresh() {
        window.location = window.location.href;
    }
    setInterval("autoRefresh()", 5000);
</script>';
                break;

            case "QRCODE":
                $img = $response->qrcode;
                $msg = "QR Code Gerado! scaneie para se conectar";

                echo '
                <script>
    function autoRefresh() {
        window.location = window.location.href;
    }
    setInterval("autoRefresh()", 15000);
</script>';
                break;

            case "INITIALIZING":
                $msg = "Inicializando";
                echo '
                <script>
    function autoRefresh() {
        window.location = window.location.href;
    }
    setInterval("autoRefresh()", 10000);
</script>';
                break;

            case "CONNECTED":
                $msg = "Conectado com sucesso!";
                $img = 'https://d3a6hxod1imgxc.cloudfront.net/news/grid-images/62662f40d9f5480e9f451a4b7a9d2598_reacao-com-emojis-a-mensagens-e-sucesso-entre-os-usuarios.jpg';
        }


       // $response = $util->toArray($response);
       // checkConnectionSession
      //  statusSession

        $this->set(compact('dispositivo','response', 'img','msg'));
    }

    public function view($id = null)
    {
        $dispositivo = $this->Dispositivos->get($id, [
            'contain' => ['DispUsers'],
        ]);

        $configs = $this->Conexaowpp->lerConfig();
        $wppconnect = new Request([
            'base_url' => "$configs->host:$configs->port",
            'secret_key' => "$configs->secretKey",
            'session' => "$dispositivo->sessao",
            'token' => "$dispositivo->token"
        ]);
        $util = new Util();

        $response = $wppconnect->checkConnectionSession();

        //  $response2 = $wppconnect->checkConnectionSession();
        $response = json_decode($response);

        $this->set(compact('dispositivo','response'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $base = $_SERVER['DOCUMENT_ROOT'];
        $app = basename(dirname(APP));
        $dir = new Folder($base.'/'.$app.'/nodeserver/src');

        $files = $dir->find('config.json');
        foreach ($files as $file) {
            $file = new File($dir->pwd() . DS . $file);
            $contents = $file->read();
            // $file->write('I am overwriting the contents of this file');
            // $file->append('I am adding to the bottom of this file.');
            // $file->delete(); // I am deleting this file
            $file->close(); // Be sure to close the file when you're done
        }
        $infor = json_decode($contents);

        $dispositivo = $this->Dispositivos->newEmptyEntity();
        if ($this->request->is('post')) {
            $dispositivo = $this->Dispositivos->patchEntity($dispositivo, $this->request->getData());
            // var_dump($dispositivo);
            $date = new DateTime();
            $calculo = $date->getTimestamp();
            $dispositivoSessao = md5(uniqid("$calculo", true));

            $dispositivo['sessao'] = $dispositivoSessao;

            $wppconnect = new Request([
                'base_url' => "$infor->host:$infor->port",
                'secret_key' => "$infor->secretKey",
                'session' => "$dispositivoSessao",
                'token' => null
            ]);
            $util = new Util();

            $response = $wppconnect->generateToken();
            $response = $util->toArray($response);
            if (isset($response['status']) and $response['status'] == 'success'){
                $wppconnect->options['token'] = $response['token'];
                $dispositivo['token'] = $response['token'];

                if ($this->Dispositivos->save($dispositivo)) {
                    $this->Flash->success(__('Dispositivo Salvo, Sessão gerada!'));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('Eita Disgrama...Houve um erro ai Homi! tenta denovo...'));
            }
            $this->Flash->error(__('Eita disgrama, servidor parece que tá off, configura direito aí homi!'));
        }
        $this->set(compact('dispositivo'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Dispositivo id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $dispositivo = $this->Dispositivos->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dispositivo = $this->Dispositivos->patchEntity($dispositivo, $this->request->getData());
            if ($this->Dispositivos->save($dispositivo)) {
                $this->Flash->success(__('The dispositivo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The dispositivo could not be saved. Please, try again.'));
        }
        $this->set(compact('dispositivo'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Dispositivo id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $dispositivo = $this->Dispositivos->get($id);

        $configs = $this->Conexaowpp->lerConfig();
        $wppconnect = new Request([
            'base_url' => "$configs->host:$configs->port",
            'secret_key' => "$configs->secretKey",
            'session' => "$dispositivo->sessao",
            'token' => "$dispositivo->token"
        ]);
        $util = new Util();

        $response = $wppconnect->logoutSession();
        $response2 = $wppconnect->closeSession();

        $response2 = json_decode($response2);

        if ($response2->message == 'Session successfully closed'){
            if ($this->Dispositivos->delete($dispositivo)) {
                $this->Flash->success(__('The dispositivo has been deleted.'));
            } else {
                $this->Flash->error(__('The dispositivo could not be deleted. Please, try again.'));
            }
        }
        return $this->redirect(['action' => 'index']);
    }
}
