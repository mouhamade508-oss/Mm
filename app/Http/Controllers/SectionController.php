<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of sections
     */
    public function index()
    {
        $sections = Section::with('categories')->get();
        return view('admin.sections.index', compact('sections'));
    }

    /**
     * Show the form for creating a new section
     */
    public function create()
    {
        return view('admin.sections.create');
    }

    /**
     * Store a newly created section
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:sections',
            'slug' => 'required|string|max:255|unique:sections',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
        ]);

        Section::create($validated);

        return redirect()->route('admin.sections.index')->with('success', 'تم إنشاء القسم بنجاح');
    }

    /**
     * Display the specified section
     */
    public function show(Section $section)
    {
        $section->load('categories.products');
        return view('admin.sections.show', compact('section'));
    }

    /**
     * Show the form for editing the specified section
     */
    public function edit(Section $section)
    {
        return view('admin.sections.edit', compact('section'));
    }

    /**
     * Update the specified section
     */
    public function update(Request $request, Section $section)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:sections,name,' . $section->id,
            'slug' => 'required|string|max:255|unique:sections,slug,' . $section->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
        ]);

        $section->update($validated);

        return redirect()->route('admin.sections.index')->with('success', 'تم تحديث القسم بنجاح');
    }

    /**
     * Remove the specified section
     */
    public function destroy(Section $section)
    {
        $section->delete();
        return redirect()->route('admin.sections.index')->with('success', 'تم حذف القسم بنجاح');
    }
}
