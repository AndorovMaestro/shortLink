<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;


class LinkController extends Controller
{

public function index()
{
$links = Link::latest()->take(10)->get();

    return view('index', compact('links'));
}

public function shorten(Request $request)
{
    $request->validate([
        'url' => 'required|url',
    ]);

    $link = Link::create([
        'url' => $request->input('url'),
        'code' => $this->generateCode(),
    ]);

    return response()->json([
        'shortened_url' => url($link->code),
    ]);
}

public function redirect($code)
{
    $link = Link::where('code', $code)->firstOrFail();



    return redirect($link->url);
}

protected function generateCode()
{
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $length = strlen($alphabet);
    $code = '';

    do {
        $remainder = count(Link::all()) % $length;
        $code .= $alphabet[$remainder];
        $id = (count(Link::all()) - $remainder) / $length;
    } while ($id > 0);

    return $code;
}
}
