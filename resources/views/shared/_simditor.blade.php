@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/simditor/simditor.css') }}">
    <style>
        .simditor-body img {
            max-width: 100%;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('vendor/simditor/module.js') }}"></script>
    <script src="{{ asset('vendor/simditor/hotkeys.js') }}"></script>
    <script src="{{ asset('vendor/simditor/uploader.js') }}"></script>
    <script src="{{ asset('vendor/simditor/simditor.js') }}"></script>
@endpush
