<form class="uk-grid-small uk-margin-top uk-padding-small" uk-grid>
        <div class="uk-width-expand@s">

        </div>
        <div class="uk-width-1-1">
            <form action="/shop" method="GET">
            <div class="uk-inline uk-width-1-1">
                <a class="uk-form-icon" href="#" uk-icon="icon: search"></a>
                <input class="uk-input" name="q" value="{{$_GET['q']??''}}" placeholder="search and find your motor parts Items" type="text">
                <a class="uk-form-icon uk-form-icon-flip" onclick="$('#searchfiler').toggle();" href="javascript:void(0);" uk-icon="icon: menu"></a>
            </div>
            </form>
        </div>
         <div  id="searchfiler" style="display:none;">
            @includeIf("main.searchfilter")
        </div>
</form>

{{-- sk_test_17b11b55e732817698903279c2a92ff2331d853e --}}
