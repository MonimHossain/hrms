<template>
    <a :href="unread.data.route" class="kt-notification__item" style="background-color: #f7f8fa;" @click.prevent="markAsRead(unread.id, unread.data.route)">
        <div class="kt-notification__item-icon">
            <i class="flaticon-info kt-font-success"></i>
        </div>
        <div class="kt-notification__item-details">
            <div class="kt-notification__item-title text-black-50">
                <span class="text-bold">{{ unread.data.title }}</span> {{ unread.data.body }}
            </div>
            <div class="kt-notification__item-time">
                {{ moment(unread.data.time).fromNow() }}
            </div>
        </div>
    </a>
</template>

<script>
    export default {
        props: [
            'unread',
            'markAsRead'
        ],
    }
</script>
