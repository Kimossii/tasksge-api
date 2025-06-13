<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h2>Imagens Filtradas</h2>
@foreach($gatos as $gato)
    <div style="margin: 10px">
        <img src="{{ $gato['url'] }}" width="300">
        <form method="POST" action="{{ route('cats.favorite') }}">
            @csrf
            <input type="hidden" name="image_id" value="{{ $gato['id'] }}">
            <button type="submit">❤️ Favoritar</button>
        </form>
    </div>
@endforeach
</body>
</html>
