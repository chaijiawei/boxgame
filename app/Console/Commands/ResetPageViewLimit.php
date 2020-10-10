<?php

namespace App\Console\Commands;

use App\Models\Topic;
use Illuminate\Console\Command;

class ResetPageViewLimit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'topic:reset-page-view-limit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '清除话题阅读量限制';

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
     * @param Topic $topic
     * @return mixed
     */
    public function handle(Topic $topic)
    {
        $this->line('开始清除');
        $topic->clearPageViewSet();
        $this->line('清除完毕');
    }
}
