<template>
    <div>
        <ul class="list-group">
            <li
                v-for="friend in friends"
                :key="friend.id"
                class="list-group-item"
                :class="{ 'selected-friend': friend.id === selectedFriendId }"
                 @click="selectFriend(friend)"
            >
                <div>
                    <strong>{{ friend.name }}</strong>
                </div>
                <div style="font-size: 0.85rem; color: #6c757d;">
                    {{ friend.email }}
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: ["friends"],
    data() {
        return {
            selectedFriendId: null,
        };
    },
    methods: {
        selectFriend(friend) {
            this.selectedFriendId = friend.id;
            this.$emit('userselected', friend);
        },
    },
};
</script>

<style scoped>
.list-group-item {
    cursor: pointer;
}

.list-group-item:hover {
    background-color: #f0f0f0;
}

.selected-friend {
    background-color: #f0f0f0;
}
</style>
