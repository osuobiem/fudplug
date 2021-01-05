<style>
    #basics {
        height: 379px !important;
    }

    @media(max-width: 767px) {
        #basics {
            height: 290px !important;
        }

        .mt-xs-2 {
            margin-top: 8px;
        }
    }

    @media(min-width: 1024px) {
        .qty-field {}
    }

    .qty-input {
        height: 29px;
        margin-top: 1px;
    }

</style>

<div class="modal fade" id="regular-order-modal" tabindex="-1" data-backdrop="static" role="dialog"
    aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 pb-3">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="img-container pl-md-0 col-md-7">
                        <img id="image" class="img-edit rounded order-img"
                            src="{{Storage::url('vendor/dish/'.$dish->image)}}">
                    </div>
                    <div class="col-md-5">
                        <form id="order-form">
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
                                                    data-toggle="" data-target="#basicsCollapseOne"
                                                    aria-expanded="false" aria-controls="basicsCollapseOne">
                                                    Regular Quantity
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="basicsCollapseOne" class="collapse show"
                                            aria-labelledby="basicsHeadingOne" data-parent="#basicsAccordion" style="">
                                            <div class="card-body border-top p-2 text-muted" style="font-size: large;">
                                                <ul id="price-type" id="item"
                                                    class="list-group box-body generic-scrollbar"
                                                    style="max-height: 250px; overflow: auto;">
                                                    <li class="list-group-item pt-0">
                                                        <div class="float-left col-4">
                                                            <small>Price</small>
                                                            <p class="mt-0">
                                                                <span class="float-left text-danger"
                                                                    style="font-size: larger;">
                                                                    ₦{{$price}}</span>
                                                                <!-- <span class="badge badge-secondary float-right">
                                                                {{$quantity}} left</span> -->
                                                            </p>
                                                            <input name="order_detail[]" type="hidden" value=""
                                                                disabled>
                                                        </div>
                                                        <div class="float-right col-7 offset-1 mt-4">
                                                            <div class="input-group qty-field">
                                                                <span class="input-group-btn">
                                                                    <button onclick="clicked(event, this);"
                                                                        type="button bordered"
                                                                        class="btn btn-sm btn-secondary btn-number rounded-right-0"
                                                                        disabled="disabled" data-type="minus">
                                                                        <span class="la la-minus"></span>
                                                                    </button>
                                                                </span>
                                                                <input type="text" name="order_quantity[]"
                                                                    onkeydown="keydown(event)"
                                                                    onchange="change(event, this)"
                                                                    onfocus="focusin(event, this)"
                                                                    class="form-control rounded-left-0 rounded-right-0 form-control-sm qty-input"
                                                                    value="0" min="0" max="{{$quantity}}" disabled>
                                                                <span class="input-group-btn">
                                                                    <button onclick="clicked(event, this);"
                                                                        type="button"
                                                                        class="btn btn-sm btn-secondary btn-number rounded-left-0"
                                                                        data-type="plus">
                                                                        <span class="la la-plus"></span>
                                                                    </button>
                                                                </span>
                                                            </div>
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
                                            aria-labelledby="basicsHeadingOne" data-parent="#basicsAccordion" style="">
                                            <div class="card-body border-top p-2 text-muted" style="font-size: large;">

                                                <ul id="price-type" class="list-group box-body generic-scrollbar"
                                                    style="max-height: 250px; overflow: auto;">
                                                    @php
                                                    $i = 1;
                                                    @endphp
                                                    @foreach($regular_qty as $key=>$qty)
                                                    <li id="price-type" class="list-group-item pt-0 col">
                                                        <div class="float-left col-4">
                                                            <small>{{$qty->title}}</small>
                                                            <p class="mt-0">
                                                                <span class="float-left text-danger"
                                                                    style="font-size: larger;">
                                                                    ₦{{$qty->price}}</span>
                                                                <!-- {{$qty->quantity}} left -->
                                                            </p>
                                                            <input name="order_detail[]" type="hidden"
                                                                value="['regular','{{$key}}']" disabled>
                                                        </div>
                                                        <div class="float-right col-7 offset-1 mt-4">
                                                            <div class="input-group qty-field">
                                                                <span class="input-group-btn">
                                                                    <button onclick="clicked(event, this);"
                                                                        type="button bordered"
                                                                        class="btn btn-sm btn-secondary btn-number rounded-right-0"
                                                                        disabled="disabled" data-type="minus">
                                                                        <span class="la la-minus"></span>
                                                                    </button>
                                                                </span>
                                                                <input type="text" onkeydown="keydown(event)"
                                                                    onchange="change(event, this)"
                                                                    onfocus="focusin(event, this)"
                                                                    name="order_quantity[]"
                                                                    class="form-control rounded-left-0 rounded-right-0 form-control-sm qty-input"
                                                                    value="0" min="0" max="{{$qty->quantity}}">
                                                                <span class="input-group-btn">
                                                                    <button onclick="clicked(event, this);"
                                                                        type="button"
                                                                        class="btn btn-sm btn-secondary btn-number rounded-left-0"
                                                                        data-type="plus">
                                                                        <span class="la la-plus"></span>
                                                                    </button>
                                                                </span>
                                                            </div>
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
                                    <button type="submit" id="order-btn"
                                        class="btn btn-sm btn-primary btn-block font-weight-bold"
                                        data-attach-loading="true" disabled>
                                        Add to basket <span id="final-price" class="float-right"
                                            data-item-subtotal="">₦0.00</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<span class="d-none" data-toggle="modal" href="#loginModal" id="login-pop"></span>

