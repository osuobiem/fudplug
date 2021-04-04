<div class="modal fade" id="dish-add-modal" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog mt-1 modal-lg" style="height: 500px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Dish</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-sign">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add-dish" enctype="multipart/form-data">
                    @csrf
                    <!-- Form Type Input -->
                    <input type="hidden" name="form_type" id="form-type" value="simple">

                    <!-- Info alert box -->
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <h4 class="alert-heading"><i class="las la-info"></i> Notice!</h4>
                        <p>Please note that title fields require alphabets & hyphens only, image fields require images
                            of type jpg & jpeg with max size of 25mb. Price and quantity fields require numeric values
                            only. Click on the green buttons to add another item or click on the red to remove items.
                            You can add five items at a time.</p>
                        <hr>
                        <p class="mb-0">Once you have filled all the details, click on the 'Add' button to continue.
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
                                <div class="modal-body" id="modal-body">
                                    <p>Modal body text goes here.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Form Error Toast -->


                    <div class="box shadow-sm border rounded bg-white mb-3">
                        <ul class="nav nav-tab border-bottom box-title d-flex justify-content-center osahan-line-tab"
                            id="myTab" role="tablist">
                            <li class="nav-item col-6">
                                <a class="nav-link text-center active" id="profile-tab" data-toggle="tab" href="#simple"
                                    role="tab" aria-controls="profile" aria-selected="false">Simple</a>
                                <!-- <h6 class="m-0">Dishes</h6> -->
                            </li>
                            <li class="nav-item border-left col-6">
                                <a class="nav-link text-center" id="home-tab" data-toggle="tab" href="#advanced"
                                    role="tab" aria-controls="home" aria-selected="true">Advanced</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade active show container" id="simple" role="tabpanel"
                                aria-labelledby="profile-tab">
                                <div class="row border rounded pt-2 mt-2 shadow-sm mb-2 bg-white">
                                    <div class="col text-center mb-2 d-block d-sm-none">
                                        <div class="btn btn-secondary btn-md" style="border-top-left-radius: 2.25rem;
                                            border-top-right-radius: 2.25rem;
                                            border-bottom-right-radius: 2.25rem;
                                            border-bottom-left-radius: 2.25rem;">1</div>
                                    </div>

                                    <div class="col-sm-6 col-xs-6 mb-2">
                                        <input class="form-control" name="title[]" type="text"
                                            placeholder="Name of dish" />
                                    </div>
                                    <div class="col-sm-6 col-xs-6 mb-2">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="image[]">
                                            <label class="custom-file-label" for="customFile">choose image</label>
                                        </div>
                                        <small class="text-danger error-message" id="image.0"></small>
                                    </div>
                                    <div class="col-sm-6 col-xs-6 mb-2">
                                        <input class="form-control" name="price[]" type="number" placeholder="Price" />
                                    </div>
                                    <div class="col-sm-6 col-xs-6 mb-2">
                                        <input class="form-control" name="quantity[]" type="text"
                                            placeholder="Quantity available e.g 10 plates" />
                                    </div>

                                    <div class="input-group-btn col-sm-12 my-2 add-btn-one-simple">
                                        <button type="button" onclick="toggleMain(this)"
                                            class="btn btn-success btn-lg btn-add first">
                                            <span class="las la-plus" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                </div>

                                <div class="row border rounded pt-2 mt-2 shadow-sm mb-2 bg-white d-none">
                                    <div class="col text-center mb-2 d-block d-sm-none">
                                        <div class="btn btn-secondary btn-md" style="border-top-left-radius: 2.25rem;
                                            border-top-right-radius: 2.25rem;
                                            border-bottom-right-radius: 2.25rem;
                                            border-bottom-left-radius: 2.25rem;">2</div>
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <input class="form-control" name="title[]" type="text"
                                            placeholder="Name of dish" disabled />
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="image[]" accept="image/*"
                                                disabled>
                                            <label class="custom-file-label" for="customFile">choose image</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-6 mb-2">
                                        <input class="form-control" name="price[]" type="number" placeholder="Price"
                                            disabled />
                                    </div>
                                    <div class="col-sm-6 col-xs-6 mb-2">
                                        <input class="form-control" name="quantity[]" type="text"
                                            placeholder="Quantity available e.g 10 plates" disabled />
                                    </div>

                                    <div class="input-group-btn col-sm-12 my-2">
                                        <button type="button" onclick="toggleMain(this)"
                                            class="btn btn-success btn-lg btn-add first">
                                            <span class="las la-plus" aria-hidden="true"></span>
                                        </button>
                                        <button type="button" onclick='toggleMain(this, false)'
                                            class="btn btn-danger btn-lg btn-remove first">
                                            <span class="las la-minus" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                </div>

                                <div class="row border rounded pt-2 mt-2 shadow-sm mb-2 bg-white d-none">
                                    <div class="col text-center mb-2 d-block d-sm-none">
                                        <div class="btn btn-secondary btn-md" style="border-top-left-radius: 2.25rem;
                                            border-top-right-radius: 2.25rem;
                                            border-bottom-right-radius: 2.25rem;
                                            border-bottom-left-radius: 2.25rem;">3</div>
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <input class="form-control" name="title[]" type="text"
                                            placeholder="Name of dish" disabled />
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="image[]" accept="image/*"
                                                disabled>
                                            <label class="custom-file-label" for="customFile">choose image</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-6 mb-2">
                                        <input class="form-control" name="price[]" type="number" placeholder="Price"
                                            disabled />
                                    </div>
                                    <div class="col-sm-6 col-xs-6 mb-2">
                                        <input class="form-control" name="quantity[]" type="text"
                                            placeholder="Quantity available e.g 10 plates" disabled />
                                    </div>

                                    <div class="input-group-btn col-sm-12 my-2">
                                        <button type="button" onclick="toggleMain(this)"
                                            class="btn btn-success btn-lg btn-add first">
                                            <span class="las la-plus" aria-hidden="true"></span>
                                        </button>
                                        <button type="button" onclick='toggleMain(this, false)'
                                            class="btn btn-danger btn-lg btn-remove first">
                                            <span class="las la-minus" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                </div>

                                <div class="row border rounded pt-2 mt-2 shadow-sm mb-2 bg-white d-none">
                                    <div class="col text-center mb-2 d-block d-sm-none">
                                        <div class="btn btn-secondary btn-md" style="border-top-left-radius: 2.25rem;
                                            border-top-right-radius: 2.25rem;
                                            border-bottom-right-radius: 2.25rem;
                                            border-bottom-left-radius: 2.25rem;">4</div>
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <input class="form-control" name="title[]" type="text"
                                            placeholder="Name of dish" disabled />
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="image[]" accept="image/*"
                                                disabled>
                                            <label class="custom-file-label" for="customFile">choose image</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-6 mb-2">
                                        <input class="form-control" name="price[]" type="number" placeholder="Price"
                                            disabled />
                                    </div>
                                    <div class="col-sm-6 col-xs-6 mb-2">
                                        <input class="form-control" name="quantity[]" type="text"
                                            placeholder="Quantity available e.g 10 plates" disabled />
                                    </div>

                                    <div class="input-group-btn col-sm-12 my-2">
                                        <button type="button" onclick="toggleMain(this)"
                                            class="btn btn-success btn-lg btn-add first">
                                            <span class="las la-plus" aria-hidden="true"></span>
                                        </button>
                                        <button type="button" onclick='toggleMain(this, false)'
                                            class="btn btn-danger btn-lg btn-remove first">
                                            <span class="las la-minus" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                </div>

                                <div class="row border rounded pt-2 mt-2 shadow-sm mb-2 bg-white d-none">
                                    <div class="col text-center mb-2 d-block d-sm-none">
                                        <div class="btn btn-secondary btn-md" style="border-top-left-radius: 2.25rem;
                                            border-top-right-radius: 2.25rem;
                                            border-bottom-right-radius: 2.25rem;
                                            border-bottom-left-radius: 2.25rem;">5</div>
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <input class="form-control" name="title[]" type="text"
                                            placeholder="Name of dish" disabled />
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="image[]" accept="image/*"
                                                disabled>
                                            <label class="custom-file-label" for="customFile">choose image</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-6 mb-2">
                                        <input class="form-control" name="price[]" type="number" placeholder="Price"
                                            disabled />
                                    </div>
                                    <div class="col-sm-6 col-xs-6 mb-2">
                                        <input class="form-control" name="quantity[]" type="text"
                                            placeholder="Quantity available e.g 10 plates" disabled />
                                    </div>

                                    <div class="input-group-btn col-sm-12 my-2">
                                        <button type="button" onclick='toggleMain(this, false)'
                                            class="btn btn-danger btn-lg btn-remove first">
                                            <span class="las la-minus" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade container" id="advanced" role="tabpanel"
                                aria-labelledby="home-tab">
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

                                    <div class="col-sm-6 border pt-2 pb-3">
                                        <div class="text-center mb-3 border-bottom">
                                            <label> Regular Quantity </label>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <span> Title </span>
                                            </div>
                                            <div class="col-4">
                                                <span> Price </span>
                                            </div>
                                            <div class="col-4">
                                                <span> Quantity </span>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="mb-2 form-inline">
                                                <input class="form-control rounded-right-0 col-4 one"
                                                    name="regular_title_one[]" type="text" placeholder="Max-pack"
                                                    disabled />
                                                <input class="form-control col-4 rounded-0 one"
                                                    name="regular_price_one[]" type="number" placeholder="1000"
                                                    disabled />
                                                <input class="form-control rounded-left-0 col-4 one"
                                                    name="regular_quantity_one[]" type="text" placeholder="20 Plates"
                                                    disabled />
                                                <div class="col-sm-12 pt-2 text-left input-group-btn">
                                                    <button type="button" onclick="toggleMain(this)"
                                                        class="btn btn-success btn-sm qty-btn-add-1">
                                                        <span class="las la-plus" aria-hidden="true"></span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="mb-2 form-inline d-none">
                                                <input class="form-control rounded-right-0 col-4"
                                                    name="regular_title_one[]" type="text" placeholder="Max-pack"
                                                    disabled />
                                                <input class="form-control col-4 rounded-0" name="regular_price_one[]"
                                                    type="number" placeholder="1000" disabled />
                                                <input class="form-control rounded-left-0 col-4"
                                                    name="regular_quantity_one[]" type="text" placeholder="20 Plates"
                                                    disabled />
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
                                                <input class="form-control rounded-right-0 col-4"
                                                    name="regular_title_one[]" type="text" placeholder="Max-pack"
                                                    disabled />
                                                <input class="form-control col-4 rounded-0" name="regular_price_one[]"
                                                    type="number" placeholder="1000" disabled />
                                                <input class="form-control rounded-left-0 col-4"
                                                    name="regular_quantity_one[]" type="text" placeholder="20 Plates"
                                                    disabled />
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
                                                <input class="form-control rounded-right-0 col-4"
                                                    name="regular_title_one[]" type="text" placeholder="Max-pack"
                                                    disabled />
                                                <input class="form-control col-4 rounded-0" name="regular_price_one[]"
                                                    type="number" placeholder="1000" disabled />
                                                <input class="form-control rounded-left-0 col-4"
                                                    name="regular_quantity_one[]" type="text" placeholder="20 Plates"
                                                    disabled />
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
                                                <input class="form-control rounded-right-0 col-4"
                                                    name="regular_title_one[]" type="text" placeholder="Max-pack"
                                                    disabled />
                                                <input class="form-control col-4 rounded-0" name="regular_price_one[]"
                                                    type="number" placeholder="1000" disabled />
                                                <input class="form-control rounded-left-0 col-4"
                                                    name="regular_quantity_one[]" type="text" placeholder="20 Plates"
                                                    disabled />
                                                <div class="col-sm-12 pt-2 text-left input-group-btn">
                                                    <button type="button" onclick="toggleMain(this, false)"
                                                        class="btn btn-danger btn-sm qty-btn-add-1">
                                                        <span class="las la-minus" aria-hidden="true"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 border pt-2 pb-3">
                                        <div class="text-center mb-3 border-bottom">
                                            <label> Bulk Quantity </label>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <span> Litres </span>
                                            </div>
                                            <div class="col-4">
                                                <span> Price </span>
                                            </div>
                                            <div class="col-4">
                                                <span> Quantity </span>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="bulk-entry-1 mb-2 form-inline">
                                                <input class="form-control col-4 rounded-right-0 one"
                                                    name="bulk_title_one[]" step="0.01" type="number" placeholder="2.5"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0 rounded-right-0 one"
                                                    name="bulk_price_one[]" type="number" placeholder="1000" disabled />
                                                <input class="form-control col-4 rounded-left-0 one"
                                                    name="bulk_quantity_one[]" type="number" placeholder="10"
                                                    disabled />
                                                <div class="col-sm-12 pt-2 text-left input-group-btn">
                                                    <button type="button" onclick="toggleMain(this)"
                                                        class="btn btn-success btn-sm qty-btn-add-1">
                                                        <span class="las la-plus" aria-hidden="true"></span>
                                                    </button>
                                                </div>
                                                <!-- <input class="form-control col-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-4 rounded-right-0"
                                                    name="bulk_title_one[]" step="0.01" type="number" placeholder="2.5"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0 rounded-right-0"
                                                    name="bulk_price_one[]" type="number" placeholder="1000" disabled />
                                                <input class="form-control col-4 rounded-left-0"
                                                    name="bulk_quantity_one[]" type="number" placeholder="10"
                                                    disabled />
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
                                                <!-- <input class="form-control col-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-4 rounded-right-0"
                                                    name="bulk_title_one[]" step="0.01" type="number" placeholder="2.5"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0 rounded-right-0"
                                                    name="bulk_price_one[]" type="number" placeholder="1000" disabled />
                                                <input class="form-control col-4 rounded-left-0"
                                                    name="bulk_quantity_one[]" type="number" placeholder="10"
                                                    disabled />
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
                                                <!-- <input class="form-control col-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-4 rounded-right-0"
                                                    name="bulk_title_one[]" step="0.01" type="number" placeholder="2.5"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0 rounded-right-0"
                                                    name="bulk_price_one[]" type="number" placeholder="1000" disabled />
                                                <input class="form-control col-4 rounded-left-0"
                                                    name="bulk_quantity_one[]" type="number" placeholder="10"
                                                    disabled />
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
                                                <!-- <input class="form-control col-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-4 rounded-right-0"
                                                    name="bulk_title_one[]" step="0.01" type="number" placeholder="2.5"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0 rounded-right-0"
                                                    name="bulk_price_one[]" type="number" placeholder="1000" disabled />
                                                <input class="form-control col-4 rounded-left-0"
                                                    name="bulk_quantity_one[]" type="number" placeholder="10"
                                                    disabled />
                                                <div class="col-sm-12 pt-2 text-left input-group-btn">
                                                    <button type="button" onclick="toggleMain(this, false)"
                                                        class="btn btn-danger btn-sm qty-btn-add-1">
                                                        <span class="las la-minus" aria-hidden="true"></span>
                                                    </button>
                                                </div>
                                                <!-- <input class="form-control col-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="input-group-btn col-sm-12 my-2 add-btn-one-advanced">
                                        <button type="button" onclick="toggleMain(this, true, true)"
                                            class="btn btn-success btn-lg btn-add first">
                                            <span class="las la-plus" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                </div>

                                <div class="row border rounded pt-2 mt-2 shadow-sm mb-2 bg-white d-none">
                                    <div class="col text-center mb-2 d-block d-sm-none">
                                        <div class="btn btn-secondary btn-md" style="border-top-left-radius: 2.25rem;
                                            border-top-right-radius: 2.25rem;
                                            border-bottom-right-radius: 2.25rem;
                                            border-bottom-left-radius: 2.25rem;">2</div>
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <input class="form-control init" name="title[]" type="text"
                                            placeholder="Name of dish" disabled />
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input init" name="image[]"
                                                accept="image/*" disabled>
                                            <label class="custom-file-label" for="customFile">choose image</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 border pt-2 pb-3">
                                        <div class="text-center mb-3 border-bottom">
                                            <label> Regular Quantity </label>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <span> Title </span>
                                            </div>
                                            <div class="col-4">
                                                <span> Price </span>
                                            </div>
                                            <div class="col-4">
                                                <span> Quantity </span>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="mb-2 form-inline">
                                                <input class="form-control rounded-right-0 col-4 init"
                                                    name="regular_title_two[]" type="text" placeholder="Max-pack"
                                                    disabled />
                                                <input class="form-control col-4 rounded-0 init"
                                                    name="regular_price_two[]" type="number" placeholder="1000"
                                                    disabled />
                                                <input class="form-control rounded-left-0 col-4 init"
                                                    name="regular_quantity_two[]" type="text" placeholder="20 Plates"
                                                    disabled />
                                                <div class="col-sm-12 pt-2 text-left input-group-btn">
                                                    <button type="button" onclick="toggleMain(this)"
                                                        class="btn btn-success btn-sm qty-btn-add-1">
                                                        <span class="las la-plus" aria-hidden="true"></span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="mb-2 form-inline d-none">
                                                <input class="form-control rounded-right-0 col-4"
                                                    name="regular_title_two[]" type="text" placeholder="Max-pack"
                                                    disabled />
                                                <input class="form-control col-4 rounded-0" name="regular_price_two[]"
                                                    type="number" placeholder="1000" disabled />
                                                <input class="form-control rounded-left-0 col-4"
                                                    name="regular_quantity_two[]" type="text" placeholder="20 Plates"
                                                    disabled />
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
                                                <input class="form-control rounded-right-0 col-4"
                                                    name="regular_title_two[]" type="text" placeholder="Max-pack"
                                                    disabled />
                                                <input class="form-control col-4 rounded-0" name="regular_price_two[]"
                                                    type="number" placeholder="1000" disabled />
                                                <input class="form-control rounded-left-0 col-4"
                                                    name="regular_quantity_two[]" type="text" placeholder="20 Plates"
                                                    disabled />
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
                                                <input class="form-control rounded-right-0 col-4"
                                                    name="regular_title_two[]" type="text" placeholder="Max-pack"
                                                    disabled />
                                                <input class="form-control col-4 rounded-0" name="regular_price_two[]"
                                                    type="number" placeholder="1000" disabled />
                                                <input class="form-control rounded-left-0 col-4"
                                                    name="regular_quantity_two[]" type="text" placeholder="20 Plates"
                                                    disabled />
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
                                                <input class="form-control rounded-right-0 col-4"
                                                    name="regular_title_two[]" type="text" placeholder="Max-pack"
                                                    disabled />
                                                <input class="form-control col-4 rounded-0" name="regular_price_two[]"
                                                    type="number" placeholder="1000" disabled />
                                                <input class="form-control rounded-left-0 col-4"
                                                    name="regular_quantity_two[]" type="text" placeholder="20 Plates"
                                                    disabled />
                                                <div class="col-sm-12 pt-2 text-left input-group-btn">
                                                    <button type="button" onclick="toggleMain(this, false)"
                                                        class="btn btn-danger btn-sm qty-btn-add-1">
                                                        <span class="las la-minus" aria-hidden="true"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 border pt-2 pb-3">
                                        <div class="text-center mb-3 border-bottom">
                                            <label> Bulk Quantity </label>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <span> Litres </span>
                                            </div>
                                            <div class="col-4">
                                                <span> Price </span>
                                            </div>
                                            <div class="col-4">
                                                <span> Quantity </span>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="bulk-entry-1 mb-2 form-inline">
                                                <input class="form-control col-4 rounded-right-0 init"
                                                    name="bulk_title_two[]" step="0.01" type="number" placeholder="2.5"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0 rounded-right-0 init"
                                                    name="bulk_price_two[]" type="number" placeholder="1000" disabled />
                                                <input class="form-control col-4 rounded-left-0 init"
                                                    name="bulk_quantity_two[]" type="number" placeholder="10"
                                                    disabled />
                                                <div class="col-sm-12 pt-2 text-left input-group-btn">
                                                    <button type="button" onclick="toggleMain(this)"
                                                        class="btn btn-success btn-sm qty-btn-add-1">
                                                        <span class="las la-plus" aria-hidden="true"></span>
                                                    </button>
                                                </div>
                                                <!-- <input class="form-control col-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-4 rounded-right-0"
                                                    name="bulk_title_two[]" step="0.01" type="number" placeholder="2.5"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0 rounded-right-0"
                                                    name="bulk_price_two[]" type="number" placeholder="1000" disabled />
                                                <input class="form-control col-4 rounded-left-0"
                                                    name="bulk_quantity_two[]" type="number" placeholder="10"
                                                    disabled />
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
                                                <!-- <input class="form-control col-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-4 rounded-right-0"
                                                    name="bulk_title_two[]" step="0.01" type="number" placeholder="2.5"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0 rounded-right-0"
                                                    name="bulk_price_two[]" type="number" placeholder="1000" disabled />
                                                <input class="form-control col-4 rounded-left-0"
                                                    name="bulk_quantity_two[]" type="number" placeholder="10"
                                                    disabled />
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
                                                <!-- <input class="form-control col-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-4 rounded-right-0"
                                                    name="bulk_title_two[]" step="0.01" type="number" placeholder="2.5"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0" name="bulk_price_two[]"
                                                    type="number" placeholder="1000" disabled />
                                                <input class="form-control col-4 rounded-left-0"
                                                    name="bulk_quantity_two[]" type="number" placeholder="10"
                                                    disabled />
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
                                                <!-- <input class="form-control col-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-4 rounded-right-0"
                                                    name="bulk_title_two[]" step="0.01" type="number" placeholder="2.5"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0" name="bulk_price_two[]"
                                                    type="number" placeholder="1000" disabled />
                                                <input class="form-control col-4 rounded-left-0"
                                                    name="bulk_quantity_two[]" type="number" placeholder="10"
                                                    disabled />
                                                <div class="col-sm-12 pt-2 text-left input-group-btn">
                                                    <button type="button" onclick="toggleMain(this, false)"
                                                        class="btn btn-danger btn-sm qty-btn-add-1">
                                                        <span class="las la-minus" aria-hidden="true"></span>
                                                    </button>
                                                </div>
                                                <!-- <input class="form-control col-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="input-group-btn col-sm-12 my-2">
                                        <button type="button" onclick="toggleMain(this, true, true)"
                                            class="btn btn-success btn-lg btn-add first">
                                            <span class="las la-plus" aria-hidden="true"></span>
                                        </button>
                                        <button type="button" onclick='toggleMain(this, false)'
                                            class="btn btn-danger btn-lg btn-remove first">
                                            <span class="las la-minus" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                </div>

                                <div class="row border rounded pt-2 mt-2 shadow-sm mb-2 bg-white d-none">
                                    <div class="col text-center mb-2 d-block d-sm-none">
                                        <div class="btn btn-secondary btn-md" style="border-top-left-radius: 2.25rem;
                                            border-top-right-radius: 2.25rem;
                                            border-bottom-right-radius: 2.25rem;
                                            border-bottom-left-radius: 2.25rem;">3</div>
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <input class="form-control init" name="title[]" type="text"
                                            placeholder="Name of dish" disabled />
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input init" name="image[]"
                                                accept="image/*" disabled>
                                            <label class="custom-file-label" for="customFile">choose image</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 border pt-2 pb-3">
                                        <div class="text-center mb-3 border-bottom">
                                            <label> Regular Quantity </label>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <span> Title </span>
                                            </div>
                                            <div class="col-4">
                                                <span> Price </span>
                                            </div>
                                            <div class="col-4">
                                                <span> Quantity </span>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="mb-2 form-inline">
                                                <input class="form-control rounded-right-0 col-4 init"
                                                    name="regular_title_three[]" type="text" placeholder="Max-pack"
                                                    disabled />
                                                <input class="form-control col-4 rounded-0 init"
                                                    name="regular_price_three[]" type="number" placeholder="1000"
                                                    disabled />
                                                <input class="form-control rounded-left-0 col-4 init"
                                                    name="regular_quantity_three[]" type="text" placeholder="20 Plates"
                                                    disabled />
                                                <div class="col-sm-12 pt-2 text-left input-group-btn">
                                                    <button type="button" onclick="toggleMain(this)"
                                                        class="btn btn-success btn-sm qty-btn-add-1">
                                                        <span class="las la-plus" aria-hidden="true"></span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="mb-2 form-inline d-none">
                                                <input class="form-control rounded-right-0 col-4"
                                                    name="regular_title_three[]" type="text" placeholder="Max-pack"
                                                    disabled />
                                                <input class="form-control col-4 rounded-0" name="regular_price_three[]"
                                                    type="number" placeholder="1000" disabled />
                                                <input class="form-control rounded-left-0 col-4"
                                                    name="regular_quantity_three[]" type="text" placeholder="20 Plates"
                                                    disabled />
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
                                                <input class="form-control rounded-right-0 col-4"
                                                    name="regular_title_three[]" type="text" placeholder="Max-pack"
                                                    disabled />
                                                <input class="form-control col-4 rounded-0" name="regular_price_three[]"
                                                    type="number" placeholder="1000" disabled />
                                                <input class="form-control rounded-left-0 col-4"
                                                    name="regular_quantity_three[]" type="text" placeholder="20 Plates"
                                                    disabled />
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
                                                <input class="form-control rounded-right-0 col-4"
                                                    name="regular_title_three[]" type="text" placeholder="Max-pack"
                                                    disabled />
                                                <input class="form-control col-4 rounded-0" name="regular_price_three[]"
                                                    type="number" placeholder="1000" disabled />
                                                <input class="form-control rounded-left-0 col-4"
                                                    name="regular_quantity_three[]" type="text" placeholder="20 Plates"
                                                    disabled />
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
                                                <input class="form-control rounded-right-0 col-4"
                                                    name="regular_title_three[]" type="text" placeholder="Max-pack"
                                                    disabled />
                                                <input class="form-control col-4 rounded-0" name="regular_price_three[]"
                                                    type="number" placeholder="1000" disabled />
                                                <input class="form-control rounded-left-0 col-4"
                                                    name="regular_quantity_three[]" type="text" placeholder="20 Plates"
                                                    disabled />
                                                <div class="col-sm-12 pt-2 text-left input-group-btn">
                                                    <button type="button" onclick="toggleMain(this, false)"
                                                        class="btn btn-danger btn-sm qty-btn-add-1">
                                                        <span class="las la-minus" aria-hidden="true"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 border pt-2 pb-3">
                                        <div class="text-center mb-3 border-bottom">
                                            <label> Bulk Quantity </label>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <span> Litres </span>
                                            </div>
                                            <div class="col-4">
                                                <span> Price </span>
                                            </div>
                                            <div class="col-4">
                                                <span> Quantity </span>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="bulk-entry-1 mb-2 form-inline">
                                                <input class="form-control col-4 rounded-right-0 init"
                                                    name="bulk_title_three[]" step="0.01" type="number"
                                                    placeholder="2.5" disabled />
                                                <input class="form-control col-4 rounded-left-0 rounded-right-0 init"
                                                    name="bulk_price_three[]" type="number" placeholder="1000"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0 init"
                                                    name="bulk_quantity_three[]" type="number" placeholder="10"
                                                    disabled />
                                                <div class="col-sm-12 pt-2 text-left input-group-btn">
                                                    <button type="button" onclick="toggleMain(this)"
                                                        class="btn btn-success btn-sm qty-btn-add-1">
                                                        <span class="las la-plus" aria-hidden="true"></span>
                                                    </button>
                                                </div>
                                                <!-- <input class="form-control col-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-4 rounded-right-0"
                                                    name="bulk_title_three[]" step="0.01" type="number"
                                                    placeholder="2.5" disabled />
                                                <input class="form-control col-4 rounded-left-0 rounded-right-0"
                                                    name="bulk_price_three[]" type="number" placeholder="1000"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0"
                                                    name="bulk_quantity_three[]" type="number" placeholder="10"
                                                    disabled />
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
                                                <!-- <input class="form-control col-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-4 rounded-right-0"
                                                    name="bulk_title_three[]" step="0.01" type="number"
                                                    placeholder="2.5" disabled />
                                                <input class="form-control col-4 rounded-left-0 rounded-right-0"
                                                    name="bulk_price_three[]" type="number" placeholder="1000"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0"
                                                    name="bulk_quantity_three[]" type="number" placeholder="10"
                                                    disabled />
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
                                                <!-- <input class="form-control col-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-4 rounded-right-0"
                                                    name="bulk_title_three[]" step="0.01" type="number"
                                                    placeholder="2.5" disabled />
                                                <input class="form-control col-4 rounded-left-0 rounded-right-0"
                                                    name="bulk_price_three[]" type="number" placeholder="1000"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0"
                                                    name="bulk_quantity_three[]" type="number" placeholder="10"
                                                    disabled />
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
                                                <!-- <input class="form-control col-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-4 rounded-right-0"
                                                    name="bulk_title_three[]" step="0.01" type="number"
                                                    placeholder="2.5" disabled />
                                                <input class="form-control col-4 rounded-left-0 rounded-right-0"
                                                    name="bulk_price_three[]" type="number" placeholder="1000"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0"
                                                    name="bulk_quantity_three[]" type="number" placeholder="10"
                                                    disabled />
                                                <div class="col-sm-12 pt-2 text-left input-group-btn">
                                                    <button type="button" onclick="toggleMain(this, false)"
                                                        class="btn btn-danger btn-sm qty-btn-add-1">
                                                        <span class="las la-minus" aria-hidden="true"></span>
                                                    </button>
                                                </div>
                                                <!-- <input class="form-control col-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="input-group-btn col-sm-12 my-2">
                                        <button type="button" onclick="toggleMain(this, true, true)"
                                            class="btn btn-success btn-lg btn-add first">
                                            <span class="las la-plus" aria-hidden="true"></span>
                                        </button>
                                        <button type="button" onclick='toggleMain(this, false)'
                                            class="btn btn-danger btn-lg btn-remove first">
                                            <span class="las la-minus" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                </div>

                                <div class="row border rounded pt-2 mt-2 shadow-sm mb-2 bg-white d-none">
                                    <div class="col text-center mb-2 d-block d-sm-none">
                                        <div class="btn btn-secondary btn-md" style="border-top-left-radius: 2.25rem;
                                            border-top-right-radius: 2.25rem;
                                            border-bottom-right-radius: 2.25rem;
                                            border-bottom-left-radius: 2.25rem;">4</div>
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <input class="form-control init" name="title[]" type="text"
                                            placeholder="Name of dish" disabled />
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input init" name="image[]"
                                                accept="image/*" disabled>
                                            <label class="custom-file-label" for="customFile">choose image</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 border pt-2 pb-3">
                                        <div class="text-center mb-3 border-bottom">
                                            <label> Regular Quantity </label>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <span> Title </span>
                                            </div>
                                            <div class="col-4">
                                                <span> Price </span>
                                            </div>
                                            <div class="col-4">
                                                <span> Quantity </span>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="mb-2 form-inline">
                                                <input class="form-control rounded-right-0 col-4 init"
                                                    name="regular_title_four[]" type="text" placeholder="Max-pack"
                                                    disabled />
                                                <input class="form-control col-4 rounded-0 init"
                                                    name="regular_price_four[]" type="number" placeholder="1000"
                                                    disabled />
                                                <input class="form-control rounded-left-0 col-4 init"
                                                    name="regular_quantity_four[]" type="text" placeholder="20 Plates"
                                                    disabled />
                                                <div class="col-sm-12 pt-2 text-left input-group-btn">
                                                    <button type="button" onclick="toggleMain(this)"
                                                        class="btn btn-success btn-sm qty-btn-add-1">
                                                        <span class="las la-plus" aria-hidden="true"></span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="mb-2 form-inline d-none">
                                                <input class="form-control rounded-right-0 col-4"
                                                    name="regular_title_four[]" type="text" placeholder="Max-pack"
                                                    disabled />
                                                <input class="form-control col-4 rounded-0" name="regular_price_four[]"
                                                    type="number" placeholder="1000" disabled />
                                                <input class="form-control rounded-left-0 col-4"
                                                    name="regular_quantity_four[]" type="text" placeholder="20 Plates"
                                                    disabled />
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
                                                <input class="form-control rounded-right-0 col-4"
                                                    name="regular_title_four[]" type="text" placeholder="Max-pack"
                                                    disabled />
                                                <input class="form-control col-4 rounded-0" name="regular_price_four[]"
                                                    type="number" placeholder="1000" disabled />
                                                <input class="form-control rounded-left-0 col-4"
                                                    name="regular_quantity_four[]" type="text" placeholder="20 Plates"
                                                    disabled />
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
                                                <input class="form-control rounded-right-0 col-4"
                                                    name="regular_title_four[]" type="text" placeholder="Max-pack"
                                                    disabled />
                                                <input class="form-control col-4 rounded-0" name="regular_price_four[]"
                                                    type="number" placeholder="1000" disabled />
                                                <input class="form-control rounded-left-0 col-4"
                                                    name="regular_quantity_four[]" type="text" placeholder="20 Plates"
                                                    disabled />
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
                                                <input class="form-control rounded-right-0 col-4"
                                                    name="regular_title_four[]" type="text" placeholder="Max-pack"
                                                    disabled />
                                                <input class="form-control col-4 rounded-0" name="regular_price_four[]"
                                                    type="number" placeholder="1000" disabled />
                                                <input class="form-control rounded-left-0 col-4"
                                                    name="regular_quantity_four[]" type="text" placeholder="20 Plates"
                                                    disabled />
                                                <div class="col-sm-12 pt-2 text-left input-group-btn">
                                                    <button type="button" onclick="toggleMain(this, false)"
                                                        class="btn btn-danger btn-sm qty-btn-add-1">
                                                        <span class="las la-minus" aria-hidden="true"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 border pt-2 pb-3">
                                        <div class="text-center mb-3 border-bottom">
                                            <label> Bulk Quantity </label>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <span> Litres </span>
                                            </div>
                                            <div class="col-4">
                                                <span> Price </span>
                                            </div>
                                            <div class="col-4">
                                                <span> Quantity </span>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="bulk-entry-1 mb-2 form-inline">
                                                <input class="form-control col-4 rounded-right-0 init"
                                                    name="bulk_title_four[]" step="0.01" type="number" placeholder="2.5"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0 rounded-right-0 init"
                                                    name="bulk_price_four[]" type="number" placeholder="1000"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0 init"
                                                    name="bulk_quantity_four[]" type="number" placeholder="10"
                                                    disabled />
                                                <div class="col-sm-12 pt-2 text-left input-group-btn">
                                                    <button type="button" onclick="toggleMain(this)"
                                                        class="btn btn-success btn-sm qty-btn-add-1">
                                                        <span class="las la-plus" aria-hidden="true"></span>
                                                    </button>
                                                </div>
                                                <!-- <input class="form-control col-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-4 rounded-right-0"
                                                    name="bulk_title_four[]" step="0.01" type="number" placeholder="2.5"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0 rounded-right-0"
                                                    name="bulk_price_four[]" type="number" placeholder="1000"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0"
                                                    name="bulk_quantity_four[]" type="number" placeholder="10"
                                                    disabled />
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
                                                <!-- <input class="form-control col-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-4 rounded-right-0"
                                                    name="bulk_title_four[]" step="0.01" type="number" placeholder="2.5"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0 rounded-right-0"
                                                    name="bulk_price_four[]" type="number" placeholder="1000"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0"
                                                    name="bulk_quantity_four[]" type="number" placeholder="10"
                                                    disabled />
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
                                                <!-- <input class="form-control col-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-4 rounded-right-0"
                                                    name="bulk_title_four[]" step="0.01" type="number" placeholder="2.5"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0 rounded-right-0"
                                                    name="bulk_price_four[]" type="number" placeholder="1000"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0"
                                                    name="bulk_quantity_four[]" type="number" placeholder="10"
                                                    disabled />
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
                                                <!-- <input class="form-control col-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-4 rounded-right-0"
                                                    name="bulk_title_four[]" step="0.01" type="number" placeholder="2.5"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0 rounded-right-0"
                                                    name="bulk_price_four[]" type="number" placeholder="1000"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0"
                                                    name="bulk_quantity_four[]" type="number" placeholder="10"
                                                    disabled />
                                                <div class="col-sm-12 pt-2 text-left input-group-btn">
                                                    <button type="button" onclick="toggleMain(this, false)"
                                                        class="btn btn-danger btn-sm qty-btn-add-1">
                                                        <span class="las la-minus" aria-hidden="true"></span>
                                                    </button>
                                                </div>
                                                <!-- <input class="form-control col-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="input-group-btn col-sm-12 my-2">
                                        <button type="button" onclick="toggleMain(this, true, true)"
                                            class="btn btn-success btn-lg btn-add first">
                                            <span class="las la-plus" aria-hidden="true"></span>
                                        </button>
                                        <button type="button" onclick='toggleMain(this, false)'
                                            class="btn btn-danger btn-lg btn-remove first">
                                            <span class="las la-minus" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                </div>

                                <div class="row border rounded pt-2 mt-2 shadow-sm mb-2 bg-white d-none">
                                    <div class="col text-center mb-2 d-block d-sm-none">
                                        <div class="btn btn-secondary btn-md" style="border-top-left-radius: 2.25rem;
                                            border-top-right-radius: 2.25rem;
                                            border-bottom-right-radius: 2.25rem;
                                            border-bottom-left-radius: 2.25rem;">5</div>
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <input class="form-control init" name="title[]" type="text"
                                            placeholder="Name of dish" disabled />
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input init" name="image[]"
                                                accept="image/*" disabled>
                                            <label class="custom-file-label" for="customFile">choose image</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 border pt-2 pb-3">
                                        <div class="text-center mb-3 border-bottom">
                                            <label> Regular Quantity </label>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <span> Title </span>
                                            </div>
                                            <div class="col-4">
                                                <span> Price </span>
                                            </div>
                                            <div class="col-4">
                                                <span> Quantity </span>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="mb-2 form-inline">
                                                <input class="form-control rounded-right-0 col-4 init"
                                                    name="regular_title_five[]" type="text" placeholder="Max-pack"
                                                    disabled />
                                                <input class="form-control col-4 rounded-0 init"
                                                    name="regular_price_five[]" type="number" placeholder="1000"
                                                    disabled />
                                                <input class="form-control rounded-left-0 col-4 init"
                                                    name="regular_quantity_five[]" type="text" placeholder="20 Plates"
                                                    disabled />
                                                <div class="col-sm-12 pt-2 text-left input-group-btn">
                                                    <button type="button" onclick="toggleMain(this)"
                                                        class="btn btn-success btn-sm qty-btn-add-1">
                                                        <span class="las la-plus" aria-hidden="true"></span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="mb-2 form-inline d-none">
                                                <input class="form-control rounded-right-0 col-4"
                                                    name="regular_title_five[]" type="text" placeholder="Max-pack"
                                                    disabled />
                                                <input class="form-control col-4 rounded-0" name="regular_price_five[]"
                                                    type="number" placeholder="1000" disabled />
                                                <input class="form-control rounded-left-0 col-4"
                                                    name="regular_quantity_five[]" type="text" placeholder="20 Plates"
                                                    disabled />
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
                                                <input class="form-control rounded-right-0 col-4"
                                                    name="regular_title_five[]" type="text" placeholder="Max-pack"
                                                    disabled />
                                                <input class="form-control col-4 rounded-0" name="regular_price_five[]"
                                                    type="number" placeholder="1000" disabled />
                                                <input class="form-control rounded-left-0 col-4"
                                                    name="regular_quantity_five[]" type="text" placeholder="20 Plates"
                                                    disabled />
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
                                                <input class="form-control rounded-right-0 col-4"
                                                    name="regular_title_five[]" type="text" placeholder="Max-pack"
                                                    disabled />
                                                <input class="form-control col-4 rounded-0" name="regular_price_five[]"
                                                    type="number" placeholder="1000" disabled />
                                                <input class="form-control rounded-left-0 col-4"
                                                    name="regular_quantity_five[]" type="text" placeholder="20 Plates"
                                                    disabled />
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
                                                <input class="form-control rounded-right-0 col-4"
                                                    name="regular_title_five[]" type="text" placeholder="Max-pack"
                                                    disabled />
                                                <input class="form-control col-4 rounded-0" name="regular_price_five[]"
                                                    type="number" placeholder="1000" disabled />
                                                <input class="form-control rounded-left-0 col-4"
                                                    name="regular_quantity_five[]" type="text" placeholder="20 Plates"
                                                    disabled />
                                                <div class="col-sm-12 pt-2 text-left input-group-btn">
                                                    <button type="button" onclick="toggleMain(this, false)"
                                                        class="btn btn-danger btn-sm qty-btn-add-1">
                                                        <span class="las la-minus" aria-hidden="true"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 border pt-2 pb-3">
                                        <div class="text-center mb-3 border-bottom">
                                            <label> Bulk Quantity </label>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <span> Litres </span>
                                            </div>
                                            <div class="col-4">
                                                <span> Price </span>
                                            </div>
                                            <div class="col-4">
                                                <span> Quantity </span>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="bulk-entry-1 mb-2 form-inline">
                                                <input class="form-control col-4 rounded-right-0 init"
                                                    name="bulk_title_five[]" step="0.01" type="number" placeholder="2.5"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0 rounded-right-0 init"
                                                    name="bulk_price_five[]" type="number" placeholder="1000"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0 init"
                                                    name="bulk_quantity_five[]" type="number" placeholder="10"
                                                    disabled />
                                                <div class="col-sm-12 pt-2 text-left input-group-btn">
                                                    <button type="button" onclick="toggleMain(this)"
                                                        class="btn btn-success btn-sm qty-btn-add-1">
                                                        <span class="las la-plus" aria-hidden="true"></span>
                                                    </button>
                                                </div>
                                                <!-- <input class="form-control col-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-4 rounded-right-0"
                                                    name="bulk_title_five[]" step="0.01" type="number" placeholder="2.5"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0 rounded-right-0"
                                                    name="bulk_price_five[]" type="number" placeholder="1000"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0"
                                                    name="bulk_quantity_five[]" type="number" placeholder="10"
                                                    disabled />
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
                                                <!-- <input class="form-control col-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-4 rounded-right-0"
                                                    name="bulk_title_five[]" step="0.01" type="number" placeholder="2.5"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0 rounded-right-0"
                                                    name="bulk_price_five[]" type="number" placeholder="1000"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0"
                                                    name="bulk_quantity_five[]" type="number" placeholder="10"
                                                    disabled />
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
                                                <!-- <input class="form-control col-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-4 rounded-right-0"
                                                    name="bulk_title_five[]" step="0.01" type="number" placeholder="2.5"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0 rounded-right-0"
                                                    name="bulk_price_five[]" type="number" placeholder="1000"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0"
                                                    name="bulk_quantity_five[]" type="number" placeholder="10"
                                                    disabled />
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
                                                <!-- <input class="form-control col-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-4 rounded-right-0"
                                                    name="bulk_title_five[]" step="0.01" type="number" placeholder="2.5"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0 rounded-right-0"
                                                    name="bulk_price_five[]" type="number" placeholder="1000"
                                                    disabled />
                                                <input class="form-control col-4 rounded-left-0"
                                                    name="bulk_quantity_five[]" type="number" placeholder="10"
                                                    disabled />
                                                <div class="col-sm-12 pt-2 text-left input-group-btn">
                                                    <button type="button" onclick="toggleMain(this, false)"
                                                        class="btn btn-danger btn-sm qty-btn-add-1">
                                                        <span class="las la-minus" aria-hidden="true"></span>
                                                    </button>
                                                </div>
                                                <!-- <input class="form-control col-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="input-group-btn col-sm-12 my-2">
                                        <button type="button" onclick='toggleMain(this, false)'
                                            class="btn btn-danger btn-lg btn-remove first">
                                            <span class="las la-minus" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="form-group text-center col-sm-12 mt-3">
                    <button id="submit-btn" class="btn btn-primary px-5">
                        <span id="vendor-txt">Add</span>
                        <div class="spinner-border spinner-border-sm btn-pr" id="vendor-spinner" style="display: none;"
                            role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<span class="d-none" data-toggle="modal" href="#loginModal" id="login-pop"></span>

