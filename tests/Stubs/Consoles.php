<?php

namespace DavidIanBonner\Enumerated\Stubs;

use DavidIanBonner\Enumerated\Enumerated;
use DavidIanBonner\Enumerated\HasEnumeration;

enum Consoles: string implements Enumerated
{
    use HasEnumeration;

    case PLAYSTATION_4 = 'playstation 4';
    case XBOX_ONE = 'xbox one';
    case NINTENDO_SWITCH = 'nintendo switch';

    public static function key(): string
    {
        return 'consoles';
    }

    public static function keyPrefix(): string
    {
        return 'package::';
    }
}
