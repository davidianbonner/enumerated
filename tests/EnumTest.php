<?php

namespace DavidIanBonner\Enumerated;

use Mockery;
use Illuminate\Support\Collection;
use DavidIanBonner\Enumerated\Stubs\Editor;
use DavidIanBonner\Enumerated\Stubs\Language;
use DavidIanBonner\Enumerated\EnumNotValidException;

class EnumTest extends TestCase
{
    /** @test */
    function it_only_performs_constant_reflection_once_and_caches_the_values()
    {
        // Language::resetValues();

        $mock = Mockery::mock(Language::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $mock->shouldReceive('getDeclaredConstants')
            ->once()
            ->andReturn([
                'PHP' => 'php',
                'JS' => 'javascript',
                'CSS' => 'css',
                'GO' => 'go',
                'HTML' => 'html',
                'PYTHON' => 'python',
            ]);

        $mock->allValues();
        $mock->allValues();
    }

    /** @test */
    function it_can_return_an_array_of_values()
    {
        $values = Language::allValues();

        $this->assertTrue(is_array($values));
        $this->assertCount(6, $values);
        $this->assertEquals([
            'php',
            'javascript',
            'css',
            'go',
            'html',
            'python',
        ], $values);
    }

    /** @test */
    function it_can_return_an_array_of_values_with_keys()
    {
        $values = Language::allValues(true);

        $this->assertTrue(is_array($values));
        $this->assertCount(6, $values);
        $this->assertEquals([
            'PHP' => 'php',
            'JS' => 'javascript',
            'CSS' => 'css',
            'GO' => 'go',
            'HTML' => 'html',
            'PYTHON' => 'python',
        ], $values);
    }

    /** @test */
    function it_can_validate_a_value()
    {
        Editor::validateValue(Editor::VIM);
        $this->assertTrue(true);
    }

    /** @test */
    function it_can_validate_a_value_and_return_boolean()
    {
        $this->assertTrue(Editor::isValid('vim'));
        $this->assertFalse(Editor::isValid('Editor::FOOBAR'));
    }

    /** @test */
    function it_can_return_a_value()
    {
        $language = Language::ofType(Language::PHP);

        $this->assertInstanceOf(Language::class, $language);
        $this->assertEquals('php', $language->value());

        $editor = Editor::ofType(Editor::SUBLIME);

        $this->assertInstanceOf(Editor::class, $editor);
        $this->assertEquals('sublime text 3', $editor->value());
    }

    /** @test */
    function it_will_throw_an_exception_if_the_value_is_invalid()
    {
        $this->expectException(EnumNotValidException::class);

        Language::ofType('foobar');
    }

    /** @test */
    function it_can_return_a_collection()
    {
        $language = Language::collect(true);
        $editor = Editor::collect();

        $this->assertInstanceOf(Collection::class, $language);
        $this->assertInstanceOf(Collection::class, $editor);

        $this->assertEquals([
            'PHP' => 'php',
            'JS' => 'javascript',
            'CSS' => 'css',
            'GO' => 'go',
            'HTML' => 'html',
            'PYTHON' => 'python',
        ], $language->all());

        $this->assertEquals([
            'visual studio code', 'sublime text 3', 'vim',
        ], $editor->all());
    }
}
