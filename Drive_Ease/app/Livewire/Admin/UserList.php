<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class UserList extends Component
{
    public $search = '';

    public function render()
    {
        $users = User::where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('username', 'like', '%' . $this->search . '%')
                    ->get();

        return view('livewire.admin.user-list', [
            'users' => $users,
        ]);
    }
}


