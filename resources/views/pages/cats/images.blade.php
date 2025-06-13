<!DOCTYPE html>
<html>
<head>
    <title>Gatos Bonitos 😸</title>
</head>
<body>
    <h2>Imagens</h2>
@foreach($gatos as $gato)
    <div style="margin: 20px">
        <img src="{{ $gato['url'] }}" width="300">
        <form action="{{ route('gatos.favoritar') }}" method="POST">
            @csrf
            <input type="hidden" name="image_id" value="{{ $gato['id'] }}">
            <button type="submit">❤️ Favoritar</button>
        </form>
    </div>
@endforeach

</body>
</html>
