<div class="modal fade" id="forgot-password-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog mt-5" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Password Recovery</h5>
        <button type="button" class="close" id="close-login" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <!-- Form Error -->
        <div class="alert alert-danger d-none text-center animate__animated animate__headShake" id="forgot-password-error"
          role="alert">
        </div>

        <form id="forgot-password-form" method="POST">
          @csrf
          <div class="form-group">
            <label class="mb-1"> Email <small class="text-danger">*</small></label>
            <div class="position-relative icon-form-control">
              <!-- <i class="la la-at position-absolute"></i> -->
              <input type="email" class="form-control" placeholder="Enter Email Address" required
                name="email">
            </div>
            <small class="text-danger error-message" id="l-login"></small>
          </div>

          <div class="form-group text-center col-sm-12">
            <button class="btn btn-primary px-5" type="submit" id="forgot-password-btn">
              <span id="forgot-password-txt">Send Password Reset Link</span>
              <div class="spinner-border spinner-border-sm btn-pr" id="forgot-password-spinner" style="display: none;"
                role="status">
                <span class="sr-only">Loading...</span>
              </div>
            </button>
          </div>
        </form>

        <div class="py-3 d-flex align-item-center">
          <!-- <a href="forgot-password.html">Forgot password?</a> -->
          <span class=""> Already on FudPlug? <a class="font-weight-bold" href="#"
              onclick="loginModal()">Login</a></span>
          <span class="ml-auto"> New to FudPlug? <a class="font-weight-bold" href="#" onclick="signModal()">Join
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
    $('#forgot-password-form').submit(el => {
      sendMail(el)
    })
  });

  // Process Login
  function sendMail(el) {
    el.preventDefault()

    spin('forgot-password')
    offError('forgot-password-error')

    let url = `{{ url('forgot-password-email') }}`;
    let data = new FormData(el.target)

    goPost(url, data)
      .then((res) => {
        spin('forgot-password')

        if(handleFormRes(res, 'forgot-password-error', 'l')){
            showAlert(true, res.message);
        }

        // Reset form
        el.target.reset();
      })
      .catch(err => {
        spin('forgot-password')
        handleFormRes(err, 'forgot-password-error');
      })
  }
</script>
@endpush
