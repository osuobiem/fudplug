<style>
  #init-crisp {
    background: url("{{ url('assets/img/jol1.jpg') }}");
    height: 300px;
    background-position: center;
    background-size: cover;
    box-shadow: 0 0 20px 0px #000c;
  }
</style>

<div class="modal fade" id="boardModal" tabindex="-1" role="dialog" data-backdrop="static"
  aria-labelledby="staticBackdropLabel" aria-hidden="true" aria-hidden="true">

  <div class="modal-dialog mt-5" role="document">
    <div class="modal-content">
      <div id="init-mod" class="animate__animated animate__fadeIn">
        <div class="modal-header" id="init-crisp">
          <div></div>
        </div>
        <div class="modal-body">
          <span>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer
            took
            a galley of type and scrambled it to make a type specimen book.</span>
          <div class="text-right mt-3">
            <button class="btn btn-primary px-5" id="init-btn">Let's Go <i class="la la-angle-right"></i>
            </button>
          </div>
        </div>
      </div>

      <div class="modal-content">
        <div id="board-mod" class="animate__animated animate__flipInX">
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

              <div class="form-group text-center col-sm-12 d-none animate__animated animate__fadeInDown"
                id="proceed-btn">
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

  </div>
  <span class="d-none" data-toggle="modal" href="#signupModal" id="sign-pop"></span>

  <script>
    $(document).ready(function () {
      seenInit = localStorage.getItem('seenInit')

      if (seenInit) {
        $('#init-mod').addClass('d-none')
      }
      else {
        $('#board-mod').addClass('d-none')
        localStorage.setItem('seenInit', true)
      }

      // Attach board form event listener
      $('#board-form').submit(el => {
        submitLoc(el)
      })

      $('#init-btn').click(() => {
        $('#init-mod').addClass('d-none');
        $('#board-mod').removeClass('d-none');
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
          showAlert(false, "Oops! Something's not right. Please Reload Page")
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
          loadFeed();
        })
        .catch(err => {
          spin('board')
          showAlert(false, "Oops! Something's not right. Please Reload Page")
        })
    }
  </script>