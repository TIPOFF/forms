<?php

namespace Tipoff\Forms\Commands;

use Illuminate\Console\Command;

class FormsCommand extends Command
{
    public $signature = 'forms';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
