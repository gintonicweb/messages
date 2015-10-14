<?php
namespace Messages\Controller;

use App\Controller\AppController;

/**
 * Messages Controller
 *
 * @property \Messages\Model\Table\MessagesTable $Messages
 */
class MessagesController extends AppController
{
    /**
     * Add method 
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $message = $this->Messages->newEntity();
        $status = 'error';

        if ($this->request->is('post')) {
            $this->request->data['user_id'] = $this->Auth->user('id');
            $message = $this->Messages->patchEntity($message, $this->request->data);
            if ($this->Messages->save($message)) {
                $status = 'success';
            }
        }

        $message->user = $this->Auth->user();
        $this->set(compact('status'));
        $this->set('_serialize', ['status']);
        $this->set('_ws', [
            'users' => $this->Messages->Users->find()->all(),
            'data' => $message->toArray()
        ]);
    }
}
