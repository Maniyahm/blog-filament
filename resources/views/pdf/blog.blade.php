<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $blog->title }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
        h1 { font-size: 24px; color: #333; margin-top: 0; }
        p { font-size: 14px; color: #666; }
        .created-at { font-size: 12px; color: #999; margin-top: -10px; }
        .image { max-width: 100%; height: auto; margin: 20px 0; }
    </style>
</head>
<body>
    <h1>{{ $blog->title }}</h1>
    
    <p class="created-at">Craeted on: {{ $blog->created_at->format('F j, Y') }}</p>
    
    @if($blog->image)
        <img src="{{ public_path('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="image">
    @endif

    <p>{{ $blog->description }}</p>
</body>
</html>
