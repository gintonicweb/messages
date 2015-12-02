<?php
namespace Messages\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Messages\Model\Entity\Thread;

/**
 * Threads Model
 *
 * @property \Cake\ORM\Association\HasMany $Messages
 * @property \Cake\ORM\Association\BelongsToMany $Users
 */
class ThreadsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('threads');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Messages', [
            'foreignKey' => 'thread_id',
            'className' => 'Messages.Messages'
        ]);
        $this->belongsToMany('Users', [
            'foreignKey' => 'thread_id',
            'targetForeignKey' => 'user_id',
            'joinTable' => 'threads_users',
            'className' => 'Users.Users'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        return $validator;
    }

    /**
     * Dynamic finder that find threads where given users are involved
     *
     * @param \Cake\ORM\Query $query the original query to append to
     * @param array $users the list of user ids like ```[1, 2, 3]```
     * @return \Cake\ORM\Query The amended query
     */
    public function findParticipating(Query $query, array $users = null)
    {
        if (empty($users)) {
            return $query;
        }
        return $query
            ->matching('Users', function ($q) use ($users) {
                return $q->where(['Users.id IN' => $users]);
            });
    }

    /**
     * Dynamic finder that loads all users for a thread without me
     *
     * @param \Cake\ORM\Query $query the original query to append to
     * @param array $users the list of users to be ignored like ```[1, 2, 3]```
     * @return \Cake\ORM\Query The amended query
     */
    public function findOtherUsers(Query $query, array $users)
    {
        return $query
            ->contain(['Users' => function ($q) use ($users) {
                return $q->where(['Users.id NOT IN' => $users]);
            }]);
    }

    /**
     * Dynamic finder that loads all users for a thread without me
     *
     * @param \Cake\ORM\Query $query the original query to append to
     * @param array $users the list of users to be ignored
     * @return \Cake\ORM\Query The amended query
     */
    public function findReadStatus(Query $query, array $users)
    {
        $query->contain(['Messages' => function ($q) use ($users) {
            return $q->find('readStatus', $users);
        }]);
        return $query->map(function ($thread) {
            $opened = false;
            foreach ($thread['messages'] as $message) {
                if ($message['message_read_statuses'][0]['opened']) {
                    $opened = true;
                    break;
                }
            }
            $thread['opened'] = $opened;
            return $thread;
        });
    }

    /**
     * Creates the thread, then links the sender and reciever to it, then adds
     * the message to the thread. The messages table is in charge of handling
     * message read statuses
     *
     * ```
     * $data = [
     *     'thread' => ['title' => 'This is a title'],
     *     'message' => ['body' => 'This is a message'],
     *     'users' => [1,2,3,4],
     * ]
     * ```
     *
     * @param int $userId Id of the sender
     * @param array $data message data
     * @return \Cake\ORM\Entity
     */
    public function open($userId, array $data)
    {
        // Create thread
        $thread = $this->newEntity($data['thread']);
        $this->save($thread);

        // Retrieve users involved and adds them to the thread
        $sender = $this->Users->get($userId);
        $recipients = $this->Users->find()
            ->where(['id IN' => $data['users']])
            ->andWhere(['id NOT IN' => $sender->id])
            ->toArray();

        $recipients[] = $sender;
        $this->Users->link($thread, $recipients);

        // Add Message to thread
        $message = $this->Messages->add($sender, $thread, $data['message']);
        $thread->messages = [$message];
        return $thread;
    }
}
