/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('friend-list', require('./components/FriendList.vue').default);
Vue.component('chat-messages', require('./components/ChatMessages.vue').default);
Vue.component('chat-form', require('./components/ChatForm.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to္
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        friends: [],
        messages: [],
        selectedFriend: null,
        currentUserId: document.querySelector('meta[name="user-id"]').getAttribute('content')
    },
    created() {
        this.fetchFriends();

        window.Echo.private('chat.' + this.currentUserId)
            .listen('MessageSent', (e) => {
                if (e.message.sender_id === this.selectedFriend.id || e.message.receiver_id === this.selectedFriend.id) {
                    this.messages.push({
                        ...e.message,
                    });
                }
            });
    },
    methods: {
        fetchFriends() {
            axios.get('/friends').then(response => {
                this.friends = response.data;
            });
        },
        selectFriend(friend) {
            this.selectedFriend = friend;
            this.fetchMessages(friend.id);
        },
        fetchMessages(friendId) {
            axios.get(`/messages/${friendId}`).then(response => {
                this.messages = response.data;
            });
        },
        addMessage(message) {
            this.messages.push(message);

            axios.post('/messages', {
                message: message.message,
                sender_id: message.sender_id,
                receiver_id: message.receiver_id,
            }).then(response => {
                console.log(response.data);
            });
        }
    }
});
