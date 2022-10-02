<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
/**
 * Server Controller
 *
 * @method \App\Model\Entity\Server[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ServerController extends AppController
{
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
            $conteudo = '';
            $conteudo = $contents;
            // $file->write('I am overwriting the contents of this file');
            // $file->append('I am adding to the bottom of this file.');
            // $file->delete(); // I am deleting this file
            $file->close(); // Be sure to close the file when you're done
        }
        $this->set(compact('conteudo'));
     //   $test = json_decode($contents);

    }








    public function update($update = null){

        if ($this->request->is('get')){
            return $this->redirect(['action' => 'index']);
        }
        if ($this->request->is('post')){
            $data = $this->request->getData();


            $base = $_SERVER['DOCUMENT_ROOT'];
            $app = basename(dirname(APP));
            $dir = new Folder($base.'/'.$app.'/nodeserver/src');

            $files = $dir->find('config.json');
            foreach ($files as $file) {
                $file = new File($dir->pwd() . DS . $file);
                if ($file->write($data['json'])){
                    $this->Flash->success(__('Configurações atualizada com sucesso.'));
                    return $this->redirect(['action' => 'index']);
                    $file->close();
                }else{
                    $this->Flash->success(__('Houve algum erro.'));
                    return $this->redirect(['action' => 'index']);
                }

            }


          //Future Update

          /*  $secretKey = $data['secretKey'];
            $host = $data['host'];
            $port = $data['port'];
            $deviceName = $data['deviceName'];
            $poweredBy = $data['poweredBy'];
            $startAllSession = $data['startAllSession'];
            switch ($startAllSession){
                case 'on':
                    $startAllSession = true;
                    break;
                default:
                    $startAllSession = false;
                    break;
            }
            $tokenStoreType = $data['tokenStoreType'];
            $maxListeners = $data['maxListeners'];
            $customUserDataDir = $data['customUserDataDir'];
            $webhookUrl = $data['WebhookUrl'];
            $ulala = '{
  "secretKey": "'.$secretKey.'",
  "host": "'.$host.'",
  "port": "'.$port.'",
  "deviceName": "'.$deviceName.'",
  "poweredBy": "'.$poweredBy.'",
  "startAllSession": "'.$startAllSession.'",
  "tokenStoreType": "'.$tokenStoreType.'",
  "maxListeners": "'.$maxListeners.'",
  "customUserDataDir": "'.$customUserDataDir.'",
  "webhook": {
    "url": "'.$webhookUrl.'",
    "autoDownload": true,
    "uploadS3": false,
    "readMessage": true,
    "allUnreadOnStart": false,
    "listenAcks": true,
    "onPresenceChanged": true,
    "onParticipantsChanged": true,
    "onReactionMessage": true
  },
  "archive": {
    "enable": false,
    "waitTime": 10,
    "daysToArchive": 45
  },
  "log": {
    "level": "error",
    "logger": ["console", "file"]
  },
  "createOptions": {
    "browserArgs": [
      "--disable-web-security",
      "--no-sandbox",
      "--disable-web-security",
      "--aggressive-cache-discard",
      "--disable-cache",
      "--disable-application-cache",
      "--disable-offline-load-stale-cache",
      "--disk-cache-size=0",
      "--disable-background-networking",
      "--disable-default-apps",
      "--disable-extensions",
      "--disable-sync",
      "--disable-translate",
      "--hide-scrollbars",
      "--metrics-recording-only",
      "--mute-audio",
      "--no-first-run",
      "--safebrowsing-disable-auto-update",
      "--ignore-certificate-errors",
      "--ignore-ssl-errors",
      "--ignore-certificate-errors-spki-list"
    ]
  },
  "mapper": {
    "enable": false,
    "prefix": "tagone-"
  },
  "db": {
    "mongodbDatabase": "tokens",
    "mongodbCollection": "",
    "mongodbUser": "",
    "mongodbPassword": "",
    "mongodbHost": "",
    "mongoIsRemote": true,
    "mongoURLRemote": "",
    "mongodbPort": 27017,
    "redisHost": "localhost",
    "redisPort": 6379,
    "redisPassword": "",
    "redisDb": 0,
    "redisPrefix": "docker"
  }
}';



            $json = json_encode($ulala);

            var_dump($json);

            die();

            $this->Flash->success(__('The server has been saved.'));*/
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Server id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */

    public function edit($id = null)
    {
        $server = $this->Server->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $server = $this->Server->patchEntity($server, $this->request->getData());
            if ($this->Server->save($server)) {
                $this->Flash->success(__('The server has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The server could not be saved. Please, try again.'));
        }
        $this->set(compact('server'));
    }

}
