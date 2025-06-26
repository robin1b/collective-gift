@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Bewerk Affiliate Cadeau-idee</h1>
    <form action="{{ route('admin.gifts.update', $recommended_gift) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Affiliate URL</label>
            <input name="affiliate_url" class="form-control"
                value="{{ old('affiliate_url', $recommended_gift->affiliate_url) }}">
        </div>
        <div class="mb-3">
            <label>Afbeelding (URL)</label>
            <input name="image_url" class="form-control"
                value="{{ old('image_url', $recommended_gift->image_url) }}">
        </div>
        <button class="btn btn-primary">Bijwerken</button>
    </form>
</div>
@endsection