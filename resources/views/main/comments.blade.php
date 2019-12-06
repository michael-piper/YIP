@php
if(isset($_GET['action']) && $_GET['action']=='comment'){
    $comment_message=['warning'=>'Comment submitted'];
    if(isset($_GET['comment']) && strlen($_GET['comment'])>5){
        $comment_message=['success'=>'Comment submitted'];
        $comment = new App\Comment();
        $comment->product_id=$product->id;
        $comment->user_id=Auth::user()->id;
        $comment->comment=rawurldecode($_GET['comment']);
        $comment->save();
    }else{
        $comment_message=['error'=>'Comment can\'t be empty'];

    }
    if(isset($_GET['rate'])){
        $_GET['rate']=(int)$_GET['rate'];
        if($_GET['rate']>5){
            $_GET['rate']=5;
        }
        $user=Auth::user();
        $rate_message=['success'=>'Rating submitted'];
        $rate= App\Rating::where(['user_id'=>$user->id,'product_id'=>$product->id])->first();
        if(is_null($rate)){
            $rate = new App\Rating();
        }
        $rate->product_id=$product->id;
        $rate->user_id=$user->id;
        $rate->rate=$_GET['rate'];
        $rate->save();
    }else{
        $rate_message=['error'=>'Rating can\'t be empty'];
    }
}
@endphp
@php($comments=App\Comment::where(['product_id'=>$product->id])->orderBy('created_at','DESC')->paginate(10))

<div class="uk-grid-small uk-child-width-1-2@s" uk-grid>
    <div>
        <section class="uk-margin-left uk-section uk-margin-small uk-dark uk-card-default uk-card-body">
        <h4 class="uk-padding-remove uk-margin-remove">Product review <span class="float-right"><small>{{$comments->total()}} Review{{$comments->total()<=1?'':'s'}}</small> <span class="rating">{!!App\Product::rating($product->id)!!}</span>&nbsp;</span></h4>
            <hr class="m-0 p-0">
            <ul class="uk-comment-list">
                @foreach($comments as $comment)
                @php($cuser=App\User::where('id',$comment->user_id)->first())
                <li class="uk-margin-small">
                        <article class="uk-comment uk-visible-toggle" tabindex="-1">
                            <header class="uk-comment-header uk-position-relative">
                                <div class="uk-grid-medium uk-flex-middle" uk-grid>
                                    {{-- thanks of  --}}
                                    <div class="uk-width-expand">
                                        <h4 class="uk-comment-title uk-margin-remove"><a class="uk-link-reset" href="#">{{$cuser->display_name}}</a></h4>
                                    <p class="uk-comment-meta uk-margin-remove-top"> <span class="rating">{!!App\Product::rating($product->id)!!}</span>&nbsp;<a class="uk-link-reset" href="#">{{date('l M d Y \a\t H:ia',strtotime($comment->created_at))}}</a></p>
                                    </div>
                                </div>
                                <div class="uk-position-top-right uk-position-small uk-hidden-hover"><a class="uk-link-muted reply" comment-id="2" href="Javascript:void(0);">Reply</a></div>
                            </header>
                            <div class="uk-comment-body">
                            <p style="font-size:12px;">{{$comment->comment}}</p>
                            </div>
                        </article>
                </li>
                @endforeach
            </ul>
            {{$comments->links()}}
        </section>
    </div>
    <div>
        <section class="uk-section radius uk-margin-right uk-padding-small uk-dark uk-card-default uk-card-body" id="product-comment-{{$product->id}}">
            @auth
            @if(isset($comment_message))
                @alert($comment_message)
                @endalert
                @push('scripts')
                <script>
                    setTimeout(function(){window.location.search=''},3000);
                    jQuery('html').scrollTop(jQuery('#product-comment-29')[0].offsetTop);
                </script>
                @endpush
            @endif
            @if(isset($rate_message))
                @alert($rate_message)
                @endalert
                @push('scripts')
                <script>
                    setTimeout(function(){window.location.search=''},3000);
                    jQuery('html').scrollTop(jQuery('#product-comment-29')[0].offsetTop);
                </script>
                @endpush
            @endif
            <form action="#product-comment-29" method="GET">
            <input type="hidden" value="comment" name="action">
                <fieldset class="uk-fieldset">
                    <legend class="uk-legend">What do you think about this product?</legend>
                    <div class="uk-margin">
                        <select class="uk-select" name="rate">
                            <option value="5">Excellent</option>
                            <option value="4">Very good</option>
                            <option value="3">Good</option>
                            <option value="2">Bad</option>
                            <option value="1">Very bad</option>
                        </select>
                    </div>
                    <div class="uk-margin">
                        <textarea name="comment" class="uk-textarea radius" style="resize:none;" rows="5" placeholder="Type your review here...."></textarea>
                    </div>
                    <div class="uk-margin">
                        <button class="uk-button uk-button-primary radius-large float-right">Post</button>
                    </div>
                </fieldset>
            </form>
            @else
            <div class="uk-text-center">
                Please login to add review<br/>
            <a href="/login?r={{Request::url()}}">login</a>
            </div>
            @endauth
        </section>
    </div>
</div>
