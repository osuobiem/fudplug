<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog mt-1" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-light" id="exampleModalLabel">Sign Up</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-sign">
          <span aria-hidden="true" class="text-light">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <ul class="nav nav-justified border-bottom osahan-line-tab" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" style="padding-top: 0 !important;" id="vendor-tab" data-toggle="tab"
              href="#vendor" role="tab" aria-controls="vendor" aria-selected="true"><i
                class="la la-utensils la-lg"></i>&nbsp;Vendor</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" style="padding-top: 0 !important;" id="profile-tab" data-toggle="tab" href="#user"
              role="tab" aria-controls="user" aria-selected="false"><i class="la la-user la-lg"></i>&nbsp;User</a>
          </li>
        </ul>

        <div class="tab-content mt-3" id="myTabContent">
          <!-- Vendor Form -->
          <div class="tab-pane fade show active" id="vendor" role="tabpanel" aria-labelledby="vendor-tab">
            <!-- Form Error -->
            <div class="alert alert-danger d-none text-center animate__animated animate__headShake" id="v-sign-error"
              role="alert">
            </div>
            <form class="row" id="vendor-signup" method="POST">
              @csrf
              <div class="form-group col-sm-12">
                <label class="mb-1">Business Name <small class="text-danger">*</small></label>
                <div class="position-relative icon-form-control">
                  <i class="la la-store-alt position-absolute"></i>
                  <input type="text" class="form-control" placeholder="Business Name" name="business_name" required>
                </div>
                <small class="text-danger error-message" id="business_name"></small>
              </div>

              <div class="form-group col-sm-6">
                <label class="mb-1">Username</label>
                <div class="position-relative icon-form-control">
                  <i class="la la-at position-absolute"></i>
                  <input type="text" class="form-control" placeholder="Username" name="username">
                </div>
                <small class="text-danger error-message" id="username"></small>
              </div>

              <div class="form-group col-sm-6">
                <label class="mb-1">Email <small class="text-danger">*</small></label>
                <div class="position-relative icon-form-control">
                  <i class="la la-envelope position-absolute"></i>
                  <input type="email" class="form-control" placeholder="Email Address" name="email" required>
                </div>
                <small class="text-danger error-message" id="email"></small>
              </div>

              <div class="form-group col-sm-6">
                <label class="mb-1">Phone <small class="text-danger">*</small></label>
                <div class="position-relative icon-form-control">
                  <i class="la la-phone position-absolute"></i>
                  <input type="text" class="form-control" placeholder="Phone Number" name="phone" required>
                </div>
                <small class="text-danger error-message" id="phone"></small>
              </div>

              <div class="form-group col-sm-6">
                <label class="mb-1">Password <small class="text-danger">*</small></label>
                <div class="position-relative icon-form-control">
                  <i class="la la-key position-absolute"></i>
                  <input type="password" class="form-control" placeholder="Password" id="v-pass" required name="password">
                  <i class="la la-eye position-absolute" title="Show Password" onclick="showPassword(this, 'v-pass', true)" style="right: 0"></i>
                </div>
                <small class="text-danger error-message" id="password"></small>
              </div>

              <div class="form-group text-center col-sm-12">
                <button class="btn btn-primary px-5" type="submit" id="vendor-btn">
                  <span id="vendor-txt">Sign Up</span>
                  <div class="spinner-border spinner-border-sm btn-pr" id="vendor-spinner" style="display: none;"
                    role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                </button>
              </div>
            </form>
          </div>

          <!-- User Form -->
          <div class="tab-pane fade" id="user" role="tabpanel" aria-labelledby="user-tab">
            <!-- Form Error -->
            <div class="alert alert-danger d-none text-center animate__animated animate__headShake" id="u-sign-error"
              role="alert">
            </div>
            <form class="row" id="user-signup" method="POST">
              @csrf
              <div class="form-group col-sm-12">
                <label class="mb-1">Name <small class="text-danger">*</small></label>
                <div class="position-relative icon-form-control">
                  <i class="la la-user position-absolute"></i>
                  <input type="text" class="form-control" placeholder="Name" required name="name">
                </div>
                <small class="text-danger error-message" id="u-name"></small>
              </div>

              <div class="form-group col-sm-6">
                <label class="mb-1">Email <small class="text-danger">*</small></label>
                <div class="position-relative icon-form-control">
                  <i class="la la-envelope position-absolute"></i>
                  <input type="email" class="form-control" placeholder="Email Address" name="email" required>
                </div>
                <small class="text-danger error-message" id="u-email"></small>
              </div>

              <div class="form-group col-sm-6">
                <label class="mb-1">Phone <small class="text-danger">*</small></label>
                <div class="position-relative icon-form-control">
                  <i class="la la-phone position-absolute"></i>
                  <input type="text" class="form-control" placeholder="Phone Number" name="phone" required>
                </div>
                <small class="text-danger error-message" id="u-phone"></small>
              </div>

              <div class="form-group col-sm-12">
                <label class="mb-1">Password <small class="text-danger">*</small></label>
                <div class="position-relative icon-form-control">
                  <i class="la la-key position-absolute"></i>
                  <input type="password" class="form-control" placeholder="Password" id="u-pass" name="password" required>
                  <i class="la la-eye position-absolute" title="Show Password" onclick="showPassword(this, 'u-pass', true)" style="right: 0"></i>
                </div>
                <small class="text-danger error-message" id="u-password"></small>
              </div>

              <div class="form-group text-center col-sm-12">
                <button class="btn btn-primary px-5" type="submit">
                  <span id="user-txt">Sign Up</span>
                  <div class="spinner-border spinner-border-sm btn-pr" id="user-spinner" style="display: none;"
                    role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                </button>
              </div>
            </form>
          </div>
        </div>

        <div class="py-3 d-flex align-item-center">
        <a onclick="forgotPasswordModal()" href="javascript:void(0)">Forgot password?</a>
          <span class="ml-auto"> Already on FudPlug? <a class="font-weight-bold" href="#"
              onclick="loginModal()">Login</a></span>
        </div>
      </div>
    </div>
  </div>
</div>

<span class="d-none" data-toggle="modal" href="#loginModal" id="login-pop"></span>

@push('scripts')
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

        handleFormRes(res, 'v-sign-error') ? location.replace("{{route('verify-email')}}") : null
      })
      .catch(err => {
        spin('vendor')
        handleFormRes(err, 'v-sign-error');
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

        handleFormRes(res, 'u-sign-error', 'u') ? location.replace("{{route('verify-email')}}") : null
      })
      .catch(err => {
        spin('user')
        handleFormRes(err, 'u-sign-error');
      })
  }

  function loginModal() {
    $("#forgot-password-modal").modal('hide');
    $('#close-sign').click()
    $('#login-pop').click()
  }
</script>
@endpush
