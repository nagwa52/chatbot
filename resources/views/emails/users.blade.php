@component('mail::message')
# Welcome to the first Newletter<br>
Name: {{$fname}}<br>
Surname: {{$lname}}<br>
Telephone: {{$phone}}<br>
Email: {{$email}}<br>
We look forward to communicating more with you. For more information visit our blog.
@component('mail::button', ['url' => 'https://laraveltuts.com'])
Blog
@endcomponent
Thanks,<br>
{{ config('app.name') }}
@endcomponent
