<div class="modal fade" id="profile-edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog mt-1" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Profile Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-sign">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <ul class="nav nav-justified border-bottom osahan-line-tab" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" style="padding-top: 0 !important;" id="vendor-tab" data-toggle="tab"
                            href="#vendor" role="tab" aria-controls="vendor" aria-selected="true"><i
                                class="la la-user la-lg"></i>&nbsp;Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="padding-top: 0 !important;" id="profile-tab" data-toggle="tab"
                            href="#user" role="tab" aria-controls="user" aria-selected="false"><i
                                class="la la-key la-lg"></i>&nbsp;Password</a>
                    </li>
                </ul>

                <div class="tab-content mt-3" id="myTabContent">
                    <!-- Profile Form -->
                    <div class="tab-pane fade show active" id="vendor" role="tabpanel" aria-labelledby="vendor-tab">
                        <!-- Form Error -->
                        <div class="alert alert-danger d-none text-center animate__animated animate__headShake"
                            id="v-sign-error" role="alert">
                        </div>
                        <form class="js-validate" method="POST" id="profile-update" novalidate="false">
                            @csrf
                            <!-- Form Success -->
                            <!-- <div class="alert alert-success d-none text-center animate__animated animate__headShake"
                                id="v-update-error" role="alert">
                            </div> -->

                            <!-- Form Error -->
                            <div class="alert alert-danger d-none text-center animate__animated animate__headShake"
                                id="pr-update-error" role="alert">
                            </div>
                            <div class="row">
                                <!-- Input -->
                                <div class="col-sm-6 mb-2">
                                    <div class="js-form-message">
                                        <label id="nameLabel" class="form-label">
                                            Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="name"
                                                value="{{Auth::guard('user')->user()->name}}"
                                                placeholder="Enter your business name"
                                                aria-label="Enter your business name" required=""
                                                aria-describedby="nameLabel" data-msg="Please enter your name."
                                                data-error-class="u-has-error" data-success-class="u-has-success">

                                            <small class="form-text text-muted">Displayed on your public profile,
                                                notifications
                                                and other places.</small>
                                        </div>
                                    </div>
                                    <small class="text-danger error-message" id="name"></small>
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
                                                value="{{Auth::guard('user')->user()->email}}"
                                                placeholder="Enter your email address"
                                                aria-label="Enter your email address" required=""
                                                aria-describedby="emailLabel"
                                                data-msg="Please enter a valid email address."
                                                data-error-class="u-has-error" data-success-class="u-has-success">
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
                                                value="{{Auth::guard('user')->user()->username}}"
                                                placeholder="Enter your username" aria-label="Enter your username"
                                                required="" aria-describedby="usernameLabel"
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
                                                value="{{Auth::guard('user')->user()->phone_number}}"
                                                placeholder="Enter your phone number"
                                                aria-label="Enter your phone number" required=""
                                                aria-describedby="phoneNumberLabel"
                                                data-msg="Please enter a valid phone number"
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
                                            <select name="area" onchange="fetchAreas(this.value)" class="form-control"
                                                required>
                                                @foreach($states as $key=>$val)
                                                @if($user_location->state_id == $val->id)
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
                                            <select name="area" class="form-control" id="area-list" required>
                                                @foreach($areas as $key=>$val)
                                                @if($user_location->area_id == $val->id)
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
                                <!-- Input -->
                                <div class="col-sm-12 mb-2">
                                    <div class="js-form-message">
                                        <label id="organizationLabel" class="form-label">
                                            Adress
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="form-group">
                                            <textarea class="form-control" rows="4" name="address"
                                                placeholder="Enter business info" aria-label="Enter your address"
                                                required="" aria-describedby="organizationLabel"
                                                data-msg="Please enter your address" data-error-class="u-has-error"
                                                data-success-class="u-has-success">{{Auth::guard('user')->user()->address}}</textarea>
                                        </div>
                                    </div>
                                    <small class="text-danger error-message" id="address"></small>
                                </div>
                                <!-- End Input -->
                            </div>
                            <div class="form-group text-center col-sm-12">
                                <button class="btn btn-primary px-5" type="submit">
                                    <span id="vendor-txt">Update</span>
                                    <div class="spinner-border spinner-border-sm btn-pr" id="profile-spinner"
                                        style="display: none;" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Password Reset Form -->
                    <div class="tab-pane fade" id="user" role="tabpanel" aria-labelledby="user-tab">
                        <!-- Form Error -->
                        <div class="alert alert-danger d-none text-center animate__animated animate__headShake"
                            id="p-update-error" role="alert">
                        </div>
                        <form class="row" id="password-update" method="POST">
                            @csrf

                            <div class="form-group col-sm-12">
                                <label class="mb-1">Current Password <small class="text-danger">*</small></label>
                                <div class="position-relative icon-form-control">
                                    <i class="la la-key position-absolute"></i>
                                    <input type="password" class="form-control" placeholder="Password"
                                        name="current_password" required>
                                </div>
                                <small class="text-danger error-message" id="current_password"></small>
                            </div>

                            <div class="form-group col-sm-12">
                                <label class="mb-1">New Password <small class="text-danger">*</small></label>
                                <div class="position-relative icon-form-control">
                                    <i class="la la-key position-absolute"></i>
                                    <input type="password" class="form-control" placeholder="Password"
                                        name="new_password" required>
                                </div>
                                <small class="text-danger error-message" id="new_password"></small>
                            </div>

                            <div class="form-group text-center col-sm-12">
                                <button class="btn btn-primary px-5" type="submit">
                                    <span id="user-txt">Update</span>
                                    <div class="spinner-border spinner-border-sm btn-pr" id="password-spinner"
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


<script>
    $(document).ready(function () {
        // Attach User Profile Update Form Event Listener
        $('#profile-update').submit(el => {
            userUpdate(el)
        })

        // Attach User Password Update Form Event Listener
        $('#password-update').submit(el => {
            passwordUpdate(el)
        })
    });

    // User Profile Update
    function userUpdate(el) {
        el.preventDefault()

        spin('profile')
        offError('pr-update-error')

        let url = `{{ url('user/update-profile') }}`;
        let data = new FormData(el.target)

        goPost(url, data)
            .then(res => {
                spin('profile')

                if (handleFormRes(res)) {
                    showAlert(true, res.message);

                    // Hide Profile Edit Modal & Remove Excess Modal Backdrops On Successful Profile Edit
                    $("#profile-edit-modal").modal('hide');
                    $(".modal-backdrop").remove();
                    // Hide Profile Edit Modal & Remove Excess Modal Backdrops On Successful Profile Edit

                    // Refresh Right Side Without Removing Profile Edit Modal
                    loadUserRight(true, true);
                }
            })
            .catch(err => {
                spin('profile');
                handleFormRes(err, 'pr-update-error');
                showAlert(false, "Oops! Something's not right. Try again.");
            })
    }

    // User Password Update
    function passwordUpdate(el) {
        el.preventDefault()

        spin('password')
        offError('p-update-error')

        let url = `{{ url('user/update-password') }}`;
        let data = new FormData(el.target)

        goPost(url, data)
            .then(res => {
                spin('password')

                if (handleFormRes(res)) {
                    showAlert(true, res.message);

                    // Remove Profile Edit Form Modal After Password Change
                    $("#profile-edit-modal").modal('hide');
                }
            })
            .catch(err => {
                spin('password')
                handleFormRes(err, 'p-update-error');
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
                showAlert(false, "Oops! Something's not right. Please reload page")
            })
    }

</script>
