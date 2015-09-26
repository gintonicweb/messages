<?php
namespace Messages\Model\Entity;

use Cake\Datasource\EntityInterface;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Thread Entity.
 */
class Thread extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     * Note that '*' is set to true, which allows all unspecified fields to be
     * mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    /**
     * Add a message to the given thread and creates the matching
     * "messageReadStatuses" for each participant.
     *
     * @param  \Cake\Datasource\EntityInterface $sender the user entity
     * @param  array $messageData content of the message
     * @return void
     */
    public function addMessage(EntityInterface $sender, array $messageData)
    {
        $messageData['user_id'] = $sender->id;
        $messageData['thread_id'] = $this->id;
        foreach ($this->users as $user) {
            $messageData['message_read_statuses'][] = [
                'user_id' => $user->id
            ];
        }
        $messagesTable = TableRegistry::get('Messages.Messages');
        $message = $messagesTable->newEntity($messageData, [
            'associated' => ['MessageReadStatuses']
        ]);
        $messagesTable->save($message);
    }
}
