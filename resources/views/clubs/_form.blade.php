<div>
    <label for="name">Назва клубу</label><br>
    <input id="name" name="name" type="text" value="{{ old('name', $club->name ?? '') }}">
    @error('name') <p class="error">{{ $message }}</p> @enderror
</div>
<div>
    <label for="city">Місто</label><br>
    <input id="city" name="city" type="text" value="{{ old('city', $club->city ?? '') }}">
    @error('city') <p class="error">{{ $message }}</p> @enderror
</div>
<div>
    <label for="stadium">Стадіон</label><br>
    <input id="stadium" name="stadium" type="text" value="{{ old('stadium', $club->stadium ?? '') }}">
    @error('stadium') <p class="error">{{ $message }}</p> @enderror
</div>
<div>
    <label for="founded_year">Рік заснування</label><br>
    <input id="founded_year" name="founded_year" type="number" value="{{ old('founded_year', $club->founded_year ?? '') }}">
    @error('founded_year') <p class="error">{{ $message }}</p> @enderror
</div>
<div>
    <label for="head_coach">Головний тренер</label><br>
    <input id="head_coach" name="head_coach" type="text" value="{{ old('head_coach', $club->head_coach ?? '') }}">
    @error('head_coach') <p class="error">{{ $message }}</p> @enderror
</div>
