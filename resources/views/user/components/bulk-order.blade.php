<div class="img-container pl-md-0 col-md-7">
    <img id="image" class="img-edit rounded order-img" src="{{Storage::url('vendor/dish/'.$dish->image)}}">
</div>
<div class="col-md-5">
    <form id="bulk-order-form">
        @csrf
        @if($dish->type == "simple")
        <div id="basics">
            <div class="mb-5 pt-3 text-lg-left text-center">
                <div class="float-left">
                    <h4 class="font-weight-semi-bold"> {{ucfirst($dish->title)}} </h4>
                </div>
            </div>

            <div id="basicsAccordion">
                <div class="box shadow-sm border rounded bg-white mb-2">
                    <div id="basicsHeadingOne">
                        <h5 class="mb-0">
                            <button type="button"
                                class="shadow-none btn btn-block d-flex justify-content-between card-btn p-3 collapsed font-weight-bold"
                                data-toggle="" data-target="#basicsCollapseOne" aria-expanded="false"
                                aria-controls="basicsCollapseOne">
                                Regular Quantity
                            </button>
                        </h5>
                    </div>
                    <div id="basicsCollapseOne" class="collapse show" aria-labelledby="basicsHeadingOne"
                        data-parent="#basicsAccordion" style="">
                        <div class="card-body border-top p-2 text-muted" style="font-size: large;">
                            <ul id="bulk-price-type" id="item" class="list-group box-body generic-scrollbar"
                                style="max-height: 250px; overflow: auto;">
                                <li class="list-group-item pt-0">
                                    <div class="float-left col-4">
                                        <small>Price</small>
                                        <p class="mt-0">
                                            <span class="float-left text-danger" style="font-size: larger;">
                                                ₦{{$price}}</span>
                                            <!-- <span class="badge badge-secondary float-right">
                                                {{$quantity}} left</span> -->
                                        </p>
                                        <input name="order_detail[]" type="hidden" value="" disabled>
                                    </div>
                                    <div class="float-right col-6 offset-2 mt-4">
                                        @if(in_array($dish->id, $basket_items))
                                        <span class="font-weight-bold font-italic"><small>Item
                                                already in
                                                basket.</small></span>
                                        @else
                                        <div class="input-group qty-field">
                                            <span class="input-group-btn">
                                                <button onclick="clicked(event, this);" type="button bordered"
                                                    class="btn btn-sm btn-secondary btn-number rounded-right-0 qty-btn"
                                                    disabled="disabled" data-type="minus">
                                                    <span class="la la-minus"></span>
                                                </button>
                                            </span>
                                            <input type="text" name="order_quantity[]" onkeydown="keydown(event)"
                                                onchange="change(event, this)" onfocus="focusin(event, this)"
                                                class="form-control rounded-left-0 rounded-right-0 form-control-sm qty-input"
                                                data-order-type="bulk" value="0" min="0" max="{{$quantity}}"
                                                style="margin-top: 4px;" id="item-{{$dish->id}}" disabled>
                                            <span class="input-group-btn">
                                                <button onclick="clicked(event, this);" type="button"
                                                    class="btn btn-sm btn-secondary btn-number rounded-left-0 qty-btn"
                                                    data-type="plus">
                                                    <span class="la la-plus"></span>
                                                </button>
                                            </span>
                                        </div>
                                        @endif
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        @else
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
                            <button type="button"
                                class="shadow-none btn btn-block d-flex justify-content-between card-btn p-3 collapsed font-weight-bold"
                                data-toggle="collapse" data-target="#basicsCollapseOne" aria-expanded="false"
                                aria-controls="basicsCollapseOne">
                                Bulk Quantity
                                <span class="card-btn-arrow">
                                    <span class="la la-chevron-down"></span>
                                </span>
                            </button>
                        </h5>
                    </div>
                    <div id="basicsCollapseOne" class="collapse show" aria-labelledby="basicsHeadingOne"
                        data-parent="#basicsAccordion" style="">
                        <div class="card-body border-top p-2 text-muted" style="font-size: large;">

                            <ul id="bulk-price-type" class="list-group box-body generic-scrollbar"
                                style="max-height: 250px; overflow: auto;">
                                @php
                                $i = 1;
                                @endphp
                                @foreach($bulk_qty as $key=>$qty)
                                <li class="list-group-item pt-0 col">
                                    <div class="float-left col-4">
                                        <small>{{$qty->title}} <strong>Litres</strong></small>
                                        <p class="mt-0">
                                            <span class="float-left text-danger" style="font-size: larger;">
                                                ₦{{$qty->price}}</span>
                                        </p>
                                        <input name="order_detail[]" type="hidden" value="['bulk','{{$key}}']" disabled>
                                    </div>
                                    <div class="float-right col-6 offset-2 mt-4">
                                        @if(!empty($basket_items) &&
                                        array_key_exists('item'.$dish->id, $basket_items))
                                        @if(in_array($key,
                                        $basket_items['item'.$dish->id]['bulk_items']))
                                        <span class="font-weight-bold font-italic"><small>Item
                                                already in
                                                basket.</small></span>
                                        @else
                                        <div class="input-group qty-field">
                                            <span class="input-group-btn">
                                                <button onclick="clicked(event, this);" type="button bordered"
                                                    class="btn btn-sm btn-secondary btn-number rounded-right-0 qty-btn"
                                                    disabled="disabled" data-type="minus">
                                                    <span class="la la-minus"></span>
                                                </button>
                                            </span>
                                            <input type="text" onkeydown="keydown(event)" onchange="change(event, this)"
                                                onfocus="focusin(event, this)" name="order_quantity[]"
                                                id="item-{{$dish->id}}-{{$key}}"
                                                class="form-control rounded-left-0 rounded-right-0 form-control-sm qty-input"
                                                data-order-type="bulk" value="0" min="0" max="{{$qty->quantity}}"
                                                style="margin-top: 4px;" disabled>
                                            <span class="input-group-btn">
                                                <button onclick="clicked(event, this);" type="button"
                                                    class="btn btn-sm btn-secondary btn-number rounded-left-0 qty-btn"
                                                    data-type="plus">
                                                    <span class="la la-plus"></span>
                                                </button>
                                            </span>
                                        </div>
                                        @endif
                                        @else
                                        <div class="input-group qty-field">
                                            <span class="input-group-btn">
                                                <button onclick="clicked(event, this);" type="button bordered"
                                                    class="btn btn-sm btn-secondary btn-number rounded-right-0 qty-btn"
                                                    disabled="disabled" data-type="minus">
                                                    <span class="la la-minus"></span>
                                                </button>
                                            </span>
                                            <input type="text" onkeydown="keydown(event)" onchange="change(event, this)"
                                                onfocus="focusin(event, this)" name="order_quantity[]"
                                                id="item-{{$dish->id}}-{{$key}}"
                                                class="form-control rounded-left-0 rounded-right-0 form-control-sm qty-input"
                                                data-order-type="bulk" value="0" min="0" max="{{$qty->quantity}}"
                                                style="margin-top: 4px;" disabled>
                                            <span class="input-group-btn">
                                                <button onclick="clicked(event, this);" type="button"
                                                    class="btn btn-sm btn-secondary btn-number rounded-left-0 qty-btn"
                                                    data-type="plus">
                                                    <span class="la la-plus"></span>
                                                </button>
                                            </span>
                                        </div>
                                        @endif
                                    </div>
                                </li>
                                @php
                                $i++;
                                @endphp
                                @endforeach
                            </ul>

                        </div>
                    </div>
                </div>

            </div>

        </div>
        @endif
        <div class="row">
            <div class="col-md-12 mt-xs-2">
                <button type="submit" id="bulk-order-btn" class="btn btn-sm btn-primary btn-block font-weight-bold"
                    data-attach-loading="true" disabled>
                    <span id="bulk-order-txt">Add to basket</span>
                    <div class="spinner-border spinner-border-sm btn-pr" id="bulk-order-spinner" style="display: none;"
                        role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <span id="bulk-final-price" class="float-right" data-item-subtotal="">₦0.00</span>
                </button>

            </div>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        $("#bulk-order-form").submit(function (el) {
            addToBasket(el, '{{$dish->vendor_id}}');
        });
    });

    // Place order
    function addToBasket(el, vendorId) {
        spin('bulk-order');
        $("#bulk-order-btn").attr('disabled', 'disabled');

        el.preventDefault()

        let url = `{{url('user/add-to-basket')}}`;
        let data = new FormData(el.target);
        data.append('vendor_id', '{{$dish->vendor_id}}');
        data.append('item_id', '{{$dish->id}}');
        data.append('order_type', '{{$dish->type}}');


        goPost(url, data)
            .then(res => {
                spin('bulk-order');
                $("#bulk-order-btn").removeAttr('disabled');

                if (handleFormRes(res)) {
                    if (res.type == "error") {
                        handleValidateErr(res);
                    } else {
                        showAlert(true, res.message);

                        // Load user basket details
                        getBasket(1);

                        // Close modal
                        $("#order-modal").modal('hide');

                        // Reset bulk price (to be reflected on "add to basket button")
                        bulkPrices = resetOrderPrice("bulk");
                    }
                }
            })
            .catch(err => {
                spin('bulk-order');
                $("#bulk-order-btn").removeAttr('disabled');
                showAlert(false, "Oops! Something's not right. Try again");
            })
    }

</script>
