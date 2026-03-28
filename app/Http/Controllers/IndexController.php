<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $data = News::latest()->paginate(10);
        return view('pages.index', [
            'data' => $data
        ]);
    }
    public function detail($id){
        $data = News::findOrFail($id);

        return view('pages.detail-berita', [
            'data' => $data
        ]);
    }
}
