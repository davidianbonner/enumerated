<?php

namespace DavidIanBonner\Enumerated;

use DavidIanBonner\Enumerated\Stubs\Consoles;
use DavidIanBonner\Enumerated\Stubs\Language;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Lang;
use SebastianBergmann\Environment\Console;

class EnumTest extends TestCase
{
    /** @test */
    function it_can_return_an_array_of_values()
    {
        $values = Language::values();

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
    function it_can_return_a_collection()
    {
        $language = Language::collect();

        $this->assertInstanceOf(Collection::class, $language);

        $this->assertEquals([
            'php',
            'javascript',
            'css',
            'go',
            'html',
            'python',
        ], $language->all());
    }

    /** @test */
    function it_can_return_line_for_an_item()
    {
        Lang::shouldReceive('get')->once()->with('enum.language.php')->andReturn('PHP');

        $line = Language::PHP->line();

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
        ], Language::toSelect()->toArray());
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
        ], Consoles::toSelect()->toArray());
    }

    /** @test */
    function it_will_return_true_if_enum_is_exists()
    {
        $this->assertTrue(Consoles::exists('playstation 4'));
    }

    /** @test */
    function it_will_return_false_if_enum_value_doesnot_exist()
    {
        $this->assertFalse(Consoles::exists('playstation 360'));
    }
}
