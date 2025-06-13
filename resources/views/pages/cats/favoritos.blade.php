<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h2>Meus Gatos Favoritos</h2>

@if(count($favoritos) > 0)
    @foreach($favoritos as $fav)
        <div style="margin-bottom: 20px">
            <img src="{{ $fav['image']['url'] }}" width="300">
            <p>ID do Favorito: {{ $fav['id'] }}</p>
        </div>
    @endforeach
@else
    <p>Nenhum favorito encontrado.</p>
@endif

</body>
</html>
