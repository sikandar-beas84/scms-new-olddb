<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\LoginSessionModel;

class CleanupOldLoginSessions extends BaseCommand
{
    protected $group       = 'Custom';
    protected $name        = 'cleanup:oldlogins';
    protected $description = 'Delete old, inactive login sessions older than 30 days';

    public function run(array $params)
    {
        $loginSessionModel = new LoginSessionModel();

        $builder = $loginSessionModel->builder();
        $builder->where('is_active', false);
        $builder->where('logout_time <', date('Y-m-d H:i:s', strtotime('-30 days')));

        $deleted = $builder->delete();

        CLI::write("✅ Deleted $deleted old login session(s).", 'green');
    }
}
