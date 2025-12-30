<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gym Helper - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        .navbar-brand { font-weight: bold; letter-spacing: 1px; }
        .section-title { border-bottom: 2px solid #dee2e6; padding-bottom: 10px; margin-bottom: 20px; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-5 shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="#">GYM HELPER</a>

    <div class="d-flex">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                👤 Guest User 
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                @if(Cookie::get('guest_session'))
                    <li><span class="dropdown-item-text text-muted small">Your Code: <b>{{ Cookie::get('guest_session') }}</b></span></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="{{ route('guest.logout') }}">Logout</a></li>
                @else
                    <li><a class="dropdown-item" href="{{ route('guest.login') }}">Login (Enter Code)</a></li>
                    <li><a class="dropdown-item fw-bold text-primary" href="{{ route('guest.register') }}">Register (New Code)</a></li>
                @endif
            </ul>
        </div>
    </div>
  </div>
</nav>

<div class="container">

    @if($currentGuest)
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow border-primary">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">My Personal Plan </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>My Exercises</h5>
                            @if($currentGuest->exercises->count() > 0)
                                <ul class="list-group">
                                    @foreach($currentGuest->exercises as $myEx)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $myEx->title }}
                                            <a href="{{ route('guest.toggle.exercise', $myEx->exercise_id) }}" class="btn btn-sm btn-outline-danger">Remove</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">Your plan is empty. Add exercises below!</p>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <h5>My Supplies</h5>
                            @if($currentGuest->supplies->count() > 0)
                                <ul class="list-group">
                                    @foreach($currentGuest->supplies as $mySup)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $mySup->title }}
                                            <a href="{{ route('guest.toggle.supply', $mySup->supply_id) }}" class="btn btn-sm btn-outline-danger">Remove</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">Your list is empty. Add products below!</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h4 class="mb-0 text-primary">All Exercises</h4>
                    <a href="{{ route('exercises.create') }}" class="btn btn-primary btn-sm">+ Add Exercise</a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Title</th>
                                <th>Muscle</th>
                                <th>Level</th>
                                <th>My Plan</th> <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($exercises as $ex)
                            <tr>
                                <td class="fw-bold">{{ $ex->title }}</td>
                                <td>{{ $ex->muscle_group }}</td>
                                <td>
                                    <span class="badge bg-{{ $ex->level == 'Beginner' ? 'success' : ($ex->level == 'Intermediate' ? 'warning' : 'danger') }}">
                                        {{ $ex->level }}
                                    </span>
                                </td>
                                <td>
                                    @if($currentGuest)
                                        @if($currentGuest->exercises->contains($ex->exercise_id))
                                            <a href="{{ route('guest.toggle.exercise', $ex->exercise_id) }}" class="btn btn-sm btn-success">✅ Added</a>
                                        @else
                                            <a href="{{ route('guest.toggle.exercise', $ex->exercise_id) }}" class="btn btn-sm btn-outline-success">+ Add</a>
                                        @endif
                                    @else
                                        <span class="text-muted small">Login to add</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('exercises.edit', $ex->exercise_id) }}" class="btn btn-sm btn-outline-primary">✏️</a>
                                    <form action="{{ route('exercises.destroy', $ex->exercise_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">🗑️</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-3">No exercises added yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h4 class="mb-0 text-success">Supplies</h4>
                    <a href="{{ route('supplies.create') }}" class="btn btn-success btn-sm">+ Add Supply</a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Link</th>
                                <th>My Plan</th> <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($supplies as $sup)
                            <tr>
                                <td class="fw-bold">{{ $sup->title }}</td>
                                <td><span class="badge bg-secondary">{{ $sup->category }}</span></td>
                                <td>
                                    @if($sup->source) <a href="{{ $sup->source }}" target="_blank">Link 🔗</a> @else - @endif
                                </td>
                                <td>
                                    @if($currentGuest)
                                        @if($currentGuest->supplies->contains($sup->supply_id))
                                            <a href="{{ route('guest.toggle.supply', $sup->supply_id) }}" class="btn btn-sm btn-success">✅ Added</a>
                                        @else
                                            <a href="{{ route('guest.toggle.supply', $sup->supply_id) }}" class="btn btn-sm btn-outline-success">+ Add</a>
                                        @endif
                                    @else
                                        <span class="text-muted small">Login to add</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('supplies.edit', $sup->supply_id) }}" class="btn btn-sm btn-outline-primary">✏️</a>
                                    <form action="{{ route('supplies.destroy', $sup->supply_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">🗑️</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-3">No supplies added yet.</td></tr>
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