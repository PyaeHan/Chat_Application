<template>
    <div>
        <div v-if="loading" class="loading-indicator">
            Loading messages...
        </div>
        <ul v-else-if="messages.length > 0" class="chat">
            <li v-for="message in messages" :key="message.id"
                :class="{ 'right-message': message.sender_id === currentUserId, 'left-message': message.sender_id !== currentUserId }">
                <div>
                    <div class="header">
                        <strong>
                            {{ message.sender_id === currentUserId ? 'YOU' : (message.sender ? message.sender.name :
                            'Unknown') }}
                        </strong>
                    </div>
                    <p class="chat-bubble">
                        {{ message.message }}
                    </p>
                </div>
            </li>
        </ul>
        <div v-else class="no-messages">
            No messages here yet...<br>
            Start a conversation now.
        </div>
    </div>
</template>
<script>
export default {
    props: ["messages", "currentUserId"],
    data() {
        return {
            loading: true
        };
    },
    watch: {
        messages() {
            this.loading = false;
        }
    }
};
</script>

<style scoped>
.chat {
    list-style-type: none;
    padding: 0;
}

.no-messages, .loading-indicator {
    text-align: center;
    color: #888;
    margin-top: 10px;
}

.left-message {
    text-align: left;
}

.right-message {
    text-align: right;
}

.chat-bubble {
    display: inline-block;
    background-color: #e0e0e0;
    padding: 10px;
    border-radius: 15px;
    max-width: 70%;
    margin-bottom: 5px;
    word-wrap: break-word;
}

.right-message .chat-bubble {
    background-color: #b8e5f9;
}

.left-message .chat-bubble {
    background-color: #f1f1f1;
}
</style>
