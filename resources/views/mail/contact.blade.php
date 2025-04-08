<x-mail::message>

  Olá, equipe da Prefeitura Municipal de Viadutos.<br>

  Este é um e-mail preenchido automaticamente pelo(a)
  estudante(a): <strong>{{ $data['name'] }}</strong>. <br>

  No mesmo contém o anexo da Declaração do auxílio transporte, previsto na
  Lei Municipal nº 2.721/2011
  alterado pela Lei Municipal nº 3.647/2025. <br>

  Uma cópia deste e-mail foi enviada para o(a) estudante(a)
  e/ou aos responsáveis no endereço eletrônico a seguir: <br>
  Email: <strong>{{ $data['email'] }} </strong> <br>


  <x-mail::button :url="'https://www.google.com.br/?hl=pt-BR'">
    Link do Formulário
  </x-mail::button>

  Atenciosamente, {{ $data['name'] }}<br>
  <br><br>

  <p style="font-size: 9px;">
    Desenvolvido por: Daniel Henrique Bellé
  </p>
</x-mail::message>
