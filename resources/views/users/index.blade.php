@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-3">
                    <h2 class="card-header">User List</h2>
                    <div class="card-body">

                        @if (session('success'))
                            <div class="alert alert-success" role="alert"> {{ session('success') }} </div>
                        @endif
                        @if (session('delete_error'))
                            <div class="alert alert-danger" role="alert"> {{ session('delete_error') }} </div>
                        @endif

                        <div class="container">
                            <div class="d-flex ms-auto">
                                <div class="d-grid gap-2">
                                    <a class="btn btn-info btn-sm" href="{{ route('chat') }}"> <i
                                            class="fas fa-comment-dots"></i> Chats</a>
                                </div>
                                <div class="d-grid gap-2 ms-2">
                                    <a class="btn btn-secondary btn-sm" href="{{ route('group.messages') }}"> <i
                                            class="fas fa-comments"></i> Group Messaging</a>
                                </div>
                                <div class="d-grid gap-2 ms-2">
                                    <a class="btn btn-success btn-sm" href="{{ route('users.create') }}"> <i
                                            class="fa fa-plus"></i> Create New User</a>
                                </div>
                            </div>
                        </div>

                        <table class="table table-bordered table-striped mt-4">
                            <thead>
                                <tr>
                                    <th width="80px">User ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th width="250px">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role == 1 ? 'ADMIN' : 'MEMBER' }}</td>
                                        <td>
                                            <a class="btn btn-primary btn-sm" href="{{ route('users.edit', $user->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>

                                            @if (auth()->user()->id !== $user->id)
                                                <form action="{{ route('users.delete', $user->id) }}" method="POST"style="display: inline;" onsubmit="return confirmDelete()">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5"
                                            style="text-align: center; vertical-align: middle; height: 100px;">
                                            There are no data.</td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this user?");
    }
</script>
