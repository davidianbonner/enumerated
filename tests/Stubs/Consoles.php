<?php

namespace DavidIanBonner\Enumerated\Stubs;

use DavidIanBonner\Enumerated\Enum;

class Consoles extends Enum
{
    const PLAYSTATION_4 = 'playstation 4';
    const XBOX_ONE = 'xbox one';
    const NINTENDO_SWITCH = 'nintendo switch';

    public function langKey(): string
    {
        return 'consoles';
    }

    public function langKeyPrefix(): string
    {
        return 'package';
    }
}
