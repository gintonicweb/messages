<?php
namespace Messages\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Threads Controller
 *
 * @property \Messages\Model\Table\ThreadsTable $Threads
 */
class ThreadsController extends AppController
{
    /**
     * View method
     *
     * @param string|null $id Thread id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $threads = $this->Threads
            ->find()
            ->contain([
                'Users',
                 'Messages' => function ($q){
                     // TODO: get a single message per thread
                     return $q->order('created DESC');
                }
            ])
            ->find('withUsers', [$this->Auth->user('id')]);

        $id = isset($id)? $id : $threads->first()->id;
        // TODO: handle no threads
        
        $messages = $this->Threads->Messages
            ->find()
            ->contain(['Threads', 'Users'])
            ->where(['Threads.id' => $id]);

        $this->set('threads', $this->paginate($threads));
        $this->set('messages', $this->paginate($messages));
        $this->set('_serialize', ['threads']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $thread = $this->Threads->newEntity();

        if ($this->request->is('post')) {

            $sender = $this->Threads->Users
                ->get($this->request->session()->read('Auth.User.id'));

            $recipient = $this->Threads->Users
                ->get($this->request->data['user']);

            if ($this->Threads->save($thread)) {

                $this->Threads->Users->link($thread, [$sender, $recipient]);
                $thread->addMessage($sender, $this->request->data['message']);

                $this->Flash->success(__('The thread has been saved.'));
                return $this->redirect(['action' => 'view']);

            } else {
                $this->Flash->error(__('The thread could not be saved. Please, try again.'));
            }
        }
        $users = $this->Threads->Users->find('list', ['limit' => 200]);
        $this->set(compact('thread', 'users'));
        $this->set('_serialize', ['thread']);
    }
}
