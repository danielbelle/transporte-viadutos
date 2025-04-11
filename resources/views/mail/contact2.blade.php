<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Transporte Viadutos</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

  <section class="text-gray-600 body-font relative">
    <div class="container px-5 py-10 mx-auto">
      <div class="lg:w-2/3 mx-auto p-4">
        <h1
          class="sm:text-3xl lg:w-2/3 mx-auto text-2xl font-medium title-font mb-4 text-gray-900 text-center">
          Email Enviado do Auxílio Transporte</h1>
        <p class="lg:w-2/3 mx-auto leading-relaxed text-center mb-4 ">Município de
          Viadutos-RS para quem vai de <b>VEÍCULO PRÓPRIO</b>.</p>
      </div>

      <div class="lg:w-2/3 mx-auto p-4">
        <div
          class="flex flex-wrap w-full cursor-default bg-gray-100 bg-opacity-50 rounded-lg border
          border-gray-400 text-base outline-none text-gray-800 py-10 px-5 leading-8">
          <p>Olá, equipe da Prefeitura Municipal de Viadutos.</p>

          <p>Este é um e-mail preenchido automaticamente pelo(a)
            estudante(a):

            @if (session('process'))
              <strong>{{ session('process.name') }}</strong>.
            @endif

          </p>

          <p>No mesmo contém o anexo da Declaração do auxílio transporte, previsto na
            <a href="{{ URL::temporarySignedRoute(
                'show.attachment',
                now()->addMinutes(10), // Link timer
                ['filename' => $_ENV['PDF_LEI_2011_ATUALIZADA']],
            ) }}"
              target="_blank"
              class="rounded-lg transition duration-300 items-center font-medium text-blue-600 underline dark:text-blue-500 hover:no-underline">Lei
              Municipal nº 2.721/2011</a> alterado pela <a
              href="{{ URL::temporarySignedRoute(
                  'show.attachment',
                  now()->addMinutes(10), // Link timer
                  ['filename' => $_ENV['PDF_LEI_2025']],
              ) }}"
              target="_blank"
              class="rounded-lg transition duration-300 items-center font-medium text-blue-600 underline dark:text-blue-500 hover:no-underline">
              Lei Municipal nº 3.647/2025</a>.
          </p>

          <p>Uma cópia deste e-mail foi enviada para o(a) estudante(a)
            e/ou aos responsáveis no endereço eletrônico a seguir

            @if (session('process'))
              <strong>{{ session('process.email') }}</strong>.
            @endif
          </p>

          <p>Atenciosamente,
            @if (session('process'))
              {{ session('process.name') }}.
            @endif
          </p>
        </div>
      </div>

      <div class="lg:w-2/3 mx-auto p-4">
        <div
          class="mx-auto bg-white shadow-md overflow-hidden w-full cursor-default rounded-lg text-base outline-none text-gray-800 py-10 px-5 leading-8 justify-center text-center">

          <h1 class="text-2xl font-bold text-gray-800">Baixar a
            sua assinatura e o documentos assinado</h1>

          <div class="flex flex-col md:flex-row gap-8">
            <!-- Área da Imagem -->
            <div class="w-full md:w-1/2">
              <div
                class="border-2 border-gray-200 rounded-lg p-4 flex justify-center items-center bg-gray-50">
                @if (session('process'))
                  <?php $img = URL::temporarySignedRoute(
                      'show.attachment',
                      now()->addMinutes(10), // Link timer
                      ['filename' => session('process.sign')],
                  ); ?>
                  <a href="{{ $img }}" target="_blank">
                    <img src="{{ $img }}" alt="Assinatura"
                      class="max-w-full h-auto rounded-lg shadow-md">
                  </a>
                @else
                  <p class="text-gray-500">Nenhuma imagem disponível</p>
                @endif
              </div>
            </div>

            <!-- Área de Download -->
            <div class="w-full md:w-1/2">
              <h2 class="text-lg font-semibold text-gray-700 mb-3">Arquivo para Download</h2>
              <div class="border-2 border-gray-200 rounded-lg p-6 bg-gray-50">
                <div class="flex flex-col items-center justify-center h-full">

                  <p class="text-gray-600 mb-4 text-center">
                    Clique no botão abaixo para baixar o documento
                  </p>

                  @if (session('process'))
                    <div class="flex justify-center items-center">
                      <a href="{{ URL::temporarySignedRoute(
                          'show.attachment',
                          now()->addMinutes(10), // Link timer
                          ['filename' => session('process.outputPath')],
                      ) }}"
                        target="_blank"
                        class="px-6 py-3 bg-blue-600 text-black font-medium rounded-lg hover:bg-blue-700 transition duration-300 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2"
                          viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd"
                            d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                        </svg>
                        <span>Baixar Documento</span>
                      </a>
                    </div>
                  @else
                    <p class="text-red-500">Arquivo não disponível para download</p>
                  @endif
                </div>
              </div>

              <!-- Botão Voltar -->
              <div class="mt-8">
                <a href="{{ route('input.form') }}"
                  class="text-blue-600 hover:text-blue-800 font-medium">
                  &larr; Voltar para a lista
                </a>
              </div>
            </div>
          </div>



        </div>
      </div>

  </section>
  <footer class="text-gray-600 body-font">
    <div class="container px-5 py-8 mx-auto flex items-center sm:flex-col">
      <p class="text-sm text-gray-500 sm:ml-4 sm:pl-4 sm:border-gray-200 sm:py-2 sm:mt-0 mt-4">
        Desenvolvido por - Daniel Henrique Bellé - 2025
        <a href="https://github.com/danielbelle" class="text-gray-600 ml-1"
          rel="noopener noreferrer" target="_blank">
          <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5 inline"
            viewBox="0 0 24 24">
            <path
              d="M12 0C5.37 0 0 5.37 0 12c0 5.3 3.438 9.8 8.207 11.387.6.113.793-.262.793-.583 0-.287-.01-1.05-.015-2.06-3.338.725-4.042-1.61-4.042-1.61-.546-1.387-1.333-1.757-1.333-1.757-1.09-.745.083-.73.083-.73 1.205.085 1.84 1.237 1.84 1.237 1.07 1.835 2.807 1.305 3.492.997.108-.775.418-1.305.76-1.605-2.665-.305-5.467-1.332-5.467-5.93 0-1.31.468-2.382 1.236-3.222-.124-.303-.535-1.523.117-3.176 0 0 1.008-.322 3.3 1.23a11.52 11.52 0 0 1 3.003-.403c1.02.005 2.045.137 3.003.403 2.29-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.873.118 3.176.77.84 1.235 1.912 1.235 3.222 0 4.61-2.807 5.623-5.48 5.92.43.37.823 1.102.823 2.222 0 1.606-.015 2.898-.015 3.293 0 .323.192.7.8.583C20.565 21.797 24 17.298 24 12c0-6.63-5.37-12-12-12z" />
          </svg>
        </a>
      </p>
    </div>
  </footer>
</body>

</html>
