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
                                                    @if(!empty($regular_qty))
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
                                                    @else
                                                    <div class="bg-light text-center py-5">
                                                        <i class="las la-info" style="font-size:xx-large;"></i><br>
                                                        <small>Empty Content</small>
                                                    </div>
                                                    @endif
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
                                                            <small>{{$qty->title}} Litres</small>
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
                        <form id="update-dish" enctype="multipart/form-data">
                            @csrf
                            <!-- Form Type Input -->
                            <input type="hidden" name="form_type" id="form-type" value="{{$dish->type}}">

                            <!-- Dish ID -->
                            <input type="hidden" name="dish_id" id="dish-id" value="{{$dish->id}}">

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

                            <!-- Form Error Toast -->
                            <div class="modal" id="error-modal" tabindex="-1" role="dialog">
                                <div class="modal-dialog animate__heartBeat" role="document" style="top: 200px;">
                                    <div class="modal-content shadow-lg" style="color: #721c24;
                            background-color: #f8d7da;
                            border-color: #f5c6cb;">
                                        <div class="modal-body" id="modal-edit-body">
                                            <p>Modal body text goes here.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Form Error Toast -->


                            @if($dish->type == "simple")
                            <div class="row border rounded pt-2 mt-2 shadow-sm mb-2 bg-white">
                                <div class="col text-center mb-2 d-block d-sm-none">
                                    <div class="btn btn-secondary btn-md" style="border-top-left-radius: 2.25rem;
                                    border-top-right-radius: 2.25rem;
                                    border-bottom-right-radius: 2.25rem;
                                    border-bottom-left-radius: 2.25rem;">1</div>
                                </div>

                                <div class="col-sm-6 col-xs-6 mb-2">
                                    <input class="form-control" name="title" type="text" placeholder="Name of dish"
                                        value="{{$dish->title}}" required />
                                </div>
                                <div class="col-sm-6 col-xs-6 mb-2">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="image">
                                        <label class="custom-file-label" for="customFile">change image</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-6 mb-2">
                                    <input class="form-control" name="price" type="number" placeholder="Price"
                                        value="{{$price}}" required />
                                </div>
                                <div class="col-sm-6 col-xs-6 mb-2">
                                    <input class="form-control" name="quantity" type="number" placeholder="Quantity"
                                        value="{{$quantity}}" required />
                                </div>

                                <div class="input-group-btn col-sm-12 my-2">
                                    <a class="btn btn-secondary" id="back-btn" role="tab" aria-controls="home"
                                        aria-selected="true"><i class="la la-arrow-left"></i>
                                        Back</a>
                                    <button id="submit-btn" class="btn btn-primary px-5">
                                        <span id="vendor-txt">Update</span>
                                        <div class="spinner-border spinner-border-sm btn-pr" id="vendor-spinner"
                                            style="display: none;" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
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
                                    <input class="form-control one" name="title" type="text" placeholder="Name of dish"
                                        value="{{$dish->title}}" required />
                                </div>
                                <div class="col-sm-6 col-xs-6 mb-2">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input one" name="image">
                                        <label class="custom-file-label" for="customFile">change image</label>
                                    </div>
                                </div>

                                <div class="col-sm-6 border text-center pt-3 pb-3">
                                    <label class="text-center"> Regular Quantity </label>
                                    <div>
                                        @if(!empty($regular_qty))
                                        @foreach($regular_qty as $qty)
                                        <div class="mb-2 form-inline">
                                            <input class="form-control rounded-right-0 col-sm-4 one"
                                                name="regular_title[]" type="text" value="{{$qty->title}}"
                                                placeholder="Title" required />
                                            <input class="form-control col-sm-4 rounded-0 one" name="regular_price[]"
                                                type="number" value="{{$qty->price}}" placeholder="Price" required />
                                            <input class="form-control rounded-left-0 col-sm-4 one"
                                                name="regular_quantity[]" type="number" value="{{$qty->quantity}}"
                                                placeholder="Quantity Available" required />
                                        </div>
                                        @endforeach
                                        @else
                                        <div class="bg-light text-center py-5">
                                            <i class="las la-info" style="font-size:xx-large;"></i><br>
                                            <small>No fields for this category</small>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6 border text-center pt-3 pb-3">
                                    <label class="text-center"> Bulk Quantity </label>
                                    <div>

                                        @if(!empty($bulk_qty))
                                        @foreach($bulk_qty as $qty)
                                        <div class="bulk-entry-1 mb-2 form-inline">
                                            <input class="form-control col-sm-4 rounded-right-0" name="bulk_title[]"
                                                value="{{$qty->title}}" step="0.01" type="number" placeholder="Litres"
                                                required />
                                            <input class="form-control col-sm-4 rounded-left-0 rounded-right-0"
                                                name="bulk_price[]" type="number" value="{{$qty->price}}"
                                                placeholder="Price" required />
                                            <input class="form-control col-sm-4 rounded-left-0 init"
                                                name="bulk_quantity[]" value="{{$qty->quantity}}" type="number"
                                                placeholder="Quantity Available" required />
                                            <!-- <input class="form-control col-sm-4" name="fields[]" type="text"
                                            placeholder="Quantity Available" /> -->
                                        </div>
                                        @endforeach
                                        @else
                                        <div class="bg-light text-center py-5">
                                            <i class="las la-info" style="font-size:xx-large;"></i><br>
                                            <small>No fields for this category</small>
                                        </div>
                                        @endif

                                    </div>
                                </div>

                                <div class="input-group-btn col-sm-12 my-2">
                                    <a class="btn btn-secondary" id="back-btn" role="tab" aria-controls="home"
                                        aria-selected="true"><i class="la la-arrow-left"></i>
                                        Back</a>
                                    <button id="submit-btn" class="btn btn-primary px-5">
                                        <span id="vendor-txt">Update</span>
                                        <div class="spinner-border spinner-border-sm btn-pr" id="vendor-spinner"
                                            style="display: none;" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
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
    $(document).ready(function () {
        // Toggle dish view and dish edit form
        $("#form").hide()
        $("#edit-btn").on('click', function () {
            $("#form").fadeIn("fast")
            $("#view").hide()
        });

        $("#back-btn").on('click', function () {
            $("#form").hide()
            $("#view").fadeIn("fast")
        });
    });

    // Check form validity and fire submit event
    var updateForm = document.getElementById('update-dish');
    document.getElementById('submit-btn').onclick = function () {
        if (updateForm.reportValidity()) {
            $('#update-dish').trigger('submit')
        }
    }

    // Attach dish form event listener
    $('#update-dish').submit(el => {
        el.preventDefault()
        updateDish(el)
    });

    // Update dish
    function updateDish(el) {
        el.preventDefault()

        spin('vendor')
        offError('v-dish-error')

        let url = `{{ url('vendor/update-dish') }}`;
        let data = new FormData(el.target)

        goPost(url, data)
            .then(res => {
                spin('vendor')

                if (handleFormRes(res, false, false, 'modal-edit-body')) {
                    // console.log(res)
                    showAlert(true, res.message);

                    // Reload the Right Bar on Completion
                    loadRight(activeTab);
                }
            })
            .catch(err => {
                spin('vendor')
                handleFormRes(err, 'v-dish-error');
            })
    }




    $(".custom-file-input").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

</script>
