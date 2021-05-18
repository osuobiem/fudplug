<div class="img-container px-md-0 col-md-7">
    @php $photo = Storage::url('vendor/dish/'.$dish->image) @endphp
    <div class="item-view-image" style="background: url('{{ $photo }}')"></div>
</div>
<div class="col-md-5 pl-md-0">
    <form id="order-form">
        @csrf
        @if ($dish->type == 'simple')
            <div id="basics">
                <div>
                    <h3 class="font-weight-semi-bold text-center text-lg-left mb-0 pb-1"
                        style="border-bottom: dashed 1px #d3d3d3;">{{ ucfirst($dish->title) }} </h3>
                </div>

                <div id="basicsAccordion">
                    <div class="box mb-2">
                        <div id="basicsHeadingOne">
                            <h5 class="mb-0">
                                <button type="button"
                                    class="shadow-none btn btn-block d-flex justify-content-between card-btn px-1 py-2 font-weight-bold"
                                    data-toggle="collapse" data-target="#basicsCollapseOne" aria-expanded="false"
                                    aria-controls="basicsCollapseOne">
                                    Regular Order
                                    <span class="card-btn-arrow">
                                        <span class="la la-chevron-down" style="color: var(--i-primary)"></span>
                                    </span>
                                </button>
                            </h5>
                        </div>
                        <div id="basicsCollapseOne" class="collapse show" aria-labelledby="basicsHeadingOne"
                            data-parent="#basicsAccordion" style="">
                            <div class="card-body p-0 text-muted" style="font-size: large;">
                                <ul id="price-type" id="item" class="list-group box-body generic-scrollbar"
                                    style="max-height: 250px; overflow: auto;">
                                    <li class="list-group-item pt-0 col">
                                        <div class="float-left col-4">
                                            <small>Price</small>
                                            <p class="mt-0">
                                                <span class="float-left"
                                                    style="font-size: larger; color: var(--i-primary);">
                                                    ₦{{ $price }}</span>
                                            </p>
                                            <input name="order_detail[]" type="hidden" value="" disabled>
                                        </div>
                                        <div class="float-right col-6 offset-2" style="margin-top: 8px;">
                                            <span class="badge item-qty-badge text-wrap float-right">
                                                {{ $quantity }} {{ $qty_title }} left</span>
                                            @if (in_array($dish->id, $basket_items))
                                                <p class="text-right">
                                                    <span class="font-weight-bold font-italic"><small>Item
                                                            already in
                                                            basket.</small></span>
                                                </p>
                                            @else
                                                <div class="input-group qty-field" style="justify-content: flex-end;">
                                                    <span class="input-group-btn">
                                                        <button onclick="clicked(event, this);" type="button bordered"
                                                            class="btn btn-sm btn-number rounded-right-0 qty-btn item-manip-btn"
                                                            disabled="disabled" data-type="minus"
                                                            style="padding: 0px 8px;">
                                                            -
                                                        </button>
                                                    </span>
                                                    <input type="text" name="order_quantity[]"
                                                        onkeydown="keydown(event)" onchange="change(event, this)"
                                                        onfocus="focusin(event, this)"
                                                        class="form-control rounded-left-0 rounded-right-0 form-control-sm qty-input item-manip-input"
                                                        value="0" min="0" max="{{ $quantity }}"
                                                        style="margin-top: 3px;" id="item-{{ $dish->id }}" data-order-type="regular" disabled>
                                                    <span class="input-group-btn">
                                                        <button onclick="clicked(event, this);" type="button"
                                                            class="btn btn-sm btn-number rounded-left-0 qty-btn item-manip-btn"
                                                            data-type="plus">
                                                            +
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

                <div>
                    <h3 class="font-weight-semi-bold text-center text-lg-left mb-0 pb-1"
                        style="border-bottom: dashed 1px #d3d3d3;">{{ ucfirst($dish->title) }} </h3>
                </div>
                <div id="basicsAccordion">

                    <div class="box mb-2">
                        <div id="basicsHeadingOne">
                            <h5 class="mb-0">
                                <button type="button"
                                    class="shadow-none btn btn-block d-flex justify-content-between card-btn px-1 py-2 font-weight-bold"
                                    data-toggle="collapse" data-target="#basicsCollapseOne" aria-expanded="false"
                                    aria-controls="basicsCollapseOne">
                                    Regular Order
                                    <span class="card-btn-arrow">
                                        <span class="la la-chevron-down" style="color: var(--i-primary)"></span>
                                    </span>
                                </button>
                            </h5>
                        </div>
                        <div id="basicsCollapseOne" class="collapse show" aria-labelledby="basicsHeadingOne"
                            data-parent="#basicsAccordion" style="">
                            <div class="card-body p-0 text-muted" style="font-size: large;">

                                <ul id="price-type" class="list-group box-body generic-scrollbar"
                                    style="max-height: 250px; overflow: auto;">
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($regular_qty as $key => $qty)
                                        <li class="list-group-item pt-0 col">
                                            <div class="float-left col-4">
                                                <small class="text-dark"
                                                    style="font-size: 13px;">{{ $qty->title }}</small>
                                                <p class="m-0">
                                                    <span class="float-left" style="color: var(--i-primary); font-size: larger;width: 156%;
                                                                    word-wrap: break-word;">
                                                        ₦{{ $qty->price }}</span>
                                                </p>
                                                <input name="order_detail[]" type="hidden"
                                                    value="['regular','{{ $key }}']" disabled>
                                            </div>
                                            <div class="float-right col-6 offset-2" style="margin-top: 8px;">
                                                <span class="badge item-qty-badge text-wrap float-right">
                                                    {{ $qty->quantity }} {{ $qty->qty_title }} left</span>


                                                @if (!empty($basket_items) && array_key_exists('item' . $dish->id, $basket_items))
                                                    @if (in_array($key, $basket_items['item' . $dish->id]['regular_items']))
                                                        <p class="text-right">
                                                            <span class="font-weight-bold font-italic"><small>Item
                                                                    already in
                                                                    basket.</small></span>
                                                        </p>
                                                    @else
                                                        <div class="input-group qty-field"
                                                            style="justify-content: flex-end;">
                                                            <span class="input-group-btn">
                                                                <button onclick="clicked(event, this);"
                                                                    type="button bordered"
                                                                    class="btn btn-sm btn-number rounded-right-0 qty-btn item-manip-btn"
                                                                    disabled="disabled" data-type="minus"
                                                                    style="padding: 0px 8px;">
                                                                    -
                                                                </button>
                                                            </span>
                                                            <input type="text" onkeydown="keydown(event)"
                                                                onchange="change(event, this)"
                                                                onfocus="focusin(event, this)" name="order_quantity[]"
                                                                id="item-{{ $dish->id }}-{{ $key }}"
                                                                data-order-type="regular"
                                                                class="form-control rounded-left-0 rounded-right-0 form-control-sm qty-input item-manip-input"
                                                                value="0" min="0" max="{{ $qty->quantity }}"
                                                                style="margin-top: 3px;" disabled>
                                                            <span class="input-group-btn">
                                                                <button onclick="clicked(event, this);" type="button"
                                                                    class="btn btn-sm btn-number rounded-left-0 qty-btn item-manip-btn"
                                                                    data-type="plus">
                                                                    +
                                                                </button>
                                                            </span>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="input-group qty-field"
                                                        style="justify-content: flex-end;">
                                                        <span class="input-group-btn">
                                                            <button onclick="clicked(event, this);"
                                                                type="button bordered"
                                                                class="btn btn-sm btn-number rounded-right-0 qty-btn item-manip-btn"
                                                                disabled="disabled" data-type="minus"
                                                                style="padding: 0px 8px;">
                                                                -
                                                            </button>
                                                        </span>
                                                        <input type="text" onkeydown="keydown(event)"
                                                            onchange="change(event, this)"
                                                            onfocus="focusin(event, this)" name="order_quantity[]"
                                                            id="item-{{ $dish->id }}-{{ $key }}"
                                                            class="form-control rounded-left-0 rounded-right-0 form-control-sm qty-input item-manip-input"
                                                            value="0" min="0" max="{{ $qty->quantity }}"
                                                            style="margin-top: 3px;" data-order-type="regular" disabled>
                                                        <span class="input-group-btn">
                                                            <button onclick="clicked(event, this);" type="button"
                                                                class="btn btn-sm btn-number rounded-left-0 qty-btn item-manip-btn"
                                                                data-type="plus">
                                                                +
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
            <div class="col-md-12">
                <button type="submit" id="regular-order-btn"  class="btn btn-primary btn-lg btn-block font-weight-bold" disabled style="border-radius: unset; font-size: 15px;">
                    <span id="regular-order-txt">Add to basket</span>
                    <div class="spinner-border spinner-border-sm btn-pr" id="regular-order-spinner"
                        style="display: none;" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <span id="regular-final-price" class="float-right" data-item-subtotal=""
                        style="position: absolute;right: 15px;">₦0.00</span>
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        $("#order-form").submit(function(el) {
            addToBasket(el, '{{ $dish->vendor_id }}');
        });
    });

    // Place order
    function addToBasket(el, vendorId) {
        spin('regular-order');
        $("#regular-order-btn").attr('disabled', 'disabled');

        el.preventDefault()

        offError('pr-update-error')

        let url = `{{ url('user/add-to-basket') }}`;
        let data = new FormData(el.target);
        data.append('vendor_id', '{{ $dish->vendor_id }}');
        data.append('item_id', '{{ $dish->id }}');
        data.append('order_type', '{{ $dish->type }}');


        goPost(url, data)
            .then(res => {
                spin('regular-order');
                $("#regular-order-btn").removeAttr('disabled');

                if (handleFormRes(res)) {
                    if (res.type == "error") {
                        handleValidateErr(res);
                    } else {
                        showAlert(true, res.message);
                        // Load user basket details
                        getBasket();
                        // Close modal
                        $("#order-modal").modal('hide');

                        // Reset regular price (to be reflected on "add to basket button")
                        prices = resetOrderPrice("regular");
                    }
                }
            })
            .catch(err => {
                spin('regular-order');
                $("#regular-order-btn").removeAttr('disabled');

                handleFormRes(err, 'pr-update-error');
            })
    }

</script>
