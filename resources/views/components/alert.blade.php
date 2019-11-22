
@isset($message)
<div class="uk-alert-primary" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <p>{{$message}}</p>
</div>
@endisset

@isset($success)
<div class="uk-alert-success" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <p>{{$success}}</p>
</div>
@endisset
@isset($warning)
<div class="uk-alert-warning" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <p>{{$warning}}</p>
</div>
@endisset
@isset($error)
<div class="uk-alert-danger" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <p>{{$error}}</p>
</div>
@endisset
