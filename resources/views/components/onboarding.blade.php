<div class="modal fade" id="boardModal" tabindex="-1" role="dialog" data-backdrop="static"
  aria-labelledby="staticBackdropLabel" aria-hidden="true" aria-hidden="true">
  <div class="modal-dialog modal-sm mt-5" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tell us your location</h5>
        <button type="button" class="close d-none" data-dismiss="modal" aria-label="Close" id="close-board">
        </button>
      </div>
      <div class="modal-body">

        <!-- Form Error -->
        <div class="alert alert-danger d-none text-center animate__animated animate__headShake" id="login-error"
          role="alert">
        </div>

        <form id="board-form" method="POST">

          <div class="form-group">
            <label class="mb-1"><i class="la la-map"></i> State</label>
            <select class="form-control" id="state-list" onchange="fetchAreas(this.value)">
              <option selected disabled>Please select state</option>
              @foreach ($states as $state)
              <option value="{{ $state->id }}">{{ $state->name }}</option>
              @endforeach
            </select>
            <small class="text-danger error-message" id="l-login"></small>
          </div>

          <div class="form-group animate__animated animate__fadeInDown d-none" id="area-list-cont">
            <label class="mb-1"><i class="la la-map-marker"></i> Area</label>
            <select class="form-control" id="area-list">
            </select>
            <small class="text-danger error-message" id="l-login"></small>
          </div>

          <div class="form-group text-center col-sm-12 d-none animate__animated animate__fadeInDown" id="proceed-btn">
            <button class="btn btn-primary px-5" type="submit">
              <span id="board-txt">Proceed <i class="la la-angle-right"></i></span>
              <div class="spinner-border spinner-border-sm btn-pr" id="board-spinner" style="display: none;"
                role="status">
                <span class="sr-only">Loading...</span>
              </div>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<span class="d-none" data-toggle="modal" href="#signupModal" id="sign-pop"></span>

<script>
  $(document).ready(function () {
    // Attach board form event listener
    $('#board-form').submit(el => {
      submitLoc(el)
    })
  });

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
        showAlert(false, "Oops! Something's not right. Try Again")
      })
  }

  // Submit Location
  function submitLoc(el) {
    el.preventDefault()

    spin('board')
    offError('u-sign-error')

    area = $('#area-list').val()

    let url = `{{ url('location') }}/${area}`;

    goGet(url)
      .then(res => {
        spin('board')
        $('#close-board').click()
      })
      .catch(err => {
        spin('board')
        showAlert(false, "Oops! Something's not right. Try Again")
      })
  }
</script>