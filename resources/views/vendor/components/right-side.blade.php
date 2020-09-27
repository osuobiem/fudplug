<div class="box shadow-sm border rounded bg-white mb-3">
    <ul class="nav border-bottom box-title d-flex justify-content-center osahan-line-tab" id="myTab" role="tablist">
        <li class="nav-item col-6">
            <a class="nav-link text-center active" id="profile-tab" data-toggle="tab" href="#menu" role="tab"
                aria-controls="profile" aria-selected="false">Today's Menu</a>
            <!-- <h6 class="m-0">Dishes</h6> -->
        </li>
        <li class="nav-item border-left col-6">
            <a class="nav-link text-center" id="home-tab" data-toggle="tab" href="#dish" role="tab" aria-controls="home"
                aria-selected="false">Dishes</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="menu" role="tabpanel" aria-labelledby="profile-tab">
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
        <div class="tab-pane fade" id="dish" role="tabpanel" aria-labelledby="home-tab">
            <div class="box-body p-3 overflow-auto" style="height: 300px;">
                @if(!empty($dishes))
                @foreach($dishes as $dish)
                <div class="d-flex align-items-center osahan-post-header mb-3 people-list">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="{{Storage::url('vendor/dish/'.$dish->image)}}" alt="">

                    </div>
                    <div class="font-weight-bold mr-2">
                        <div class="text-truncate"><a href="http://">
                                {{$dish->title}}
                            </a></div>
                        <div class="small text-gray-500"><b>Qty:</b> 10
                        </div>
                    </div>
                    <span title="add to today's menu" class="ml-auto">
                        <button type="button" class="btn btn-outline-danger btn-sm text-nowrap"
                            onclick="viewDish('{{$dish->id}}')"><i class="feather-eye"></i>
                            View</button>
                        <!-- <div class="custom-control custom-switch pull-left">
                            <input type="checkbox" class="custom-control-input" id="customSwitch1">
                            <label class="custom-control-label" for="customSwitch1"></label>
                        </div> -->
                    </span>
                </div>
                @endforeach
                @else
                <div class="bg-light text-center" style="height:inherit; padding-top: 7rem;">
                    <i class="las la-info" style="font-size:xx-large;"></i><br>
                    <small>Empty Content</small>
                </div>
                @endif
            </div>
            <div class="box-footer p-2 border-top">
                <button type="button" class="btn btn-primary btn-block" data-toggle="modal"
                    data-target="#dish-add-modal"> Add Item </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Function that displays dish view modal with its contents
    function viewDish(dishId) {
        let getUrl = "{{url('vendor/dish/')}}";
        getUrl += '/' + dishId;
        goGet(getUrl).then((res) => {
            $("#dish-modal-holder").html(res);
            $("#dish-view-modal").modal('show');
        }).catch((err) => {
            console.error(err);
        });
    }

</script>
