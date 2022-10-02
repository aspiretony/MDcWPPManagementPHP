<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;

class ConexaowppComponent extends Component
{

    public function conectaWPP($token)
    {


        $http = new Client();
        $response = $http->post(
            $this->_server() . 'api/' . $token . '/' . $this->_token() . '/generate-token',
        );
        if ($response->isOk()) {
            return $response->getJson();
        } else {
            return $response->getStatusCode();
        }


    }

    public function lerConfig()
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
        return json_decode($contents);
    }

    public function checarStatus()
    {



    }

}
