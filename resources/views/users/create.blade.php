@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-3">
                    <h2 class="card-header">Add New User</h2>
                    <div class="card-body">

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a class="btn btn-primary btn-sm" href="{{ route('users.index') }}"><i
                                    class="fa fa-arrow-left"></i> Back</a>
                        </div>

                        <form action="{{ route('users.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="inputName" class="form-label"><strong>User Name:</strong></label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror" id="inputName"
                                    placeholder="User Name" autocomplete="off" required>
                                @error('name')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="inputEmail" class="form-label"><strong>Email:</strong></label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror" id="inputEmail"
                                    placeholder="Email" autocomplete="off" required>
                                @error('email')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="d-block mb-2" for="inputUserRole" class="form-label"><strong>User Role:</strong></label>
                                <label>
                                    <input type="radio" id="role_admin" name="role" value="1"
                                        {{ old('role') == 1 ? 'checked' : '' }}>
                                    ADMIN
                                </label>

                                <label>
                                    <input type="radio" id="role_member" name="role" value="0"
                                        {{ old('role') == 0 ? 'checked' : '' }}>
                                    MEMBER
                                </label>
                                @error('role')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i>
                                Submit</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
