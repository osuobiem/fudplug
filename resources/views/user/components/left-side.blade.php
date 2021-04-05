<div class="box shadow-sm border rounded bg-white mb-3">
    <div class="box-title border-bottom pt-2 pl-2 pr-2 pb-0">
        <div class="text-left mb-n3">
            <h6 class="m-0"> <strong>Vendors In
                    Your Area</strong></h6>
        </div>

        <div class="text-right" style="margin-top: -24px;
        margin-bottom: -12px;">
            <h6>
                <i class="la la-map-marker-alt text-warning text-bold" style="font-size:25px;"></i>
            </h6>
        </div>
    </div>
    <div class="box-body p-3 h-100 overflow-auto text-center">
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
                <div class="carousel-item active shadow-lg">
                    @else
                    <div class="carousel-item shadow-lg">
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
                                <a class="font-weight-bold d-block" href="{{ url($vendor->username) }}">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                    @php $i++;
                    @endphp
                    @endforeach
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
            <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#view-all-modal">
                View all </button>
        </div>
    </div>
