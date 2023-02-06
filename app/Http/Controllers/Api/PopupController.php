<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Popup;
use Illuminate\Http\Request;

class PopupController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Popup $popup
     * @return string
     */
    public function show(Popup $popup)
    {
        $result = [];
        if ($popup->active) {
            $html = view('popups.modal', compact('popup'))->render();
            $result = ['html' => $html];
            $status = 200;
        } else {
            $status = 404;
        }
        return response()->json($result, $status);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Models\Popup $popup
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Popup $popup)
    {
        $popup->update(['show_count' => $popup->show_count + 1]);
    }

}
