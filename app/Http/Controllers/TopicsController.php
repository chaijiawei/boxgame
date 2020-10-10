<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\TopicRequest;
use App\Models\Category;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'])->except('index', 'show');
    }

    public function index(Request $request)
    {
        $query = Topic::query();
        $category = null;
        if($search = $request->q) {
            $query->where('title', 'like', "%$search%")
                ->orWhere('content', 'like', "%$search%")
                ->orWhere(function($query) use ($search) {
                    $query->whereExists(function($query) use ($search) {
                        $query->selectRaw(1)
                            ->from('users')
                            ->whereRaw('topics.user_id = users.id')
                            ->where('users.name', 'like', "%$search%");
                    });
                });
        }
        if($request->category_id &&
            $category = Category::query()->findOrFail($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }
        $topics = $query->with('user', 'category')->latest('updated_at')->paginate();
        return view('topics.index', compact('topics', 'category'));
    }

    public function destroy(Topic $topic)
    {
        $this->authorize('operate', $topic);
        $topic->delete();
        return redirect()->route('topics.index')->with('success', '话题删除成功');
    }

    public function create(Topic $topic)
    {
        $categories = Category::all();
        return view('topics.create_and_edit', compact('categories', 'topic'));
    }

    public function store(TopicRequest $request)
    {
        $data = $request->validated();

        $topic = $request->user()->topics()->create($data);
        return redirect()->to($topic->link())->with('success', '话题创建成功');
    }

    public function show(Topic $topic, Request $request, $slug = '')
    {
        if(($topic->slug && $slug !== $topic->slug) ||
            (!$topic->slug && $slug)) {
            return redirect($topic->link(), 301);
        }

        $backUrl = URL::previous();
        if($backUrl) {
            $urlInfo = parse_url($backUrl);
            if(Str::startsWith($urlInfo['path'], '/topics/show') ||
                Str::endsWith($urlInfo['path'], ['edit', 'create'])) {
                $backUrl = route('topics.index');
            }
        }

        $topic->recordPageView($request->ip());
        return view('topics.show', compact('topic', 'backUrl'));
    }

    public function edit(Topic $topic)
    {
        $this->authorize('operate', $topic);
        $categories = Category::all();
        return view('topics.create_and_edit', compact('topic', 'categories'));
    }

    public function update(Topic $topic, TopicRequest $request)
    {
        $this->authorize('operate', $topic);
        $data = $request->validated();

        $topic->update($data);

        return redirect()->to($topic->link())->with('success', '话题修改成功');
    }

    public function uploadImage(Request $request, ImageUploadHandler $imgHandler)
    {
        $validator = Validator::make(
            $request->all(),
            ['upload_file' => ['required', 'image']],
            [],
            ['upload_file' => '上传文件']
        );

        $response = [
            'success'   => true,
            'msg'       => '',
            'file_path' => '',
        ];
        if($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorStr = implode('，', $errors);
            $response['success'] = false;
            $response['msg'] = $errorStr;
            return $response;
        }

        $response['file_path'] = $imgHandler->save($request->upload_file, 'topics', $request->user()->id, 800, true);
        return $response;
    }
}
