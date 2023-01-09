<a href="{{ route($notification->data['route'], ['notificationId' => auth()->user()->unreadNotifications[0]->id ]) }}" class="kt-notification__item">
    <div class="kt-notification__item-icon">
        <i class="flaticon-info kt-font-success"></i>
    </div>
    <div class="kt-notification__item-details">
        <div class="kt-notification__item-title text-info">
            {{ $notification->data['data'] }}
            {{ $notification->data['route'] }}
        </div>
        <div class="kt-notification__item-time">
            2 hrs ago
        </div>
    </div>
</a>
