<?php
namespace Teto\Traits;

use Teto\Utility\IOUtil;

/**
 * Trait for writable class
 *
 * @author  USAMI Kenta <tadsan@zonu.me>
 * @license http://opensource.org/licenses/MIT The MIT License
 */
trait Readable
{
    /**
     * @return bool
     */
    public function isReadable()
    {
        return IOUtil::isReadableMode($this->mode);
    }
}
