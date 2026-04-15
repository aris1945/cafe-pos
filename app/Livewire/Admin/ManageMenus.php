<?php

namespace App\Livewire\Admin;

use App\Models\Menu;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class ManageMenus extends Component
{
    use WithPagination;

    public $name, $slug, $description, $price, $category_id, $is_active = true, $menuId;
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
            'name' => 'required', 'slug' => 'required|unique:menus,slug',
            'price' => 'required|numeric', 'category_id' => 'required'
        ]);
        Menu::create([
            'name' => $this->name, 'slug' => $this->slug, 'description' => $this->description,
            'price' => $this->price, 'category_id' => $this->category_id, 'is_active' => $this->is_active
        ]);
        session()->flash('success', 'Menu berhasil ditambah.');
        $this->resetFields();
    }

    public function edit($id)
    {
        $m = Menu::findOrFail($id);
        $this->menuId = $m->id;
        $this->name = $m->name; $this->slug = $m->slug; $this->description = $m->description;
        $this->price = $m->price; $this->category_id = $m->category_id; $this->is_active = $m->is_active;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required', 'slug' => 'required|unique:menus,slug,'.$this->menuId,
            'price' => 'required|numeric', 'category_id' => 'required'
        ]);
        Menu::find($this->menuId)->update([
            'name' => $this->name, 'slug' => $this->slug, 'description' => $this->description,
            'price' => $this->price, 'category_id' => $this->category_id, 'is_active' => $this->is_active
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
        $this->name = ''; $this->slug = ''; $this->description = '';
        $this->price = ''; $this->category_id = ''; $this->is_active = true;
        $this->menuId = null; $this->isEdit = false;
    }
}
