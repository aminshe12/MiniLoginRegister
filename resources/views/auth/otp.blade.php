@extends('layouts.layoutLogin')
@section('content')
    <div class="splash-container">
        @include('partials.alert')
        <div class="card ">
            <div class="card-header text-center"></div>
            <div class="card-body">
                <form method="POST" action="{{route('check-otp')}}">
                    @csrf
                    <div class="form-group">
                        <input class="form-control form-control-lg required-field @error('otp') is-invalid @enderror"
                               id="otp"  name="otp"
                               placeholder="One time password..." required>

                        @error('otp')
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
