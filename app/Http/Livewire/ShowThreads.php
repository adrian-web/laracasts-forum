<?php

namespace App\Http\Livewire;

use App\Models\Channel;
use App\Models\Thread;
use App\Models\Trending;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ShowThreads extends Component
{
    use WithPagination;

    protected $threads;

    public $channel;

    public $popular = 0;

    public $unanswered = 0;

    public $by = '';

    public $page = 1;

    protected $queryString = [
        'popular' => ['except' => 0],
        'unanswered' => ['except' => 0],
        'by' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount(Channel $channel)
    {
        $this->fill(request()->only('popular', 'unanswered', 'by', 'page'));

        $this->channel = $channel;
    }

    public function filter($type, $value)
    {
        $this->popular = 0;
        $this->unanswered = 0;
        $this->by = '';

        if ($type == 'popular') {
            $this->popular = $value;
        } elseif ($type == 'unanswered') {
            $this->unanswered = $value;
        } elseif ($type == 'by') {
            $this->by = $value;
        }

        $this->resetPage();
    }

    protected function getThreads()
    {
        if ($this->popular == 1) {
            $this->threads = Thread::orderBy('replies_count', 'desc');
        } elseif ($this->unanswered == 1) {
            $this->threads = Thread::doesntHave('replies');
        } elseif ($this->by != '') {
            $user = User::where('username', $this->by)->firstOrFail();
            $this->threads = Thread::where('user_id', $user->id);
        } else {
            $this->threads = Thread::latest();
        }

        if ($this->channel->exists) {
            $this->threads->where('channel_id', $this->channel->id);
        }

        return $this->threads;
    }

    public function render()
    {
        $this->threads = $this->getThreads();

        return view('livewire.show-threads', [
            'threads' => $this->threads->paginate(10),
            'trending' => (new Trending)->get(),
        ]);
    }
}
