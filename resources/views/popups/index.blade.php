@extends('layouts/app')

@section('content')
    @if(session('status'))
        <div class="row justify-content-center">
            <div class="col-6 text-center">
                <div class="alert alert-{{session('status')['color']}}" role="alert">
                    {{session('status')['text']}}
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-6">
            <h3>Popups</h3>
        </div>
        @if (Auth::check())
            <div class="col-6">
                <a href="{{route('popups.create')}}" class="btn btn-success btn-lg float-end">Create a new popup <i
                        class="bi bi-plus-square"></i></a>
            </div>
        @endif
    </div>

    <div class="row">
        <table class="table table-stripped">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Active</th>
                <th>Show count</th>
                <th>***</th>
            </tr>
            </thead>
            <tbody>
            @if($popups)
                @foreach($popups as $popup)
                <tr>
                    <td>{{$popup->id}}</td>
                    <td>{{$popup->name}}</td>
                    <td>{{$popup->description}}</td>
                    <td>
                        @if ($popup->active)
                            <i class="bi bi-check text-success turn-popup" title="Turn on popup"></i>
                        @else
                            <i class="bi bi-x text-danger turn-popup" title="Turn off popup"></i>
                        @endif
                    </td>
                    <td>{{$popup->show_count}}</td>
                    <td class="td-action">
                        <a href="{{route('popups.show',$popup)}}" class="btn btn-light btn-lg float-end"
                           title="Show a popup"><i class="bi bi-eye"></i></a>
                        @if (Auth::check())
                            <a href="{{route('popups.edit', ['popup'=>$popup])}}"
                               class="btn btn-light btn-lg float-end" title="Edit a popup"><i
                                    class="bi bi-pencil-square"></i></a>
                            <form action="{{route('popups.destroy', $popup)}}" method="POST" class="float-end"
                                  title="Delete a popup">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-light btn-lg"><i class="bi bi-trash3"></i></button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            @endif
            </tbody>
        </table>
    </div>

    <div class="row justify-content-md-center p-5">
        <div class="col-md-auto">
            {{ $popups->links('pagination::bootstrap-4') }}
        </div>
    </div>

@endsection
