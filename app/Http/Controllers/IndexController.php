<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ImportRequest;
use App\Imports\ProductsCollectionImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class IndexController extends Controller
{

    /**
     * @return View
     */
    public function showForm(): View
    {
        return view('index');
    }

    /**
     * @param ImportRequest $request
     * @return RedirectResponse
     */
    public function importFile(ImportRequest $request): RedirectResponse
    {
        $file = $request->file('file');
        $dateTime = date('Ymd_His');
        $fileName = $dateTime . '-' . $file->getClientOriginalName();
        $uploadPath = public_path('upload\\');
        $file->move($uploadPath, $fileName);
        Excel::import(new ProductsCollectionImport, $uploadPath . $fileName);
        session()->flash('success', 'File imported successfully');

        return redirect()->route('index');
    }
}
