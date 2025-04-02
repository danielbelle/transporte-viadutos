<div class="container">
  <form method="POST" action="{{ route('process.input') }}">
    @csrf
    <div class="mb-3">
      <label for="input" class="form-label">First Name</label>
      <input type="text" class="form-control" id="input" name="input" required>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>

  @if (session('result'))
    <div class="mt-3 alert alert-info">
      Result: {{ session('result') }}
    </div>
  @endif
</div>
