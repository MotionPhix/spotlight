<?php

namespace App\Livewire;

use Livewire\Component;

class DropdownMenu extends Component
{
    public $open = false;
    public $items = [];
    public $selected = null;

    public function toggle()
    {
        $this->open = !$this->open;
    }

    public function select($index)
    {
        $this->selected = $index;
        $this->open = false;
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.dropdown-menu');
    }
}
