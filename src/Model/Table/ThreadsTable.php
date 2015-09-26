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
     * Dynamic finder that loads all users for a thread without me
     *
     * @param \Cake\ORM\Query $query the original query to append to
     * @param array $users the list of users to be ignored
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
     * Dynamic finder to restrict the query where at least some undeleted 
     * messages exist in the thread
     *
     * @param \Cake\ORM\Query $query the original query to append to
     * @param array $users the list of users id formatted according to cake stadards
     * @return \Cake\ORM\Query The amended query
     */
    public function findSummary(Query $query, array $users)
    {
        // Retrieve the last visible (not deleted) message for user per thread
        $messages = $this->Messages->getRecent($users[0]);

        return $query
            ->find('otherUsers', $users)
            ->matching('Messages', function($q) use ($messages) {
                return $q->where(['Messages.id IN' => $messages]);
            });
    }

    /**
     * Links the sender and reciever to the thread then adds the message
     *
     * @param \Cake\ORM\Query $query the original query to append to
     * @param array $users the list of users id formatted according to cake stadards
     * @return \Cake\ORM\Query The amended query
     */
    public function open(Thread $thread, $userId, $data)
    {
        $sender = $this->Users->get($userId);
        $recipient = $this->Users->get($data['user']);
        $this->patchEntity($thread, [$data['thread']]);

        if (!$this->save($thread)) {
            return false;
        }

        $this->Users->link($thread, [$sender, $recipient]);
        $thread->addMessage($sender, $data['message']);
        return true;
    }
}
