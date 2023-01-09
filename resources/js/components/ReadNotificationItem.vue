<template>
    <a :href="read.data.route" class="kt-notification__item">
        <div class="kt-notification__item-icon">
            <i class="flaticon-info kt-font-success"></i>
        </div>
        <div class="kt-notification__item-details">
            <div class="kt-notification__item-title text-black-50">
                <span class="text-bold">{{ read.data.title }}</span> {{ read.data.body }}
            </div>
            <div class="kt-notification__item-time">
                {{ moment(read.data.time).fromNow() }}
            </div>
        </div>
    </a>
</template>

<script>
    export default {
        props: ['read'],
    }
</script>
