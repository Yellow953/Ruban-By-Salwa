<?php

namespace App\Http\Controllers;

use App\Exports\CategoriesExport;
use App\Models\Category;
use App\Models\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::select('id', 'name', 'description', 'image')->with('products')->filter()->orderBy('id', 'desc')->paginate(25);
        return view('categories.index', compact('categories'));
    }

    public function new()
    {
        return view('categories.new');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|string',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = auth()->id() . '_' . time() . '.' . $ext;
            $image = Image::make($file);
            $image->fit(300, 300, function ($constraint) {
                $constraint->upsize();
            });
            $image->save(public_path('uploads/categories/' . $filename));
            $path = '/uploads/categories/' . $filename;
        } else {
            $path = "assets/images/no_img.png";
        }

        Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $path,
        ]);

        $text = ucwords(auth()->user()->name) .  " created Category " . $request->name . ", datetime: " . now();
        Log::create(['text' => $text]);

        return redirect()->route('categories')->with('success', 'Category was successfully created.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:255|string'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = auth()->id() . '_' . time() . '.' . $ext;
            $image = Image::make($file);
            $image->fit(300, 300, function ($constraint) {
                $constraint->upsize();
            });
            $image->save(public_path('uploads/categories/' . $filename));
            $path = '/uploads/categories/' . $filename;
        } else {
            $path = $category->image;
        }

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $path,
        ]);

        $text = ucwords(auth()->user()->name) .  " updated Category " . $category->name . ", datetime: " . now();
        Log::create(['text' => $text]);

        return redirect()->route('categories')->with('success', 'Category was successfully updated.');
    }

    public function destroy(Category $category)
    {
        if ($category->can_delete()) {
            $text = ucwords(auth()->user()->name) .  " deleted Category " . $category->name . ", datetime: " . now();

            $category->delete();
            Log::create(['text' => $text]);

            return redirect()->back()->with('danger', 'Category was successfully deleted');
        } else {
            return redirect()->back()->with('danger', 'Unable to delete');
        }
    }

    public function export(Request $request)
    {
        $filters = $request->all();
        return Excel::download(new CategoriesExport($filters), 'Categories.xlsx');
    }

    public function pdf(Request $request)
    {
        $categories = Category::select('name', 'description', 'created_at')->filter()->get();

        $pdf = Pdf::loadView('categories.pdf', compact('categories'));

        return $pdf->download('Categories.pdf');
    }
}
