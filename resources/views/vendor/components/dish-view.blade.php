<div class="modal fade" id="dish-view-modal" tabindex="-1" data-backdrop="static" role="dialog"
    aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">{{ucfirst($dish->title)}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body row">
                <div class="img-container col-md-6">
                    <img id="image" class="img-edit rounded" style="height:350px;"
                        src="{{Storage::url('vendor/dish/'.$dish->image)}}">
                </div>
                <div class="col-md-6">
                    <div id="basics">

                        <div class="mb-3 mt-0 text-lg-left text-center">
                            <h4 class="font-weight-semi-bold">Quantity/Price</h4>
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
                                <div id="basicsCollapseOne" class="collapse show" aria-labelledby="basicsHeadingOne"
                                    data-parent="#basicsAccordion" style="">
                                    <div class="card-body border-top p-2 text-muted" style="font-size: large;">
                                        <ul class="list-group">
                                            @foreach($regular_qty as $qty)
                                            <li class="list-group-item">
                                                <span class="badge badge-success">{{$qty->title}}:
                                                    ₦{{$qty->price}}</span>
                                                <span class="badge badge-secondary">Quantity:
                                                    {{$qty->quantity}} Plates</span>
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
                                <div id="basicsCollapseTwo" class="collapse" aria-labelledby="basicsHeadingTwo"
                                    data-parent="#basicsAccordion">
                                    <div class="card-body border-top p-2 text-muted" style="font-size:large;">
                                        @if(!empty($bulk_qty))
                                        <ul class="list-group">
                                            @foreach($bulk_qty as $qty)
                                            <li class="list-group-item">
                                                <span class="badge badge-success">{{$qty->title}}:
                                                    ₦{{$qty->price}}</span>
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary" id="crop">Crop & Save</button>
                <label type="button" class="btn btn-primary d-none" for="input" id="change">Change</label> -->
            </div>
        </div>
    </div>
</div>

<span class="d-none" data-toggle="modal" href="#loginModal" id="login-pop"></span>
