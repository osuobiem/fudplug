<div class="modal fade" id="dish-add-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
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

                    @include('vendor.components.error-modal')

                    <div class="box shadow-sm border rounded bg-white mb-3">
                        <ul class="nav nav-tabs border-bottom box-title d-flex justify-content-center osahan-line-tab"
                            id="myTab" role="tablist">
                            <li class="nav-item col-6">
                                <a class="nav-link text-center active" id="profile-tab" data-toggle="tab" href="#simple"
                                    role="tab" aria-controls="profile" aria-selected="false">Simple</a>
                                <!-- <h6 class="m-0">Dishes</h6> -->
                            </li>
                            <li class="nav-item border-left col-6">
                                <a class="nav-link text-center" id="home-tab" data-toggle="tab" href="#advanced"
                                    role="tab" aria-controls="home" aria-selected="true">advanced</a>
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
                                        <input class="form-control" name="quantity[]" type="number"
                                            placeholder="Quantity" />
                                    </div>

                                    <div class="input-group-btn col-sm-12 my-2">
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
                                        <input class="form-control" name="quantity[]" type="number"
                                            placeholder="Quantity" disabled />
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
                                        <input class="form-control" name="quantity[]" type="number"
                                            placeholder="Quantity" disabled />
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
                                        <input class="form-control" name="quantity[]" type="number"
                                            placeholder="Quantity" disabled />
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
                                        <input class="form-control" name="quantity[]" type="number"
                                            placeholder="Quantity" disabled />
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
                                        <input class="form-control" name="title[]" type="text"
                                            placeholder="Name of dish" disabled />
                                    </div>
                                    <div class="col-sm-6 col-xs-6 mb-2">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="image[]" disabled>
                                            <label class="custom-file-label" for="customFile">choose image</label>
                                        </div>
                                        <small class="text-danger error-message" id="image.0"></small>
                                    </div>

                                    <div class="col-sm-6 border text-center pt-3 pb-3">
                                        <label class="text-center"> Regular Quantity </label>
                                        <div>
                                            <div class="mb-2 form-inline">
                                                <input class="form-control rounded-right-0 col-sm-4"
                                                    name="regular_title_one[]" type="text" placeholder="Title"
                                                    disabled />
                                                <input class="form-control col-sm-4 rounded-0"
                                                    name="regular_price_one[]" type="number" placeholder="Price"
                                                    disabled />
                                                <input class="form-control rounded-left-0 col-sm-4"
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
                                                    name="regular_title_one[]" type="text" placeholder="Title"
                                                    disabled />
                                                <input class="form-control col-sm-4 rounded-0"
                                                    name="regular_price_one[]" type="number" placeholder="Price"
                                                    disabled />
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
                                                    name="regular_title_one[]" type="text" placeholder="Title"
                                                    disabled />
                                                <input class="form-control col-sm-4 rounded-0"
                                                    name="regular_price_one[]" type="number" placeholder="Price"
                                                    disabled />
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
                                                    name="regular_title_one[]" type="text" placeholder="Title"
                                                    disabled />
                                                <input class="form-control col-sm-4 rounded-0"
                                                    name="regular_price_one[]" type="number" placeholder="Price"
                                                    disabled />
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
                                                    name="regular_title_one[]" type="text" placeholder="Title"
                                                    disabled />
                                                <input class="form-control col-sm-4 rounded-0"
                                                    name="regular_price_one[]" type="number" placeholder="Price"
                                                    disabled />
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
                                                <input class="form-control col-sm-6 rounded-right-0"
                                                    name="bulk_title_one[]" type="text" placeholder="Title" disabled />
                                                <input class="form-control col-sm-6 rounded-left-0"
                                                    name="bulk_price_one[]" type="number" placeholder="Price"
                                                    disabled />
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
                                                <input class="form-control col-sm-6 rounded-right-0"
                                                    name="bulk_title_one[]" type="text" placeholder="Title" disabled />
                                                <input class="form-control col-sm-6 rounded-left-0"
                                                    name="bulk_price_one[]" type="number" placeholder="Price"
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
                                                <!-- <input class="form-control col-sm-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-sm-6 rounded-right-0"
                                                    name="bulk_title_one[]" type="text" placeholder="Title" disabled />
                                                <input class="form-control col-sm-6 rounded-left-0"
                                                    name="bulk_price_one[]" type="number" placeholder="Price"
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
                                                <!-- <input class="form-control col-sm-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-sm-6 rounded-right-0"
                                                    name="bulk_title_one[]" type="text" placeholder="Title" disabled />
                                                <input class="form-control col-sm-6 rounded-left-0"
                                                    name="bulk_price_one[]" type="number" placeholder="Price"
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
                                                <!-- <input class="form-control col-sm-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-sm-6 rounded-right-0"
                                                    name="bulk_title_one[]" type="text" placeholder="Title" disabled />
                                                <input class="form-control col-sm-6 rounded-left-0"
                                                    name="bulk_price_one[]" type="number" placeholder="Price"
                                                    disabled />
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

                                    <div class="col-sm-6 border text-center pt-3 pb-3">
                                        <label class="text-center"> Regular Quantity </label>
                                        <div>
                                            <div class="mb-2 form-inline">
                                                <input class="form-control rounded-right-0 col-sm-4"
                                                    name="regular_title_two[]" type="text" placeholder="Title"
                                                    disabled />
                                                <input class="form-control col-sm-4 rounded-0"
                                                    name="regular_price_two[]" type="number" placeholder="Price"
                                                    disabled />
                                                <input class="form-control rounded-left-0 col-sm-4"
                                                    name="regular_quantity_two[]" type="number"
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
                                                    name="regular_title_two[]" type="text" placeholder="Title"
                                                    disabled />
                                                <input class="form-control col-sm-4 rounded-0"
                                                    name="regular_price_two[]" type="number" placeholder="Price"
                                                    disabled />
                                                <input class="form-control rounded-left-0 col-sm-4"
                                                    name="regular_quantity_two[]" type="number"
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
                                                    name="regular_title_two[]" type="text" placeholder="Title"
                                                    disabled />
                                                <input class="form-control col-sm-4 rounded-0"
                                                    name="regular_price_two[]" type="number" placeholder="Price"
                                                    disabled />
                                                <input class="form-control rounded-left-0 col-sm-4"
                                                    name="regular_quantity_two[]" type="number"
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
                                                    name="regular_title_two[]" type="text" placeholder="Title"
                                                    disabled />
                                                <input class="form-control col-sm-4 rounded-0"
                                                    name="regular_price_two[]" type="number" placeholder="Price"
                                                    disabled />
                                                <input class="form-control rounded-left-0 col-sm-4"
                                                    name="regular_quantity_two[]" type="number"
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
                                                    name="regular_title_two[]" type="text" placeholder="Title"
                                                    disabled />
                                                <input class="form-control col-sm-4 rounded-0"
                                                    name="regular_price_two[]" type="number" placeholder="Price"
                                                    disabled />
                                                <input class="form-control rounded-left-0 col-sm-4"
                                                    name="regular_quantity_two[]" type="number"
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
                                                <input class="form-control col-sm-6 rounded-right-0"
                                                    name="bulk_title_two[]" type="text" placeholder="Title" disabled />
                                                <input class="form-control col-sm-6 rounded-left-0"
                                                    name="bulk_price_two[]" type="number" placeholder="Price"
                                                    disabled />
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
                                                <input class="form-control col-sm-6 rounded-right-0"
                                                    name="bulk_title_two[]" type="text" placeholder="Title" disabled />
                                                <input class="form-control col-sm-6 rounded-left-0"
                                                    name="bulk_price_two[]" type="number" placeholder="Price"
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
                                                <!-- <input class="form-control col-sm-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-sm-6 rounded-right-0"
                                                    name="bulk_title_two[]" type="text" placeholder="Title" disabled />
                                                <input class="form-control col-sm-6 rounded-left-0"
                                                    name="bulk_price_two[]" type="number" placeholder="Price"
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
                                                <!-- <input class="form-control col-sm-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-sm-6 rounded-right-0"
                                                    name="bulk_title_two[]" type="text" placeholder="Title" disabled />
                                                <input class="form-control col-sm-6 rounded-left-0"
                                                    name="bulk_price_two[]" type="number" placeholder="Price"
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
                                                <!-- <input class="form-control col-sm-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-sm-6 rounded-right-0"
                                                    name="bulk_title_two[]" type="text" placeholder="Title" disabled />
                                                <input class="form-control col-sm-6 rounded-left-0"
                                                    name="bulk_price_two[]" type="number" placeholder="Price"
                                                    disabled />
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

                                    <div class="col-sm-6 border text-center pt-3 pb-3">
                                        <label class="text-center"> Regular Quantity </label>
                                        <div>
                                            <div class="mb-2 form-inline">
                                                <input class="form-control rounded-right-0 col-sm-4"
                                                    name="regular_title_three[]" type="text" placeholder="Title"
                                                    disabled />
                                                <input class="form-control col-sm-4 rounded-0"
                                                    name="regular_price_three[]" type="number" placeholder="Price"
                                                    disabled />
                                                <input class="form-control rounded-left-0 col-sm-4"
                                                    name="regular_quantity_three[]" type="number"
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
                                                    name="regular_title_three[]" type="text" placeholder="Title"
                                                    disabled />
                                                <input class="form-control col-sm-4 rounded-0"
                                                    name="regular_price_three[]" type="number" placeholder="Price"
                                                    disabled />
                                                <input class="form-control rounded-left-0 col-sm-4"
                                                    name="regular_quantity_three[]" type="number"
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
                                                    name="regular_title_three[]" type="text" placeholder="Title"
                                                    disabled />
                                                <input class="form-control col-sm-4 rounded-0"
                                                    name="regular_price_three[]" type="number" placeholder="Price"
                                                    disabled />
                                                <input class="form-control rounded-left-0 col-sm-4"
                                                    name="regular_quantity_three[]" type="number"
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
                                                    name="regular_title_three[]" type="text" placeholder="Title"
                                                    disabled />
                                                <input class="form-control col-sm-4 rounded-0"
                                                    name="regular_price_three[]" type="number" placeholder="Price"
                                                    disabled />
                                                <input class="form-control rounded-left-0 col-sm-4"
                                                    name="regular_quantity_three[]" type="number"
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
                                                    name="regular_title_three[]" type="text" placeholder="Title"
                                                    disabled />
                                                <input class="form-control col-sm-4 rounded-0"
                                                    name="regular_price_three[]" type="number" placeholder="Price"
                                                    disabled />
                                                <input class="form-control rounded-left-0 col-sm-4"
                                                    name="regular_quantity_three[]" type="number"
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
                                                <input class="form-control col-sm-6 rounded-right-0"
                                                    name="bulk_title_three[]" type="text" placeholder="Title"
                                                    disabled />
                                                <input class="form-control col-sm-6 rounded-left-0"
                                                    name="bulk_price_three[]" type="number" placeholder="Price"
                                                    disabled />
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
                                                <input class="form-control col-sm-6 rounded-right-0"
                                                    name="bulk_title_three[]" type="text" placeholder="Title"
                                                    disabled />
                                                <input class="form-control col-sm-6 rounded-left-0"
                                                    name="bulk_price_three[]" type="number" placeholder="Price"
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
                                                <!-- <input class="form-control col-sm-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-sm-6 rounded-right-0"
                                                    name="bulk_title_three[]" type="text" placeholder="Title"
                                                    disabled />
                                                <input class="form-control col-sm-6 rounded-left-0"
                                                    name="bulk_price_three[]" type="number" placeholder="Price"
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
                                                <!-- <input class="form-control col-sm-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-sm-6 rounded-right-0"
                                                    name="bulk_title_three[]" type="text" placeholder="Title"
                                                    disabled />
                                                <input class="form-control col-sm-6 rounded-left-0"
                                                    name="bulk_price_three[]" type="number" placeholder="Price"
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
                                                <!-- <input class="form-control col-sm-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-sm-6 rounded-right-0"
                                                    name="bulk_title_three[]" type="text" placeholder="Title"
                                                    disabled />
                                                <input class="form-control col-sm-6 rounded-left-0"
                                                    name="bulk_price_three[]" type="number" placeholder="Price"
                                                    disabled />
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

                                    <div class="col-sm-6 border text-center pt-3 pb-3">
                                        <label class="text-center"> Regular Quantity </label>
                                        <div>
                                            <div class="mb-2 form-inline">
                                                <input class="form-control rounded-right-0 col-sm-4"
                                                    name="regular_title_four[]" type="text" placeholder="Title"
                                                    disabled />
                                                <input class="form-control col-sm-4 rounded-0"
                                                    name="regular_price_four[]" type="number" placeholder="Price"
                                                    disabled />
                                                <input class="form-control rounded-left-0 col-sm-4"
                                                    name="regular_quantity_four[]" type="number"
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
                                                    name="regular_title_four[]" type="text" placeholder="Title"
                                                    disabled />
                                                <input class="form-control col-sm-4 rounded-0"
                                                    name="regular_price_four[]" type="number" placeholder="Price"
                                                    disabled />
                                                <input class="form-control rounded-left-0 col-sm-4"
                                                    name="regular_quantity_four[]" type="number"
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
                                                    name="regular_title_four[]" type="text" placeholder="Title"
                                                    disabled />
                                                <input class="form-control col-sm-4 rounded-0"
                                                    name="regular_price_four[]" type="number" placeholder="Price"
                                                    disabled />
                                                <input class="form-control rounded-left-0 col-sm-4"
                                                    name="regular_quantity_four[]" type="number"
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
                                                    name="regular_title_four[]" type="text" placeholder="Title"
                                                    disabled />
                                                <input class="form-control col-sm-4 rounded-0"
                                                    name="regular_price_four[]" type="number" placeholder="Price"
                                                    disabled />
                                                <input class="form-control rounded-left-0 col-sm-4"
                                                    name="regular_quantity_four[]" type="number"
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
                                                    name="regular_title_four[]" type="text" placeholder="Title"
                                                    disabled />
                                                <input class="form-control col-sm-4 rounded-0"
                                                    name="regular_price_four[]" type="number" placeholder="Price"
                                                    disabled />
                                                <input class="form-control rounded-left-0 col-sm-4"
                                                    name="regular_quantity_four[]" type="number"
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
                                                <input class="form-control col-sm-6 rounded-right-0"
                                                    name="bulk_title_four[]" type="text" placeholder="Title" disabled />
                                                <input class="form-control col-sm-6 rounded-left-0"
                                                    name="bulk_price_four[]" type="number" placeholder="Price"
                                                    disabled />
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
                                                <input class="form-control col-sm-6 rounded-right-0"
                                                    name="bulk_title_four[]" type="text" placeholder="Title" disabled />
                                                <input class="form-control col-sm-6 rounded-left-0"
                                                    name="bulk_price_four[]" type="number" placeholder="Price"
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
                                                <!-- <input class="form-control col-sm-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-sm-6 rounded-right-0"
                                                    name="bulk_title_four[]" type="text" placeholder="Title" disabled />
                                                <input class="form-control col-sm-6 rounded-left-0"
                                                    name="bulk_price_four[]" type="number" placeholder="Price"
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
                                                <!-- <input class="form-control col-sm-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-sm-6 rounded-right-0"
                                                    name="bulk_title_four[]" type="text" placeholder="Title" disabled />
                                                <input class="form-control col-sm-6 rounded-left-0"
                                                    name="bulk_price_four[]" type="number" placeholder="Price"
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
                                                <!-- <input class="form-control col-sm-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-sm-6 rounded-right-0"
                                                    name="bulk_title_four[]" type="text" placeholder="Title" disabled />
                                                <input class="form-control col-sm-6 rounded-left-0"
                                                    name="bulk_price_four[]" type="number" placeholder="Price"
                                                    disabled />
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

                                    <div class="col-sm-6 border text-center pt-3 pb-3">
                                        <label class="text-center"> Regular Quantity </label>
                                        <div>
                                            <div class="mb-2 form-inline">
                                                <input class="form-control rounded-right-0 col-sm-4"
                                                    name="regular_title_five[]" type="text" placeholder="Title"
                                                    disabled />
                                                <input class="form-control col-sm-4 rounded-0"
                                                    name="regular_price_five[]" type="number" placeholder="Price"
                                                    disabled />
                                                <input class="form-control rounded-left-0 col-sm-4"
                                                    name="regular_quantity_five[]" type="number"
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
                                                    name="regular_title_five[]" type="text" placeholder="Title"
                                                    disabled />
                                                <input class="form-control col-sm-4 rounded-0"
                                                    name="regular_price_five[]" type="number" placeholder="Price"
                                                    disabled />
                                                <input class="form-control rounded-left-0 col-sm-4"
                                                    name="regular_quantity_five[]" type="number"
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
                                                    name="regular_title_five[]" type="text" placeholder="Title"
                                                    disabled />
                                                <input class="form-control col-sm-4 rounded-0"
                                                    name="regular_price_five[]" type="number" placeholder="Price"
                                                    disabled />
                                                <input class="form-control rounded-left-0 col-sm-4"
                                                    name="regular_quantity_five[]" type="number"
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
                                                    name="regular_title_five[]" type="text" placeholder="Title"
                                                    disabled />
                                                <input class="form-control col-sm-4 rounded-0"
                                                    name="regular_price_five[]" type="number" placeholder="Price"
                                                    disabled />
                                                <input class="form-control rounded-left-0 col-sm-4"
                                                    name="regular_quantity_five[]" type="number"
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
                                                    name="regular_title_five[]" type="text" placeholder="Title"
                                                    disabled />
                                                <input class="form-control col-sm-4 rounded-0"
                                                    name="regular_price_five[]" type="number" placeholder="Price"
                                                    disabled />
                                                <input class="form-control rounded-left-0 col-sm-4"
                                                    name="regular_quantity_five[]" type="number"
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
                                                <input class="form-control col-sm-6 rounded-right-0"
                                                    name="bulk_title_five[]" type="text" placeholder="Title" disabled />
                                                <input class="form-control col-sm-6 rounded-left-0"
                                                    name="bulk_price_five[]" type="number" placeholder="Price"
                                                    disabled />
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
                                                <input class="form-control col-sm-6 rounded-right-0"
                                                    name="bulk_title_five[]" type="text" placeholder="Title" disabled />
                                                <input class="form-control col-sm-6 rounded-left-0"
                                                    name="bulk_price_five[]" type="number" placeholder="Price"
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
                                                <!-- <input class="form-control col-sm-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-sm-6 rounded-right-0"
                                                    name="bulk_title_five[]" type="text" placeholder="Title" disabled />
                                                <input class="form-control col-sm-6 rounded-left-0"
                                                    name="bulk_price_five[]" type="number" placeholder="Price"
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
                                                <!-- <input class="form-control col-sm-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-sm-6 rounded-right-0"
                                                    name="bulk_title_five[]" type="text" placeholder="Title" disabled />
                                                <input class="form-control col-sm-6 rounded-left-0"
                                                    name="bulk_price_five[]" type="number" placeholder="Price"
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
                                                <!-- <input class="form-control col-sm-4" name="fields[]" type="text"
                                                    placeholder="Quantity Available" /> -->
                                            </div>
                                            <div class="bulk-entry-1 mb-2 form-inline d-none">
                                                <input class="form-control col-sm-6 rounded-right-0"
                                                    name="bulk_title_five[]" type="text" placeholder="Title" disabled />
                                                <input class="form-control col-sm-6 rounded-left-0"
                                                    name="bulk_price_five[]" type="number" placeholder="Price"
                                                    disabled />
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
    function toggleMain(element, newf = true) {
        if (newf) {
            //let parentDiv = $(element).parent().parent().parent()
            // let origCop = $('#orig-cop').clone(true)
            // origCop.attr('id', '')

            // $($($(origCop.children()[2]).children()[1]).children()[0]).attr('id', '') // Clean Regular Fields
            // $($($(origCop.children()[3]).children()[1]).children()[0]).attr('id', '') // Clean Bulk Fields

            // parentDiv.append(origCop)

            $(element).parent().parent().next().find('input').removeAttr('disabled');
            $(element).parent().parent().next().removeClass('d-none');
            $(element).parent().addClass('d-none');

            //$(element).attr('onclick', `toggleMain(this, false)`)
            // $(element).removeClass('btn-add').addClass('btn-remove').removeClass(
            //     'btn-success').addClass('btn-danger').html(`<i class="las la-minus"></i>`);
        } else {
            // let parentDiv = $(element).parent().parent()
            // parentDiv.remove()
            $(element).parent().parent().addClass('d-none');
            $(element).parent().parent().find('input').attr('disabled', '');
            $(element).parent().parent().prev().find('.input-group-btn').removeClass('d-none');

            // if ($(element).parent().parent().next().hasClass('d-block')) {
            //     $(element).attr('onclick', `toggleMain(this, true)`)
            //     $(element).removeClass('btn-remove').addClass('btn-add').removeClass('btn-danger').addClass(
            //         'btn-success').html(`<i class="las la-plus"></i>`);
            // }
        }
    }
    // Block to handle main form repeaters


    // // Functions to handle Regular Quantity form repeaters
    // function toggleMain(element, newf = true) {
    //     if (newf) {
    //         let parentDiv = $(element).parent().parent().parent()
    //         let origCop = $(element).parent().parent().clone(true)
    //         origCop.find('input').val("")
    //         //origCop.attr('id', '')
    //         parentDiv.append(origCop)

    //         $(element).attr('onclick', `toggleMain(this, false)`)
    //         $(element).removeClass('btn-add').addClass('btn-remove').removeClass(
    //             'btn-success').addClass('btn-danger').html(`<i class="las la-minus"></i>`);
    //     } else {
    //         let nextDiv = $(element).parent().parent().next()
    //         $(element).parent().parent()
    //     }
    // }
    // // Functions to handle Regular Quantity form repeaters


    // Function to handle Bulk Quantity form repeaters
    function toggleBulkFields(element, newf = true) {
        if (newf) {
            let parentDiv = $(element).parent().parent().parent()
            let origCop = $(element).parent().parent().clone(true)
            origCop.find('input').val("").attr('required', '')
            $(element).parent().parent().find('input').attr('required', '')
            //origCop.attr('id', '')
            parentDiv.append(origCop)
            console.log($(".bulk-entry-1").index($(element).parent().parent()));

            $(element).attr('onclick', `toggleBulkFields(this, false)`)
            $(element).removeClass('btn-add').addClass('btn-remove').removeClass(
                'btn-success').addClass('btn-danger').html(`<i class="las la-minus"></i>`);
        } else {
            let nextDiv = $(element).parent().parent().next()
            nextDiv.find('input').removeAttr('required')
            nextDiv.remove()
            $(element).attr('onclick', `toggleMain(this, true)`)
            $(element).removeClass('btn-remove').addClass('btn-add').removeClass(
                'btn-danger').addClass('btn-success').html(`<i class="las la-plus"></i>`);
        }
    }
    // Function to handle Bulk Quantity form repeaters

    // Disable Input Elements for Inactive Form Tabs
    let activeForm = "";
    $('.nav-tabs a:first').click(function () {
        $("#form-type").val("simple")
        $("#simple").children('div').eq(0).find('input').removeAttr('disabled', '');
        $("#simple").children('div').eq(0).find('.input-group-btn').removeClass('d-none');
        $("#simple").children().not(':eq(0)').addClass('d-none')
        $("#advanced").find('input').attr('disabled', '');
    })

    $('.nav-tabs a:last').click(function () {
        $("#form-type").val("advanced")
        $("#advanced").children('div').eq(0).find('input').removeAttr('disabled', '');
        $("#advanced").children('div').eq(0).find('.input-group-btn').removeClass('d-none');
        $("#advanced").children().not(':eq(0)').addClass('d-none').find('input').val("")
        $("#simple").find('input').attr('disabled', '');
    })



    $(document).ready(function () {
        // Set required fields
        $("[name='title[]']").attr('required', 'true');
        $("[name='image[]']").attr('required', 'true');
        $("[name^='regular']").attr('required', 'true');

        // Check form validity and fire submit event
        let form = document.getElementById('add-dish');
        document.getElementById('submit-btn').onclick = function () {
            if (form.reportValidity()) {
                $('#add-dish').trigger('submit')
            }
        }

        // Attach dish form event listener
        $('#add-dish').submit(el => {
            el.preventDefault()
            addDish(el)
        });
    });

    // Add dish
    function addDish(el) {
        el.preventDefault()

        spin('vendor')
        offError('v-dish-error')

        let url = `{{ url('vendor/add-dish') }}`;
        let data = new FormData(el.target)

        goPost(url, data)
            .then(res => {
                spin('vendor')

                if (handleFormRes(res, false, false, 'modal-body')) {
                    console.log(res)
                    showAlert(true, res.message);
                    // setTimeout(() => {
                    //     $('#add-dish').trigger('reset');
                    // }, 2000)
                }
            })
            .catch(err => {
                spin('vendor')
                handleFormRes(err, 'v-dish-error');
            })
    }

</script>
