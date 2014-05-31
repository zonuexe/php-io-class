<?php
namespace Teto\Utility;

/**
 * Utility functions for IO-Classes
 *
 * @author  USAMI Kenta <tadsan@zonu.me>
 * @license http://opensource.org/licenses/MIT The MIT License
 */
class IOUtil
{
    private static $readable_modes = ['r', 'r+', 'w+', 'a+', 'x+', 'c+'];
    private static $writable_modes = ['r+', 'w', 'w+', 'a', 'a+', 'x', 'x+', 'c', 'c+'];
    
    /**
     * @param  string $mode
     * @return bool
     */
    public static function isReadableMode($mode)
    {
        return in_array($mode, self::$readable_modes);
    }

    /**
     * @param  string $mode
     * @return bool
     */
    public static function isWritableMode($mode)
    {
        return in_array($mode, self::$writable_modes);
    }

    /**
     * @param  string $mode
     * @return bool
     */
    public static function isValidMode($mode)
    {
        return self::isReadableMode($mode) || self::isWritableMode($mode);
    }
}
