<div class="modal fade" id="rating-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content border">
            <div class="border-bottom red-bottom">
                <h4 class="text-center my-1">
                    Rate {{$vendor->business_name}}
                </h4>
            </div>
            <div class="modal-body">
                <!-- Rating Stars Box -->
                <div class='rating-stars text-center mt-2'>
                    <ul id='stars-main' style="font-size: 19px;">
                        <li class='star' title='Poor' data-value='1'>
                            <i class='lar la-star fa-fw'></i>
                        </li>
                        <li class='star' title='Fair' data-value='2'>
                            <i class='lar la-star fa-fw'></i>
                        </li>
                        <li class='star' title='Good' data-value='3'>
                            <i class='lar la-star fa-fw'></i>
                        </li>
                        <li class='star' title='Excellent' data-value='4'>
                            <i class='lar la-star fa-fw'></i>
                        </li>
                        <li class='star' title='WOW!!!' data-value='5'>
                            <i class='lar la-star fa-fw'></i>
                        </li>
                    </ul>
                </div>
                <!-- Rating Stars Box -->
                <div id="rating-comment" class="text-center font-weight-bold">
                </div>
            </div>
        </div>
    </div>
</div>

<span class="d-none" data-toggle="modal" href="#loginModal" id="login-pop"></span>
