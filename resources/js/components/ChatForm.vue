<template>
    <div class="input-group mb-2">
        <textarea
            id="btn-input"
            name="message"
            class="form-control input-sm"
            placeholder="Type your message here..."
            v-model="newMessage"
            @keydown.enter.exact.prevent="addNewLine"
            @keydown.enter.shift="sendMessage"
        ></textarea>
        <span class="input-group-btn">
            <button class="btn btn-primary btn-sm" id="btn-chat" @click="sendMessage">
                <i class="fas fa-paper-plane"></i>
            </button>
        </span>
    </div>
</template>
<script>
export default {
    props: ["currentUserId", "selectedFriend"],
    data() {
        return {
            newMessage: "",
        };
    },
    methods: {
        sendMessage() {
            if (this.newMessage.trim() === "") return;
            this.$emit("messagesent", {
                sender_id: this.currentUserId,
                receiver_id: this.selectedFriend.id,
                message: this.newMessage,
            });
            this.newMessage = "";
        },
        addNewLine() {
            this.newMessage += '\n';
        }
    },
};
</script>

<style scoped>
.input-group .form-control {
    margin-right: 5px;
    resize: none;
}

#btn-chat {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem;
}
</style>
