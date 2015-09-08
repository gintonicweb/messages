<?php

namespace Messages\Model\Entity;

use GintonicCMS\ORM\Entity;

/**
 * MessageReadStatus Entity.
 */
class MessageReadStatus extends Entity
{

    const TYPE_UNREAD = 0;
    const TYPE_READ = 1;
    const TYPE_DELETED = 2;

    /**
     * static enum: DescriptorChoice::types()
     * @access static
     */
     public static function types($value = null) {
        $options = [
            self::TYPE_UNREAD => 'unread',
            self::TYPE_READ => 'read',
            self::TYPE_DELETED => 'deleted',
        ];
        return parent::enum($value, $options);
    }

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
}
