<div class="box shadow-sm border rounded bg-white mb-3">
    <div class="box-title border-bottom p-3">
        <h6 class="m-0">Today's Vendors</h6>
    </div>
    <div class="box-body p-3 h-100 overflow-auto">
        <div id="featured-properties" class="carousel slide" data-ride="carousel">
            <!-- <ol class="carousel-indicators">
                <li data-target="#featured-properties" data-slide-to="0" class="text-dark">
                    < </li> <li data-target="#featured-properties" data-slide-to="1" class="active text-dark"> >
                </li>
            </ol> -->
            <div class="carousel-inner">
                @php $i = 1; @endphp
                @foreach($vendors as $vendor)
                @if($i == 1)
                <div class="carousel-item active">
                    @else
                    <div class="carousel-item">
                        @endif
                        <div class="border rounded bg-white job-item">
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
                                <a class="font-weight-bold d-block" data-toggle="modal" href="#profile-edit-modal"> View
                                </a>
                            </div>
                        </div>
                    </div>
                    @php $i++; @endphp
                    @endforeach

                    <!-- <div class="carousel-item">
                        <div class="border rounded bg-white job-item">
                            <div class="d-flex align-items-center p-3 job-item-header">
                                <div class="overflow-hidden mr-2">
                                    <h6 class="font-weight-bold text-dark mb-0 text-truncate">Product Director</h6>
                                    <div class="text-truncate text-primary">Spotify Inc.</div>
                                    <div class="small text-gray-500"><i class="feather-map-pin"></i> India, Punjab</div>
                                </div>
                                <img class="img-fluid ml-auto" src="img/l3.png" alt="">
                            </div>
                            <div class="d-flex align-items-center p-3 border-top border-bottom job-item-body">
                                <div class="overlap-rounded-circle">
                                    <img class="rounded-circle shadow-sm" data-toggle="tooltip" data-placement="top"
                                        title="" src="img/p9.png" alt="" data-original-title="Sophia Lee">
                                    <img class="rounded-circle shadow-sm" data-toggle="tooltip" data-placement="top"
                                        title="" src="img/p10.png" alt="" data-original-title="John Doe">
                                    <img class="rounded-circle shadow-sm" data-toggle="tooltip" data-placement="top"
                                        title="" src="img/p11.png" alt="" data-original-title="Julia Cox">
                                    <img class="rounded-circle shadow-sm" data-toggle="tooltip" data-placement="top"
                                        title="" src="img/p12.png" alt="" data-original-title="Robert Cook">
                                </div>
                                <span class="font-weight-bold text-muted">18 connections</span>
                            </div>
                            <div class="p-3 job-item-footer">
                                <small class="text-gray-500"><i class="feather-clock"></i> Posted 3 Days ago</small>
                            </div>
                        </div>
                    </div> -->
                </div>
                <a class="carousel-control-prev" href="#featured-properties" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#featured-properties" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="box-footer p-2 border-top">
            <button type="button" class="btn btn-primary btn-block"> View all </button>
        </div>
    </div>
