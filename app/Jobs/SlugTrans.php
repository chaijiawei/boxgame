<?php

namespace App\Jobs;

use App\Models\Topic;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Handlers\SlugTransHandler;
use Illuminate\Support\Facades\DB;

class SlugTrans implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $topic;

    /**
     * Create a new job instance.
     *
     * @param Topic $topic
     */
    public function __construct(Topic $topic)
    {
        $this->topic = $topic;
    }

    /**
     * Execute the job.
     *
     * @param SlugTransHandler $handler
     * @return void
     */
    public function handle(SlugTransHandler $handler)
    {
        $slug = $handler->trans($this->topic->title);
        DB::table('topics')->update(['slug' => $slug]);
    }
}
