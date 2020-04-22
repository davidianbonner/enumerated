<?php

namespace DavidIanBonner\Enumerated\Stubs;

use DavidIanBonner\Enumerated\Enum;

class Language extends Enum
{
    const PHP = 'php';
    const JS = 'javascript';
    const CSS = 'css';
    const GO = 'go';
    const HTML = 'html';
    const PYTHON = 'python';

    protected $langKey = 'language';
}
