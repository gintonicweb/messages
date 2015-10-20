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

}
