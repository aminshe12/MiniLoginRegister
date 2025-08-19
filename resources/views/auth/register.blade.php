@extends('layouts.layoutLogin')

@section('content')
<div class="splash-container">
    @include('partials.alert')
    <div class="card ">
        <div class="card-header text-center">تکمیل ثبت نام</div>
        <div class="card-body">
            <form method="POST" action="{{ route('register-user') }}">
                @csrf
                <input type="hidden" name="mobile" value="{{ $mobile ?? old('mobile') }}">
                <div class="form-group">
                    <input id="first_name" name="first_name" class="form-control form-control-lg @error('first_name') is-invalid @enderror" placeholder="نام" value="{{ old('first_name') }}" required>
                    @error('first_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <input id="last_name" name="last_name" class="form-control form-control-lg @error('last_name') is-invalid @enderror" placeholder="نام خانوادگی" value="{{ old('last_name') }}" required>
                    @error('last_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <input id="national_code" name="national_code" class="form-control form-control-lg @error('national_code') is-invalid @enderror" placeholder="کد ملی" value="{{ old('national_code') }}" required>
                    @error('national_code')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <input id="password" type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" placeholder="کلمه عبور" required>
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block">تکمیل ثبت نام</button>
            </form>
        </div>
    </div>
</div>
@endsection
