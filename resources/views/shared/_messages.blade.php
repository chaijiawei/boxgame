@foreach(['danger', 'success', 'info', 'warning'] as $msg)
    @if(session()->has($msg))
        <div class="container">
            <div class="alert alert-{{ $msg }} alert-dismissible fade show">
                {{ session()->get($msg) }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif
@endforeach

@if(session()->has('verified') && session()->get('verified'))
    <div class="container">
        <div class="alert alert-success alert-dismissible fade show">
            恭喜您，邮件验证成功！
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
@endif

@if(session()->has('status'))
    <div class="container">
        <div class="alert alert-success alert-dismissible fade show">
            {{ session()->get('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
@endif
