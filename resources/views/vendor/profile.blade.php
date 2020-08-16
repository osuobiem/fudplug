@extends('layouts.master')

@section('content')
<div class="row">
    <!-- Main Content -->
    <aside class="col col-xl-3 order-xl-1 col-lg-12 order-lg-1 col-12">
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
    </aside>
    <main class="col col-xl-6 order-xl-2 col-lg-12 order-lg-2 col-md-12 col-sm-12 col-12">
        <div class="box mb-3 shadow-sm border rounded bg-white profile-box text-center">
            <div class="cover">
                <a href="#profile-edit-modal" data-toggle="modal" target="_blank" title="edit profile"
                    rel="noopener noreferrer">
                    <i class="la la-pen la-2x icon-hover text-white" style="margin-left: 90%;"></i>
                </a>
                <div class="py-4 px-3 border-bottom">
                    <img src="{{ Storage::url('vendor/'.Auth::user()->profile_image) }}"
                        class="img-fluid mt-2 rounded-circle col-md-3" alt="Responsive image">
                    <h5 class="font-weight-bold text-dark mb-1 mt-4">{{ Auth::user()->business_name }}</h5>
                    <p class="mb-0 text-dark"><b>{{ Auth::user()->username }}</b></p>
                </div>
            </div>
            <div class="">
                <div class="row">
                    <div class="col-6 border-right p-4">
                        <h6 class="font-weight-bold text-dark mb-1">Joined</h6>
                        <p class="mb-0 text-black-50 small">{{ date("d M, Y", strtotime(Auth::user()->created_at)) }}
                        </p>
                    </div>
                    <div class="col-6 p-3">
                        <h6 class="font-weight-bold text-dark mb-1">Location</h6>
                        <p class="mb-0 text-black-50 small"><i class="las la-map-marker-alt"></i>Calabar</p>
                    </div>
                </div>
                <div class="overflow-hidden border-top">
                    <!-- <a class="font-weight-bold p-3 d-block" href="sign-in.html"> Log Out </a> -->
                    <div class="text-center">
                        <ul class="nav border-bottom d-flex justify-content-center osahan-line-tab" id="myTab"
                            role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                    aria-controls="profile" aria-selected="false">Overview</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                    aria-controls="home" aria-selected="false">About</a>
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
                                        <td class="p-3">{{ Auth::user()->email }}</td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <th class="p-3">Phone</th>
                                        <td class="p-3">{{ Auth::user()->phone_number }}</td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <th class="p-3">Address</th>
                                        <td class="p-3">{{ Auth::user()->address }}</td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <th class="p-3">Media Handles</th>
                                        <td class="p-3">...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="box shadow-sm border rounded bg-white mb-3">
                        <div class="box-title border-bottom p-3">
                            <h6 class="m-0">About</h6>
                        </div>
                        <div class="box-body p-3">
                            <p>{{ Auth::user()->about_business }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
    <aside class="col col-xl-3 order-xl-3 col-lg-12 order-lg-3 col-12">
        <div class="box shadow-sm border rounded bg-white mb-3">
            <div class="box-title border-bottom p-3">
                <h6 class="m-0">Menu</h6>
            </div>
            <div class="box-body p-3 h-100 overflow-auto">
                <div class="d-flex align-items-center osahan-post-header mb-3 people-list">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="{{Storage::url('vendor/fud1.jpeg')}}" alt="">

                    </div>
                    <div class="font-weight-bold mr-2">
                        <div class="text-truncate"><a href="http://">
                                Eba & Soup
                            </a></div>
                        <div class="small text-gray-500"><b>Qty:</b> 10
                        </div>
                    </div>
                    <span title="add to today's menu" class="ml-auto">
                        <div class="custom-control custom-switch pull-left">
                            <input type="checkbox" class="custom-control-input" id="customSwitch1">
                            <label class="custom-control-label" for="customSwitch1"></label>
                        </div>
                    </span>
                </div>
                <div class="d-flex align-items-center osahan-post-header mb-3 people-list">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="{{Storage::url('vendor/fud2.jpeg')}}" alt="">

                    </div>
                    <div class="font-weight-bold mr-2">
                        <div class="text-truncate"><a href="http://">
                                Fried Rice
                            </a></div>
                        <div class="small text-gray-500"><b>Qty:</b> 10
                        </div>
                    </div>
                    <span class="ml-auto">
                        <div class="custom-control custom-switch pull-left">
                            <input type="checkbox" class="custom-control-input" id="customSwitch2">
                            <label class="custom-control-label" for="customSwitch2"></label>
                        </div>
                    </span>
                </div>
                <div class="d-flex align-items-center osahan-post-header mb-3 people-list">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="{{Storage::url('vendor/fud3.jpeg')}}" alt="">

                    </div>
                    <div class="font-weight-bold mr-2">
                        <div class="text-truncate"><a href="http://">
                                Banga Soup
                            </a></div>
                        <div class="small text-gray-500"><b>Qty:</b> 10
                        </div>
                    </div>
                    <span class="ml-auto">
                        <div class="custom-control custom-switch pull-left">
                            <input type="checkbox" class="custom-control-input" id="customSwitch3">
                            <label class="custom-control-label" for="customSwitch3"></label>
                        </div>
                    </span>
                </div>
                <div class="d-flex align-items-center osahan-post-header mb-3 people-list">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="{{Storage::url('vendor/fud4.jpeg')}}" alt="">

                    </div>
                    <div class="font-weight-bold mr-2">
                        <div class="text-truncate"><a href="http://">
                                Jollof Rice
                            </a></div>
                        <div class="small text-gray-500"><b>Qty:</b> 10
                        </div>
                    </div>
                    <span class="ml-auto">
                        <div class="custom-control custom-switch pull-left">
                            <input type="checkbox" class="custom-control-input" id="customSwitch4">
                            <label class="custom-control-label" for="customSwitch4"></label>
                        </div>
                    </span>
                </div>
                <div class="d-flex align-items-center osahan-post-header people-list">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="{{Storage::url('vendor/fud5.jpeg')}}" alt="">
                    </div>
                    <div class="font-weight-bold mr-2">
                        <div class="text-truncate"><a href="http://">
                                White Soup
                            </a></div>
                        <div class="small text-gray-500"><b>Qty:</b> 10
                        </div>
                    </div>
                    <span class="ml-auto">
                        <div class="custom-control custom-switch pull-left">
                            <input type="checkbox" class="custom-control-input" id="customSwitch5">
                            <label class="custom-control-label" for="customSwitch5"></label>
                        </div>
                    </span>
                </div>
            </div>
            <div class="box-footer p-2 border-top">
                <button type="button" class="btn btn-primary btn-block"> Add Item </button>
            </div>
        </div>
    </aside>
</div>
@endsection


@section('scripts')
@endsection
