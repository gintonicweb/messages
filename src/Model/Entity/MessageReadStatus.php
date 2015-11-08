<?php

namespace Messages\Model\Entity;

use Cake\ORM\Entity;

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
        return self::enum($value, $options);
    }

    /**
     * The main method for any enumeration, should be called statically
     * Now also supports reordering/filtering
     *
     * @link http://www.dereuromark.de/2010/06/24/static-enums-or-semihardcoded-attributes/
     * @param string $value or array $keys or NULL for complete array result
     * @param array $options (actual data)
     * @return mixed string/array
     */
    public static function enum($value, array $options, $default = null)
    {
        if ($value !== null && !is_array($value)) {
            if (array_key_exists($value, $options)) {
                return $options[$value];
            }
            return $default;
        }
        if ($value !== null) {
            $newOptions = [];
            foreach ($value as $v) {
                $newOptions[$v] = $options[$v];
            }
            return $newOptions;
        }
        return $options;
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
