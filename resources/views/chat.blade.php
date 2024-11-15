@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"><strong>Friends</strong></div>
                <div class="card-body">
                    <friend-list :friends="friends" @userselected="selectFriend"></friend-list>
                </div>
            </div>
        </div>

        <div class="col-md-8" v-if="selectedFriend">
            <div class="card">
                <div class="card-header">
                    <strong v-text="selectedFriend.name"></strong>
                </div>
                <div class="card-body">
                    <chat-messages :messages="messages" :current-user-id="{{ Auth::id() }}"></chat-messages>
                </div>
                <div class="card-footer">
                    <chat-form v-on:messagesent="addMessage" :current-user-id="{{ Auth::id() }}" :selected-friend="selectedFriend"></chat-form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
