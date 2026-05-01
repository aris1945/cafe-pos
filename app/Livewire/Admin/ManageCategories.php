<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;

class ManageCategories extends Component
{
    public $categories;
    public $name, $categoryId;
    public $isEdit = false;

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function render()
    {
        return view('livewire.admin.manage-categories')->layout('layouts.admin');
    }

    public function store()
    {
        $this->validate(['name' => 'required']);

        $slug = \Illuminate\Support\Str::slug($this->name);
        $originalSlug = $slug;
        $counter = 1;
        while(Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        Category::create(['name' => $this->name, 'slug' => $slug]);
        session()->flash('success', 'Kategori ditambahkan.');
        $this->resetFields();
        $this->mount();
    }

    public function edit($id)
    {
        $cat = Category::findOrFail($id);
        $this->categoryId = $cat->id;
        $this->name = $cat->name;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate(['name' => 'required']);

        $slug = \Illuminate\Support\Str::slug($this->name);
        $originalSlug = $slug;
        $counter = 1;
        while(Category::where('slug', $slug)->where('id', '!=', $this->categoryId)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        Category::find($this->categoryId)->update(['name' => $this->name, 'slug' => $slug]);
        session()->flash('success', 'Kategori diupdate.');
        $this->resetFields();
        $this->mount();
    }

    public function delete($id)
    {
        Category::find($id)->delete();
        session()->flash('success', 'Kategori dihapus.');
        $this->mount();
    }

    private function resetFields()
    {
        $this->name = ''; $this->categoryId = null; $this->isEdit = false;
    }
}
