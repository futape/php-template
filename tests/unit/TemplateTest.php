<?php


use Futape\PhpTemplate\Template;
use Futape\PhpTemplate\Exception\InvalidVariableNameException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Futape\PhpTemplate\Template
 */
class TemplateTest extends TestCase
{
    public function testRender()
    {
        $template = new Template(dirname(__DIR__) . '/fixtures/template.php');
        $template->addVariable('name', 'John Doe');
        $template->addVariable('birth', new DateTime('1970-01-01T00:00:00Z'));
        $template->addVariable('country', 'DE');

        $this->assertEquals('Name: John Doe' . "\n" . 'Birth: 1.1.1970' . "\n" . 'Country: DE', $template->render());
    }

    public function testRenderFailure()
    {
        $template = new Template('./not_existing.php');

        $this->assertNull(@$template->render());
    }

    public function testAddVariableWithInvalidName()
    {
        $template = new Template(dirname(__DIR__) . '/fixtures/template.php');
        $this->expectException(InvalidVariableNameException::class);
        $template->addVariable('foo bar', 'John Doe');
    }
}
