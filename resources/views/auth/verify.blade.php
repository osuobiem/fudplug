@extends('layouts.master')

@section('content')

{{--<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

<div class="card-body">
    @if(session()->has('message'))
    <div class="alert alert-danger" role="alert">
        {{ __(session()->get('message')) }}
    </div>
    @else
    <div class="alert alert-success" role="alert">
        {{ __('A fresh verification link has been sent to your email address.') }}
    </div>
    @endif

    {{ __('Before proceeding, please check your email for a verification link.') }}
    {{ __('If you did not receive the email') }},
    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
        @csrf
        <input type="hidden" name="email" value="{{session()->get('verify_email')}}">
        <button type="submit"
            class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
    </form>
</div>
</div>
</div>
</div>
</div>--}}


<div class="vh-100 bg-white">
    <div class="container">
        <div class="row align-items-center vh-100">
            <div class="col-md-12 text-center">
                @if(session()->get('verify_email')[1] == "unverified_login")
                <div>
                    <img src="{{ url('assets/img/verify-email.svg') }}" alt="">
                    <h2 class="text-dark font-weight-bold">Welcome.
                        {{ __('You are seeing this page because your email has not been verified.') }}</h2>
                    <p class="lead mb-2">
                        {{ __('If you did not receive the verification email') }}
                    </p>
                </div>
                @else
                <div>
                    <img src="{{ url('assets/img/verify-email.svg') }}" alt="">
                    <h2 class="text-dark font-weight-bold">Welcome.
                        {{ __('We have sent a verification link to your email address.') }}</h2>
                    <p class="lead mb-2">
                        {{ __('If you did not receive the email') }}
                    </p>
                </div>
                @endif
                <div class="d-inline">
                    {{--<button id="resend-btn" type="button"
                        class="btn btn-primary btn-lg">{{ __('Click here to resend') }}</button>.--}}

                    <button class="btn btn-primary btn-lg px-5" type="button" id="resend-btn">
                        <span id="resend-txt">{{ __('Click here to resend') }}</span>
                        <div class="spinner-border spinner-border-sm btn-pr" id="resend-spinner" style="display: none;"
                            role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </button>
                </div>
                <!-- <a href="index.html" class="btn btn-primary btn-lg"> {{ __('Click here to resend') }} </a> -->
                <!-- <a href="https://themeforest.net/item/osahanin-job-portal-social-network-html-template/25255511"
                    class="btn btn-light btn-lg"> Buy Now </a> -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $("#resend-btn").on('click', function () {
        resendEmail();
    });

    function resendEmail() {
        // Btn spinner
        spin('resend');

        let url = "{{ route('verification.resend') }}";
        let formData = new FormData();
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('email', "{{session()->get('verify_email')[0]}}");

        goPost(url, formData)
            .then(res => {
                // Btn spinner
                spin('resend');
                if (res.success) {
                    showAlert(true, res.message);
                } else {
                    showAlert(false, res.message);
                }
            })
            .catch(err => {
                // Btn spinner
                spin('resend');

                showAlert(false, err.responseJSON.message);
            })
    }

</script>
@endpush
