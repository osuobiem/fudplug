<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog mt-5" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Login</h5>
        <button type="button" class="close" id="close-login" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form>
          <div class="form-group">
            <label class="mb-1">Email or Phone</label>
            <div class="position-relative icon-form-control">
              <i class="la la-at position-absolute"></i>
              <input type="email" class="form-control" placeholder="Email or Phone Number">
            </div>
          </div>
          <div class="form-group">
            <label class="mb-1">Password</label>
            <div class="position-relative icon-form-control">
              <i class="la la-key position-absolute"></i>
              <input type="password" class="form-control" placeholder="Password">
            </div>
          </div>
          <div class="custom-control custom-checkbox mb-3">
            <input type="checkbox" class="custom-control-input" checked id="customCheck1">
            <label class="custom-control-label" for="customCheck1">Remember password</label>
          </div>
          <div class="form-group text-center">
            <button class="btn btn-primary px-5" type="submit"> Login </button>
          </div>
        </form>

        <div class="py-3 d-flex align-item-center">
          <a href="forgot-password.html">Forgot password?</a>
          <span class="ml-auto"> New to FudPlug? <a class="font-weight-bold" href="#" onclick="signModal()">Join
              now</a></span>
        </div>
      </div>
    </div>
  </div>
</div>
<span class="d-none" data-toggle="modal" href="#signupModal" id="sign-pop"></span>

<script>
  function signModal() {
    $('#close-login').click()
    $('#sign-pop').click()
  }
</script>