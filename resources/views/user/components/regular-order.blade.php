<div class="modal fade" id="regular-order-modal" tabindex="-1" data-backdrop="static" role="dialog"
    aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
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
                <!-- <div>
                    <div class="container" id="view" role="tabpanel" aria-labelledby="profile-tab">

                    </div>

                </div> -->
                <div class="row">
                            <div class="img-container pl-md-0 col-md-7">
                                <img id="image" class="img-edit rounded order-img"
                                    src="{{Storage::url('vendor/dish/'.$dish->image)}}">
                            </div>
                            @if($dish->type == "simple")
                            <div class="col-md-5">
                                <div id="basics">

                                    <div class="mb-5 pt-3 text-lg-left text-center">
                                        <div class="float-left">
                                            <h4 class="font-weight-semi-bold">{{ucfirst($dish->title)}} </h4>
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

                                        <!-- <div class="box shadow-sm border rounded bg-white mb-2">
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
                                        </div> -->

                                    </div>

                                </div>
                            </div>
                            @endif
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
