<div class="box shadow-sm border rounded bg-white mb-3" id="dish-menu">
    <ul class="nav border-bottom box-title d-flex justify-content-center osahan-line-tab" id="rightTab" role="tablist">
        <li class="nav-item col-6">
            <a class="nav-link text-center active" id="profile-tab" onclick="track('1')" data-toggle="tab" href="#menu"
                role="tab" aria-controls="profile" aria-selected="false">Today's Menu <span
                    class="badge badge-dark">{{$menu_count}}</span></a>
            <!-- <h6 class="m-0">Dishes</h6> -->
        </li>
        <li class="nav-item border-left col-6">
            <a class="nav-link text-center" id="home-tab" onclick="track('2')" data-toggle="tab" href="#dish" role="tab"
                aria-controls="home" aria-selected="false">Dishes <span
                    class="badge badge-dark">{{$dish_count}}</span></a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="menu" role="tabpanel" aria-labelledby="profile-tab">
            <div class="box-body p-3 overflow-auto generic-scrollbar" style="height: 300px;" id="vendor-menu-container">
                @if(!empty($menu_dishes))
                @foreach($menu_dishes as $menu_dish)
                <div class="d-flex align-items-center osahan-post-header mb-3 people-list">
                    <div class="dropdown-list-image mr-2">
                        <img class="rounded-circle" src="{{Storage::url('vendor/dish/'.$menu_dish->image)}}" alt="">

                    </div>
                    <div class="font-weight-bold text-truncate mr-1 text-left" style="width: 64%;">
                        {{$menu_dish->title}}
                    </div>
                    <span title="add to today's menu" class="ml-auto">
                        <button type="button" class="btn btn-outline-danger border-0 btn-sm text-nowrap"
                            onclick="viewDish('{{$menu_dish->id}}')"><i class="feather-eye"></i>
                            <i class="las la-eye la-2x"></i></button>
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
                <button type="button" onclick="loadMenuModal()" class="btn btn-primary btn-block"> Update Menu </button>
            </div>
        </div>
        <div class="tab-pane fade" id="dish" role="tabpanel" aria-labelledby="home-tab">
            <div class="box-body p-3 overflow-auto generic-scrollbar" style="height: 300px;" id="vendor-dish-container">
                @if(!empty($dishes))
                @foreach($dishes as $dish)
                <div class="d-flex align-items-center osahan-post-header mb-3 people-list">
                    <div class="dropdown-list-image mr-2">
                        <img class="rounded-circle" src="{{Storage::url('vendor/dish/'.$dish->image)}}" alt="">

                    </div>
                    <div class="font-weight-bold text-truncate mr-1 text-left" style="width: 54%;">
                        {{$dish->title}}
                    </div>
                    <span title="add to today's menu" class="ml-auto">
                        <button type="button" class="btn btn-outline-danger border-0 btn-sm text-nowrap px-0"
                            onclick="viewDish('{{$dish->id}}')">
                            <i class="las la-eye la-2x"></i></button>
                        <button type="button" class="btn btn-outline-danger border-0 btn-sm text-nowrap"
                            onclick="dishDelete('{{$dish->id}}', '{{$dish->title}}')">
                            <i class="las la-trash-alt la-2x"></i></button>
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
    // Scrollspy for right side components (Vendor menu)
    $("#vendor-menu-container").loadMore({
        scrollBottom: 35,
        async: true,
        error: function () {
            loadMoreRight("menu"); //load content
        },
    });

    // Scrollspy for right side components (Vendor dish)
    $("#vendor-dish-container").loadMore({
        scrollBottom: 35,
        async: true,
        error: function () {
            loadMoreRight("dish"); //load content
        },
    });

    // Function that displays dish view modal with its contents
    function viewDish(dishId) {
        $("#dish-view-container").empty();
        $("#dish-view-modal-spinner").removeClass('d-none');
        $("#dish-view-modal").modal('show');

        let getUrl = "{{url('vendor/dish/')}}";
        getUrl += '/' + dishId;
        goGet(getUrl).then((res) => {
            $("#dish-view-modal-spinner").addClass('d-none');
            $("#dish-view-container").html(res);
        }).catch((err) => {
            showAlert(false, "Oops! Something's not right. Try again");
        });
    }

    // Function that displays dish delete modal
    function dishDelete(dishId, dishTitle) {
        // Dish data object
        let dishData = {
            dishId,
            dishTitle
        }

        // Attach dish ttle to confirmation
        $("#del-dish-title").html(dishData.dishTitle);

        // Save dish data to sessionStorage
        sessionStorage.setItem('dishId', dishData.dishId);

        // Pop confirmation
        $("#dish-delete-modal").modal('show');
    }

    // Function Deletes Dish
    function deleteDish() {
        spin('dish-delete');

        // Get saved data from sessionStorage
        let dishId = sessionStorage.getItem('dishId');

        let getUrl = "{{url('vendor/delete-dish/')}}";
        getUrl += '/' + dishId;
        goGet(getUrl).then((res) => {
            spin('dish-delete');

            showAlert(true, res.message);
            $("#dish-delete-modal").modal('hide');
            loadRight(activeTab);
        }).catch((err) => {
            spin('dish-delete');

            showAlert(false, "Oops! Something's not right. Try again");
        });
    }

</script>
