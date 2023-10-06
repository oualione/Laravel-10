<div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text" class="form-control" id="title" name="title"
        value="{{ old('title', $post->title ?? null) }}">
</div>
<div class="mb-3">
    <label for="content" class="form-label">Description</label>
    <textarea class="form-control" id="content" name="content" rows="3">{{ old('content', $post->content ?? null) }}</textarea>
</div>
<div class="mb-3">
    <label for="image" class="form-label">Image</label>
    <input type="file" class="form-control" id="image" name="image" accept="image/*">
</div>
<button type="submit" class="btn btn-primary">Submit</button>

<x-error></x-error>
