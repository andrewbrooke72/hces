<template>
    <div>
        <div v-for="(notification, index) in notifications" :class="'callout callout-' + notification.color + ' m-0 py-3'" v-if="notification.has_viewed == 0">
            <div class="avatar float-right">
                <i :class="notification.icon"></i>
            </div>
            <div>
                <strong>
                    {{ notification.title }}
                </strong>
                <br>
                <small>{{ notification.message }}</small>
            </div>
            <small class="text-muted mr-3"><i class="icon-calendar"></i>&nbsp; {{ notification.created_at }}</small>
            <hr class="mx-3 my-0">
            <a href="#attachment" @click="downloadAttachment(notification)" v-if="notification.attachment != null"><i class="icon-cloud-download"></i> Attached file</a>
            <a href="#view" class = "mark-view-button" @click="markAsViewed(notification)"><i class="icon-eye"></i> Mark as viewed</a>
        </div>
        <hr class="mx-3 my-0">
    </div>
</template>

<script>
    export default {
        data(){
            return {
                notifications: [],
                notification_count: 0
            }
        },
        mounted(){
            var app = this;
            app.loadNotifications();
            Echo.channel('private-notification.' + $('#uid').val()).listen('Notify', (data) => {
                app.notifications.unshift(data.notification);
                var sound = new Audio('/audio/alert.mp3');
                sound.play();
            });
        },
        updated: function () {
        },
        computed: {},
        watch: {
            notifications: function () {
                var app = this;
                var notification_count = app.notifications.length;
                app.notification_count = notification_count;
                if (notification_count > 0) {
                    $("#notification-count").attr('class', 'badge badge-pill badge-danger bg-arsenal-blue');
                } else {
                    $("#notification-count").attr('class', 'badge badge-pill badge-light');
                }
                $("#notification-count").text(app.notification_count);
            }
        },
        methods: {
            loadNotifications(){
                var app = this;
                $.get('/vue/notifications/load', function (response) {
                    app.notifications = response;
                }).fail(function (response) {
                    console.log(response);
                });
            },
            downloadAttachment(notification){
                var app = this;
                $.ajax({
                    url: '/vue/notifications/download/' + notification.id,
                    method: 'GET',
                    xhrFields: {
                        responseType: 'blob'
                    },
                    success: function (data) {
                        var a = document.createElement('a');
                        var url = window.URL.createObjectURL(data);
                        a.href = url;
                        a.download = notification.attachment;
                        a.click();
                        window.URL.revokeObjectURL(url);
                        app.removeFromArray(app.notifications, notification.id);
                        var sound = new Audio('/audio/remove.mp3');
                        sound.play();
                    }
                });
            },
            markAsViewed(notification){
                var app = this;
                $.get('/vue/notifications/mark/view/' + notification.id, function (response) {
                    app.removeFromArray(app.notifications, notification.id);
                    var sound = new Audio('/audio/remove.mp3');
                    sound.play();
                }).fail(function (response) {
                    console.log(response);
                });
            },
            removeFromArray(haystack, needle, identifier = 'id'){
                const index = haystack.findIndex(obj => obj[identifier] === needle);
                haystack.splice(index, 1);
            }
        }
    }
</script>
