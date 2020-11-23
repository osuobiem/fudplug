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
                                    <button type="submit" class="btn btn-primary btn-sm hover-lift" id="search-btn"
                                        title="Search">
                                        <i class="la la-search la-lg"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col">
                        <form id="filter-form">
                            <div class="row">
                                <div class="col-md-4 col-4 mt-md-0 mt-2 offset-md-2">
                                    <select class="form-control form-control-sm" id="state-list"
                                        onchange="getAreas(this.value)" required>
                                        <option value="*">Select State</option>
                                    </select>
                                </div>
                                <div class="col-md-4 col-4 mt-md-0 mt-2">
                                    <select class="form-control form-control-sm" id="area" required>
                                        <option value="*">Select Area</option>
                                    </select>
                                </div>
                                <div class="col-md-2 col-4 mt-md-0 mt-2">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="submit" class="btn btn-secondary hover-lift btn-sm"
                                            title="Filter"><i class="la la-filter la-lg"></i></button>
                                        <button type="button" id="reset-btn" class="btn btn-secondary hover-lift btn-sm"
                                            title="Clear Search & Filters"><i class="las la-sync-alt"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <hr class="my-2">
                <div class="row" id="results" style="height: 420px; overflow-y: scroll;">

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


@push('scripts')
<script>
    // Initialize state and area filters
    initFilter("{{Auth::guard('user')->user()->area_id}}");

    $(document).ready(function () {

        // Wait for filter values to load completely
        setTimeout(function () {
            /*********************************** INIT *****************************************/
            //track user scroll as page number, right now page number is 1
            var page = 1;

            // Filter/Search Variables (Holds their state)
            var searchData = "";
            var stateData = $("#state-list").val();
            var areaData = $("#area").val();
            var fetchStatus = "all";

            //initial content load
            load_more(page, searchData, stateData, areaData, fetchStatus, true);

            /*********************************** INIT *****************************************/

            $("#reset-btn").on('click', function (e) {
                // Initialize state and area filters
                initFilter("{{Auth::guard('user')->user()->area_id}}");

                // Wait for filter values to load completely
                setTimeout(function () {
                    //track user scroll as page number, right now page number is 1
                    var page = 1;

                    // Reset search form
                    document.getElementById("search-form").reset();

                    // Filter/Search Variables (Holds their state)
                    searchData = "";
                    stateData = $("#state-list").val();
                    areaData = $("#area").val();
                    fetchStatus = "all";

                    //initial content load
                    load_more(page, searchData, stateData, areaData, fetchStatus, true);
                }, 500);

            });

            $("#search-form").on('submit', function (e) {
                e.preventDefault();

                searchData = $("#search-input").val();
                // stateData = $("#state-list").val();
                // areaData = $("#area").val();
                fetchStatus = "search";

                //Reset page number to 1
                page = 1;

                //Content load
                load_more(page, searchData, stateData, areaData, fetchStatus, true);

            });

            $("#filter-form").on('submit', function (e) {
                e.preventDefault();

                // searchData = $("#search-input").val();
                stateData = $("#state-list").val();
                areaData = $("#area").val();
                fetchStatus = "filter";

                //Reset page number to 1
                page = 1;

                //Content load
                load_more(page, searchData, stateData, areaData, fetchStatus, true);

            });

            $('#results').bind('scroll', function (e) {
                var elem = $(e.currentTarget);
                if (elem[0].scrollHeight - elem.scrollTop() == elem.outerHeight()) {
                    // console.log("bottom");
                    page++; //page number increment
                    //console.log(searchData, stateData, areaData, fetchStatus);
                    load_more(page, searchData, stateData, areaData,
                        fetchStatus); //load content
                }
            });
        }, 1500);

    });


    // Function to load more data on scrolling to bottom
    function load_more(page, searchData = "", stateData = "", areaData = "", fetchStatus = "all", refresh = false) {
        url = "{{ url('/user/all-vendors') }}";
        url += fixUrl(page, searchData, stateData, areaData, fetchStatus);
        $.ajax({
                url: url,
                type: "get",
                datatype: "html",
                beforeSend: function () {
                    // let ajaxLoading = $('.ajax-loading').html();
                    // $('#results').append(ajaxLoading);
                    $('.ajax-loading').show();
                }
            })
            .done(function (data) {
                if (data.length == 0) {
                    // console.log(data.length);

                    //notify user if nothing to load
                    if (refresh) {
                        $(".vend").remove();
                        $('.ajax-loading').html("No records!");
                    } else {
                        $('.ajax-loading').html("No more records!");
                    }
                    return;
                }
                $('.ajax-loading').hide(); //hide loading animation once data is received

                // Check if action requires refreshing the contents
                if (refresh) {
                    // console.log(data);
                    // $("#results").empty();
                    // $('.ajax-loading').appendTo($('#results'));
                    // //load data into #results element
                    $(".vend").remove();
                    $(".ajax-loading").before(data);
                } else {
                    // console.log(data);
                    // $("#results").append(data); //append data into #results element
                    $(".ajax-loading").before(data);
                }

            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                alert('No response from server');
            });
    }

    // Function to fix fetch url
    function fixUrl(page, searchData = "", stateData = "", areaData = "", fetchStatus = "all") {
        fixed_url =
            `?page=${page}&search_data=${searchData}&state_data=${stateData}&area_data=${areaData}&fetch_status=${fetchStatus}`;
        return fixed_url;
    }

    // Fetch States
    function getStates(state_id = "") {
        let url = `{{ url('states') }}`;

        goGet(url)
            .then(res => {
                let html = `<option value="*">All States</option>`;
                $('#state-list').html('');

                if (state_id == "") {
                    [...res.states].forEach(state => {
                        html += `
        <option value="${state.id}">${state.name}</option>
        `;
                    });
                } else {
                    [...res.states].forEach(state => {
                        if (state.id == state_id) {
                            html += `
        <option value="${state.id}" selected>${state.name}</option>
        `;
                        } else {
                            html += `
        <option value="${state.id}">${state.name}</option>
        `;
                        }
                    });
                }
                //             $('#state-list').append(`
                // <option value="${state.id}">${state.name}</option>
                // `)


                $('#state-list').html(html);

                $('#state-list-cont').removeClass('d-none');
                $('#proceed-btn').removeClass('d-none')
            })
            .catch(err => {
                showAlert(false, "Oops! Something's not right. Please Reload Page")
            })
    }

    // Fetch Areas according to state
    function getAreas(state, area_id = "") {
        let url = `{{ url('areas') }}/${state}`;

        goGet(url)
            .then(res => {
                let html = "";
                if (res.areas.length == 0) {
                    html = `<option value="*">Select Area</option>`;
                } else {
                    html = `<option value="*">All Areas</option>`;
                }

                $('#area').html('');

                if (area_id == "") {
                    [...res.areas].forEach(area => {
                        html += `
        <option value="${area.id}">${area.name}</option>
        `;
                    });
                } else {
                    [...res.areas].forEach(area => {
                        if (area.id == area_id) {
                            html += `
        <option value="${area.id}" selected>${area.name}</option>
        `;
                        } else {
                            html += `
        <option value="${area.id}">${area.name}</option>
        `;
                        }
                    });
                }



                $('#area').html(html);

                $('#area-cont').removeClass('d-none');
                $('#proceed-btn').removeClass('d-none')
            })
            .catch(err => {
                showAlert(false, "Oops! Something's not right. Please Reload Page")
            })
    }

    // Fetch States
    function initFilter($area_id) {
        let url = `{{ url('states') }}`;
        url += `/${$area_id}`;

        goGet(url)
            .then(res => {
                // Populate state list on page load
                getStates(res.user_state.state_id);

                // Populate area list on page load
                getAreas(res.user_state.state_id, $area_id);
            })
            .catch(err => {
                showAlert(false, "Oops! Something's not right. Please Reload Page")
            })
    }

</script>
@endpush
