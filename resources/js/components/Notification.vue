<template>
    <div class="kt-header__topbar-item dropdown">
        <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="30px,0px" aria-expanded="false">
                    <span class="kt-header__topbar-icon kt-pulse kt-pulse--brand">
                        <i class="flaticon-alert"></i>
                        <span v-if="unreadNotifications.length" class="kt-pulse__ring"></span>
                    </span>
            <span v-if="unreadNotifications.length" class="kt-badge kt-badge--danger" style="margin: 18px 0 0 -12px;">{{ unreadNotifications.length }}</span>

        </div>
        <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-lg" x-placement="bottom-end"
             style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(44px, 64px, 0px);">
            <form>

                <!--begin: Head -->
                <div class="kt-head kt-head--skin-dark kt-head--fit-x kt-head--fit-b" :style="{ backgroundImage: `url('/assets/media/misc/bg-1.jpg')` }">
                    <h3 class="kt-head__title">
                        Notifications
                        &nbsp;
                        <span class="btn btn-success btn-sm btn-bold btn-font-md">{{ unreadNotifications.length }}</span>
                    </h3>
                    <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-success kt-notification-item-padding-x" role="tablist">

                    </ul>
                </div>

                <a class="nav-link active show pull-left" href="#" @click="markNotificationAsRead">Mark all as read</a>
                <a class="nav-link active show pull-right" href="#" @click="deleteAllNotification">Delete All</a>
                <br>
                <div class="clearfix"></div>
                <!--end: Head -->
                <div class="kt-notification kt-margin-t-10 kt-margin-b-10 kt-scroll ps" data-scroll="true" data-height="300" data-mobile-height="200"
                     style="height: 300px; overflow: hidden;">
                    <!-- unread notification -->
                    <unread-notification-item v-for="(unread, index) in unreadNotifications" :unread="unread" :key="unread.id" :markAsRead="markAsRead" ></unread-notification-item>

                    <!-- read notification -->
                    <read-notification-item v-for="(read, index) in readNotifications" :read="read" :key="read.id"></read-notification-item>


                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                        <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                    </div>
                    <div class="ps__rail-y" style="top: 0px; right: 0px;">
                        <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</template>

<script>
    import UnreadNotificationItem from "./UnreadNotificationItem";
    import ReadNotificationItem from "./ReadNotificationItem";


    export default {
        props: ['reads', 'unreads', 'userid'],
        components: {UnreadNotificationItem, ReadNotificationItem},
        data() {
            return {
                unreadNotifications: this.unreads,
                readNotifications: this.reads,
                sound: '/assets/sound/notification.ogg'
                // sound: "http://soundbible.com/mp3/Air%20Plane%20Ding-SoundBible.com-496729130.mp3"
            }
        },
        methods: {
            playSound() {
                if (this.sound) {

                    let audio = new Audio(this.sound);
                    var playPromise = audio.play();
                    if (playPromise !== undefined) {
                        playPromise.then(_ => {
                            // Automatic playback started!
                            // Show playing UI.
                            audio.play();
                        })
                            .catch(error => {
                                // Auto-play was prevented
                                // Show paused UI.
                                console.log(error)
                            });
                    }
                }
            },

            markNotificationAsRead() {
                if (this.unreadNotifications.length) {

                    axios.get('/notification/read/all/' + this.userid)
                        .then(response => {
                            let newRead = [...this.unreadNotifications];
                            this.unreadNotifications.splice(this.unreadNotifications);
                            newRead.map((readAble)  => {
                                this.readNotifications.push(readAble);
                            });
                        })
                        .catch(error => {
                            console.log(error)
                        });
                }
            },

            markAsRead(notification_id, route) {
                axios.get('/notification/read/' + notification_id)
                    .then(response => {
                        location.href = (route);
                    })
                    .catch(error => {
                        console.log(error)
                    });
            },

            deleteAllNotification() {
                axios.get('/notification/delete/all/' + this.userid)
                    .then(response => {
                        this.unreadNotifications.splice(this.unreadNotifications);
                        this.readNotifications.splice(this.readNotifications);
                    })
                    .catch(error => {
                        console.log(error)
                    });
            },
        },
        created() {

        },
        mounted() {
            console.log('Component mounted.');

            Echo.private('App.User.' + this.userid)
                .notification((notification) => {

                    console.log(notification.time);
                    let newUnreadNotifications = {time: notification.time, data: {leave: notification.leave, route: notification.route, title: notification.title, body: notification.body, user: notification.user}};
                    this.unreadNotifications.push(newUnreadNotifications);
                    this.playSound();
                });

        }
    }
</script>
