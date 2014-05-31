<?php
namespace Teto\Utility;

/**
 * Unit test for \Teto\Utility\IOUtil
 *
 * @see     \Teto\Utility\IOUtil
 * @author  USAMI Kenta <tadsan@zonu.me>
 * @license http://opensource.org/licenses/MIT The MIT License
 */
class IOUtilTest extends  \Teto\TestCase
{
    public function test_isReadableMode_be_true()
    {
        $value = 'r+';
        $actual = IOUtil::isReadableMode($value);

        $this->assertTrue($actual);
    }

    public function test_isReadableMode_be_false()
    {
        $value = 'foo';
        $actual = IOUtil::isReadableMode($value);

        $this->assertFalse($actual);
    }

    public function test_isWritableMode_be_true()
    {
        $value = 'r+';
        $actual = IOUtil::isWritableMode($value);

        $this->assertTrue($actual);
    }

    public function test_isWritableMode_be_false()
    {
        $value = 'foo';
        $actual = IOUtil::isWritableMode($value);

        $this->assertFalse($actual);
    }

    public function test_isValidMode_be_true()
    {
        $value = 'r+';
        $actual = IOUtil::isValidMode($value);

        $this->assertTrue($actual);
    }

    public function test_isValidMode_be_false()
    {
        $value = 'foo';
        $actual = IOUtil::isValidMode($value);

        $this->assertFalse($actual);
    }
}