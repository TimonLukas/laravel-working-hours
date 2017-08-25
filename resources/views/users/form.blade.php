<div class="form-group label-static is-empty">
    <label for="name" class="control-label">Name</label>
    <input type="text" class="form-control" name="name" placeholder="John Doe" value="{{ $user->name }}">
</div>

<div class="form-group label-static is-empty">
    <label for="email" class="control-label">E-Mail</label>
    <input type="email" class="form-control" name="email" placeholder="john@doe.com" value="{{ $user->email }}">
</div>

<div class="checkbox">
    <label>
        <input type="checkbox" {{ $user->is_manager ? 'checked' : '' }} name="isManager"> Is a manager
    </label>
</div>