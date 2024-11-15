@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-3">
                    <h2 class="card-header">Group Messaging</h2>
                    <div class="card-body">

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a class="btn btn-primary btn-sm" href="{{ route('users.index') }}"><i
                                    class="fa fa-arrow-left"></i> Back</a>
                        </div>

                        <form action="{{ route('send.group.messages') }}" method="POST">
                            @csrf

                            <div class="row">
                                @error('friend_ids')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <!-- ADMIN Section -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">ADMIN:</label>
                                        <div class="form-check">
                                            @foreach ($friends->where('role', 1) as $admin)
                                                <div class="mb-1">
                                                    <input class="form-check-input" type="checkbox" name="friend_ids[]"
                                                        value="{{ $admin->id }}" id="admin{{ $admin->id }}"
                                                        {{ in_array($admin->id, old('friend_ids', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="admin{{ $admin->id }}">
                                                        {{ $admin->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- MEMBER Section -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">MEMBER:</label>
                                        <div class="form-check">
                                            @foreach ($friends->where('role', 0) as $member)
                                                <div class="mb-1">
                                                    <input class="form-check-input" type="checkbox" name="friend_ids[]"
                                                        value="{{ $member->id }}" id="member{{ $member->id }}"
                                                        {{ in_array($member->id, old('friend_ids', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="member{{ $member->id }}">
                                                        {{ $member->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label">Message:</label>
                                <textarea class="form-control" id="message" name="message" rows="4" placeholder="Type your message here...">{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success">Send Message</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
