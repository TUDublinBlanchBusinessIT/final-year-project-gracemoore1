
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <input type="email" name="email" required placeholder="Email">
    <input type="password" name="password" required placeholder="New password">
    <input type="password" name="password_confirmation" required placeholder="Confirm password">

    <button type="submit">Reset Password</button>
</form>