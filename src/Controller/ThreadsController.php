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
    public $paginate = [
        'limit' => 5,
    ];

    /**
     * View method
     *
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function index()
    {
        $threads = $this->Threads->find('summary', [$this->Auth->user('id')]);
        $id = $threads->select('id')->first()->id;
        $this->set('id', $id);
        $this->set('_serialize', ['id']);
    }

    /**
     * View method
     *
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view()
    {
        if (isset($this->request->data['id'])) {
            $id = $this->request->data['id'];
        } else {
            $threads = $this->Threads->find('summary', [$this->Auth->user('id')]);
            $id = $threads->select('id')->first()->id;
        }

        $thread = $this->Threads
            ->find('otherUsers', [$this->Auth->user('id')])
            ->where(['Threads.id' => $id])
            ->first();

        $messages = $this->Threads->Messages
            ->find()
            ->contain(['Users'])
            ->where(['Messages.thread_id' => $id]);

        $this->set('thread', $thread);
        $this->set('messages', $this->paginate($messages));
        $this->set('_serialize', ['messages', 'thread']);
    }

    /**
     * Summary method
     *
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function summary()
    {
        $threads = $this->Threads->find('summary', [$this->Auth->user('id')]);
        if ($threads->count() < 1) {
            // TODO: something about that
        }
        $this->set('threads', $this->paginate($threads));
        $this->set('_serialize', ['threads']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $userId = $this->Auth->user('id');
            $thread = $this->Threads->open($userId, $this->request->data);
            if ($thread) {
                $this->set([
                    'success' => true,
                    'data' => ['id' => $thread->id],
                    '_serialize' => ['success', 'data']
                ]);
                return;
            } 
        }
        $this->set([
            'success' => false,
            '_serialize' => ['success']
        ]);
    }
}
