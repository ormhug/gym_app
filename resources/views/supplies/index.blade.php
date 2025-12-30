<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GymHelp - Supplies</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="#">GymHelp</a>
    <div class="navbar-nav">
      <a class="nav-link" href="{{ route('exercises.index') }}">Exercises</a>
      <a class="nav-link active" href="{{ route('supplies.index') }}">Supplies</a>
    </div>
  </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h4 class="mb-0 text-success">All Supplies</h4>
                    <a href="{{ route('supplies.create') }}" class="btn btn-success btn-sm">+ Add Product</a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Link/Source</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($supplies as $item)
                            <tr>
                                <td>{{ $item->supply_id }}</td>
                                <td class="fw-bold">{{ $item->title }}</td>
                                <td><span class="badge bg-secondary">{{ $item->category }}</span></td>
                                <td>
                                    @if($item->source)
                                        <a href="{{ $item->source }}" target="_blank">Link 🔗</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('supplies.edit', $item->supply_id) }}" class="btn btn-sm btn-outline-primary">✏️</a>
                                        <form action="{{ route('supplies.destroy', $item->supply_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this product?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">🗑️</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No supplies yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>