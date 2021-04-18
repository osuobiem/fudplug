@extends('layouts.master')

@section('content')

<style>
    #cover-holder {
        background-image: url("{{ Storage::url('vendor/cover/'.$vendor->cover_image) }}");
    }

</style>

<div class="box mb-3 shadow-sm border rounded bg-white profile-box">

    <div id="cover-holder">
        <!-- Cover image holder -->
        <img id="cover" src="{{ Storage::url('vendor/cover/'.$vendor->cover_image) }}" class="d-none">
        <!-- Cover image file input -->
        <input type="file" class="sr-only" id="cover-input" name="cover-image" accept="image/*">


        <div class="py-4 px-3 border-bottom text-center">
            <img style="width:100px;height:100px;border-radius:50%;object-fit:cover;overflow:hidden;"
                src="{{ Storage::url('vendor/profile/'.$vendor->profile_image) }}" class="mt-2 img-fluid rounded-circle"
                alt="Responsive image">
            <input type="file" class="sr-only" id="input" name="image" accept="image/*">
            <br />

            <h5 class="font-weight-bold text-white mb-n3 mt-0">{{ $vendor->business_name }}</h5>
            <p class="mb-0 text-white">@<b>{{ $vendor->username }}</b></p>
        </div>
    </div>
    <div class="text-center">
        <div class="row">
            <div class="col-6 border-right p-2">
                <h6 class="font-weight-bold text-dark mb-1">Joined</h6>
                <p class="mb-0 text-black-50 small">{{ date("d M, Y", strtotime($vendor->created_at)) }}
                </p>
            </div>
            <div class="col-6 p-2">
                <h6 class="font-weight-bold text-dark mb-1">Location</h6>
                <p class="mb-0 text-black-50 small"><i class="las la-map-marker-alt"></i>{{ $vendor_location->area }},
                    {{ $vendor_location->state }}
                </p>
            </div>
        </div>
        <div class="overflow-hidden border-top">
            <!-- <a class="font-weight-bold p-3 d-block" href="sign-in.html"> Log Out </a> -->
            <div class="text-center">
                <ul class="nav border-bottom d-flex justify-content-center osahan-line-tab" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                            aria-controls="profile" aria-selected="false">Overview</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                            aria-selected="false">Feed</a>
                    </li>
                    @if(!Auth::guard('user')->guest())
                    <li class="nav-item">
                        <a class="nav-link" id="home-tab" data-toggle="tab" href="#menu-dish" role="tab"
                            aria-controls="home" aria-selected="false">Menu</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="">
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="box shadow-sm border rounded bg-white mb-3">
                <div class="box-title border-bottom p-3">
                    <h6 class="m-0">Overview</h6>
                </div>
                <div class="box-body">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr class="border-bottom">
                                <th class="p-3">Email</th>
                                <td class="p-3">{{ $vendor->email }}</td>
                            </tr>
                            <tr class="border-bottom">
                                <th class="p-3">Phone</th>
                                <td class="p-3">{{ $vendor->phone_number }}</td>
                            </tr>
                            <tr class="border-bottom">
                                <th class="p-3">Address</th>
                                <td class="p-3">{{ $vendor->address }}</td>
                            </tr>
                            <tr class="border-bottom">
                                <th class="p-3">Media Handles</th>
                                <td class="p-3">
                                    <ul class="list-inline">
                                        @if(!empty($social_handles->instagram))
                                        <li class="list-inline-item">
                                            <a href="{{ $social_handles->instagram }}" target="_blank"
                                                rel="noopener noreferrer">
                                                <i class="la la-instagram text-warning m-0"
                                                    style="font-size:25px; font-weight: bold;"></i>
                                            </a>
                                        </li>
                                        @endif

                                        @if(!empty($social_handles->facebook))
                                        <li class="list-inline-item">
                                            <a href="{{ $social_handles->facebook }}" target="_blank"
                                                rel="noopener noreferrer">
                                                <i class="la la-facebook text-primary"
                                                    style="font-size:25px; font-weight: bold;"></i>
                                            </a>
                                        </li>
                                        @endif

                                        @if(!empty($social_handles->twitter))
                                        <li class="list-inline-item">
                                            <a href="{{ $social_handles->twitter }}" target="_blank"
                                                rel="noopener noreferrer">
                                                <i class="la la-twitter text-info"
                                                    style="font-size:25px; font-weight: bold;"></i>
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </td>
                            </tr>
                            <tr class="border-bottom">
                                <th class="p-3">About</th>
                                <td class="p-3">{{ $vendor->about_business }}</td>
                            </tr>
                            <tr>
                                <th class="">User Rating</th>
                                <td class="">
                                    <!-- Rating Stars Box -->
                                    <div @if($rating_data['user_rating']) @else id="rating-view" @endif
                                        class='rating-stars text-left float-left d-inline' title="Rate Vendor">
                                        <ul id='stars'>
                                            <li class='star' data-value='1'>
                                                <i class='lar la-star fa-fw'></i>
                                            </li>
                                            <li class='star' data-value='2'>
                                                <i class='lar la-star fa-fw'></i>
                                            </li>
                                            <li class='star' data-value='3'>
                                                <i class='lar la-star fa-fw'></i>
                                            </li>
                                            <li class='star' data-value='4'>
                                                <i class='lar la-star fa-fw'></i>
                                            </li>
                                            <li class='star' data-value='5'>
                                                <i class='lar la-star fa-fw'></i>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- Rating Stars Box -->
                                    <div class="d-inline" id="rating-holder">
                                        @if($rating_data['user_rating'])
                                        <div class="ml-3 d-inline float-left mt-1 font-weight-bold">
                                            <span>{{ $rating_data['total_rating'] }}</span>/5
                                            <sub class="d-block">You have rated this vendor.</sub>
                                        </div>
                                        @else
                                        <div class="ml-3 d-inline float-left mt-2 font-weight-bold">
                                            <span id="rating-val">{{ $rating_data['total_rating'] }}</span>/5
                                        </div>
                                        @endif
                                    </div>
                                    <!-- Rating Modal -->
                                    @include('user.components.rating')
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="box shadow-sm border rounded bg-white mb-3 p-3">
                <!-- <div class="box-title border-bottom p-3">
                    <h6 class="m-0">About</h6>
                </div>
                <div class="box-body p-3">
                    <p>{{ $vendor->about_business }}</p>
                </div> -->
                <div class="alert alert-warning">
                    Coming soon
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="menu-dish" role="tabpanel" aria-labelledby="menu-dish-tab">
            <div class="box shadow-sm border rounded bg-white mb-3 p-3">
                <div class="box-body row p-3 overflow-auto generic-scrollbar" style="height: 300px;">
                    @if(!empty($vendor_menu))
                    @foreach($vendor_menu as $menu_dish)
                    <div class="col-md-6">
                        <div class="border shadow-sm border rounded bg-white job-item-2 pl-3 pt-3 pb-1 pr-0">
                            <div class="media">
                                <div class="u-avatar mr-3">
                                    <img class="img-fluid rounded-circle"
                                        src="{{Storage::url('vendor/dish/'.$menu_dish->image)}}"
                                        alt="Image Description">
                                </div>
                                <div class="media-body">
                                    <div class="mb-3">
                                        <h6 class="font-weight-bold mb-0"><a class="text-dark"
                                                href="javascript:void(0)">{{$menu_dish->title}}</a></h6>
                                        <!-- <a class="d-inline-block small pt-1" href="javascript:void(0)">
                                            <span class="text-warning">
                                                <span class="feather-star"></span>
                                                <span class="feather-star"></span>
                                                <span class="feather-star"></span>
                                                <span class="feather-star text-gray-500"></span>
                                                <span class="feather-star text-gray-500"></span>
                                            </span>
                                            <span class="text-dark font-weight-bold ml-2">3.74</span>
                                            <span class="text-muted">(567 reviews)</span>
                                        </a> -->
                                    </div>
                                    <div class="d-flex align-items-center border-top">
                                        @if($menu_dish->type == "simple")
                                        <a class="small" onclick="loadRegOrderModal('{{$menu_dish->id}}')">Regular
                                            Order</a>
                                        @else
                                        @php
                                        $bulk_qty = json_decode($menu_dish->quantity, true)['bulk'];
                                        $regular_qty = json_decode($menu_dish->quantity, true)['regular'];
                                        @endphp
                                        @if($bulk_qty == "null")
                                        <a class="small" onclick="loadRegOrderModal('{{$menu_dish->id}}')">Regular
                                            Order</a>
                                        @elseif($regular_qty == "null")
                                        <div class="pr-3 mr-3">
                                            <a class="text-secondary small"
                                                onclick="loadBulkOrderModal('{{$menu_dish->id}}')">Bulk Order</a>
                                        </div>
                                        @else
                                        <div class="border-right pr-3 mr-3">
                                            <a class="text-secondary small"
                                                onclick="loadBulkOrderModal('{{$menu_dish->id}}')">Bulk Order</a>
                                        </div>
                                        <a class="small" onclick="loadRegOrderModal('{{$menu_dish->id}}')">Regular
                                            Order</a>
                                        @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="bg-light text-center col-md-12" style="height:inherit; padding-top: 7rem;">
                        <i class="las la-info" style="font-size:xx-large;"></i><br>
                        <small>Empty Content</small>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>
@endsection
