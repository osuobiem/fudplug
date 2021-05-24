<div class="modal fade" id="profile-edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog mt-1 modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-light" id="exampleModalLabel">Edit Profile</h5>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close" id="close-sign">
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
                                        value="{{ Auth::user('vendor')->business_name }}"
                                        placeholder="Enter your business name" aria-label="Enter your business name"
                                        required="" aria-describedby="nameLabel"
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
                                        value="{{ Auth::user('vendor')->email }}" placeholder="Enter your email address"
                                        aria-label="Enter your email address" required="" aria-describedby="emailLabel"
                                        data-msg="Please enter a valid email address." data-error-class="u-has-error"
                                        data-success-class="u-has-success">
                                    <small class="form-text text-muted">We'll never share your email with
                                        anyone.</small>
                                </div>
                            </div>
                            <small class="text-danger error-message" id="email"></small>
                        </div>
                        <!-- End Input -->
                    </div>
                    <div class="row">
                        <!-- Input -->
                        <div class="col-6 mb-2">
                            <div class="js-form-message">
                                <label id="usernameLabel" class="form-label">
                                    Username
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="username"
                                        value="{{ Auth::user('vendor')->username }}" placeholder="Enter your username"
                                        aria-label="Enter your username" required="" aria-describedby="usernameLabel"
                                        data-msg="Please enter your username." data-error-class="u-has-error"
                                        data-success-class="u-has-success">
                                </div>
                            </div>
                            <small class="text-danger error-message" id="username"></small>
                        </div>
                        <!-- End Input -->
                        <!-- Input -->
                        <div class="col-6" style="margin-bottom: 15px">
                            <div class="js-form-message">
                                <label id="phoneNumberLabel" class="form-label">
                                    Phone number
                                    <span class="text-danger">*</span>
                                </label>
                                <div cfreachlass="form-group">
                                    <input class="form-control" type="tel" name="phone_number"
                                        value="{{ Auth::user('vendor')->phone_number }}"
                                        placeholder="Enter your phone number" aria-label="Enter your phone number"
                                        required="" aria-describedby="phoneNumberLabel"
                                        data-msg="Please enter a valid phone number" data-error-class="u-has-error"
                                        data-success-class="u-has-success">
                                </div>
                            </div>
                            <small class="text-danger error-message" id="phone_number"></small>
                        </div>
                        <!-- End Input -->
                    </div>
                    <div class="row">
                        <!-- Input -->
                        <div class="col-md-6">
                            <div class="col-12 p-0" style="margin-bottom: 15px">
                                <div class="js-form-message">
                                    <label id="locationLabel" class="form-label">
                                        State
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="form-group">
                                        <select onchange="fetchAreas(this.value)" class="form-control">
                                            @foreach ($states as $state)
                                                <option
                                                    {{ $vendor_location[0]->state->id == $state->id ? 'selected' : '' }}
                                                    value="{{ $state->id }}">{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 p-3 d-none d-md-block"
                                style="border: solid 1px #cfd1d2; border-radius: 5px; margin-bottom: 15px;">
                                <span><strong>Selected Areas</strong></span>
                                <hr class="my-2">
                                <div id="selected-areas-d">
                                    @foreach ($vendor_location as $key => $area)
                                        <span>{{ $key == 0 ? $area->name : ', ' . $area->name }}</span>
                                    @endforeach
                               </div>
                            </div>
                        </div>
                        <!-- End Input -->
                        <!-- Input -->
                        <div class="col-md-6" style="margin-bottom: 15px">
                            <div class="js-form-message">
                                <label id="locationLabel" class="form-label">
                                    Areas
                                    <span class="text-danger">*</span>
                                </label>
                                @php $v_areas = $vendor->areas->pluck('id')->toArray() @endphp
                                <div class="row m-auto"
                                    style="border: solid 1px #cfd1d2; border-radius: 5px; padding: 5px;" id="area-list">
                                    @foreach ($vendor_location[0]->state->areas as $area)
                                        <div class="form-group col-6 m-0">
                                            <label for="area-{{ $area->id }}">{{ $area->name }}</label>
                                            <input {{ in_array($area->id, $v_areas) ? 'checked' : '' }} value="{{ $area->id }}"
                                                type="checkbox" id="area-{{ $area->id }}" style="float: right" onchange="addToAreas(this)">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <small class="text-danger error-message" id="areas"></small>
                        </div>
                        <!-- End Input -->

                        <div class="col-12 d-md-none" style="margin-bottom: 15px">
                            <div class="col-12 p-3" style="border: solid 1px #cfd1d2; border-radius: 5px;">
                                <span><strong>Selected Areas</strong></span>
                                <hr class="my-2">
                               <div id="selected-areas-m">
                                    @foreach ($vendor_location as $key => $area)
                                        <span>{{ $key == 0 ? $area->name : ', ' . $area->name }}</span>
                                    @endforeach
                               </div>
                            </div>
                        </div>
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
                                        <i class="la la-instagram position-absolute m-0"></i>
                                        @if (empty($social_handles->instagram))
                                            <input placeholder="Instagram Handle" name="instagram" type="text"
                                                class="form-control">
                                        @else
                                            <input placeholder="Instagram Handle" name="instagram" type="text"
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
                                        <i class="la la-facebook position-absolute"></i>
                                        @if (empty($social_handles->facebook))
                                            <input placeholder="Facebook Page" name="facebook" type="text"
                                                class="form-control">
                                        @else
                                            <input placeholder="Facebook Page" name="facebook" type="text"
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
                                        <i class="la la-twitter position-absolute"></i>
                                        @if (empty($social_handles->twitter))
                                            <input placeholder="Twitter Handle" name="twitter" type="text"
                                                class="form-control">
                                        @else
                                            <input placeholder="Twitter Handle" name="twitter" type="text"
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
                                <textarea class="form-control" rows="4" name="address" placeholder="Your Business Address"
                                    required>{{ Auth::user('vendor')->address }}</textarea>
                            </div>
                            <small class="text-danger error-message" id="address"></small>
                        </div>
                        <!-- End Input -->
                        <!-- Input -->
                        <div class="form-group mb-4 col-md-6">
                            <label class="mb-1">About Business</label>
                            <div class="position-relative">
                                <textarea class="form-control" rows="4" name="about" placeholder="Tell us about your Business">{{ Auth::user('vendor')->about_business }}</textarea>
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
    let vAreas = JSON.parse(`{{ json_encode($v_areas) }}`);

    $(document).ready(function() {
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
        let data = new FormData(el.target);
        data.append('areas', vAreas);

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
                showAlert(false, "Oops! Something's not right. Try again");
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
                        <div class="form-group col-6 m-0">
                            <label for="area-${area.id}">${area.name}</label>
                            <input ${inArray(area.id, vAreas) ? 'checked' : ''} value="${area.id}" onchange="addToAreas(this)" type="checkbox" id="area-${area.id}" style="float: right;">
                        </div>
                    `)
                })

                $('#area-list-cont').removeClass('d-none');
                $('#proceed-btn').removeClass('d-none')
            })
            .catch(err => {
                showAlert(false, "Oops! Something's not right. Try again");
            })
    }

    // Emulate PHP's in_array
    function inArray(needle, haystack) {
        var length = haystack.length;
        for (var i = 0; i < length; i++) {
            if (haystack[i] == needle) return true;
        }
        return false;
    }

    // Add area to array
    function addToAreas(el) {
        el = $(el);
        value = parseInt(el.attr('value'));
        label = $(el.siblings()[0]).text();
        selected = $('#selected-areas-d').text().trim();
        
        if(el.prop("checked") == true) {
            vAreas.push(value)
            $('#areas').text('');

            $('#selected-areas-d').text(selected + ', ' + label);
            $('#selected-areas-m').text(selected + ', ' + label);
        }
        else {
            if(vAreas.length == 1) {
                $('#areas').text('You must select at least 1 area');
                el.prop("checked", true);

                setTimeout(() => {
                    $('#areas').text('');
                }, 3000);
            }
            else {
                index = vAreas.indexOf(value);
                if(index > -1) {
                    vAreas.splice(index, 1);
                    
                    replace = selected.replace(', '+label, '');
                    if(replace.length == selected.length) {
                        replace = selected.replace(label+', ', '');
                    }

                    $('#selected-areas-d').text(replace);
                    $('#selected-areas-m').text(replace);
                }
            }
        }
    }

</script>
