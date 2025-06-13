<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h2>Categorias</h2>
<ul>
@foreach($categorias as $cat)
    <li><a href="{{ route('category.imagens', $cat['id']) }}">{{ $cat['name'] }}</a></li>
@endforeach
</ul>

</body>
</html>
