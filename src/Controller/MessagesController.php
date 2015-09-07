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
        if ($this->request->is('post')) {
            $this->request->data['user_id'] = $this->Auth->user('id');
            $message = $this->Messages->patchEntity($message, $this->request->data);
            if ($this->Messages->save($message)) {
                return $this->redirect([
                    'plugin' => 'messages',
                    'controller' => 'threads',
                    'action' => 'view',
                    $message->thread_id
                ]);
            } else {
                $this->Flash->error(__('The message could not be saved. Please, try again.'));
                debug($message->errors());exit;
            }
        }
        return $this->redirect([
            'plugin' => 'messages',
            'controller' => 'threads',
            'action' => 'view',
        ]);
    }
}
