@extends('layouts.layoutLogin')
@section('content')
    <div class="splash-container">
        @include('partials.alert')
        <div class="card ">
            <div class="card-header text-center"></div>
            <div class="card-body">
                <form method="POST" action="{{route('check-password')}}">
                    @csrf
                    <div class="form-group">
                        <input type="password" class="form-control form-control-lg required-field @error('password') is-invalid @enderror"
                               id="password"  name="password"
                               placeholder="Password" required>

                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Verify Password</button>
                </form>
            </div>
        </div>
    </div>
@endsection
