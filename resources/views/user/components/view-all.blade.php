<div class="modal fade" id="view-all-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog mt-1 modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Vendors</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-sign">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-2">
                <div class="row">

                    <div class="col-md-5 col-12">
                        <form id="search-form">
                            <div class="input-group">
                                <input type="text" id="search-input" class="form-control form-control-sm"
                                    placeholder="Search fudplug" aria-label="Search" aria-describedby="basic-addon2"
                                    required>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary btn-sm hover-lift" type="button"
                                        id="search-btn" title="Search">
                                        <i class="la la-search la-lg"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-2 offset-md-2 col-5 mt-md-0 mt-2">
                        <select class="form-control form-control-sm" id="state-list" onchange="getAreas(this.value)"
                            required>
                            <option>Select State</option>
                        </select>
                    </div>
                    <div class="col-md-2 col-5 mt-md-0 mt-2">
                        <select class="form-control form-control-sm" id="area-list" required>
                            <option>Select Area</option>
                        </select>
                    </div>
                    <div class="col-md-1 col-2 mt-md-0 mt-2">
                        <button class="btn btn-primary hover-lift btn-sm" title="Filter"><i
                                class="la la-filter la-lg"></i></button>
                    </div>
                </div>
                <hr class="my-2">
                <div class="row" id="results" style="height: 100px; overflow-y: scroll;">

                </div>
                <div class="row">
                    <div class="col-12 text-center ajax-loading">
                        <div class="spinner-border spinner-border-sm btn-pr" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function () {
        // Populate state list
        fetchStates();

        //track user scroll as page number, right now page number is 1
        var page = 1;

        //initial content load
        load_more(page);

        $('#results').bind('scroll', function (e) {
            var elem = $(e.currentTarget);
            if (elem[0].scrollHeight - elem.scrollTop() == elem.outerHeight()) {
                // console.log("bottom");
                page++; //page number increment
                load_more(page); //load content
            }
        });

        $("#search-form").on('submit', function (e) {
            e.preventDefault();

            let searchData = $("#search-input").val();
            let stateData = $("#state-list").val();
            let areaData = $("#area-list").val();

            //Reset page number to 1
            var page = 1;

            //Content load
            load_more(page, searchData, stateData, areaData);

            console.log(searchInput);
        });
    });

    // Function to load more data on scrolling to bottom
    function load_more(page, searchData = "", stateData = "", areaData = "") {

        url = "{{ url('/user/all-vendors') }}";
        $.ajax({
                url: url + '?page=' + page,
                type: "get",
                datatype: "html",
                beforeSend: function () {
                    $('.ajax-loading').appendTo($('#results'));
                    $('.ajax-loading').show();
                }
            })
            .done(function (data) {
                if (data.length == 0) {
                    // console.log(data.length);

                    //notify user if nothing to load
                    $('.ajax-loading').html("No more records!");
                    return;
                }
                $('.ajax-loading').hide(); //hide loading animation once data is received
                $("#results").append(data); //append data into #results element
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                alert('No response from server');
            });
    }

    // Fetch States
    function fetchStates() {
        let url = `{{ url('states') }}`;

        goGet(url)
            .then(res => {
                let html = `<option value="*">Select State</option>`;
                $('#state-list').html('');

                [...res.states].forEach(state => {
                    html += `
        <option value="${state.id}">${state.name}</option>
        `;
                    //             $('#state-list').append(`
                    // <option value="${state.id}">${state.name}</option>
                    // `)
                });

                $('#state-list').html(html);

                $('#state-list-cont').removeClass('d-none');
                $('#proceed-btn').removeClass('d-none')
            })
            .catch(err => {
                showAlert(false, "Oops! Something's not right. Please Reload Page")
            })
    }

    // Fetch Areas according to state
    function getAreas(state) {
        let url = `{{ url('areas') }}/${state}`;

        goGet(url)
            .then(res => {
                let html = `<option value="*">All Areas</option>`;

                $('#area').html('');

                [...res.areas].forEach(area => {
                    html += `
        <option value="${area.id}">${area.name}</option>
        `;
                    //             $('#area-list').append(`
                    // <option value="${area.id}">${area.name}</option>
                    // `)
                });



                $('#area-list').html(html);

                $('#area-list-cont').removeClass('d-none');
                $('#proceed-btn').removeClass('d-none')
            })
            .catch(err => {
                showAlert(false, "Oops! Something's not right. Please Reload Page")
            })
    }

</script>
