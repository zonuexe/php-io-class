<?php
namespace Teto\Traits;

use Teto\Utility\IOUtil;

/**
 * Trait for writable class
 *
 * @author  USAMI Kenta <tadsan@zonu.me>
 * @license http://opensource.org/licenses/MIT The MIT License
 */
trait Writable
{
    /**
     * @return bool
     */
    public function isWritable()
    {
        return IOUtil::isWritableMode($this->mode);
    }
}
