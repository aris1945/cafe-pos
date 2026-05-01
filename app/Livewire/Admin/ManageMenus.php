<?php

namespace App\Livewire\Admin;

use App\Models\Menu;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ManageMenus extends Component
{
    use WithPagination, WithFileUploads;

    public $name, $slug, $description, $price, $category_id, $is_active = true, $menuId;
    public $newImage, $existingImage;
    public $isEdit = false;

    public function render()
    {
        $menus = Menu::with('category')->paginate(10);
        $categories = Category::all();
        return view('livewire.admin.manage-menus', compact('menus', 'categories'))->layout('layouts.admin');
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'price' => 'required|numeric', 'category_id' => 'required',
            'newImage' => 'nullable|image|max:2048'
        ]);

        $imageUrl = null;
        if ($this->newImage) {
            $path = $this->newImage->store('menus', 'public');
            $imageUrl = '/storage/' . $path;
        }

        $slug = \Illuminate\Support\Str::slug($this->name);
        $originalSlug = $slug;
        $counter = 1;
        while(Menu::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        Menu::create([
            'name' => $this->name, 'slug' => $slug, 'description' => $this->description,
            'price' => $this->price, 'category_id' => $this->category_id, 'is_active' => $this->is_active,
            'image' => $imageUrl
        ]);
        session()->flash('success', 'Menu berhasil ditambah.');
        $this->resetFields();
    }

    public function edit($id)
    {
        $m = Menu::findOrFail($id);
        $this->menuId = $m->id;
        $this->name = $m->name; $this->description = $m->description;
        $this->price = $m->price; $this->category_id = $m->category_id; $this->is_active = $m->is_active;
        $this->existingImage = $m->image;
        $this->newImage = null;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'price' => 'required|numeric', 'category_id' => 'required',
            'newImage' => 'nullable|image|max:2048'
        ]);

        $m = Menu::find($this->menuId);
        $imageUrl = $m->image;

        if ($this->newImage) {
            $path = $this->newImage->store('menus', 'public');
            $imageUrl = '/storage/' . $path;
        }

        $slug = \Illuminate\Support\Str::slug($this->name);
        $originalSlug = $slug;
        $counter = 1;
        while(Menu::where('slug', $slug)->where('id', '!=', $this->menuId)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $m->update([
            'name' => $this->name, 'slug' => $slug, 'description' => $this->description,
            'price' => $this->price, 'category_id' => $this->category_id, 'is_active' => $this->is_active,
            'image' => $imageUrl
        ]);
        session()->flash('success', 'Menu diupdate.');
        $this->resetFields();
    }

    public function delete($id)
    {
        Menu::find($id)->delete();
        session()->flash('success', 'Menu dihapus.');
    }

    private function resetFields()
    {
        $this->name = ''; $this->description = '';
        $this->price = ''; $this->category_id = ''; $this->is_active = true;
        $this->menuId = null; $this->isEdit = false; 
        $this->newImage = null; $this->existingImage = null;
    }
}
