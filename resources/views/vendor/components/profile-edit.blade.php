<div class="modal fade" id="profile-edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog mt-1 modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-sign">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="js-validate" method="POST" id="vendor-update" novalidate="false">
                    @csrf
                    <!-- Form Success -->
                    <div class="alert alert-success d-none text-center animate__animated animate__headShake"
                        id="v-update-error" role="alert">
                    </div>

                    <!-- Form Error -->
                    <div class="alert alert-danger d-none text-center animate__animated animate__headShake"
                        id="v-update-error" role="alert">
                    </div>
                    <div class="row">
                        <!-- Input -->
                        <div class="col-sm-6 mb-2">
                            <div class="js-form-message">
                                <label id="nameLabel" class="form-label">
                                    Business Name
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="business_name"
                                        value="{{Auth::user('vendor')->business_name}}" placeholder="Enter your business name"
                                        aria-label="Enter your business name" required="" aria-describedby="nameLabel"
                                        data-msg="Please enter your business name." data-error-class="u-has-error"
                                        data-success-class="u-has-success">

                                    <small class="form-text text-muted">Displayed on your public profile, notifications
                                        and other places.</small>
                                </div>
                            </div>
                            <small class="text-danger error-message" id="business_name"></small>
                        </div>
                        <!-- End Input -->
                        <!-- Input -->
                        <div class="col-sm-6 mb-2">
                            <div class="js-form-message">
                                <label id="emailLabel" class="form-label">
                                    Email address
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email"
                                        value="{{Auth::user('vendor')->email}}" placeholder="Enter your email address"
                                        aria-label="Enter your email address" required="" aria-describedby="emailLabel"
                                        data-msg="Please enter a valid email address." data-error-class="u-has-error"
                                        data-success-class="u-has-success">
                                    <small class="form-text text-muted">We'll never share your email with anyone
                                        else.</small>
                                </div>
                            </div>
                            <small class="text-danger error-message" id="email"></small>
                        </div>
                        <!-- End Input -->
                    </div>
                    <div class="row">
                        <!-- Input -->
                        <div class="col-sm-6 mb-2">
                            <div class="js-form-message">
                                <label id="usernameLabel" class="form-label">
                                    Username
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="username"
                                        value="{{Auth::user('vendor')->username}}" placeholder="Enter your username"
                                        aria-label="Enter your username" required="" aria-describedby="usernameLabel"
                                        data-msg="Please enter your username." data-error-class="u-has-error"
                                        data-success-class="u-has-success">
                                </div>
                            </div>
                            <small class="text-danger error-message" id="username"></small>
                        </div>
                        <!-- End Input -->
                        <!-- Input -->
                        <div class="col-sm-6 mb-2">
                            <div class="js-form-message">
                                <label id="phoneNumberLabel" class="form-label">
                                    Phone number
                                    <span class="text-danger">*</span>
                                </label>
                                <div cfreachlass="form-group">
                                    <input class="form-control" type="tel" name="phone_number"
                                        value="{{Auth::user('vendor')->phone_number}}" placeholder="Enter your phone number"
                                        aria-label="Enter your phone number" required=""
                                        aria-describedby="phoneNumberLabel" data-msg="Please enter a valid phone number"
                                        data-error-class="u-has-error" data-success-class="u-has-success">
                                </div>
                            </div>
                            <small class="text-danger error-message" id="phone_number"></small>
                        </div>
                        <!-- End Input -->
                    </div>
                    <div class="row">
                        <!-- Input -->
                        <div class="col-sm-6 mb-2">
                            <div class="js-form-message">
                                <label id="locationLabel" class="form-label">
                                    State
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="form-group">
                                    <select name="area" onchange="fetchAreas(this.value)" class="form-control">
                                        @foreach($states as $key=>$val)
                                        @if($vendor_location->state_id == $val->id)
                                        <option value="{{$val->id}}" selected>{{$val->name}}</option>
                                        @else
                                        <option value="{{$val->id}}">{{$val->name}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End Input -->
                        <!-- Input -->
                        <div class="col-sm-6 mb-2">
                            <div class="js-form-message">
                                <label id="locationLabel" class="form-label">
                                    Area
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="form-group">
                                    <select name="area" id="area-list" class="form-control">
                                        @foreach($areas as $key=>$val)
                                        @if($vendor_location->area_id == $val->id)
                                        <option value="{{$val->id}}" selected>{{$val->name}}</option>
                                        @else
                                        <option value="{{$val->id}}">{{$val->name}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End Input -->
                    </div>
                    <div class="row">
                        <!-- Social Input -->
                        <div class="col-sm-12">
                            <label id="organizationLabel" class="form-label">
                                Social Handles
                            </label>
                        </div>
                        <div class="col-sm-4 mb-2">
                            <div class="js-form-message">
                                <div class="form-group">
                                    <div class="position-relative icon-form-control">
                                        <i class="la la-instagram position-absolute text-warning m-0"></i>
                                        @if(empty($social_handles->instagram))
                                        <input placeholder="Add Instagram link" name="instagram" type="text"
                                            class="form-control">
                                        @else
                                        <input placeholder="Add Instagram link" name="instagram" type="text"
                                            value="{{ $social_handles->instagram }}" class="form-control">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <small class="text-danger error-message" id="instagram"></small>
                        </div>
                        <div class="col-sm-4 mb-2">
                            <div class="js-form-message">
                                <div class="form-group">
                                    <div class="position-relative icon-form-control">
                                        <i class="la la-facebook position-absolute text-primary"></i>
                                        @if(empty($social_handles->facebook))
                                        <input placeholder="Add Facebook link" name="facebook" type="text"
                                            class="form-control">
                                        @else
                                        <input placeholder="Add Facebook link" name="facebook" type="text"
                                            value="{{ $social_handles->facebook }}" class="form-control">
                                        @endif

                                    </div>
                                </div>
                            </div>
                            <small class="text-danger error-message" id="facebook"></small>
                        </div>
                        <div class="col-sm-4 mb-2">
                            <div class="js-form-message">
                                <div class="form-group">
                                    <div class="position-relative icon-form-control">
                                        <i class="la la-twitter position-absolute text-info"></i>
                                        @if(empty($social_handles->twitter))
                                        <input placeholder="Add Twitter link" name="twitter" type="text"
                                            class="form-control">
                                        @else
                                        <input placeholder="Add Twitter link" name="twitter" type="text"
                                            value="{{ $social_handles->twitter }}" class="form-control">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <small class="text-danger error-message" id="twitter"></small>
                        </div>
                        <!-- End Social Input -->
                    </div>
                    <div class="row">
                        <!-- Input -->
                        <div class="form-group mb-4 col-md-6">
                            <label class="mb-1">Address</label>
                            <span class="text-danger">*</span>
                            <div class="position-relative">
                                <textarea class="form-control" rows="4" name="address" placeholder="Enter business info"
                                    required>{{Auth::user('vendor')->address}}</textarea>
                            </div>
                            <small class="text-danger error-message" id="about"></small>
                        </div>
                        <!-- End Input -->
                        <!-- Input -->
                        <div class="form-group mb-4 col-md-6">
                            <label class="mb-1">About Business</label>
                            <span class="text-danger">*</span>
                            <div class="position-relative">
                                <textarea class="form-control" rows="4" name="about" placeholder="Enter business info"
                                    required>{{Auth::user('vendor')->about_business}}</textarea>
                            </div>
                            <small class="text-danger error-message" id="about"></small>
                        </div>
                        <!-- End Input -->
                    </div>
                    <div class="form-group text-center col-sm-12">
                        <button class="btn btn-primary px-5" type="submit">
                            <span id="vendor-txt">Update</span>
                            <div class="spinner-border spinner-border-sm btn-pr" id="vendor-spinner"
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
        $('#vendor-update').submit(el => {
            vendorUpdate(el)
        })
    });

    // Vendor Update
    function vendorUpdate(el) {
        el.preventDefault()

        spin('vendor')
        offError('v-update-error')

        let url = `{{ url('vendor/profile_update') }}`;
        let data = new FormData(el.target)

        goPost(url, data)
            .then(res => {
                spin('vendor')

                if (handleFormRes(res)) {
                    showAlert(true, res.message);
                    setTimeout(() => {
                        location.reload()
                    }, 2000)
                }
            })
            .catch(err => {
                spin('vendor')
                handleFormRes(err, 'v-sign-error');
            })
    }

    // Fetch Areas according to state
    function fetchAreas(state) {
        let url = `{{ url('areas') }}/${state}`;

        goGet(url)
            .then(res => {

                $('#area-list').html('');

                [...res.areas].forEach(area => {
                    $('#area-list').append(`
        <option value="${area.id}">${area.name}</option>
        `)
                })

                $('#area-list-cont').removeClass('d-none');
                $('#proceed-btn').removeClass('d-none')
            })
            .catch(err => {
                showAlert(false, "Oops! Something's not right. Please Reload Page")
            })
    }

</script>