<script>
    /*********************************** Quantity input script **************************************/
    $(document).ready(function () {
        $("#order-form").submit(function (el) {
            addToBasket(el, '{{$dish->vendor_id}}');
        });
    });

    function clicked(e, element) {
        e.preventDefault();
        fieldName = $(element).attr('data-field');
        type = $(element).attr('data-type');
        var input = $(element).parent().parent().find('input');
        var currentVal = parseInt(input.val());
        if (!isNaN(currentVal)) {
            if (type == 'minus') {

                if (currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                }
                if (parseInt(input.val()) == input.attr('min')) {
                    $(element).attr('disabled', true);
                }

            } else if (type == 'plus') {

                if (currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();
                }
                if (parseInt(input.val()) == input.attr('max')) {
                    $(element).attr('disabled', true);
                }

            }
        } else {
            input.val(0);
        }
    }

    function focusin(e, element) {
        $(element).data('oldValue', $(element).val());
    }

    function change(e, element) {
        minValue = parseInt($(element).attr('min'));
        maxValue = parseInt($(element).attr('max'));
        valueCurrent = parseInt($(element).val());

        // Compute total amount and bind to order button. Also disable and enable order button
        bindQtyPrice(element);

        // Disable and enable details input field
        handleDetailInput(element);

        name = $(element).attr('name');
        if (valueCurrent >= minValue) {
            // $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
            $(element).prev().find('button').removeAttr('disabled');
        } else {
            alert('Sorry, the minimum value was reached');
            $(element).val($(element).data('oldValue'));
        }


        if (valueCurrent <= maxValue) {
            // $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
            $(element).next().find('button').removeAttr('disabled');
        } else {
            alert('Sorry, the maximum value was reached');
            $(element).val($(this).data('oldValue'));
        }
    }

    function keydown(e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
            // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode >
                105)) {
            e.preventDefault();
        }
    }


    /****** Initiate price input field state ***************/
    packCount = $("#price-type li").length;
    prices = [];
    for (let i = 0; i < packCount; i++) {
        prices[i] = 0;
    }
    /****** Initiate price input field state ***************/

    // Function to compute total amount and bind to order button. Also disable and enable order button
    function bindQtyPrice(element) {
        let index = $(element).parent().parent().parent().index();
        let price = Number($(element).parent().parent().prev().find('span').text().replace('₦', '').trim());
        let qty = $(element).val();
        let finalTotal = (price * qty);
        prices[index] = finalTotal;
        finalTotal = prices.reduce((a, b) => a + b);

        if (finalTotal < 1) {
            $("#final-price").text('₦' + String(finalTotal.toFixed(2)));
            $("#order-btn").attr('disabled', '');
        } else {
            $("#final-price").text('₦' + String(finalTotal.toFixed(2)));
            $("#order-btn").removeAttr('disabled');
        }
    }

    // Function to disable and enable details input field
    function handleDetailInput(element) {
        valueCurrent = parseInt($(element).val());
        if (valueCurrent < 1) {
            $(element).parent().parent().prev().find('input').attr('disabled', '');
            $(element).attr('disabled', '');
        } else {
            $(element).parent().parent().prev().find('input').removeAttr('disabled');
            $(element).removeAttr('disabled');
        }
    }

    // Place order
    function addToBasket(el, vendorId) {
        el.preventDefault()

        // spin('profile')
        offError('pr-update-error')

        let url = `{{url('user/place-order')}}`;
        url += '/' + vendorId;
        let data = new FormData(el.target);
        data.append('vendor_id', '{{$dish->vendor_id}}');
        data.append('item_id', '{{$dish->id}}');
        data.append('order_type', '{{$dish->type}}');


        goPost(url, data)
            .then(res => {
                // spin('profile')

                if (handleFormRes(res)) {
                    showAlert(true, res.message);
                }
            })
            .catch(err => {
                // spin('profile');
                handleFormRes(err, 'pr-update-error');
            })
    }



    /*********************************** Quantity input script **************************************/

</script>
