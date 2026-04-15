<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

class ManageKasir extends Component
{
    use WithPagination;

    public $name, $email, $password, $userId;
    public $is_active = true;
    public $isEdit = false;

    public function render()
    {
        // Hanya tampilkan akun dengan role kasir
        $kasirs = User::where('role', 'kasir')->latest()->paginate(10);
        return view('livewire.admin.manage-kasir', compact('kasirs'))->layout('layouts.admin');
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'kasir',
            'is_active' => $this->is_active,
        ]);

        session()->flash('success', 'Akun Kasir berhasil ditambahkan.');
        $this->resetFields();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->is_active = $user->is_active;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,'.$this->userId,
        ]);

        $kasir = User::findOrFail($this->userId);
        
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'is_active' => $this->is_active,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        $kasir->update($data);

        session()->flash('success', 'Akun Kasir berhasil diupdate.');
        $this->resetFields();
    }

    public function delete($id)
    {
        User::find($id)->delete();
        session()->flash('success', 'Akun Kasir berhasil dihapus.');
    }

    public function resetFields()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->is_active = true;
        $this->isEdit = false;
        $this->userId = null;
    }
}
