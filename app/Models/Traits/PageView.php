<?php

namespace App\Models\Traits;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

trait PageView
{

    protected $pageViewSetPrefix = 'page_view_set_';

    public function recordPageView($ip)
    {
        $sKey = $this->getPageViewSetKey($this->id);
        if(! Redis::sIsMember($sKey, $ip)) {
            Redis::sAdd($sKey, $ip);
            $this->increment('view_count', 1, array('updated_at' => $this->updated_at));
        }
    }

    public function clearPageViewSet()
    {
        $keyReg = $this->pageViewSetPrefix . '*';
        $keys = Redis::keys($keyReg);
        $keys = collect($keys)->map(function($key) {
            $topicId = Str::afterLast($key, '_');
            return $this->getPageViewSetKey($topicId);
        })->all();
        Redis::del($keys);
    }

    protected function getPageViewSetKey($id)
    {
        return $this->pageViewSetPrefix . $id;
    }
}
