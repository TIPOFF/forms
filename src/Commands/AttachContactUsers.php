<?php

declare(strict_types=1);

namespace Tipoff\Forms\Commands;

use Illuminate\Console\Command;
use Tipoff\Forms\Models\Contact;

class AttachContactUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attach:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Attach contacts to users with matching emails that have not yet been linked.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $contacts = Contact::whereNull('user_id')->get();
        foreach ($contacts as $contact) {
            $user = app('user')->where('email', '=', $contact->email)->first();
            if ($user) {
                $contact->user_id = $user->id;
                $contact->save();
            }
        }
    }
}
