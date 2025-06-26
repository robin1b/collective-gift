@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Affiliate Cadeau-ideeën</h1>
    <a href="{{ route('admin.gifts.create') }}" class="btn btn-primary mb-3">Nieuw idee</a>
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Gift Idee</th>
                <th>URL</th>
                <th>Afbeelding</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gifts as $gift)
            <tr>
                <td>{{ $gift->id }}</td>
                <td>{{ $gift->giftIdea->title }}</td>
                <td><a href="{{ $gift->affiliate_url }}" target="_blank">Link</a></td>
                <td>
                    @if($gift->image_url)
                    <img src="{{ $gift->image_url }}" width="50">
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.gifts.edit', $gift) }}" class="btn btn-sm btn-secondary">Bewerk</a>
                    <form action="{{ route('admin.gifts.destroy', $gift) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger"
                            onclick="return confirm('Weet je het zeker?')">Verwijder</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $gifts->links() }}
</div>
@endsection