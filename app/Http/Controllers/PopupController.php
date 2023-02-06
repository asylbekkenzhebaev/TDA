<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePopupRequest;
use App\Http\Requests\UpdatePopupRequest;
use App\Models\Popup;
use Illuminate\Support\Facades\Storage;

class PopupController extends Controller
{
    /**
     *
     */
    public function __construct()
    {
        $this->middleware(['auth'])->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $popups = Popup::paginate(5);
        return view('popups.index', compact('popups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('popups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StorePopupRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePopupRequest $request)
    {
        $data = $request->validated();
        $data['active'] = $request->boolean('active');

        $filename = uniqid() . '.js';
        $path = "js/" . $filename;
        $data['filename'] = $path;

        $popup = new Popup($data);
        $popup->save();


        $script = "
            setTimeout(() => {
                const requestShow = new XMLHttpRequest();
                const url = '" . url('/') . "/api/popups/" . $popup->id . "';
                requestShow.open('GET', url);
                requestShow.setRequestHeader('Content-Type', 'application/json');
                requestShow.addEventListener('readystatechange', () => {
                    if (requestShow.readyState === 4 && requestShow.status === 200) {
                        var responseObj = JSON.parse( requestShow.responseText );
                        var responseHTML = responseObj.html;
                        var domHTML = new DOMParser();
                        var doc = domHTML.parseFromString(responseHTML, 'text/html');
                        document.body.insertBefore(doc.body.firstChild, document.body.lastChild);
                    }
                });
                requestShow.send();

                const requestUpdate = new XMLHttpRequest();
                requestUpdate.open('PUT', url);
                requestUpdate.setRequestHeader('Content-Type', 'application/json');
                requestUpdate.send();
            }, 10000);
            ";

        Storage::disk('local')->put('public/' . $path, $script);

        return redirect()->route('popups.index')->with('status', ['text' => "{$popup->name} popup successfully created!", 'color' => 'success']);
    }


    /**
     * Display company data
     *
     * @param \App\Models\Popup $popup
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Popup $popup)
    {
        return view('popups.show', compact('popup'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Popup $popup
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Popup $popup)
    {
        return view('popups.edit', compact('popup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdatePopupRequest $request
     * @param \App\Models\Popup $popup
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdatePopupRequest $request, Popup $popup)
    {
        $data = $request->validated();
        $data['active'] = $request->boolean('active');

        if (empty($popup->filename)) {
            $filename = uniqid() . '.js';
            $path = "js/" . $filename;
            $data['filename'] = $path;

            $script = "
                setTimeout(() => {
                    const requestShow = new XMLHttpRequest();
                    const url = '" . url('/') . "/api/popups/" . $popup->id . "';
                    requestShow.open('GET', url);
                    requestShow.setRequestHeader('Content-Type', 'application/json');
                    requestShow.addEventListener('readystatechange', () => {
                        if (requestShow.readyState === 4 && requestShow.status === 200) {
                            var responseObj = JSON.parse( requestShow.responseText );
                            var responseHTML = responseObj.html;
                            var domHTML = new DOMParser();
                            var doc = domHTML.parseFromString(responseHTML, 'text/html');
                            document.body.insertBefore(doc.body.firstChild, document.body.lastChild);
                        }
                    });
                    requestShow.send();

                    const requestUpdate = new XMLHttpRequest();
                    requestUpdate.open('PUT', url);
                    requestUpdate.setRequestHeader('Content-Type', 'application/json');
                    requestUpdate.send();
                }, 10000);
                ";
            Storage::disk('local')->put('public/' . $path, $script);
        }

        $popup->update($data);

        return redirect()->route('popups.index')->with('status', ['text' => "{$popup->name} popup successfully updated!", 'color' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Popup $popup
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Popup $popup)
    {
        $popup->delete();
        return redirect()->route('popups.index')->with('status', ['text' => "{$popup->name} popup successfully deleted!", 'color' => 'danger']);
    }
}
