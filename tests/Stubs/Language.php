<?php

namespace DavidIanBonner\Enumerated\Stubs;

use DavidIanBonner\Enumerated\Enumerated;
use DavidIanBonner\Enumerated\HasEnumeration;

enum Language: string implements Enumerated
{
    use HasEnumeration;

    case PHP = 'php';
    case JS = 'javascript';
    case CSS = 'css';
    case GO = 'go';
    case HTML = 'html';
    case PYTHON = 'python';

    public static function key(): string
    {
        return 'language';
    }
}
