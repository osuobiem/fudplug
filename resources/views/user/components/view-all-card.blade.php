<!-- All vendors card component -->
<div class="col-md-4 col-6 text-center vend mb-2">
        <div class="border rounded bg-white job-item shadow">
            <div class="d-flex job-item-header border-bottom"
                style="height: 200px; background-position: center; background-size: cover; background-repeat: no-repeat; background-image: url('{{$vendor->cover_image}}');">

                <div class="overflow-hidden" style="width:100%; background-color: rgba(0,0,0,0.5)">
                    <img class="img-fluid vend-img rounded-circle mt-5"
                        src="{{$vendor->profile_image}}" alt="">
                    <h6 class="font-weight-bold text-white mb-0 text-truncate">
                        {{$vendor->business_name}}
                    </h6>
                    <div class="text-truncate text-white">@<span>{{$vendor->username}}</span></div>
                    <div class="small text-gray-500"><i
                            class="la la-map-marker-alt text-warning text-bold"></i>
                            {{$vendor->area}}, {{$vendor->state}}</div>
                </div>
            </div>
            <div class="p-3 job-item-footer">
                <a class="font-weight-bold d-block" href="{{url('user/vendor-profile/'.enc($vendor->vendor_id))}}">
                    View
                </a>
            </div>
        </div>
    </div>
