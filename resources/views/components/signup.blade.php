<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog mt-1" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Sign Up</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-sign">
          <span aria-hidden="true">&times;</span>
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
            <form class="row">

              <div class="form-group col-sm-12">
                <label class="mb-1">Business Name</label>
                <div class="position-relative icon-form-control">
                  <i class="la la-store-alt position-absolute"></i>
                  <input type="text" class="form-control" placeholder="Business Name">
                </div>
              </div>

              <div class="form-group col-sm-6">
                <label class="mb-1">Username</label>
                <div class="position-relative icon-form-control">
                  <i class="la la-at position-absolute"></i>
                  <input type="email" class="form-control" placeholder="Username">
                </div>
              </div>

              <div class="form-group col-sm-6">
                <label class="mb-1">Email</label>
                <div class="position-relative icon-form-control">
                  <i class="la la-envelope position-absolute"></i>
                  <input type="email" class="form-control" placeholder="Email Address">
                </div>
              </div>

              <div class="form-group col-sm-6">
                <label class="mb-1">Phone</label>
                <div class="position-relative icon-form-control">
                  <i class="la la-phone position-absolute"></i>
                  <input type="text" class="form-control" placeholder="Phone Number">
                </div>
              </div>

              <div class="form-group col-sm-6">
                <label class="mb-1">Password</label>
                <div class="position-relative icon-form-control">
                  <i class="la la-key position-absolute"></i>
                  <input type="password" class="form-control" placeholder="Password">
                </div>
              </div>

              <div class="form-group text-center col-sm-12">
                <button class="btn btn-primary px-5" type="submit"> Sign Up </button>
              </div>
            </form>
          </div>

          <!-- User Form -->
          <div class="tab-pane fade" id="user" role="tabpanel" aria-labelledby="user-tab">
            <form class="row">
              <div class="form-group col-sm-12">
                <label class="mb-1">Name</label>
                <div class="position-relative icon-form-control">
                  <i class="la la-user position-absolute"></i>
                  <input type="text" class="form-control" placeholder="Name">
                </div>
              </div>

              <div class="form-group col-sm-6">
                <label class="mb-1">Email</label>
                <div class="position-relative icon-form-control">
                  <i class="la la-envelope position-absolute"></i>
                  <input type="email" class="form-control" placeholder="Email Address">
                </div>
              </div>

              <div class="form-group col-sm-6">
                <label class="mb-1">Phone</label>
                <div class="position-relative icon-form-control">
                  <i class="la la-phone position-absolute"></i>
                  <input type="text" class="form-control" placeholder="Phone Number">
                </div>
              </div>

              <div class="form-group col-sm-12">
                <label class="mb-1">Password</label>
                <div class="position-relative icon-form-control">
                  <i class="la la-key position-absolute"></i>
                  <input type="password" class="form-control" placeholder="Password">
                </div>
              </div>

              <div class="form-group text-center col-sm-12">
                <button class="btn btn-primary px-5" type="submit"> Sign Up </button>
              </div>
            </form>
          </div>
        </div>

        <div class="py-3 d-flex align-item-center">
          <a href="forgot-password.html">Forgot password?</a>
          <span class="ml-auto"> Already on FudPlug? <a class="font-weight-bold" href="#"
              onclick="loginModal()">Login</a></span>
        </div>
      </div>
    </div>
  </div>
</div>

<span class="d-none" data-toggle="modal" href="#loginModal" id="login-pop"></span>

<script>
  function loginModal() {
    $('#close-sign').click()
    $('#login-pop').click()
  }
</script>