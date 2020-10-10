<div class="card mb-4">
    <div class="card-body text-center">
        <a href="{{ route('topics.create') }}" class="btn btn-success btn-block">
            <i class="fa fa-pen mr-2"></i>
            发布话题
        </a>
    </div>
</div>

@if(($links = \App\Models\Link::all()) && count($links) > 0)
    <div class="card">
        <div class="card-body">
            <h5 class="text-center">
                <i class="fa fa-link mr-2"></i>
                资源推荐
            </h5>
            <ul class="list-group list-group-flush">
                @foreach($links as $link)
                    <li class="list-group-item">
                        <a href="{{ $link->url }}" target="_blank">{{ $link->title }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
