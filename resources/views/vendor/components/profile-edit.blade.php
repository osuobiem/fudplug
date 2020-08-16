<div class="modal fade" id="profile-edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog mt-1" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-sign">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="js-validate" novalidate="novalidate">
                    <div class="row">
                        <!-- Input -->
                        <div class="col-sm-6 mb-2">
                            <div class="js-form-message">
                                <label id="nameLabel" class="form-label">
                                    Business Name
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name" value="Gurdeep Osahan"
                                        placeholder="Enter your name" aria-label="Enter your name" required=""
                                        aria-describedby="nameLabel" data-msg="Please enter your name."
                                        data-error-class="u-has-error" data-success-class="u-has-success">
                                    <small class="form-text text-muted">Displayed on your public profile, notifications
                                        and other places.</small>
                                </div>
                            </div>
                        </div>
                        <!-- End Input -->
                        <!-- Input -->
                        <div class="col-sm-6 mb-2">
                            <div class="js-form-message">
                                <label id="usernameLabel" class="form-label">
                                    Username
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="username" value="iamosahan"
                                        placeholder="Enter your username" aria-label="Enter your username" required=""
                                        aria-describedby="usernameLabel" data-msg="Please enter your username."
                                        data-error-class="u-has-error" data-success-class="u-has-success">
                                </div>
                            </div>
                        </div>
                        <!-- End Input -->
                    </div>
                    <div class="row">
                        <!-- Input -->
                        <div class="col-sm-6 mb-2">
                            <div class="js-form-message">
                                <label id="emailLabel" class="form-label">
                                    Email address
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" value="iamosahan@gmail.com"
                                        placeholder="Enter your email address" aria-label="Enter your email address"
                                        required="" aria-describedby="emailLabel"
                                        data-msg="Please enter a valid email address." data-error-class="u-has-error"
                                        data-success-class="u-has-success">
                                    <small class="form-text text-muted">We'll never share your email with anyone
                                        else.</small>
                                </div>
                            </div>
                        </div>
                        <!-- End Input -->
                        <!-- Input -->
                        <div class="col-sm-6 mb-2">
                            <div class="js-form-message">
                                <label id="locationLabel" class="form-label">
                                    Location
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="location" value="Ludhiana, Punjab"
                                        placeholder="Enter your location" aria-label="Enter your location" required=""
                                        aria-describedby="locationLabel" data-msg="Please enter your location."
                                        data-error-class="u-has-error" data-success-class="u-has-success">
                                </div>
                            </div>
                        </div>
                        <!-- End Input -->
                    </div>
                    <div class="row">
                        <!-- Input -->
                        <div class="col-sm-6 mb-2">
                            <div class="js-form-message">
                                <label id="organizationLabel" class="form-label">
                                    Adress
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="organization" value="Askbootsrap Ltd."
                                        placeholder="Enter your organization name"
                                        aria-label="Enter your organization name" required=""
                                        aria-describedby="organizationLabel"
                                        data-msg="Please enter your organization name" data-error-class="u-has-error"
                                        data-success-class="u-has-success">
                                </div>
                            </div>
                        </div>
                        <!-- End Input -->
                        <!-- Input -->
                        <div class="col-sm-6 mb-2">
                            <div class="js-form-message">
                                <label id="phoneNumberLabel" class="form-label">
                                    Phone number
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="form-group">
                                    <input class="form-control" type="tel" name="phoneNumber" value="+91 85680 79956"
                                        placeholder="Enter your phone number" aria-label="Enter your phone number"
                                        required="" aria-describedby="phoneNumberLabel"
                                        data-msg="Please enter a valid phone number" data-error-class="u-has-error"
                                        data-success-class="u-has-success">
                                </div>
                            </div>
                        </div>
                        <!-- End Input -->
                    </div>
                    <div class="row">
                        <div class="form-group mb-4 col-md-12">
                            <label class="mb-1">About Business</label>
                            <div class="position-relative">
                                <textarea class="form-control" rows="4" name="text"
                                    placeholder="Enter Bio">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor :)</textarea>
                            </div>
                        </div>

                    </div>
                    <div class="form-group text-center col-sm-12">
                        <button class="btn btn-primary px-5" type="submit">
                            <span id="user-txt">Save</span>
                            <div class="spinner-border spinner-border-sm btn-pr" id="user-spinner"
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

<span class="d-none" data-toggle="modal" href="#loginModal" id="login-pop"></span>

<script>
    $(document).ready(function () {
        // Attach vendor form event listener
        $('#vendor-signup').submit(el => {
            vendorSignUp(el)
        })

        // Attach user form event listener
        $('#user-signup').submit(el => {
            userSignUp(el)
        })
    });

    // Vendor Sign up
    function vendorSignUp(el) {
        el.preventDefault()

        spin('vendor')
        offError('v-sign-error')

        let url = `{{ url('vendor/sign-up') }}`;
        let data = new FormData(el.target)

        goPost(url, data)
            .then(res => {
                spin('vendor')

                location.reload()
            })
            .catch(err => {
                spin('vendor')
                handleFormError(err, 'v-sign-error');
            })
    }

    // User Sign up
    function userSignUp(el) {
        el.preventDefault()

        spin('user')
        offError('u-sign-error')

        let url = `{{ url('user/sign-up') }}`;
        let data = new FormData(el.target)

        goPost(url, data)
            .then(res => {
                spin('user')

                location.reload()
            })
            .catch(err => {
                spin('user')
                handleFormError(err, 'u-sign-error', 'u');
            })
    }

    function loginModal() {
        $('#close-sign').click()
        $('#login-pop').click()
    }

</script>
