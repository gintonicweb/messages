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
     * The main method for any enumeration, should be called statically
     * Now also supports reordering/filtering
     *
     * @link http://www.dereuromark.de/2010/06/24/static-enums-or-semihardcoded-attributes/
     * @param string $value or array $keys or NULL for complete array result
     * @return mixed string/array
     */
    public static function types($value = null)
    {
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
