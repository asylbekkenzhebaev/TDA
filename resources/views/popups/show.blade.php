@extends('layouts/app')

@section('content')

    <div class="row">
        <div class="col-6">
            <p class="cpName" data-idPopup="{{$popup->id}}">
                <b>Name: </b> <span>{{$popup->name}}</span>
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <p class="cpDescription">
                <b>description: </b> <span>{{$popup->description}}</span>
            </p>
        </div>
    </div>


    @if($popup->active)
        <h4>After 10 seconds, a popup will appear for demonstration.</h4>
        <div class="row">
            <div class="col-10 card highlight">
                <div class="d-flex p-2">
                    <button id="downloadJS" class="btn btn-light m-1">
                        <i class="bi bi-filetype-js show-btns" title="Download js script"></i>
                    </button>
                    <button id="clipboard" class="btn btn-light m-1 btn-clipboard">
                        <i class="bi bi-clipboard show-btns" title="Copy js script"></i>
                        <i class="bi bi-clipboard-check show-btns" title="Copied"></i>
                    </button>
                </div>
                <div class="row">
                    <pre tabindex="0" class="chroma">
                        <code id="codePopup" class="language-html" data-lang="html">
            <span><</span>script type="text/javascript" src="{{ asset('storage/'.$popup->filename)}}"><span><</span>/script<span>></span>
                        </code>
                    </pre>
                </div>
            </div>
        </div>

        @if($popup->filename)
            <script type="text/javascript" src="{{asset('storage/'.$popup->filename)}}"></script>
        @endif
    @else
        <h4>This popup is not active</h4>
    @endif




@endsection
