<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h2>Raças de Gatos</h2>
<ul>
@foreach($racas as $raca)
    <li><a href="/cats/race/{{ $raca['id'] }}">{{ $raca['name'] }}</a></li>
@endforeach
</ul>

</body>
</html>
