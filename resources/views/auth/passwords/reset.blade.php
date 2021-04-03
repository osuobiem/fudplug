@extends('layouts.master')

@section('content')
<div class="bg-white">
    <div class="">
        <div class="row justify-content-center align-items-center d-flex vh-100">
            <div class="col-md-7 mx-auto bg-light border rounded">
                <div class="osahan-login py-4">
                    <div class="text-center mb-0">
                        <img src="/assets/img/logo.png" class="col-3" alt="">
                        <!-- <h5 class="font-weight-bold mt-3">Welcome Back</h5> -->
                        <p class="text-muted">Change password for <b>{{$user->email}}</b>.</p>
                    </div>

                    <div class="p-4">
                        <!-- Form Error -->
                        <div class="alert alert-danger d-none text-center animate__animated animate__headShake"
                            id="reset-password-error" role="alert">
                        </div>

                        <form id="reset-password-form" method="POST">
                            @csrf
                            <input type="hidden" name="email" value="{{$user->email}}">
                            <div class="form-group">
                                <label class="mb-1">Password <small class="text-danger">*</small></label>
                                <div class="position-relative icon-form-control">
                                    <i class="la la-key position-absolute"></i>
                                    <input type="password" class="form-control bg-white" placeholder="Password"
                                        name="password" required>
                                </div>
                                <small class="text-danger error-message" id="r-password"></small>
                            </div>

                            <div class="form-group">
                                <label class="mb-1">Confirm password <small class="text-danger">*</small></label>
                                <div class="position-relative icon-form-control">
                                    <i class="la la-key position-absolute"></i>
                                    <input type="password" class="form-control bg-white" placeholder="Confirm password"
                                        name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="mb-3 text-justify text-dark">
                                Make sure it's at least 6 characters.
                            </div>

                            <div class="form-group text-center col-sm-12">
                                <button class="btn btn-primary px-5" type="submit" id="reset-password-btn">
                                    <span id="reset-password-txt">Change password</span>
                                    <div class="spinner-border spinner-border-sm btn-pr" id="reset-password-spinner"
                                        style="display: none;" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
    $(document).ready(function () {
        // Attach login form event listener
        $('#reset-password-form').submit(el => {
            updatePassword(el)
        })
    });

    // Process Login
    function updatePassword(el) {
        el.preventDefault()

        spin('reset-password')
        offError('reset-password-error')

        let url = `{{ url('update-password') }}`;
        let data = new FormData(el.target)

        goPost(url, data)
            .then((res) => {
                spin('reset-password')

                if (handleFormRes(res, 'reset-password-error', 'r')) {
                    showAlert(true, res.message);

                    // Redirect to home page after 5 seconds
                    setTimeout(() => {
                        location.replace("{{route('.')}}")
                    }, 5000);

                    // Reset form
                    el.target.reset();
                }

            })
            .catch(err => {
                spin('reset-password')
                handleFormRes(err, 'reset-password-error');
            })
    }

</script>
@endpush
