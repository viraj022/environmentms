@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12 col-sm-6">
                    <h1>File Letter writer</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('store.file.letter') }}" method="POST">
                @csrf
                <input type="hidden" id="client_id" name="client_id" value="{{ $id }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-2">
                                    <label for="title">Letter Title</label>
                                    <textarea name="letter_title" id="letter_title" cols="30" rows="4"
                                        class="form-control @error('letter_title') is-invalid @enderror" placeholder="Enter the letter title"
                                        value="{{ old('letter_title') }}"></textarea>
                                    @error('letter_title')
                                        <div class="invalid-feedback d-block" style="font-size: 18px;">Letter title is required
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-2 mt-3">
                                    <button type="submit" class="btn btn-success" id="save">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body">
                                <textarea name="letter_content" id="letter_content">{{ old('letter_content') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('pageScripts')
    <script src="../../dist/js/adminlte.min.js"></script>
    <script src="../../dist/js/demo.js"></script>
    <script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.editorConfig = function(config) {
            config.toolbarGroups = [{
                    name: 'document',
                    groups: ['mode', 'document', 'doctools']
                },
                {
                    name: 'clipboard',
                    groups: ['clipboard', 'undo']
                },
                {
                    name: 'editing',
                    groups: ['find', 'selection', 'spellchecker', 'editing']
                },
                {
                    name: 'forms',
                    groups: ['forms']
                },
                '/',
                {
                    name: 'basicstyles',
                    groups: ['basicstyles', 'cleanup']
                },
                {
                    name: 'paragraph',
                    groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']
                },
                {
                    name: 'links',
                    groups: ['links']
                },
                {
                    name: 'insert',
                    groups: ['insert']
                },
                '/',
                {
                    name: 'styles',
                    groups: ['styles']
                },
                {
                    name: 'colors',
                    groups: ['colors']
                },
                {
                    name: 'tools',
                    groups: ['tools']
                },
                {
                    name: 'others',
                    groups: ['others']
                },
                {
                    name: 'about',
                    groups: ['about']
                }
            ];

            config.removeButtons = 'Templates,RemoveFormat,CopyFormatting,CreateDiv,Anchor,Image,Smiley,Iframe';
        };
        var EDITOR_DATA = CKEDITOR.replace('letter_content');

        @if (session('letter_create_error'))
            Swal.fire('Error', '{{ session('letter_create_error') }}', 'error');
        @endif
    </script>
@endsection
