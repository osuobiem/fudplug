@extends('layouts.master')

@section('content')

<div class="box shadow-sm border rounded bg-white mb-3 osahan-post">
                     <div class="p-3 d-flex align-items-center border-bottom osahan-post-header">
                        <div class="dropdown-list-image mr-3">
                           <img class="rounded-circle" src="img/p5.png" alt="">
                           <div class="status-indicator bg-success"></div>
                        </div>
                        <div class="font-weight-bold">
                           <div class="text-truncate">Tobia Crivellari</div>
                           <div class="small text-gray-500">Product Designer at askbootstrap</div>
                        </div>
                        <span class="ml-auto small">3 hours</span>
                     </div>
                     <div class="p-3 border-bottom osahan-post-body">
                        <p class="mb-0">Tmpo incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco <a href="#">laboris consequat.</a></p>
                     </div>
                     <div class="p-3 border-bottom osahan-post-footer">
                        <a href="#" class="mr-3 text-secondary"><i class="feather-heart text-danger"></i> 16</a>
                        <a href="#" class="mr-3 text-secondary"><i class="feather-message-square"></i> 8</a>
                        <a href="#" class="mr-3 text-secondary"><i class="feather-share-2"></i> 2</a>
                     </div>
                     <div class="p-3">
                        <button type="button" class="btn btn-outline-primary btn-sm mr-1">Awesome!!</button>
                        <button type="button" class="btn btn-light btn-sm mr-1">😍</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm mr-1">Whats it about?</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm mr-1">Oooo Great Wow</button>
                     </div>
                  </div>

@endsection