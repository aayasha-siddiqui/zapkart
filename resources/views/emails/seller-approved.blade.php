<!DOCTYPE html>
<html>
<body style="font-family: Arial">

<h2>Hello {{ $user->name }},</h2>

<p>🎉 Congratulations!</p>

<p>
Your request to become a <strong>Seller</strong> has been <strong>approved</strong>.
</p>

<h3>🔐 Login Details</h3>

<p>
<strong>Email:</strong> {{ $user->email }} <br>
<strong>Role:</strong> Seller
</p>

<p>
You can now login and start adding your products.
</p>

<p>
Regards,<br>
<strong>{{ config('app.name') }}</strong>
</p>

</body>
</html>
