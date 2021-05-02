{{-- Format Time/Date --}}
@php
if (!function_exists('format_time')) {
    function format_time($time)
    {
        $time = strtotime($time);
        $t_diff = time() - $time;
        $res = '';

        if ($t_diff < 60) {
            $res = $t_diff < 1 ? 'now' : $t_diff . 's ago';
        } elseif ($t_diff >= 60 && $t_diff < 3600) {
            $res = (int) ($t_diff / 60) . 'm ago';
        } elseif ($t_diff >= 3600 && $t_diff < 86399) {
            $res = (int) ($t_diff / 3600) . 'h ago';
        } elseif ($t_diff >= 86400 && $t_diff < 604799) {
            $res = (int) ($t_diff / 86400) . 'd ago';
        } else {
            $res = date('y') == date('y', $time) ? date('d M', $time) : date('d M y', $time);
        }

        return $res;
    }
}
@endphp

@if (count($posts))

    @foreach ($posts as $post)

        @php
            $id = '';
            if (!Auth::guard('vendor')->guest()) {
                $id = Auth::user('vendor')->id;
            }
        @endphp

        <!-- Post -->
        <div class="box shadow-sm border rounded bg-white mb-3 osahan-post" id="post__{{ $post->id }}">
            <div class="p-3 d-flex align-items-center border-bottom osahan-post-header">
                <div class="dropdown-list-image mr-3 post-profile">
                    <a href="{{ url($post->vendor->username) }}">
                        <img class="rounded-circle"
                            src="{{ Storage::url('vendor/profile/' . $post->vendor->profile_image) }}" alt="">
                    </a>
                </div>
                <div class="font-weight-bold">
                    <div class="text-truncate post-profile"><a class="text-dark"
                            href="{{ url($post->vendor->username) }}">{{ $post->vendor->business_name }}</a></div>
                    <div><a class="small post-profile"
                            href="{{ url($post->vendor->username) }}">{{ '@' . $post->vendor->username }}</a></div>
                </div>
                <span class="ml-auto small">{{ format_time($post->created_at) }}</span>

                {{-- Post Dropdown --}}
                @if (!Auth::guard('vendor')->guest() || !Auth::guard('user')->guest())
                    <i class="la la-ellipsis-v la-2x icon-hover bright-ic ml-2 p-0" data-toggle="dropdown">
                        <div class="dropdown-menu dropdown-menu-right shadow">
                            @if (!Auth::guard('vendor')->guest())
                                @if ($id == $post->vendor_id)
                                    <a class="dropdown-item" onclick="deletePost(`{{ $post->id }}`)">
                                        <i class="la la-trash la-lg mr-1"></i>
                                        <span style="font-family: 'Ubuntu', sans-serif;">Delete Post</span>
                                    </a>
                                @endif
                            @else
                                <a class="dropdown-item">
                                    <i class="la la-flag la-lg mr-1"></i>
                                    <span style="font-family: 'Ubuntu', sans-serif;">Report Post</span>
                                </a>
                            @endif
                        </div>
                    </i>
                @endif
            </div>
            <div class="p-3 border-bottom osahan-post-body post-inner">
                <p class="mb-0 f-post" onclick="openComments('{{ $post->id }}', 'like')">{{ $post->content }}</p>

                <div class="post-media-container justify-content-center">
                    @if ($post->media)
                        @foreach ($post->media as $media)
                            @if ($media->type == 'image')
                                <div class="pm pm-im-l pm-{{ count($post->media) }}"
                                    onclick="launchLight('{{ $media->id }}')"
                                    style="background-image: url('{{ Storage::url('posts/photos/' . $media->name) }}')">
                                    <div></div>
                                </div>
                            @else
                                @php $thumb = explode('.', $media->name)[0] . '.png'; @endphp
                                <div class="w-100 feed-vid-cont">
                                    <video preload="metadata"
                                        poster="{{ Storage::url('posts/videos/thumbnails/' . $thumb) }}"
                                        class="pm-1 vid-bod" style="max-height: 300px" controls
                                        src="{{ Storage::url('posts/videos/' . $media->name) }}"></video>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>

                {{-- Tag list --}}
                <div class="pt-1">
                    @foreach ($post->tags()->orderBy('id', 'desc')->get()
    as $tag)
                        @php $tag_list_item = str_replace(' ', '_', strtolower($tag->item->title)); @endphp
                        <span class="tag-list-item">{{ $tag_list_item }}</span>
                    @endforeach
                </div>
            </div>


            {{-- Lightbox --}}
            <div uk-lightbox>
                @foreach ($post->media as $media)
                    @if ($media->type == 'image')
                        <a class="d-none" href="{{ Storage::url('posts/photos/' . $media->name) }}"
                            id="light-{{ $media->id }}"></a>
                    @endif
                @endforeach
            </div>

            @php
                $is_liker = false;
                
                if (!Auth::guard('vendor')->guest() || !Auth::guard('user')->guest()) {
                    $liker_type = Auth::guard('vendor')->guest() ? 'user' : 'vendor';
                    $liker = Auth::guard('vendor')->guest() ? Auth::guard('user')->user() : Auth::user('vendor');
                
                    $is_liker = $post
                        ->like()
                        ->where('liker_id', $liker->id)
                        ->where('liker_type', $liker_type)
                        ->count();
                
                    $is_liker = $is_liker > 0 ? true : false;
                }
            @endphp

            {{-- Actions --}}
            <div class="p-3 border-bottom osahan-post-footer">
                <a class="mr-3 text-secondary" title="Like"><i
                        class="la {{ $is_liker ? 'la-heart' : 'la-heart-o' }} la-2x text-danger"
                        like-count="{{ $post->likes }}"
                        onclick="{{ $is_liker ? 'unlikePost(`' . $post->id . '`, this)' : 'likePost(`' . $post->id . '`, this)' }}"
                        id="post-likes-{{ $post->id }}"></i><span
                        class="post-likes-inner-{{ $post->id }}">&nbsp;{{ $post->likes }}</span></a>
                <a onclick="openComments('{{ $post->id }}')" class="mr-3 text-secondary comments-ico-a"
                    title="Comment"><i class="la la-comment la-2x"></i><span
                        class="post-comm-inner-{{ $post->id }}">&nbsp;{{ $post->comments }}</span></a>
                <a style=":hover{cursor:pointer}" class="mr-3 text-secondary" title="Share this post"
                    onclick="sharePost(`{{ $post->id }}`, `{{ $post->vendor->business_name }}`)"><i
                        class="la la-share la-2x"></i></a>

                @php
                    $menu = $post->vendor->menu;
                    $items = $menu ? json_decode($menu->items)->item : [];
                    $show_add_to_b = false;
                    
                    foreach ($post->tags as $tag) {
                        if (in_array($tag->item_id, $items)) {
                            $show_add_to_b = true;
                            break;
                        }
                    }
                @endphp
                @if (!Auth::guard('user')->guest() && $post->tags()->count() > 0 && $show_add_to_b)
                    <a href="#atb-from-post-m-{{ $post->id }}" data-toggle="modal" class="btn btn-sm text-light"
                        style="float: right; background: var(--i-primary)" title="Add to Basket">
                        <i class="la la-shopping-basket la-lg"></i> Add to Basket</a>

                    <div class="modal" id="atb-from-post-m-{{ $post->id }}" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-light">Select items you wish to add</h5>
                                    <button type="button" class="close text-light" data-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @foreach ($post->tags()->orderBy('id', 'desc')->get() as $tag)
                                        @php 
                                            $photo = Storage::url('vendor/dish/' . $tag->item->image);
                                            $bulk = json_decode($tag->item->quantity)->bulk ?? false;
                                            $regular = $tag->item->type == 'simple' ? true : json_decode($tag->item->quantity)->regular ?? false;
                                        @endphp
                                        <div class="p-2 d-flex align-items-center">
                                            <div class="mr-2">
                                                <div class="item-photo-sm" style="background: url('{{ $photo }}')"></div>
                                            </div>

                                            <div><span class="text-dark">{{ $tag->item->title }}</span></div>
                                            <div class="ml-auto pl-2">
                                                @if($regular)
                                                    <a style="hover: {cursor: pointer}; color: var(--i-primary)" onclick="loadRegOrderModal('{{$tag->item->id}}')">Regular Order</a>
                                                @endif

                                                @if($bulk)
                                                    | 
                                                    <a style="hover: {cursor: pointer}; color: var(--i-primary)" onclick="loadBulkOrderModal('{{$tag->item->id}}')">Bulk Order</a>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                @endif
            </div>

        </div>
    @endforeach
@else
    <div class="box shadow-sm border rounded bg-white mb-3 osahan-post">
        <div class="p-3 d-flex align-items-center border-bottom osahan-post-header justify-content-center">
            <p class="m-0"><strong>No Posts Yet!</strong></p>
        </div>
    </div>
@endif
