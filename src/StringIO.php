<?php
namespace Teto;

use Teto\Utility\IOUtil;

/**
 * Pseudo-IO class for string
 *
 * @author  USAMI Kenta <tadsan@zonu.me>
 * @license http://opensource.org/licenses/MIT The MIT License
 * @note    default newline character is `\n`(0xA0)
 */
class StringIO implements IO, \SeekableIterator
{
    use Traits\Readable;
    use Traits\Writable;

    private $string = '';
    private $mode   = '';
    private $pos    = 0;

    private $newline = "\n";

    private $is_terminal = false;
    
    /**
     * @param  string $string
     * @param  string $mode
     * @param  array  $params
     * @throws \DomainException
     * @throws \InvalidArgumentsException
     */
    public function __construct($string = '', $mode = 'r+', array $params = [])
    {
        if (!is_string($string)) { throw new \InvalidArgumentException; }
        if (!is_string($mode)  ) { throw new \InvalidArgumentException; }
        if (!is_array($params) ) { throw new \InvalidArgumentException; }

        if (!IOUtil::isValidMode($mode)) {
            throw new \DomainException;
        }

        $this->string = $string;
        $this->mode   = $mode;

        $this->setOption($params);
    }

    public function seek($position)
    {
        $this->pos = $position;
    }

    /**
     * @return string a string of current line
     */
    public function current()
    {
        $len = strlen($this->string);
        $next_newline = $this->getNextNewline();

        if ($this->pos === $next_newline) {
            $current = '';
        } elseif ($len === 0) {
            $current = '';
        } elseif ($this->pos === $len) {
            $current = '';
        } else {
            $next_newline = ($next_newline === -1) ? $len : $next_newline;
            $offset = $next_newline - $this->pos;
            $current = substr($this->string, $this->pos, $offset);
        }

        if ($current === false) {
            throw new \LogicException;
        }

        return $current;
    }

    /**
     * @return int
     */
    public function key()
    {
        throw new \LogicException;
    }

    /**
     * @return null
     */
    public function next()
    {
        $next_newline = $this->getNextNewline();

        if ($next_newline === -1) {
            $this->is_terminal = true;
            $this->pos = strlen($this->string);
        } else {
            $this->pos = $this->getNextNewline() + strlen($this->newline);
        }
    }

    /**
     * @return null
     */
    public function rewind()
    {
        $this->pos = 0;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return !$this->isTerminal() && 0 <= $this->pos && $this->pos <= strlen($this->string);
    }

    /**
     * @return int next newline position.
     */
    public function getNextNewline()
    {
        $offset = min(strlen($this->string), strlen($this->newline));
        $offset = 0;
        $next_newline = strpos($this->string, $this->newline, $this->pos + $offset);

        if ($next_newline === false) {
            $next_newline = -1;
        }

        return $next_newline;
    }

    /**
     * @return int
     */
    public function getCurrentPosition()
    {
        return $this->pos;
    }
    
    /**
     * @return string
     */
    public function getString()
    {
        return $this->string;
    }

    /**
     * @return bool
     * @note   This method has side-effect.
     */
    public function isTerminal()
    {
        if ($this->pos !== strlen($this->string)) {
            $this->is_terminal = false;
        }

        return $this->is_terminal;
    }

    /**
     * @throws \DomainException
     * @throws \InvalidArgumentException
     */
    private function setOption(array $params)
    {
        if (isset($params['newline'])) {
            if (is_string($params['newline'])) { throw new \InvalidArgumentException; }
            $this->newline = $params['newline'];
        }
    }
}
