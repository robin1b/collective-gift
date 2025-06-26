@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Nieuw Affiliate Cadeau-idee</h1>
    <form action="{{ route('admin.gifts.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Gift Idee</label>
            <select name="gift_idea_id" class="form-control">
                @foreach($ideas as $idea)
                <option value="{{ $idea->id }}">{{ $idea->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Affiliate URL</label>
            <input name="affiliate_url" class="form-control" value="{{ old('affiliate_url') }}">
        </div>
        <div class="mb-3">
            <label>Afbeelding (URL)</label>
            <input name="image_url" class="form-control" value="{{ old('image_url') }}">
        </div>
        <button class="btn btn-primary">Opslaan</button>
    </form>
</div>
@endsection