<script>
    // Block to handle main form repeaters
    function toggleMain(element, newf = true, main = false) {
        if (newf) {
            if (main) {
                $(element).parent().parent().next().find('.init').removeAttr('disabled');
            } else {
                $(element).parent().parent().next().find('input').removeAttr('disabled');
                $(element).parent().parent().next().find('input').addClass('one');
            }
            $(element).parent().parent().next().removeClass('d-none');
            $(element).parent().addClass('d-none');

            let str = $(element).parent().parent().find('input').attr('name')
            if (str.includes("bulk")) {
                let len = $(element).parent().parent().parent().children().not('.d-none').length;
                if (len > 1) {
                    $(element).parent().parent().parent().find('input').attr('required', '')
                }
            }
        } else {
            $(element).parent().parent().addClass('d-none');
            $(element).parent().parent().find('input').attr('disabled', '');
            $(element).parent().parent().prev().find('.input-group-btn').removeClass('d-none');

            if (!main) {
                $(element).parent().parent().find('input').removeClass('one');
            }

            let str = $(element).parent().parent().find('input').attr('name')
            if (str.includes("bulk")) {
                let len = $(element).parent().parent().parent().children().not('.d-none').length;
                if (len == 1) {
                    $(element).parent().parent().parent().find('input').removeAttr('required')
                }
            }
        }
    }
    // Block to handle main form repeaters


    // Disable Input Elements for Inactive Form Tabs
    $('.nav-tab a:first').click(function () {
        $("#form-type").val("simple")
        $("#simple").children('div').eq(0).find('input').removeAttr('disabled', '');
        // $("#simple").children('div').eq(0).find('.input-group-btn').removeClass('d-none');
        $("#simple").children().not(':eq(0)').addClass('d-none')
        $("#advanced").find('input').attr('disabled', '');
        $(".add-btn-one-simple").removeClass('d-none');
    })

    $('.nav-tab a:last').click(function () {
        $("#form-type").val("advanced")
        $("#advanced").children('div').eq(0).find('.one').removeAttr('disabled', '');
        //$("#advanced").children('div').eq(0).find('.input-group-btn').removeClass('d-none');
        $("#advanced").children().not(':eq(0)').addClass('d-none').find('input').val("")
        $("#simple").find('input').attr('disabled', '');
        $(".add-btn-one-advanced").removeClass('d-none');
    })

    $(document).ready(function () {
        // Set required fields
        $("[name='title[]']").attr('required', 'true');
        $("[name='image[]']").attr('required', 'true');
        $("#advanced").children().not(':eq(0)').addClass('d-none').find("[name='image[]']").attr('disabled',
            '');
        $("[name^='regular']").attr('required', 'true');

        // Check form validity and fire submit event
        let form = document.getElementById('add-dish');
        document.getElementById('submit-btn').onclick = function () {
            // if (form.reportValidity()) {
            $('#add-dish').trigger('submit')
            // }
        }

        // Attach dish form event listener
        $('#add-dish').submit(el => {
            el.preventDefault()
            addDish(el)
        });
    });

    // Add dish
    async function addDish(el) {
        el.preventDefault()

        spin('vendor')
        offError('v-dish-error')

        let url = `{{ url('vendor/add-dish') }}`;
        data = new FormData(el.target);

        /***************   Compress images **********/
        let images = data.getAll('image[]');

        // Delete old images from form data
        data.delete('image[]');

        // Add new (compressed) set of images to form data
        for (let image of images) {
            compressedimage = await compressImg(image);

            data.append('image[]', blobToFile(compressedimage, image.name), image.name);
        }
        /***************   Compress images **********/

        goPost(url, data)
            .then(res => {
                spin('vendor');

                // Check if response carries file validation
                if (res.file_val) {
                    $("#modal-body").html(res.message);
                    $("#error-modal").modal('toggle');
                } else {
                    if (handleFormRes(res, false, false, 'modal-body')) {
                        // console.log(res)
                        showAlert(true, res.message);
                        setTimeout(() => {
                            $('#add-dish').trigger('reset');

                            // Reload the Right Bar on Completion
                            loadRight(activeTab);
                        }, 2000)
                    }
                }
            })
            .catch(err => {
                spin('vendor')
                handleFormRes(err, 'v-dish-error');
            })
    }

</script>
