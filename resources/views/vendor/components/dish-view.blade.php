<div class="modal fade" id="dish-view-modal" tabindex="-1" data-backdrop="static" role="dialog"
    aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Dish</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 pb-3">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div>
                    <div class="container" id="view" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="row shadow rounded">
                            <div class="img-container pl-md-0 col-md-7">
                                <img id="image" class="img-edit rounded" style="height:430px;"
                                    src="{{Storage::url('vendor/dish/'.$dish->image)}}">
                            </div>
                            @if($dish->type == "simple")
                            <div class="col-md-5">
                                <div id="basics">

                                    <div class="mb-5 pt-3 text-lg-left text-center">
                                        <div class="float-left">
                                            <h4 class="font-weight-semi-bold">{{ucfirst($dish->title)}} </h4>
                                        </div>
                                        <div class="float-right nav">
                                            <a class="text-dark" id="edit-btn"><i
                                                    class="la la-pen la-2x icon-hover pt-0"></i></a>
                                        </div>
                                    </div>


                                    <div id="basicsAccordion">

                                        <div class="box shadow-sm border rounded bg-white mb-2">
                                            <div id="basicsHeadingOne">
                                                <h5 class="mb-0">
                                                    <button
                                                        class="shadow-none btn btn-block d-flex justify-content-between card-btn p-3 collapsed font-weight-bold"
                                                        data-toggle="" data-target="#basicsCollapseOne"
                                                        aria-expanded="false" aria-controls="basicsCollapseOne">
                                                        Regular Quantity
                                                        <!-- <span class="card-btn-arrow">
                                                            <span class="la la-chevron-down"></span>
                                                        </span> -->
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="basicsCollapseOne" class="collapse show"
                                                aria-labelledby="basicsHeadingOne" data-parent="#basicsAccordion"
                                                style="">
                                                <div class="card-body border-top p-2 text-muted"
                                                    style="font-size: large;">
                                                    <ul class="list-group box-body generic-scrollbar"
                                                        style="max-height: 250px; overflow: auto;">
                                                        <li class="list-group-item pt-0">
                                                            <small>Price</small>
                                                            <p class="mt-0">
                                                                <span class="float-left text-danger"
                                                                    style="font-size: larger;">
                                                                    ₦{{$price}}</span>
                                                                <span class="badge badge-secondary float-right">
                                                                    {{$quantity}} left</span>
                                                            </p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            @else
                            <div class="col-md-5">
                                <div id="basics">

                                    <div class="mb-5 pt-3 text-lg-left text-center">
                                        <div class="float-left">
                                            <h4 class="font-weight-semi-bold">{{ucfirst($dish->title)}} </h4>
                                        </div>
                                        <div class="float-right pt-0 nav">
                                            <a class="text-dark" id="edit-btn"><i
                                                    class="la la-pen la-2x icon-hover pt-0"></i></a>
                                        </div>
                                    </div>


                                    <div id="basicsAccordion">

                                        <div class="box shadow-sm border rounded bg-white mb-2">
                                            <div id="basicsHeadingOne">
                                                <h5 class="mb-0">
                                                    <button
                                                        class="shadow-none btn btn-block d-flex justify-content-between card-btn p-3 collapsed font-weight-bold"
                                                        data-toggle="collapse" data-target="#basicsCollapseOne"
                                                        aria-expanded="false" aria-controls="basicsCollapseOne">
                                                        Regular Quantity
                                                        <span class="card-btn-arrow">
                                                            <span class="la la-chevron-down"></span>
                                                        </span>
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="basicsCollapseOne" class="collapse show"
                                                aria-labelledby="basicsHeadingOne" data-parent="#basicsAccordion"
                                                style="">
                                                <div class="card-body border-top p-2 text-muted"
                                                    style="font-size: large;">
                                                    <ul class="list-group box-body generic-scrollbar"
                                                        style="max-height: 250px; overflow: auto;">
                                                        @foreach($regular_qty as $qty)
                                                        <li class="list-group-item pt-0">
                                                            <small>{{$qty->title}}</small>
                                                            <p class="mt-0">
                                                                <span class="float-left text-danger"
                                                                    style="font-size: larger;">
                                                                    ₦{{$qty->price}}</span>
                                                                <span class="badge badge-secondary float-right">
                                                                    {{$qty->quantity}} left</span>
                                                            </p>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box shadow-sm border rounded bg-white mb-2">
                                            <div id="basicsHeadingTwo">
                                                <h5 class="mb-0">
                                                    <button
                                                        class="shadow-none btn btn-block d-flex justify-content-between card-btn collapsed p-3 font-weight-bold"
                                                        data-toggle="collapse" data-target="#basicsCollapseTwo"
                                                        aria-expanded="false" aria-controls="basicsCollapseTwo">
                                                        Bulk Quantity
                                                        <span class="card-btn-arrow">
                                                            <span class="la la-chevron-down"></span>
                                                        </span>
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="basicsCollapseTwo" class="collapse"
                                                aria-labelledby="basicsHeadingTwo" data-parent="#basicsAccordion">
                                                <div class="card-body border-top p-2 text-muted"
                                                    style="font-size:large;">
                                                    @if(!empty($bulk_qty))
                                                    <ul class="list-group">
                                                        @foreach($bulk_qty as $qty)
                                                        <li class="list-group-item pt-0">
                                                            <small>{{$qty->title}}</small>
                                                            <p class="mt-0">
                                                                <span class="float-left text-danger"
                                                                    style="font-size: larger;">
                                                                    ₦{{$qty->price}}</span>
                                                            </p>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                    @else
                                                    <div class="bg-light text-center py-5">
                                                        <i class="las la-info" style="font-size:xx-large;"></i><br>
                                                        <small>Empty Content</small>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="container" id="form">
                        <form id="add-dish" enctype="multipart/form-data">
                            @csrf
                            <!-- Form Type Input -->
                            <input type="hidden" name="form_type" id="form-type" value="simple">

                            <!-- Info alert box -->
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <h4 class="alert-heading"><i class="las la-info"></i> Notice!</h4>
                                <p>Please note that title fields require alphabets & hyphens only, image fields require
                                    images
                                    of type jpg & jpeg with max size of 25mb. Price and quantity fields require numeric
                                    values
                                    only. Click on the green buttons to add another item or click on the red to remove
                                    items.
                                    You can add five items at a time.</p>
                                <hr>
                                <p class="mb-0">Once you have filled all the details, click on the 'Add' button to
                                    continue.
                                </p>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            @include('vendor.components.error-modal')

                            @if($dish->type == "simple")
                            <div class="row border rounded pt-2 mt-2 shadow-sm mb-2 bg-white">
                                <div class="col text-center mb-2 d-block d-sm-none">
                                    <div class="btn btn-secondary btn-md" style="border-top-left-radius: 2.25rem;
                                    border-top-right-radius: 2.25rem;
                                    border-bottom-right-radius: 2.25rem;
                                    border-bottom-left-radius: 2.25rem;">1</div>
                                </div>

                                <div class="col-sm-6 col-xs-6 mb-2">
                                    <input class="form-control" name="title" type="text" placeholder="Name of dish" />
                                </div>
                                <div class="col-sm-6 col-xs-6 mb-2">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="image">
                                        <label class="custom-file-label" for="customFile">choose image</label>
                                    </div>
                                    <small class="text-danger error-message" id="image.0"></small>
                                </div>
                                <div class="col-sm-6 col-xs-6 mb-2">
                                    <input class="form-control" name="price" type="number" placeholder="Price" />
                                </div>
                                <div class="col-sm-6 col-xs-6 mb-2">
                                    <input class="form-control" name="quantity" type="number" placeholder="Quantity" />
                                </div>

                                <div class="input-group-btn col-sm-12 my-2">
                                    <a class="btn btn-secondary" id="back-btn" role="tab" aria-controls="home"
                                        aria-selected="true"><i class="la la-arrow-left"></i>
                                        Back</a>
                                    <button type="button" class="btn btn-primary">
                                        Update
                                    </button>
                                </div>
                            </div>
                            @else
                            <div class="row border rounded pt-2 mt-2 shadow-sm mb-2 bg-white">
                                <div class="col text-center mb-2 d-block d-sm-none">
                                    <div class="btn btn-secondary btn-md" style="border-top-left-radius: 2.25rem;
                                    border-top-right-radius: 2.25rem;
                                    border-bottom-right-radius: 2.25rem;
                                    border-bottom-left-radius: 2.25rem;">1</div>
                                </div>

                                <div class="col-sm-6 col-xs-6 mb-2">
                                    <input class="form-control one" name="title[]" type="text"
                                        placeholder="Name of dish" disabled />
                                </div>
                                <div class="col-sm-6 col-xs-6 mb-2">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input one" name="image[]" disabled>
                                        <label class="custom-file-label" for="customFile">choose image</label>
                                    </div>
                                    <small class="text-danger error-message" id="image.0"></small>
                                </div>

                                <div class="col-sm-6 border text-center pt-3 pb-3">
                                    <label class="text-center"> Regular Quantity </label>
                                    <div>
                                        <div class="mb-2 form-inline">
                                            <input class="form-control rounded-right-0 col-sm-4 one"
                                                name="regular_title_one[]" type="text" placeholder="Title" disabled />
                                            <input class="form-control col-sm-4 rounded-0 one"
                                                name="regular_price_one[]" type="number" placeholder="Price" disabled />
                                            <input class="form-control rounded-left-0 col-sm-4 one"
                                                name="regular_quantity_one[]" type="number"
                                                placeholder="Quantity Available" disabled />
                                            <div class="col-sm-12 pt-2 text-left input-group-btn">
                                                <button type="button" onclick="toggleMain(this)"
                                                    class="btn btn-success btn-sm qty-btn-add-1">
                                                    <span class="las la-plus" aria-hidden="true"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mb-2 form-inline d-none">
                                            <input class="form-control rounded-right-0 col-sm-4"
                                                name="regular_title_one[]" type="text" placeholder="Title" disabled />
                                            <input class="form-control col-sm-4 rounded-0" name="regular_price_one[]"
                                                type="number" placeholder="Price" disabled />
                                            <input class="form-control rounded-left-0 col-sm-4"
                                                name="regular_quantity_one[]" type="number"
                                                placeholder="Quantity Available" disabled />
                                            <div class="col-sm-12 pt-2 text-left input-group-btn">
                                                <button type="button" onclick="toggleMain(this)"
                                                    class="btn btn-success btn-sm qty-btn-add-1">
                                                    <span class="las la-plus" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" onclick="toggleMain(this, false)"
                                                    class="btn btn-danger btn-sm qty-btn-add-1">
                                                    <span class="las la-minus" aria-hidden="true"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mb-2 form-inline d-none">
                                            <input class="form-control rounded-right-0 col-sm-4"
                                                name="regular_title_one[]" type="text" placeholder="Title" disabled />
                                            <input class="form-control col-sm-4 rounded-0" name="regular_price_one[]"
                                                type="number" placeholder="Price" disabled />
                                            <input class="form-control rounded-left-0 col-sm-4"
                                                name="regular_quantity_one[]" type="number"
                                                placeholder="Quantity Available" disabled />
                                            <div class="col-sm-12 pt-2 text-left input-group-btn">
                                                <button type="button" onclick="toggleMain(this)"
                                                    class="btn btn-success btn-sm qty-btn-add-1">
                                                    <span class="las la-plus" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" onclick="toggleMain(this, false)"
                                                    class="btn btn-danger btn-sm qty-btn-add-1">
                                                    <span class="las la-minus" aria-hidden="true"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mb-2 form-inline d-none">
                                            <input class="form-control rounded-right-0 col-sm-4"
                                                name="regular_title_one[]" type="text" placeholder="Title" disabled />
                                            <input class="form-control col-sm-4 rounded-0" name="regular_price_one[]"
                                                type="number" placeholder="Price" disabled />
                                            <input class="form-control rounded-left-0 col-sm-4"
                                                name="regular_quantity_one[]" type="number"
                                                placeholder="Quantity Available" disabled />
                                            <div class="col-sm-12 pt-2 text-left input-group-btn">
                                                <button type="button" onclick="toggleMain(this)"
                                                    class="btn btn-success btn-sm qty-btn-add-1">
                                                    <span class="las la-plus" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" onclick="toggleMain(this, false)"
                                                    class="btn btn-danger btn-sm qty-btn-add-1">
                                                    <span class="las la-minus" aria-hidden="true"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mb-2 form-inline d-none">
                                            <input class="form-control rounded-right-0 col-sm-4"
                                                name="regular_title_one[]" type="text" placeholder="Title" disabled />
                                            <input class="form-control col-sm-4 rounded-0" name="regular_price_one[]"
                                                type="number" placeholder="Price" disabled />
                                            <input class="form-control rounded-left-0 col-sm-4"
                                                name="regular_quantity_one[]" type="number"
                                                placeholder="Quantity Available" disabled />
                                            <div class="col-sm-12 pt-2 text-left input-group-btn">
                                                <button type="button" onclick="toggleMain(this, false)"
                                                    class="btn btn-danger btn-sm qty-btn-add-1">
                                                    <span class="las la-minus" aria-hidden="true"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 border text-center pt-3 pb-3">
                                    <label class="text-center"> Bulk Quantity </label>
                                    <div>
                                        <div class="bulk-entry-1 mb-2 form-inline">
                                            <input class="form-control col-sm-6 rounded-right-0 one"
                                                name="bulk_title_one[]" type="text" placeholder="Title" disabled />
                                            <input class="form-control col-sm-6 rounded-left-0 one"
                                                name="bulk_price_one[]" type="number" placeholder="Price" disabled />
                                            <div class="col-sm-12 pt-2 text-left input-group-btn">
                                                <button type="button" onclick="toggleMain(this)"
                                                    class="btn btn-success btn-sm qty-btn-add-1">
                                                    <span class="las la-plus" aria-hidden="true"></span>
                                                </button>
                                            </div>
                                            <!-- <input class="form-control col-sm-4" name="fields[]" type="text"
                                            placeholder="Quantity Available" /> -->
                                        </div>
                                        <div class="bulk-entry-1 mb-2 form-inline d-none">
                                            <input class="form-control col-sm-6 rounded-right-0" name="bulk_title_one[]"
                                                type="text" placeholder="Title" disabled />
                                            <input class="form-control col-sm-6 rounded-left-0" name="bulk_price_one[]"
                                                type="number" placeholder="Price" disabled />
                                            <div class="col-sm-12 pt-2 text-left input-group-btn">
                                                <button type="button" onclick="toggleMain(this)"
                                                    class="btn btn-success btn-sm qty-btn-add-1">
                                                    <span class="las la-plus" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" onclick="toggleMain(this, false)"
                                                    class="btn btn-danger btn-sm qty-btn-add-1">
                                                    <span class="las la-minus" aria-hidden="true"></span>
                                                </button>
                                            </div>
                                            <!-- <input class="form-control col-sm-4" name="fields[]" type="text"
                                            placeholder="Quantity Available" /> -->
                                        </div>
                                        <div class="bulk-entry-1 mb-2 form-inline d-none">
                                            <input class="form-control col-sm-6 rounded-right-0" name="bulk_title_one[]"
                                                type="text" placeholder="Title" disabled />
                                            <input class="form-control col-sm-6 rounded-left-0" name="bulk_price_one[]"
                                                type="number" placeholder="Price" disabled />
                                            <div class="col-sm-12 pt-2 text-left input-group-btn">
                                                <button type="button" onclick="toggleMain(this)"
                                                    class="btn btn-success btn-sm qty-btn-add-1">
                                                    <span class="las la-plus" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" onclick="toggleMain(this, false)"
                                                    class="btn btn-danger btn-sm qty-btn-add-1">
                                                    <span class="las la-minus" aria-hidden="true"></span>
                                                </button>
                                            </div>
                                            <!-- <input class="form-control col-sm-4" name="fields[]" type="text"
                                            placeholder="Quantity Available" /> -->
                                        </div>
                                        <div class="bulk-entry-1 mb-2 form-inline d-none">
                                            <input class="form-control col-sm-6 rounded-right-0" name="bulk_title_one[]"
                                                type="text" placeholder="Title" disabled />
                                            <input class="form-control col-sm-6 rounded-left-0" name="bulk_price_one[]"
                                                type="number" placeholder="Price" disabled />
                                            <div class="col-sm-12 pt-2 text-left input-group-btn">
                                                <button type="button" onclick="toggleMain(this)"
                                                    class="btn btn-success btn-sm qty-btn-add-1">
                                                    <span class="las la-plus" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" onclick="toggleMain(this, false)"
                                                    class="btn btn-danger btn-sm qty-btn-add-1">
                                                    <span class="las la-minus" aria-hidden="true"></span>
                                                </button>
                                            </div>
                                            <!-- <input class="form-control col-sm-4" name="fields[]" type="text"
                                            placeholder="Quantity Available" /> -->
                                        </div>
                                        <div class="bulk-entry-1 mb-2 form-inline d-none">
                                            <input class="form-control col-sm-6 rounded-right-0" name="bulk_title_one[]"
                                                type="text" placeholder="Title" disabled />
                                            <input class="form-control col-sm-6 rounded-left-0" name="bulk_price_one[]"
                                                type="number" placeholder="Price" disabled />
                                            <div class="col-sm-12 pt-2 text-left input-group-btn">
                                                <button type="button" onclick="toggleMain(this, false)"
                                                    class="btn btn-danger btn-sm qty-btn-add-1">
                                                    <span class="las la-minus" aria-hidden="true"></span>
                                                </button>
                                            </div>
                                            <!-- <input class="form-control col-sm-4" name="fields[]" type="text"
                                            placeholder="Quantity Available" /> -->
                                        </div>
                                    </div>
                                </div>

                                <div class="input-group-btn col-sm-12 my-2">
                                    <a class="btn btn-secondary" id="back-btn" role="tab" aria-controls="home"
                                        aria-selected="true"><i class="la la-arrow-left"></i>
                                        Back</a>
                                    <button type="button" class="btn btn-primary">
                                        Update
                                    </button>
                                </div>
                            </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<span class="d-none" data-toggle="modal" href="#loginModal" id="login-pop"></span>

<script>
    $("#form").hide()
    $("#edit-btn").on('click', function () {
        $("#form").fadeIn("fast")
        $("#view").hide()
    });

    $("#back-btn").on('click', function () {
        $("#form").hide()
        $("#view").fadeIn("fast")
    });

</script>
