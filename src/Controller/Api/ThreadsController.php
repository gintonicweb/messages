<?php
namespace Messages\Controller\Api;

use App\Controller\Api\AppController;
use Cake\Network\Exception\UnauthorizedException;
use Cake\ORM\TableRegistry;

/**
 * Threads Controller
 *
 * @property \Messages\Model\Table\ThreadsTable $Threads
 */
class ThreadsController extends AppController
{
    public $paginate = [
        'page' => 1,
        'limit' => 5,
        'maxLimit' => 15,
    ];

    /**
     * Last method, returns the last thread modified
     *
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function last()
    {
        $thread = $this->Threads
            ->find('participating', [$this->Auth->user('id')])
            ->find('otherUsers', [$this->Auth->user('id')])
            ->order(['modified' => 'DESC'])
            ->first();

        $messages = $this->Threads->Messages->find()
            ->where(['thread_id' => $thread->id])
            ->order(['modified' => 'DESC']);


        $this->set(compact('thread'));
        $this->set('messages', $this->paginate($messages));
    }

    /**
     * View method
     *
     * @param int $id Id of the thread to view
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id)
    {
        $thread = $this->Threads
            ->find('otherUsers', [$this->Auth->user('id')])
            ->where(['Threads.id' => $id])
            ->first();

        $messages = $this->Threads->Messages->find()
            ->where(['thread_id' => $thread->id])
            ->order(['modified' => 'DESC']);

        $this->set(compact('thread'));
        $this->set('messages', $this->paginate($messages));
    }

    /**
     * Index method
     *
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function index()
    {
        $threads = $this->Threads
            ->find('participating', [$this->Auth->user('id')])
            ->find('otherUsers');
        $this->set('threads', $this->paginate($threads));
    }

    /**
     * Index method
     *
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function add()
    {
        if ($this->request->is('post', 'put')) {
            $userId = $this->Auth->user('id');
            $thread = $this->Threads->open($userId, $this->request->data);
            if ($thread) {
                $this->set(['success' => true, 'data' => $thread]);
                return;
            }
        }
        $this->set(['success' => false]);
    }
}
