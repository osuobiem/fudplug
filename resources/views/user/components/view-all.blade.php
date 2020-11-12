<div class="modal fade" id="view-all-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog mt-1" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Vendors</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-sign">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-2">
                <div class="row">
                    <div class="col-12">
                        <div class="input-group">
                            <input type="text" class="form-control " placeholder="Search fudplug" aria-label="Search"
                                aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary hover-lift" type="button">
                                    <i class="la la-search la-lg"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 my-2">
                        <select class="form-control form-control-sm">
                            <option>Select State</option>
                        </select>
                    </div>
                    <div class="col-6 my-2">
                        <select class="form-control form-control-sm">
                            <option>Select Area</option>
                        </select>
                    </div>
                </div>
                <hr class="my-2">
                <div class="row" style="height: 455px; overflow-y: scroll;">
                    @php $i = 1; @endphp
                    @foreach($vendors as $vendor)
                    <div class="col-md-4 col-6 text-center mb-2">
                        <div class="border rounded bg-white job-item shadow">
                            <div class="d-flex job-item-header border-bottom"
                                style="height: 200px; background-position: center; background-size: cover; background-repeat: no-repeat; background-image: url('{{ Storage::url("vendor/cover/") }}{{$vendor->cover_image}}');">

                                <div class="overflow-hidden" style="width:100%; background-color: rgba(0,0,0,0.5)">
                                    <img class="img-fluid vend-img rounded-circle mt-5"
                                        src="{{ Storage::url('vendor/profile/') }}{{$vendor->profile_image}} " alt="">
                                    <h6 class="font-weight-bold text-white mb-0 text-truncate">
                                        {{$vendor->business_name}}
                                    </h6>
                                    <div class="text-truncate text-white">@<span>{{$vendor->username}}</span></div>
                                    <div class="small text-gray-500"><i
                                            class="la la-map-marker-alt text-warning text-bold"></i>
                                        {{$vendor->area}}, {{$vendor->state}}
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 job-item-footer">
                                <a class="font-weight-bold d-block" data-toggle="modal" href="#profile-edit-modal">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6 text-center">
                        <div class="border rounded bg-white job-item shadow">
                            <div class="d-flex job-item-header border-bottom"
                                style="height: 200px; background-position: center; background-size: cover; background-repeat: no-repeat; background-image: url('{{ Storage::url("vendor/cover/") }}{{$vendor->cover_image}}');">

                                <div class="overflow-hidden" style="width:100%; background-color: rgba(0,0,0,0.5)">
                                    <img class="img-fluid vend-img rounded-circle mt-5"
                                        src="{{ Storage::url('vendor/profile/') }}{{$vendor->profile_image}} " alt="">
                                    <h6 class="font-weight-bold text-white mb-0 text-truncate">
                                        {{$vendor->business_name}}
                                    </h6>
                                    <div class="text-truncate text-white">@<span>{{$vendor->username}}</span></div>
                                    <div class="small text-gray-500"><i
                                            class="la la-map-marker-alt text-warning text-bold"></i>
                                        {{$vendor->area}}, {{$vendor->state}}
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 job-item-footer">
                                <a class="font-weight-bold d-block" data-toggle="modal" href="#profile-edit-modal">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6 text-center">
                        <div class="border rounded bg-white job-item shadow">
                            <div class="d-flex job-item-header border-bottom"
                                style="height: 200px; background-position: center; background-size: cover; background-repeat: no-repeat; background-image: url('{{ Storage::url("vendor/cover/") }}{{$vendor->cover_image}}');">

                                <div class="overflow-hidden" style="width:100%; background-color: rgba(0,0,0,0.5)">
                                    <img class="img-fluid vend-img rounded-circle mt-5"
                                        src="{{ Storage::url('vendor/profile/') }}{{$vendor->profile_image}} " alt="">
                                    <h6 class="font-weight-bold text-white mb-0 text-truncate">
                                        {{$vendor->business_name}}
                                    </h6>
                                    <div class="text-truncate text-white">@<span>{{$vendor->username}}</span></div>
                                    <div class="small text-gray-500"><i
                                            class="la la-map-marker-alt text-warning text-bold"></i>
                                        {{$vendor->area}}, {{$vendor->state}}
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 job-item-footer">
                                <a class="font-weight-bold d-block" data-toggle="modal" href="#profile-edit-modal">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                    @php $i++; @endphp
                    @endforeach
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
                showAlert(false, "Oops! Something's not right. Please Reload Page")
            })
    }

</script>
