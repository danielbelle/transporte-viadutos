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
      <div class="flex flex-col text-center w-full mb-6">
        <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">Formulário de
          Auxílio Transporte</h1>
        <p class="lg:w-2/3 mx-auto leading-relaxed text-base">Município de
          Viadutos-RS para quem vai de <b>VEÍCULO PRÓPRIO</b>.</p>
      </div>

      @include('components.form')

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

    </div>

  </section>

  <script src="{{ asset('vendor/sign-pad/sign-pad.min.js') }}"></script>

</body>

</html>
