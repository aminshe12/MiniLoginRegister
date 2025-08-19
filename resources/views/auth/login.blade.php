@extends('layouts.layoutLogin')
@section('content')
    <div class="splash-container">
        @include('partials.alert')
        <div class="card ">
            <div class="card-header text-center">ورود یا ثبت نام</div>
            <div class="card-body">
                <form method="POST" action="{{route('check-mobile')}}">
                    @csrf
                    <div class="form-group">
                        <input name="mobile" class="form-control form-control-lg @error('mobile') is-invalid @enderror"
                               id="mobile" placeholder="09120000000"
                               autocomplete="off" value="{{old('mobile')}}"  required>

                        @error('mobile')
                        <div class="invalid-feedback">
                            شماره موبایل باید 11 رقم باشد.

                        </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">تأیید</button>
                </form>
            </div>
        </div>
    </div>
@endsection
