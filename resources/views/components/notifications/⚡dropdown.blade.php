<?php

use Livewire\Component;

new class extends Component
{
    public $notifications = [];
    public $unreadCount = 0;

    public function mount(){
        $this->loadNotifications();
    }

    public function loadNotifications(){
        $this->notifications = auth()->user()
                                    ->notifications()
                                    ->latest()
                                    ->get();
        $this->unreadCount = auth()->user()
            ->unreadNotifications()
            ->count();
    }

    public function markAsRead($id){
        $notification = auth()->user()
            ->notifications()
            ->where('id', $id)
            ->first();

        if ($notification) {
            $notification->markAsRead();
            $url = $notification->data['url'] ?? null;
            $this->loadNotifications();
            if ($url) {
                return redirect()->to($url);
            }
        }
    }
    public function markAllAsRead(){
        $notifications_all = auth()->user()->notifications()->get();

        if ($notifications_all->isNotEmpty()){
            foreach ($notifications_all as $notification) {
                $notification->markAsRead();
            }
        }
        $this->loadNotifications();
    }
}
?>

<div wire:poll.5s="loadNotifications" class="relative">

    <button
        type="button"
        onclick="document.getElementById('notif-dropdown').classList.toggle('hidden')"
        class="relative flex h-9 w-9 items-center justify-center rounded-full hover:bg-slate-100"
    >
        <img src="{{ asset('images/notification_bell.svg') }}" class="h-5 w-5">
        @if ($unreadCount > 0)
            <span class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-600 text-xs font-bold text-white">
                {{ $unreadCount }}
            </span>
        @endif
    </button>

    <div
        id="notif-dropdown"
        class="hidden fixed right-6 top-16 z-[999999] w-80 rounded-3xl border border-slate-200 bg-white shadow-2xl"
    >
        <div class="border-b border-slate-100 p-4">
            <h2 class="font-bold text-lg">Notifications</h2>
        </div>

        <div class="max-h-96 overflow-y-auto">
            @forelse ($notifications as $notification)
                <button
                    type="button"
                    wire:key="notif-{{ $notification->id }}"
                    wire:click="markAsRead('{{ $notification->id }}')"
                    class="w-full border-b border-slate-100 text-left transition hover:bg-slate-50"
                >
                @if ($notification->read_at)
                    <div class="p-4">
                        <p class="text-sm font-medium text-slate-800">
                            {{ $notification->data['message'] }}
                        </p>
                        <p class="mt-1 text-xs text-slate-500">
                            {{ $notification->created_at->diffForHumans() }}
                        </p>
                    </div>
                @else
                    <div class="bg-blue-600/10 p-4">
                        <p class="text-xs font-bold font-medium text-blue-900">
                            Unread
                        </p>
                            <p class="text-sm font-medium text-slate-800">
                            {{ $notification->data['message'] }}
                        </p>
                        <p class="mt-1 text-xs text-slate-500">
                            {{ $notification->created_at->diffForHumans() }}
                        </p>
                    </div>
                @endif
                </button>
            @empty
                <div class="p-6 text-center text-sm text-slate-500">
                    No notifications found.
                </div>
            @endforelse
        </div>
        <button
                type="button"
                wire:click="markAllAsRead"
                class="w-full border-b border-slate-100 p-4 text-xs text-center transition hover:bg-slate-50"
            >
            Mark all as read
        </button>

    </div>

</div>

<script>
    // Close when clicking outside
    document.addEventListener('click', function (e) {
        const dropdown = document.getElementById('notif-dropdown');
        const bell = e.target.closest('button');


        if (!dropdown.contains(e.target) && !bell) {
            dropdown.classList.add('hidden');
        }
    });
</script>