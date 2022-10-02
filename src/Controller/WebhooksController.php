<?php

declare(strict_types=1);

namespace App\Controller;

error_reporting(E_ERROR | E_PARSE);
use App\Controller\AppController;
use App\Model\Entity\Dispositivo;
use Cake\Event\EventInterface;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\Http\ServerRequest;
use WPPConnect\Http\Request;
use WPPConnect\Helpers\Util;

/**
 * Webhook Controller
 *
 * @method \App\Model\Entity\Webhook[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WebhooksController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Security');
        $this->loadComponent('Conexaowpp');
    }


    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['index']);

    }

    public function index()
    {

        $UsersDisp = TableRegistry::getTableLocator()->get('DispUsers');
        if ($this->request->is('get')){
            $parametros = $this->request->getQueryParams();
            $decodificarBase64 = $parametros['key'];
            $decodificarBase64 = base64_decode($decodificarBase64);
            $decodificarBase64 = explode("|",$decodificarBase64);
            $id_disp = $decodificarBase64[0];
            $sessao_disp = $decodificarBase64[1];
            $token_disp = $decodificarBase64[2];
           // var_dump($parametros['uuid']);

            $primeiraCamada = $UsersDisp->find()->where(['dispositivo_id' => $id_disp[0], 'user_id' => $parametros['uuid']])->first();

            if ($primeiraCamada != null){
                $configs = $this->Conexaowpp->lerConfig();
                $wppconnect = new Request([
                    'base_url' => "$configs->host:$configs->port",
                    'secret_key' => "$configs->secretKey",
                    'session' => "$sessao_disp",
                    'token' => "$token_disp"
                ]);
                $util = new Util();

                if (!array_key_exists('grupo',$parametros)){
                    $parametros['grupo'] = false;
                }

                switch ($parametros['tipo']){

                    case "message":
                        $response = $wppconnect->sendMessage([
                            'phone' => $parametros['numero'],
                            'message' => $parametros['mensagem'],
                            'isGroup' => $parametros['grupo']
                        ]);
                        $util->debug($response);
                        break;

                    case "file":
                        $response = $wppconnect->sendFileBase64([
                            'phone' => $parametros['numero'],
                            'filename' => $parametros['filename'],
                            'base64' => $util->fileToBase64($parametros['fileURL']),
                            'isGroup' => $parametros['grupo']
                        ]);
                        $util->debug($response);

                        break;

                    case "link":

                        $response = $wppconnect->sendLinkPreview([
                            'phone' => $parametros['numero'],
                            'url' => $parametros['url'],
                            'caption' => $parametros['caption'],
                            'isGroup' => $parametros['grupo']
                        ]);

                        $util->debug($response);

                }




            }
        }


      //  var_dump($query);
        if ($this->request->is('post')){
            echo "em construção";
/*            $headers = getallheaders();
            $autorizacao = base64_decode($headers['Authorization']);
            $autorizacao = explode('|',$autorizacao);
            //Allow raw POST's
            $jsonData = $this->request->input('json_decode');
          //  (string)$request->getBody();
            $url = 'php://input';
            //decode
            $json = json_decode(file_get_contents($url), true);
            if (is_null($json)) {
                // When something goes wrong, return an invalid status code
                // such as 400 BadRequest.
                throw new NotFoundException(__('falha ao processar'));
                header('HTTP/1.1 400 Bad Request');
            }*/
        }
    }

    public function exemplos($id = null)
    {

    }



}
