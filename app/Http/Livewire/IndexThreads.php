<?php

namespace App\Http\Livewire;

use App\Models\Channel;
use App\Traits\ThreadQueries;
use Livewire\Component;
use Livewire\WithPagination;

class IndexThreads extends Component
{
    use WithPagination;
    use ThreadQueries;

    protected $threads;

    public $channel;

    public $popular = 0;

    public $unanswered = 0;

    public $by = '';

    public $search = '';

    public $page = 1;

    protected $filters = ['popular' => 0, 'unanswered' => 0, 'by' => '', 'search' => ''];

    protected $queryString = [
        'popular' => ['except' => 0],
        'unanswered' => ['except' => 0],
        'by' => ['except' => ''],
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount(Channel $channel)
    {
        $this->fill(request()->only('popular', 'unanswered', 'by', 'page', 'search'));

        $this->channel = $channel;
    }

    public function query($method, $value, $source)
    {
        $this->resetQueries($source);

        foreach (array_keys($this->filters) as $filter) {
            if ($filter == $method) {
                $this->$filter = $value;
            }
        }
    }

    protected function resetQueries($source)
    {
        $this->popular = 0;
        $this->unanswered = 0;
        $this->by = '';
        $this->page = 1;
        if ($source != 'search') {
            $this->search = '';
        }
    }

    protected function filterThreads()
    {
        foreach ($this->filters as $filter => $default) {
            if ($this->$filter != $default) {
                $this->threads = $this->$filter($this->$filter);
            }
        }

        if ($this->threads === null) {
            $this->threads = $this->latest();
        }

        if ($this->channel->exists) {
            $this->threads->where('channel_id', $this->channel->id);
        }

        return $this->threads;
    }

    public function render()
    {
        $this->threads = $this->filterThreads();

        return view('livewire.index-threads', [
            'threads' => $this->threads->paginate(10),
        ]);
    }
}
