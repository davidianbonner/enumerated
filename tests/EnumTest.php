<?php

namespace DavidIanBonner\Enumerated;

use DavidIanBonner\Enumerated\EnumeratedServiceProvider;
use DavidIanBonner\Enumerated\EnumNotValidException;
use DavidIanBonner\Enumerated\Stubs\Consoles;
use DavidIanBonner\Enumerated\Stubs\Editor;
use DavidIanBonner\Enumerated\Stubs\Language;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Lang;
use Mockery;

class EnumTest extends TestCase
{
    protected $application_mock;

    protected $service_provider;

    protected function setUp(): void
    {
        $this->setUpMocks();

        $this->service_provider = new EnumeratedServiceProvider($this->application_mock);

        $this->service_provider->register();

        parent::setUp();
    }

    protected function setUpMocks()
    {
        $this->application_mock = Mockery::mock(Application::class);
    }

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

    /** @test */
    function it_can_return_line_for_an_item()
    {
        Lang::shouldReceive('get')->once()->with('enum.language.php')->andReturn('PHP');

        $line = Language::ofType(Language::PHP)->line();

        $this->assertEquals($line, 'PHP');
    }

    /** @test */
    function it_can_return_list_for_select()
    {
        Language::collect()->each(function ($lang) {
            Lang::shouldReceive('get')->once()->with('enum.language.' . $lang)->andReturn($lang);
        });

        $this->assertEquals([
            'php' => 'php',
            'javascript' => 'javascript',
            'css' => 'css',
            'go' => 'go',
            'html' => 'html',
            'python' => 'python',
        ], Language::toSelect());
    }

    /** @test */
    function it_can_prefix_the_lang_line()
    {
        Consoles::collect()->each(function ($console) {
            Lang::shouldReceive('get')
                ->once()
                ->with('package::enum.consoles.' . $console)
                ->andReturn($console);
        });

        $this->assertEquals([
            'playstation 4' => 'playstation 4',
            'xbox one' => 'xbox one',
            'nintendo switch' => 'nintendo switch',
        ], Consoles::toSelect());
    }

    /** @test */
    function it_can_assert_it_is_an_enum()
    {
        $console = Consoles::NINTENDO_SWITCH;

        $consoleEnum = enum_if($console, Consoles::class);

        $this->assertInstanceOf(Consoles::class, $consoleEnum);
    }

    /** @test */
    function it__will_return_null_if_not_enum()
    {
        $consoleEnum = enum_if(null, Consoles::class);

        $this->assertNull($consoleEnum);
    }
}
