<div class="mb-3">
    <label for="category_id" class="form-label">Категорія</label>
    <select id="category_id" name="category_id" class="form-select">
        <option value="">- Без категорії -</option>
        @foreach ($categories as $id => $name)
            <option value="{{ $id }}" @selected(old('category_id', $blog->category_id ?? '') == $id)>
                {{ $name }}
            </option>
        @endforeach
    </select>
    @error('category_id') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<h5 class="text-primary border-bottom pb-2 mt-4">Основний контент (Українська мова)</h5>
<div class="mb-3">
    <label for="title" class="form-label">Заголовок (UA)</label>
    <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $blog->title ?? '') }}" required>
    @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Короткий опис (UA)</label>
    <textarea id="description" name="description" class="form-control" rows="2">{{ old('description', $blog->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="text" class="form-label">Повний текст (UA)</label>
    <textarea id="text" name="text" class="form-control" rows="5">{{ old('text', $blog->text ?? '') }}</textarea>
</div>

<h5 class="text-success border-bottom pb-2 mt-4">Переклад (English - Індивідуальне завдання)</h5>
<div class="mb-3">
    <label for="en_title" class="form-label">Title (EN)</label>
    <input type="text" id="en_title" name="en_title" class="form-control" value="{{ old('en_title', $en->title ?? '') }}">
</div>

<div class="mb-3">
    <label for="en_description" class="form-label">Short Description (EN)</label>
    <textarea id="en_description" name="en_description" class="form-control" rows="2">{{ old('en_description', $en->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="en_text" class="form-label">Full Text (EN)</label>
    <textarea id="en_text" name="en_text" class="form-control" rows="5">{{ old('en_text', $en->text ?? '') }}</textarea>
</div>
