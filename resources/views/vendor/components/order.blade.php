@if(empty($order_pag) && $curr_page == 1)
<div style="height: 109px;" class="pt-5 bg-light">
    <p>No Orders yet!</p>
</div>
@elseif(empty($order_pag) && $curr_page > 1)

@else
@foreach($order_pag as $order_key=>$order)
<div>
    <!-- <div class="mb-5 pt-3 text-lg-left text-center">
                <div class="float-left">
                    <h4 class="font-weight-semi-bold">
                    </h4>
                </div>
            </div> -->

    <div id="basicsAccordion">
        <div class="box shadow border rounded bg-white mb-2">
            <div id="basicsHeadingOne">
                <h5 class="mb-0">
                    <a href="javascript:void(0)" onclick="getDetail('{{$order->order_id}}')" type="button"
                        class="shadow-none d-flex p-3 collapsed font-weight-bold" data-toggle=""
                        data-target="#basicsCollapseOne" aria-expanded="false" aria-controls="basicsCollapseOne">
                        <div class="media">
                            <div class="u-avatar mr-1">
                                <img class="img-fluid rounded-circle"
                                    src="/storage/user/profile/{{$order->profile_image}}" alt="Image Description">
                            </div>
                            <div class="media-body mt-0">
                                <div class="text-left">
                                    @<span>{{$order->username}}</span>
                                    <span
                                        class="badge {{$order->order_status['colour']}} ml-1">{{$order->order_status['status']}}</span>
                                </div>
                                <div class="small text-left">
                                    @php
                                    $time = strtotime($order->date_time);
                                    $time = date('h:m a', $time);
                                    @endphp
                                    {{$time}}
                                </div>
                            </div>
                        </div>
                    </a>
                </h5>
            </div>
            <div id="basicsCollapseOne" class="d-none" aria-labelledby="basicsHeadingOne" data-parent="#basicsAccordion"
                style="">
                <div class="card-body border-top p-2 text-muted" style="font-size: large;">
                    <ul id="basket-price-type" id="item" class="list-group box-body generic-scrollbar"
                        style="max-height: 250px; overflow: auto;">
                        @foreach($order['title'] as $title_key=>$title)
                        @if($order['order_type'][$title_key] == "simple")
                        <li class="list-group-item pt-0 col">
                            @php
                            $actual_detail = json_decode($order['quantity'][$title_key], true);
                            $order_qty = json_decode($order['order_detail'][$title_key])[0];
                            @endphp
                            <div class="media mt-2">
                                <div class="u-avatar">
                                    <img class="img-fluid rounded-circle"
                                        src="/storage/vendor/dish/{{$order['image'][$title_key]}}"
                                        alt="Image Description">
                                </div>
                                <div class="media-body pl-4">
                                    <div class="text-left">
                                        @if($order_key < 1) <small>{{$title}}</small>
                                            @else
                                            <small>{{$title}}</small>
                                            @endif
                                            <p class="mb-0 mt-0" style="font-size:15px;">
                                                <span class="text-danger pr-2 border-right">
                                                    ₦{{$actual_detail['price']}}
                                                </span>
                                                <span class="text-dark pl-2">
                                                    <strong>Qty: </strong>{{$order_qty}}
                                                </span>
                                            </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @else

                        @php
                        $i = 1;

                        $regular_qty = json_decode($order['quantity'][$title_key], true)['regular'];
                        $bulk_qty = json_decode($order['quantity'][$title_key], true)['bulk'];
                        $order_detail = json_decode($order['order_detail'][$title_key], true);

                        @endphp
                        @foreach($order_detail as $key=>$detail)
                        @php
                        $index = $detail[1];
                        $type = $detail[0];
                        @endphp
                        @if($type == "regular")
                        @php
                        $qty = json_decode($regular_qty, true)[$index];
                        @endphp
                        <li id="price-type" class="list-group-item pt-0 col">
                            <div class="media mt-2">
                                <div class="u-avatar">
                                    <img class="img-fluid rounded-circle"
                                        src="/storage/vendor/dish/{{$order['image'][$title_key]}}"
                                        alt="Image Description">
                                </div>
                                <div class="media-body pl-4">
                                    <div class="text-left">
                                        <small style="">{{$title}}
                                            ({{$qty['title']}})</small>
                                        <p class="mb-0 mt-0" style="font-size:15px;">
                                            <span class="text-danger pr-3 border-right">
                                                ₦{{$qty['price']}}
                                            </span>
                                            <span class="text-dark pl-3">
                                                <strong>Qty: </strong>{{$detail[2]}}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @else
                        @php
                        $qty = json_decode($bulk_qty, true)[$index];
                        @endphp
                        <li id="price-type" class="list-group-item pt-0 col">
                            <div class="media mt-2">
                                <div class="u-avatar">
                                    <img class="img-fluid rounded-circle"
                                        src="/storage/vendor/dish/{{$order['image'][$title_key]}}"
                                        alt="Image Description">
                                </div>
                                <div class="media-body pl-4">
                                    <div class="text-left">
                                        <small style="">{{$title}}
                                            ({{$qty['title']}} <strong>Litres</strong>)</small>
                                        <p class="mb-0 mt-0" style="font-size:15px;">
                                            <span class="text-danger pr-3 border-right">
                                                ₦{{$qty['price']}}
                                            </span>
                                            <span class="text-dark pl-3">
                                                <strong>Qty: </strong>{{$detail[2]}}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endif
                        @php
                        $i++;
                        @endphp
                        @endforeach

                        @endif
                        @endforeach
                    </ul>
                </div>
                @if($order->order_status['status'] == "Pending")
                <!-- <div class="card-footer border-top p-0 text-muted"> -->
                <!-- <a href="javascript:void(0);" onclick="cancelOrder('{{$order->order_id}}')"
                                class="btn btn-sm"><i class="las la-times"></i>&nbsp;Cancel
                                order</a> -->
                <div class="card-footer border-top p-0 text-muted btn-group btn-group-sm col-12" role="group"
                    aria-label="Basic example">
                    <button type="button" class="btn text-danger" onclick="rejectOrder('{{$order->order_id}}')"><i
                            class="las la-times"></i>&nbsp;Reject</button>
                    <button type="button" class="btn border-left border-right text-success"
                        onclick="acceptOrder('{{$order->order_id}}')"><i class="las la-check"></i>&nbsp;Accept</button>
                    <button type="button" class="btn text-primary"><i class="las la-phone"></i>&nbsp;Contact</button>
                </div>
                <!-- </div> -->
                @endif
            </div>
        </div>

    </div>

</div>
@endforeach
@endif
