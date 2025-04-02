<div class="container">
  <form method="POST" action="{{ route('process.name') }}">
    @csrf
    <div class="mb-3">
      <label for="first_name" class="form-label">First Name</label>
      <input type="text" class="form-control" id="first_name" name="first_name" required>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>

  @if (session('result'))
    <div class="mt-3 alert alert-info">
      Result: {{ session('result') }}
    </div>
  @endif
</div>
