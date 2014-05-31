<?php
namespace Teto;

/**
 * Unit test for \Teto\StringIO
 *
 * @see     \Teto\StringIO
 * @author  USAMI Kenta <tadsan@zonu.me>
 * @license http://opensource.org/licenses/MIT The MIT License
 */
class StringIOTest extends  \Teto\TestCase
{
    public function test_string_is_empty()
    {
        $str = '';
        $actual = new StringIO($str);

        $this->assertSame($str, $actual->getString());

        $this->assertTrue($actual->valid());
        $this->assertSame('', $actual->current());

        $actual->next();

        $this->assertFalse($actual->valid());
    }

    public function test_string_is_oneline()
    {
        $str = 'mikumiku';
        $actual = new StringIO($str);

        $this->assertSame($str, $actual->getString());

        $this->assertTrue($actual->valid());
        $this->assertSame('mikumiku', $actual->current());

        $actual->next();

        $this->assertFalse($actual->valid());
    }
    
    public function test_string_starts_with_newline()
    {
        $str = '
abc
';
        $actual = new StringIO($str);

        $this->assertSame($str, $actual->getString());

        $this->assertTrue($actual->valid());
        $this->assertSame(0, $actual->getCurrentPosition());
        $this->assertSame(0, $actual->getNextNewline());
        $this->assertSame('', $actual->current());
        $actual->next();
        
        $this->assertTrue($actual->valid());
        $this->assertSame(1, $actual->getCurrentPosition());
        $this->assertSame(4, $actual->getNextNewline());
        $this->assertSame('abc', $actual->current());
        $actual->next();

        $this->assertTrue($actual->valid());
        $this->assertSame(5, $actual->getCurrentPosition());
        $this->assertSame(-1, $actual->getNextNewline());
        $this->assertSame('', $actual->current());
        $actual->next();

        $this->assertFalse($actual->valid());
        $this->assertSame(5, $actual->getCurrentPosition());
    }

    public function test_string_contains_only_newline()
    {
        $str = "\n\n\n";
        $actual = new StringIO($str);

        $this->assertSame($str, $actual->getString());

        $this->assertTrue($actual->valid());
        $this->assertSame(0, $actual->getCurrentPosition());
        $this->assertSame(0, $actual->getNextNewline());
        $this->assertSame('', $actual->current());
        $actual->next();
        
        $this->assertTrue($actual->valid());
        $this->assertSame(1, $actual->getCurrentPosition());
        $this->assertSame(1, $actual->getNextNewline());
        $this->assertSame('', $actual->current());
        $actual->next();

        $this->assertTrue($actual->valid());
        $this->assertSame(2, $actual->getCurrentPosition());
        $this->assertSame(2, $actual->getNextNewline());
        $this->assertSame('', $actual->current());
        $actual->next();

        $this->assertTrue($actual->valid());
        $this->assertSame(3, $actual->getCurrentPosition());
        $this->assertSame(-1, $actual->getNextNewline());
        $this->assertSame('', $actual->current());
        $actual->next();

        $this->assertFalse($actual->valid());
        $this->assertSame(3, $actual->getCurrentPosition());
        $this->assertSame(-1, $actual->getNextNewline());
    }
    
    public function test_string_3_line()
    {
        $str = 'abc
def
ghi';
        $actual = new StringIO($str);

        $this->assertSame($str, $actual->getString());

        $this->assertTrue($actual->valid());
        $this->assertSame(0, $actual->getCurrentPosition());
        $this->assertSame(3, $actual->getNextNewline());
        $this->assertSame('abc', $actual->current());
        $actual->next();

        $this->assertTrue($actual->valid());
        $this->assertSame(4, $actual->getCurrentPosition());
        $this->assertSame(7, $actual->getNextNewline());
        $this->assertSame('def', $actual->current());
        $actual->next();

        $this->assertTrue($actual->valid());
        $this->assertSame(8, $actual->getCurrentPosition());
        $this->assertSame(-1, $actual->getNextNewline());
        $this->assertSame('ghi', $actual->current());
        $actual->next();

        $this->assertFalse($actual->valid());
        $this->assertSame(11, $actual->getCurrentPosition());
        $this->assertSame(-1, $actual->getNextNewline());
    }

    public function test_string_3_line_with_last_newline()
    {
        $str = 'abc
def
ghi
';
        $actual = new StringIO($str);

        $this->assertSame($str, $actual->getString());

        $this->assertTrue($actual->valid());
        $this->assertSame(0, $actual->getCurrentPosition());
        $this->assertSame(3, $actual->getNextNewline());
        $this->assertSame('abc', $actual->current());
        $actual->next();

        $this->assertTrue($actual->valid());
        $this->assertSame(4, $actual->getCurrentPosition());
        $this->assertSame(7, $actual->getNextNewline());
        $this->assertSame('def', $actual->current());
        $actual->next();

        $this->assertTrue($actual->valid());
        $this->assertSame(8, $actual->getCurrentPosition());
        $this->assertSame(11, $actual->getNextNewline());
        $this->assertSame('ghi', $actual->current());
        $actual->next();

        $this->assertTrue($actual->valid());
        $this->assertSame(12, $actual->getCurrentPosition());
        $this->assertSame(-1, $actual->getNextNewline());
        $this->assertSame('', $actual->current());
        $actual->next();

        $this->assertFalse($actual->valid());
        $this->assertSame(12, $actual->getCurrentPosition());
        $this->assertSame(-1, $actual->getNextNewline());
    }
}
