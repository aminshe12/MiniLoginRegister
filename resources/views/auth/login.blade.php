@extends('layouts.layoutLogin')
@section('content')
    <div class="splash-container">
        @include('partials.alert')
        <div class="card ">
            <div class="card-header text-center"></div>
            <div class="card-body">
                <form method="POST" action="{{route('check-mobile')}}">
                    @csrf
                    <div class="form-group">
                        <input name="mobile" class="form-control form-control-lg @error('mobile') is-invalid @enderror"
                               id="mobile" placeholder="09120000000"
                               autocomplete="off" value="{{old('mobile')}}"  required>

                        @error('mobile')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>
                </form>
            </div>
        </div>
    </div>
@endsection
