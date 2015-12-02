<?php
namespace Messages\Model\Table;

use Cake\Datasource\ConnectionManager;
use Cake\Event\Event;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Hash;
use Cake\Validation\Validator;
use Messages\Model\Entity\Message;
use Messages\Model\Entity\MessageReadStatus;

/**
 * Messages Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Threads
 * @property \Cake\ORM\Association\HasMany $MessageReadStatuses
 */
class MessagesTable extends Table
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

        $this->table('messages');
        $this->displayField('body');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            'className' => 'Messages.Users'
        ]);
        $this->belongsTo('Threads', [
            'foreignKey' => 'thread_id',
            'joinType' => 'INNER',
            'className' => 'Messages.Threads'
        ]);
        $this->hasMany('MessageReadStatuses', [
            'foreignKey' => 'message_id',
            'className' => 'Messages.MessageReadStatuses'
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

        $validator
            ->requirePresence('thread_id', 'create')
            ->notEmpty('thread_id');

        $validator
            ->requirePresence('body', 'create')
            ->notEmpty('body');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['thread_id'], 'Threads'));
        return $rules;
    }

    /**
     * BeforeSave
     *
     * @param \Cake\Event\Event $event Event instance.
     * @param \Cake\ORM\Entity $entity Entity instance.
     * @return void
     */
    public function beforeSave(Event $event, Entity $entity)
    {
        $thread = $this->Threads->get($entity->thread_id);
        $this->Threads->touch($thread);
    }

    /**
     * Adds the 'read' property to the messages
     *
     * @param \Cake\ORM\Query $query the original query to append to
     * @param array $users the user id like ```['id' => 1]```
     * @return \Cake\ORM\Query The amended query
     */
    public function findReadStatus(Query $query, array $users = null)
    {
        $query->contain(['MessageReadStatuses' => function ($q) use ($users) {
            return $q->where(['MessageReadStatuses.user_id' => $users['id']]);
        }]);
        return $query->formatResults(function ($messages) {
            return $messages->map(function ($message) {
                $message['opened'] = $message['message_read_statuses'][0]['opened'];
                return $message;
            });
        });
    }

    /**
     * Adds a message to the given thread and creates the matching
     * "messageReadStatuses" for each participant.
     *
     * @param  \Cake\ORM\Entity $sender the user sending the message
     * @param  \Cake\ORM\Entity $thread the thread on which the message is sent
     * @param  array $messageData content of the message
     * @return \Cake\ORM\Entity|bool The newly created entity or false on fail
     */
    public function add(Entity $sender, Entity $thread, array $messageData)
    {
        $messageData['user_id'] = $sender->id;
        $messageData['thread_id'] = $thread->id;

        if (!isset($thread->users)) {
            $thread = $this->Threads->find()
                ->where(['id' => $thread->id])
                ->contain(['Users'])
                ->first();
        }

        foreach ($thread->users as $user) {
            $messageData['message_read_statuses'][] = [
                'user_id' => $user->id
            ];
        }
        $message = $this->newEntity($messageData, [
            'associated' => ['MessageReadStatuses']
        ]);
        return $this->save($message);
    }
}
