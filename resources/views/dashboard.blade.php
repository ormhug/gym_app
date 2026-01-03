<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gym Helper - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .navbar-brand { font-weight: bold; letter-spacing: 1px; }
        /* Ссылка сортировки занимает всю ячейку заголовка */
        .sort-link { 
            text-decoration: none; 
            color: inherit; 
            display: block; 
            width: 100%; 
            height: 100%; 
            cursor: pointer;
        }
        .sort-link:hover { color: #0d6efd; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-5 shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="{{ route('dashboard') }}">GYM HELPER</a>

    <div class="d-flex align-items-center">
        @if(Cookie::get('guest_session'))
            <a href="{{ route('guest.plan') }}" class="btn btn-outline-light me-3 fw-bold">
                <i class="fa-solid fa-list"></i> My Plan
            </a>
        @endif
        
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown">
                <i class="fa-solid fa-user"></i> Guest User 
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                @if(Cookie::get('guest_session'))
                    <li><span class="dropdown-item-text text-muted small">Code: <b>{{ Cookie::get('guest_session') }}</b></span></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="{{ route('guest.logout') }}">Logout</a></li>
                @else
                    <li><a class="dropdown-item" href="{{ route('guest.login') }}">Login</a></li>
                    <li><a class="dropdown-item fw-bold text-primary" href="{{ route('guest.register') }}">Register</a></li>
                @endif
            </ul>
        </div>
    </div>
  </div>
</nav>

<div class="container">

    <div class="row mb-5 ">
        <div class="col-12">
            <div class="card shadow-sm border-0 ">
                <div class="card-header bg-dark d-flex justify-content-between align-items-center py-3 ">
                    <h4 class="mb-0 text-primary">All Exercises</h4>
                    <a href="{{ route('exercises.create') }}" class="btn btn-primary btn-sm">+ Add Exercise</a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>
                                    <a href="{{ route('dashboard', ['sort' => 'title', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="sort-link">
                                        Title @if(request('sort') == 'title') {{ request('direction') == 'asc' ? '▲' : '▼' }} @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ route('dashboard', ['sort' => 'muscle_group', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="sort-link">
                                        Muscle @if(request('sort') == 'muscle_group') {{ request('direction') == 'asc' ? '▲' : '▼' }} @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ route('dashboard', ['sort' => 'level', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="sort-link">
                                        Level @if(request('sort') == 'level') {{ request('direction') == 'asc' ? '▲' : '▼' }} @endif
                                    </a>
                                </th>
                                <th>My Plan</th>
                                <th class="text-end">Actions</th>
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
                                            <a href="{{ route('guest.toggle.exercise', $ex->exercise_id) }}" class="btn btn-sm btn-success">Added</a>
                                        @else
                                            <a href="{{ route('guest.toggle.exercise', $ex->exercise_id) }}" class="btn btn-sm btn-outline-success">+ Add</a>
                                        @endif
                                    @else
                                        <span class="text-muted small">Login</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#viewExercise{{ $ex->exercise_id }}">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                    <a href="{{ route('exercises.edit', $ex->exercise_id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    
                                    <form action="{{ route('exercises.destroy', $ex->exercise_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="viewExercise{{ $ex->exercise_id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ $ex->title }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Muscle:</strong> {{ $ex->muscle_group }}</p>
                                            <p><strong>Level:</strong> {{ $ex->level }}</p>
                                            <hr>
                                            <p class="text-muted">{{ $ex->description }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-3">No exercises found.</td></tr>
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
                <div class="card-header bg-dark d-flex justify-content-between align-items-center py-3">
                    <h4 class="mb-0 text-success">Supplies</h4>
                    <a href="{{ route('supplies.create') }}" class="btn btn-success btn-sm">+ Add Supply</a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>
                                    <a href="{{ route('dashboard', ['sort_supply' => 'title', 'direction_supply' => request('direction_supply') == 'asc' ? 'desc' : 'asc']) }}" class="sort-link">
                                        Product @if(request('sort_supply') == 'title') {{ request('direction_supply') == 'asc' ? '▲' : '▼' }} @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ route('dashboard', ['sort_supply' => 'category', 'direction_supply' => request('direction_supply') == 'asc' ? 'desc' : 'asc']) }}" class="sort-link">
                                        Category @if(request('sort_supply') == 'category') {{ request('direction_supply') == 'asc' ? '▲' : '▼' }} @endif
                                    </a>
                                </th>
                                <th>Link</th>
                                <th>My Plan</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($supplies as $sup)
                            <tr>
                                <td class="fw-bold">{{ $sup->title }}</td>
                                <td><span class="badge bg-secondary">{{ $sup->category }}</span></td>
                                <td>@if($sup->source) <a href="{{ $sup->source }}" target="_blank">Link </a> @else - @endif</td>
                                <td>
                                    @if($currentGuest)
                                        @if($currentGuest->supplies->contains($sup->supply_id))
                                            <a href="{{ route('guest.toggle.supply', $sup->supply_id) }}" class="btn btn-sm btn-success">Added</a>
                                        @else
                                            <a href="{{ route('guest.toggle.supply', $sup->supply_id) }}" class="btn btn-sm btn-outline-success">+ Add</a>
                                        @endif
                                    @else
                                        <span class="text-muted small">Login</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#viewSupply{{ $sup->supply_id }}">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                    <a href="{{ route('supplies.edit', $sup->supply_id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('supplies.destroy', $sup->supply_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            
                            <div class="modal fade" id="viewSupply{{ $sup->supply_id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ $sup->title }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Category:</strong> {{ $sup->category }}</p>
                                            <p class="text-muted">{{ $sup->description }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-3">No supplies found.</td></tr>
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