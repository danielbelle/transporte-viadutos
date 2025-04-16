@if (session()->has('success'))
  <div
    class="relative flex flex-col sm:flex-row sm:items-center bg-gray-200 dark:bg-green-700 shadow rounded-md py-5 pl-6 pr-8 sm:pr-6 mb-3 mt-3">
    <div class="flex flex-row items-center border-b sm:border-b-0 w-full sm:w-auto pb-4 sm:pb-0">
      <div class="text-green-500">
        <svg class="w-6 sm:w-5 h-6 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
      </div>
      <div class="text-sm font-medium ml-3 text-white">Enviado com Sucesso. Você vai receber uma
        cópia no seu e-mail:
        email</div>
    </div>
    <div class="text-sm tracking-wide text-white mt-4 sm:mt-0 sm:ml-4">
      {{ session('success') }}</div>
    <div
      class="absolute sm:relative sm:top-auto sm:right-auto ml-auto right-4 top-4 text-gray-400 hover:text-gray-800 cursor-pointer">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M6 18L18 6M6 6l12 12"></path>
      </svg>
    </div>
  </div>
@endif

@if (session('result'))
  <div class="mt-3 alert alert-info">
    Result: {{ session('result') }}
  </div>
@endif

<form method="POST" autocomplete="off" action="{{ route('process.input') }}">

  @csrf
  <div class="lg:w-100
  mx-auto">
    <div class="flex flex-wrap">

      <div class="p-2 w-1/3">
        <div class="relative">
          <label for="name" class="leading-7 text-sm text-gray-600">Nome completo</label>
          <input type="text" id="name" name="name" autocomplete="name"
            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
        </div>
        @error('name')
          <div class="text-red-500 text-sm mt-1">
            {{ $message }}
          </div>
        @enderror
      </div>

      <div class="p-2 w-1/3">
        <div class="relative">
          <label for="email" class="leading-7 text-sm text-gray-600">Email</label>
          <input type="email" id="email" name="email" autocomplete="email"
            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
        </div>

        @error('email')
          <div class="text-red-500 text-sm mt-1">
            {{ $message }}
          </div>
        @enderror

      </div>

      <div class="p-2 w-1/3">
        <div class="relative">
          <label for="docRG" class="leading-7 text-sm text-gray-600">RG</label>
          <input type="text" id="docRG" name="docRG"
            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
        </div>
        @error('docRG')
          <div class="text-red-500 text-sm mt-1">
            {{ $message }}
          </div>
        @enderror
      </div>

      <div class="p-2 w-1/3">
        <div class="relative">
          <label for="docCPF" class="leading-7 text-sm text-gray-600">CPF</label>
          <input type="text" id="docCPF" name="docCPF"
            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
        </div>
        @error('docCPF')
          <div class="text-red-500 text-sm mt-1">
            {{ $message }}
          </div>
        @enderror
      </div>

      <div class="p-2 w-1/3">
        <div class="relative">
          <label for="period" class="leading-7 text-sm text-gray-600">Período</label>
          <input type="text" id="period" name="period"
            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
        </div>
        @error('period')
          <div class="text-red-500 text-sm mt-1">
            {{ $message }}
          </div>
        @enderror
      </div>

      <div class="p-2 w-1/3">
        <div class="relative">
          <label for="institution" class="leading-7 text-sm text-gray-600">Instituição</label>
          <input type="text" id="institution" name="institution"
            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
        </div>
        @error('institution')
          <div class="text-red-500 text-sm mt-1">
            {{ $message }}
          </div>
        @enderror
      </div>

      <div class="p-2 w-1/3">
        <div class="relative">
          <label for="course" class="leading-7 text-sm text-gray-600">Curso</label>
          <input type="text" id="course" name="course"
            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
        </div>
        @error('course')
          <div class="text-red-500 text-sm mt-1">
            {{ $message }}
          </div>
        @enderror
      </div>

      <div class="p-2 w-1/3">
        <div class="relative">
          <label for="month" class="leading-7 text-sm text-gray-600">Mês</label>
          <input type="text" id="month" name="month"
            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
        </div>
        @error('month')
          <div class="text-red-500 text-sm mt-1">
            {{ $message }}
          </div>
        @enderror
      </div>

      <div class="p-2 w-1/3">
        <div class="relative">
          <label for="timesInMonth" class="leading-7 text-sm text-gray-600">Vezes no mês</label>
          <input type="number" id="timesInMonth" name="timesInMonth"
            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
        </div>
        @error('timesInMonth')
          <div class="text-red-500 text-sm mt-1">
            {{ $message }}
          </div>
        @enderror
      </div>

      <div class="p-2 w-1/3">
        <div class="relative">
          <label for="city" class="leading-7 text-sm text-gray-600">Cidade</label>
          <input type="text" id="city" name="city"
            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
        </div>
        @error('city')
          <div class="text-red-500 text-sm mt-1">
            {{ $message }}
          </div>
        @enderror
      </div>

      <div class="p-2 w-1/3">
        <div class="relative">
          <label for="phone" class="leading-7 text-sm text-gray-600">Telefone</label>
          <input type="text" id="phone" name="phone" autocomplete="phone"
            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
        </div>
        @error('phone')
          <div class="text-red-500 text-sm mt-1">
            {{ $message }}
          </div>
        @enderror
      </div>

      <div class="p-2 w-1/3">
        <div class="relative">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 mr-2 fill-gray inline"
            viewBox="0 0 32 32">
            <path
              d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956z"
              data-original="#000000" />
            <path
              d="M20.293 19.707a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z"
              data-original="#000000" />
          </svg>
          <label for="inputDocument" class="leading-7 text-sm text-gray-600">Doc. Presença</label>
          <input type="file" id="inputDocument" name="inputDocument"
            class="w-full file:cursor-pointer text-xs bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out cursor-pointer focus:cursor-pointer">
        </div>
        @error('inputDocument')
          <div class="text-red-500 text-sm mt-1">
            {{ $message }}
          </div>
        @enderror
      </div>

      <div class="p-2 w-full">
        @error('sign')
          <div class="text-red-500 text-sm mt-1">
            {{ $message }}
          </div>
        @enderror
        <div class="block items-center justify-center">
          <p class="leading-7 text-sm text-gray-600 px-auto p-1">Desenhe a sua
            assinatura com o mouse</p>
          <x-creagia-signature-pad id='sign' name='sign' border-color="#9a9a9a"
            pad-classes="rounded-xl border-2 bg-transparent sm:w-100 sm:h-100"
            button-classes="py-2 mt-4 mx-auto text-white bg-indigo-500 border-0 px-4 focus:outline-none hover:bg-indigo-600 rounded text-md"
            clear-name="Limpar Assinatura" submit-name='Enviar' :disabled-without-signature="true" />
        </div>
      </div>

      <div class="p-2 w-1/3 hidden">
        <div class="relative">
          <label for="signatureName" class="leading-7 text-sm text-gray-600">signatureName</label>
          <input type="text" id="signatureName" name="signatureName"
            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
        </div>
        @error('signatureName')
          <div class="text-red-500 text-sm mt-1">
            {{ $message }}
          </div>
        @enderror
      </div>

    </div>
  </div>

</form>
