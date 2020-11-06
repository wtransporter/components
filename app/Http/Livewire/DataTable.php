<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class DataTable extends Component
{
    use WithPagination;
    
    public $active = true;
    public $search = '';
    public $sortField = '';
    public $sortAsc = true;

    protected $queryString = [
        'search' => ['except' => ''],
        'active' => ['except' => true],
        'sortField' => ['except' => ''],
        'sortAsc' => ['except' => true],
    ];
    
    public function mount()
    {
        $this->search = request()->query('search', $this->search);
    }

    public function sortBy($field)
    {
        if ($this->sortField == $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }
        
        $this->sortField = $field;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.data-table', [

            'users' => User::where(function($query) {
                    $query->where('name', 'LIKE', '%'.$this->search.'%')
                        ->orWhere('email', 'LIKE', '%'.$this->search.'%');
                })
                ->where('active', $this->active)
                ->when($this->sortField, function($query) {
                    $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
                })
                ->paginate(10)

        ]);
    }
}
