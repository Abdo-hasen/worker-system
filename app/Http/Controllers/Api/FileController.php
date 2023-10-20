<?php

namespace App\Http\Controllers\Api;

use App\Exports\PostsExport;
use App\Http\Controllers\Controller;
use App\Imports\PostsImport;
use Maatwebsite\Excel\Facades\Excel;

class FileController extends Controller
{
    public function export() 
    {
        return Excel::download(new PostsExport, 'posts.xlsx');
    }

    public function import() 
    {
        return  Excel::import(new PostsImport, request()->file('excelFile'));
        
    }
}

