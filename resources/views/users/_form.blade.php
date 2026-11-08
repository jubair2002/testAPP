<div class="form-grid">
    <div class="field">
        <label for="username">Username</label>
        <input class="input" id="username" name="username" type="text" maxlength="100" value="{{ old('username', $user->username ?? '') }}" required autocomplete="username">
        @error('username')<span class="field-error">{{ $message }}</span>@enderror
    </div>
    <div class="field">
        <label for="email">Email address</label>
        <input class="input" id="email" name="email" type="email" maxlength="255" value="{{ old('email', $user->email ?? '') }}" required autocomplete="email">
        @error('email')<span class="field-error">{{ $message }}</span>@enderror
    </div>
    <div class="field">
        <label for="age">Age</label>
        <input class="input" id="age" name="age" type="number" min="0" max="150" value="{{ old('age', $user->age ?? '') }}" required>
        @error('age')<span class="field-error">{{ $message }}</span>@enderror
    </div>
    <div class="field field-full">
        <label class="checkbox-row" for="is_active">
            <input id="is_active" name="is_active" type="checkbox" value="1" @checked((bool) old('is_active', old('username') !== null ? false : ($user->is_active ?? true)))>
            Active user
        </label>
        @error('is_active')<span class="field-error">{{ $message }}</span>@enderror
    </div>
</div>
<div class="form-actions">
    <a class="button button-secondary" href="{{ route('users.index') }}">Cancel</a>
    <button class="button button-primary" type="submit">{{ isset($user) ? 'Save changes' : 'Create user' }}</button>
</div>
