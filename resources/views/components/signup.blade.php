<div class="post-popup col-lg-6 col-md-8" id="sign-up-modal">
    <div class="post-project" id="sign-up-inner">
        <h3 class="curve-top">Sign Up</h3>
        <div class="post-project-fields curve-bottom py-0">
            <div class="main-ws-sec">

                <div class="user-tab-sec rewivew">
                    <h4 class="curve-top text-center mb-n1">as</h4>
                    <div class="tab-feed st2 settingjb text-center border-bottom pb-2">
                        <ul>
                            <li data-tab="feed-dd" class="active col-md-4">
                                <a href="#" title="">
                                    <span>Vendor</span>
                                </a>
                            </li>
                            <li data-tab="info-dd" class="col-md-4 border-left">
                                <a href="#" title="">
                                    <span>User</span>
                                </a>
                            </li>
                        </ul>
                    </div><!-- tab-signup end-->
                </div>
                <!--user-tab-sec end-->
                <div class="product-feed-tab current" id="feed-dd" style="height: 300px; overflow-y: scroll;">
                    <form id="vendor-signup-form" class="row my-0" method="POST">
                        <div class="form-group col-md-12 mt-2">
                            <label for="business_name">Business Name</label>
                            <input type="text" name="business_name" class="form-control mb-0 mt-2" id="business_name"
                                placeholder="Business Name">
                            <span class="text-danger error-message" id="business_name"></span>
                        </div>

                        <div class="form-group col-md-12 mt-2">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control mb-0 mt-2" id="username"
                                placeholder="Username">
                            <span class="text-danger error-message" id="username"></span>
                        </div>

                        <div class="form-group col-md-12 mt-2">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control mb-0 mt-2" id="email"
                                placeholder="Email">
                            <span class="text-danger error-message" id="email"></span>
                        </div>

                        <div class="form-group col-md-12 mt-2">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" class="form-control mb-0 mt-2" id="phone"
                                placeholder="Phone Number">
                            <span class="text-danger error-message" id="phone"></span>
                        </div>
                        <div class="form-group col-md-12 mt-2">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control mb-0 mt-2" id="password"
                                placeholder="Password">
                            <span class="text-danger error-message" id="password"></span>
                        </div>
                    </form>
                    <div class="form-group col-md-6 mx-auto">
                        <button class="btn form-btn mt-0">
                            <span id="vendor-txt">Sign Up</span>
                            <div class="spinner-border spinner-border-sm btn-pr" id="vendor-spinner" role="status"
                                style="display: none;">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </button>
                    </div>
                </div>
                <!--vendor-form-end-->
                <div class="product-feed-tab pt-3" id="info-dd" style="height: 300px; overflow-y: scroll;">
                    <form id="user-signup-form" class="row my-0" method="POST">
                        <div class="form-group col-md-12">
                            <label for="name">Name</label>
                            <input type="text" class="form-control mt-2" id="name" placeholder="Name" name="name">
                            <span class="text-danger error-message" id="home_address"></span>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="user_email">Email</label>
                            <input type="email" name="email" class="form-control mt-2" id="user_email"
                                placeholder="Email">
                            <span class="text-danger error-message" id="home_address"></span>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="user_phone">Phone</label>
                            <input type="text" name="phone" class="form-control mt-2" id="user_phone"
                                placeholder="Phone Number">
                            <span class="text-danger error-message" id="home_address"></span>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="user_password">Password</label>
                            <input type="password" name="password" class="form-control mt-2" id="user_password"
                                placeholder="Password">
                            <span class="text-danger error-message" id="home_address"></span>
                        </div>
                    </form>
                    <div class="form-group col-md-6 mx-auto">
                        <button class="btn form-btn mt-0">Sign Up</button>
                    </div>
                </div>
                <!--user-form-tab end-->
                <div class="form-group text-center">
                    <p>Already have an account?<br><a href="#" id="login-lk" class="fud-link">Login</a></p>
                </div>
            </div>

        </div>

        <a href="" title=""><i class="la la-times-circle-o"></i></a>
    </div>
</div>

<script>

    $(document).ready(function () {
        $('#vendor-signup-form').submit(el => {
            vendorSignup(el)
        })
    });

    // Vendor Signup
    function vendorSignup(el) {
        el.preventDefault()

        spin('vendor')
        offError()

        let url = `{{ url('vendor/sign-up') }}`;
        let data = new FormData(el.target)

        goPost(url, data)
            .then(res => {
                spin('vendor')
                showAlert(true, res.message)
            })
            .catch(err => {
                spin('vendor')
                handleFormError(err);
            })
    }

</script>