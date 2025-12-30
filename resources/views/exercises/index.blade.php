<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymHelp - Exercises</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h4 class="mb-0 text-primary">All Exercises</h4>
                    <a href="{{ route('exercises.create') }}" class="btn btn-primary btn-sm">
                        + Add New
                    </a>
                </div>
                <div class="card-body p-0">
                    
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Muscle Group</th>
                                <th>Level</th>
                                <th style="width: 150px;" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($exercises as $item)
                            <tr>
                                <td>{{ $item->exercise_id }}</td>
                                <td class="fw-bold">{{ $item->title }}</td>
                                <td>{{ $item->muscle_group }}</td>
                                <td>
                                    @if($item->level == 'Beginner')
                                        <span class="badge bg-success">Beginner</span>
                                    @elseif($item->level == 'Intermediate')
                                        <span class="badge bg-warning text-dark">Intermediate</span>
                                    @else
                                        <span class="badge bg-danger">Advanced</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="#" class="btn btn-sm btn-outline-secondary" title="View">👁️</a>
                                        <a href="{{ route('exercises.edit', $item->exercise_id) }}" class="btn btn-sm btn-outline-primary" title="Edit">✏️</a>
                                        <form action="{{ route('exercises.destroy', $item->exercise_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this exercise?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">🗑️</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    No exercises found. <br>
                                    <a href="{{ route('exercises.create') }}">Create your first one!</a>
                                </td>
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