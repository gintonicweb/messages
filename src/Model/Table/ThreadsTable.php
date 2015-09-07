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
            'className' => 'Messages.Users'
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
     * Dynamic finder that find threads where a given set of users are
     * participants
     *
     * @param \Cake\ORM\Query $query the original query to append to
     * @param array $users the list of users id formatted according to cake stadards
     * @return \Cake\ORM\Query The amended query
     */
    public function findWithUsers(Query $query, array $users)
    {
        return $query
            ->matching('Users', function ($q) use ($users) {
                return $q
                    ->select(['Threads.id'])
                    ->where(['Users.id IN' => $users]);
            });
    }
}
