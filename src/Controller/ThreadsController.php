<?php
namespace Messages\Controller;

use App\Controller\AppController;
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
        $userId = $this->Auth->user('id');
        if (!$userId) {
            throw new UnauthorizedException('You need to be authenticated to access this section');
        }

        $threads = $this->Threads->find('summary', [$userId]);
        $thread = $threads->select('id')->first();

        $id = null;
        if ($thread) {
            $id = $thread->id;
        }
        $this->set('id', $id);
        $this->set('_serialize', ['id']);
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
                if (!$this->request->params['isAjax']) {
                    $this->setAction('index');
                }
                return;
            } 
        }
        $this->set([
            'success' => false,
            '_serialize' => ['success']
        ]);
    }
}
