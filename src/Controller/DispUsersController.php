<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * DispUsers Controller
 *
 * @property \App\Model\Table\DispUsersTable $DispUsers
 * @method \App\Model\Entity\DispUser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DispUsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Dispositivos'],
        ];
        $dispUsers = $this->paginate($this->DispUsers);

        $this->set(compact('dispUsers'));
    }

    /**
     * View method
     *
     * @param string|null $id Disp User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $dispUser = $this->DispUsers->get($id, [
            'contain' => ['Users', 'Dispositivos'],
        ]);

        $this->set(compact('dispUser'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $dispUser = $this->DispUsers->newEmptyEntity();
        if ($this->request->is('post')) {
            $dispUser = $this->DispUsers->patchEntity($dispUser, $this->request->getData());
            if ($this->DispUsers->save($dispUser)) {
                $this->Flash->success(__('The disp user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The disp user could not be saved. Please, try again.'));
        }
        $users = $this->DispUsers->Users->find('list', ['limit' => 200])->all();
        $dispositivos = $this->DispUsers->Dispositivos->find('list', ['limit' => 200])->all();
        $this->set(compact('dispUser', 'users', 'dispositivos'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Disp User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $dispUser = $this->DispUsers->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dispUser = $this->DispUsers->patchEntity($dispUser, $this->request->getData());
            if ($this->DispUsers->save($dispUser)) {
                $this->Flash->success(__('The disp user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The disp user could not be saved. Please, try again.'));
        }
        $users = $this->DispUsers->Users->find('list', ['limit' => 200])->all();
        $dispositivos = $this->DispUsers->Dispositivos->find('list', ['limit' => 200])->all();
        $this->set(compact('dispUser', 'users', 'dispositivos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Disp User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $dispUser = $this->DispUsers->get($id);
        if ($this->DispUsers->delete($dispUser)) {
            $this->Flash->success(__('The disp user has been deleted.'));
        } else {
            $this->Flash->error(__('The disp user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
