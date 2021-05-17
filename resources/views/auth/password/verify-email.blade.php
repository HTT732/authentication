<!DOCTYPE html>
<html>
<head>
</head>
    <body>
        <div>
            The link will be invalidated after {{ $expire }} minutes.
            Click the link to complete the registration:
            <a href="{{$url}}">{{$url}}</a>
        </div>
    </body>
</html>
