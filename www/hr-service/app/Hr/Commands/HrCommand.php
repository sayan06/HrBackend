<?php

namespace App\Hr\Commands;

use Illuminate\Console\Command;

abstract class HrCommand extends Command
{
    const NAMESPACE_COMMAND = 'hr';
    const NAMESPACE_PROJECT = 'Hr';

    abstract public function handle();
}
