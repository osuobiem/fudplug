<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog mt-5" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-light" id="exampleModalLabel">Login</h5>
                <button type="button" class="close" id="close-login" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-light">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- Form Error -->
                <div class="alert alert-danger d-none text-center animate__animated animate__headShake" id="login-error"
                    role="alert">
                </div>

                <form id="login-form" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="mb-1">Username, Email or Phone <small class="text-danger">*</small></label>
                        <div class="position-relative icon-form-control">
                            <i class="la la-at position-absolute"></i>
                            <input type="text" class="form-control" placeholder="Username, Email or Phone Number"
                                required name="login">
                        </div>
                        <small class="text-danger error-message" id="l-login"></small>
                    </div>

                    <div class="form-group">
                        <label class="mb-1">Password <small class="text-danger">*</small></label>
                        <div class="position-relative icon-form-control">
                            <i class="la la-key position-absolute"></i>
                            <input type="password" class="form-control" id="l-log" placeholder="Password" name="password" required>
                            <i class="la la-eye position-absolute" title="Show Password" onclick="showPassword(this, 'l-log', true)" style="right: 0"></i>
                        </div>
                        <small class="text-danger error-message" id="l-password"></small>
                    </div>

                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" class="custom-control-input" checked id="customCheck1"
                            name="remember_me">
                        <label class="custom-control-label" for="customCheck1">Remember Me</label>
                    </div>

                    <div class="form-group text-center col-sm-12">
                        <button class="btn btn-primary px-5" type="submit" id="login-btn">
                            <span id="login-txt">Login</span>
                            <div class="spinner-border spinner-border-sm btn-pr" id="login-spinner"
                                style="display: none;" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </button>
                    </div>
                </form>
                <div class="text-center mt-3 border-bottom pb-3">
                    <p class="small text-muted">Or login with</p>
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ url('auth/google') }}" type="button"
                                class="btn btn-sm btn-outline-linkedin btn-block socialite-btn"><i
                                    class="la la-google"></i>
                                Google</a>
                        </div>
                        <div class="col-6">
                            <a href="{{ url('auth/facebook') }}" type="button"
                                class="btn btn-sm btn-outline-facebook btn-block socialite-btn"><i
                                    class="la la-facebook"></i>
                                Facebook</a>
                        </div>
                    </div>
                </div>
                <div class="py-3 d-flex align-item-center">
                    <a onclick="forgotPasswordModal()" href="javascript:void(0)">Forgot password?</a>
                    <span class="ml-auto"> New to FudPlug? <a class="font-weight-bold" href="#"
                            onclick="signModal()">Join
                            now</a></span>
                </div>
            </div>
        </div>
    </div>
</div>
<span class="d-none" data-toggle="modal" href="#signupModal" id="sign-pop"></span>

@push('scripts')
<script>
    $(document).ready(function () {
        // Attach login form event listener
        $('#login-form').submit(el => {
            login(el)
        })
    });

    // Process Login
    function login(el) {
        el.preventDefault()

        spin('login')
        offError('login-error')

        let url = `{{ url('p-login') }}`;
        let data = new FormData(el.target)

        goPost(url, data)
            .then((res) => {
                if (res.message == "unverified") {
                    location.replace("{{route('verify-email')}}");
                } else {
                    if(handleFormRes(res, 'login-error', 'l')){
                       location.reload()
                    }
                    else {
                        spin('login')
                    }
                }
            })
            .catch(err => {
                spin('login')
                handleFormRes(err, 'login-error');
            })
    }

    function signModal() {
        $("#forgot-password-modal").modal('hide');
        $('#close-login').click()
        $('#sign-pop').click()
    }

    function forgotPasswordModal() {
        $('#close-login').click()
        $('#close-sign').click()
        $("#forgot-password-modal").modal('toggle');
    }

</script>
@endpush
