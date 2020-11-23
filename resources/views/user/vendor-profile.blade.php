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

        <!-- <a href="#profile-edit-modal" data-toggle="modal" target="_blank" title="edit profile"
            rel="noopener noreferrer">
            <i class="la la-ellipsis-v la-2x icon-hover text-white" style="margin-left: 90%;"></i>
        </a> -->

        <!-- <div class="profile-dropdown">
            <a class="" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="la la-ellipsis-v la-2x icon-hover text-white"></i>
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenu2" style="">
                <button class="dropdown-item" data-target="#profile-edit-modal" data-toggle="modal" type="button">Edit
                    Profile</button>
                <label class="dropdown-item" for="input">Change Profile Image</label>
                <label class="dropdown-item" for="cover-input">Change Cover Photo</label>
            </div>
        </div> -->

        <div class="py-4 px-3 border-bottom text-center">
            <img id="avatar" src="{{ Storage::url('vendor/profile/'.$vendor->profile_image) }}"
                class="mt-2 img-fluid rounded-circle col-md-3" alt="Responsive image">
            <input type="file" class="sr-only" id="input" name="image" accept="image/*">
            <br />

            <h5 class="font-weight-bold text-white mb-1 mt-4">{{ $vendor->business_name }}</h5>
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
                    {{ $vendor_location->state }}</p>
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
                    <li class="nav-item d-lg-none">
                        <a class="nav-link" id="home-tab" data-toggle="tab" href="#order" role="tab"
                            aria-controls="home" aria-selected="false">Orders</a>
                    </li>
                    <li class="nav-item d-lg-none">
                        <a class="nav-link" id="home-tab" data-toggle="tab" href="#menu-dish" role="tab"
                            aria-controls="home" aria-selected="false">Menu/Dishes</a>
                    </li>
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


        <div class="tab-pane fade d-lg-none" id="order" role="tabpanel" aria-labelledby="order-tab">

            <div class="box shadow-sm border rounded bg-white mb-3">
                <div class="box-title border-bottom p-3">
                    <h6 class="m-0">Orders</h6>
                </div>
                <div class="box-body p-3 h-100 overflow-auto">
                    <div class="d-flex align-items-center osahan-post-header mb-3 people-list">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="{{ url('assets/img/p4.png') }}" alt="">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div class="font-weight-bold mr-2">
                            <div class="text-truncate">Sophia Lee</div>
                            <div class="small text-gray-500">@Harvard
                            </div>
                        </div>
                        <span class="ml-auto"><button type="button" class="btn btn-outline-danger btn-sm">View</button>
                        </span>
                    </div>
                    <div class="d-flex align-items-center osahan-post-header mb-3 people-list">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="{{ url('assets/img/p9.png') }}" alt="">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div class="font-weight-bold mr-2">
                            <div class="text-truncate">John Doe</div>
                            <div class="small text-gray-500">Traveler
                            </div>
                        </div>
                        <span class="ml-auto"><button type="button" class="btn btn-outline-danger btn-sm">View</button>
                        </span>
                    </div>
                    <div class="d-flex align-items-center osahan-post-header mb-3 people-list">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="{{ url('assets/img/p10.png') }}" alt="">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div class="font-weight-bold mr-2">
                            <div class="text-truncate">Julia Cox</div>
                            <div class="small text-gray-500">Art Designer
                            </div>
                        </div>
                        <span class="ml-auto"><button type="button" class="btn btn-outline-danger btn-sm">View</button>
                        </span>
                    </div>
                    <div class="d-flex align-items-center osahan-post-header mb-3 people-list">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="{{ url('assets/img/p11.png') }}" alt="">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div class="font-weight-bold mr-2">
                            <div class="text-truncate">Robert Cook</div>
                            <div class="small text-gray-500">@Photography
                            </div>
                        </div>
                        <span class="ml-auto"><button type="button" class="btn btn-outline-danger btn-sm">View</button>
                        </span>
                    </div>
                    <div class="d-flex align-items-center osahan-post-header people-list">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="{{ url('assets/img/p12.png') }}" alt="">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div class="font-weight-bold mr-2">
                            <div class="text-truncate">Richard Bell</div>
                            <div class="small text-gray-500">@Envato
                            </div>
                        </div>
                        <span class="ml-auto"><button type="button" class="btn btn-outline-danger btn-sm">View</button>
                        </span>
                    </div>
                </div>
                <div class="box-footer p-2 border-top">
                    <button type="button" class="btn btn-primary btn-block"> View all </button>
                </div>
            </div>

        </div>

        <div class="tab-pane fade d-lg-none right-side-small" id="menu-dish" role="tabpanel"
            aria-labelledby="menu-dish-tab">

        </div>
    </div>

</div>
@endsection
