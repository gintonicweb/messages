<?php
namespace Messages\Model\Table;

use Cake\Datasource\ConnectionManager;
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
     * Find unread messages
     *
     * @param \Cake\ORM\Query $query the original query to append to
     * @param array $users the list of users ids
     * @return \Cake\ORM\Query The amended query
     */
    public function findStatus(Query $query, array $users = null)
    {
        $query->contain(['MessageReadStatuses' => function ($q) use ($users) {
            return $q->where(['MessageReadStatuses.user_id' => $users['id']]);
        }]);
        return $query->formatResults(function ($messages) {
            return $messages->map(function ($message) {
                $message['status'] = $message['message_read_statuses'][0]['status'];
                return $message;
            });
        });
    }

    /**
     * Gets a list of recently updated threads and messages
     *
     * @todo figure how to do this with cakephps ORM
     *
     * @link http://www.xaprb.com/blog/2006/12/07/how-to-select-the-firstleastmax-row-per-group-in-sql/
     * @param int $userId user id
     * @return array list of recent threads
     */
    public function getRecent($userId)
    {
        $connection = ConnectionManager::get('default');
        $ids = $connection->execute('
            SELECT 
                messages.id
            FROM (
                SELECT 
                    messages.thread_id, 
                    max(messages.created) as created
                FROM message_read_statuses
                JOIN messages
                    ON message_read_statuses.message_id = messages.id
                WHERE message_read_statuses.user_id = ' . $userId . '
                    AND message_read_statuses.status != ' . MessageReadStatus::TYPE_DELETED . '
                GROUP BY messages.thread_id
            ) AS visibles 
            INNER JOIN threads
                ON visibles.thread_id = threads.id
            INNER JOIN messages
                ON visibles.thread_id = messages.thread_id
                AND visibles.created = messages.created
        ')->fetchAll('assoc');
        return Hash::extract($ids, '{n}.id');
    }
}
