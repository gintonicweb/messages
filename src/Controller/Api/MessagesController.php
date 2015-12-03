<?php
namespace Messages\Controller\Api;

use App\Controller\Api\AppController;

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
        $status = 'error';

        if ($this->request->is('post')) {
            $message = $this->Messages->add(
                $this->Auth->user('id'),
                $this->request->data['thread_id'],
                $this->request->data
            );
            if ($message) {
                $status = 'success';
            }
        }

        $this->set(compact('status'));
        $this->set('_serialize', ['status']);
        $this->set('_ws', [
            'users' => $this->Messages->Users->find()->all(),
            'data' => $message->toArray()
        ]);
    }
}
