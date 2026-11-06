<div>
    <label for="code">Код</label><br>
    <input id="code" name="code" type="text" maxlength="2" value="{{ old('code', $country->code ?? '') }}">
    @error('code') <p class="error">{{ $message }}</p> @enderror
</div>
<div>
    <label for="name">Назва</label><br>
    <input id="name" name="name" type="text" value="{{ old('name', $country->name ?? '') }}">
    @error('name') <p class="error">{{ $message }}</p> @enderror
</div>
<div>
    <label for="population">Населення</label><br>
    <input id="population" name="population" type="number" min="0" value="{{ old('population', $country->population ?? 0) }}">
    @error('population') <p class="error">{{ $message }}</p> @enderror
</div>
