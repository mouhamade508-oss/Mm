<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('products')->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::all();
        return view('admin.categories.create', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:categories,name|max:100',
            'section_id' => 'nullable|exists:sections,id',
            'description' => 'nullable|string|max:500',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Category::create($validated);

        // If section_id is provided, redirect back to that section
        if ($request->filled('section_id')) {
            $section = Section::find($request->section_id);
            return redirect()->route('admin.sections.show', $section)->with('success', 'تم إنشاء الفئة بنجاح');
        }

        return redirect()->route('admin.categories.index')->with('success', 'تم إنشاء الفئة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $sections = Section::all();
        return view('admin.categories.edit', compact('category', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:categories,name,' . $category->id . '|max:100',
            'section_id' => 'nullable|exists:sections,id',
            'description' => 'nullable|string|max:500',
        ]);

        $validated['slug'] = \Str::slug($validated['name']);

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'تم تحديث الفئة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->products()->exists()) {
            return redirect()->back()->with('error', 'لا يمكن حذف الفئة لأنها تحتوي على منتجات');
        }

        $sectionId = $category->section_id;
        $category->delete();

        // If category belongs to a section, redirect back to that section
        if ($sectionId) {
            $section = Section::find($sectionId);
            if ($section) {
                return redirect()->route('admin.sections.show', $section)->with('success', 'تم حذف الفئة بنجاح');
            }
        }

        return redirect()->route('admin.categories.index')->with('success', 'تم حذف الفئة بنجاح');
    }
}
