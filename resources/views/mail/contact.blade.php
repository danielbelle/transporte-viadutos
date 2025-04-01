<x-mail::message>
  # Introduction

  <h3>Name: {{ $data['name'] }}</h3>
  <h3>Email: {{ $data['email'] }}</h3>

  <x-mail::button :url="''">
    Button Text
  </x-mail::button>

  Atenciosamente,<br>
  {{ config('app.name') }}
</x-mail::message>
