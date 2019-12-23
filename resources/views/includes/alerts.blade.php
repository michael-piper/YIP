@if (isset($error))
@alert(['error'=>$error])
@endalert
@elseif(isset($success))
@alert(['success'=>$success])
@endalert
@elseif(isset($warning))
@alert(['warning'=>$warning])
@endalert
@elseif(isset($_GET['m']))
@alert(['warning'=>$_GET['m']])
@endalert
@endif
