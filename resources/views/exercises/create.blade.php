<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Exercise</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-white">
                    <h4 class="mb-0">Add New Exercise</h4>
                </div>
                <div class="card-body">
                    
                    <form id="exerciseForm" action="{{ route('exercises.store') }}" method="POST">
                        @csrf 
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="e.g. Bench Press" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Muscle Group</label>
                            <input type="text" name="muscle_group" class="form-control" placeholder="e.g. Chest" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Level</label>
                            <select name="level" class="form-select">
                                <option value="Beginner">Beginner</option>
                                <option value="Intermediate">Intermediate</option>
                                <option value="Advanced">Advanced</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4" placeholder="Describe the exercise..." required></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Exercise</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script> //API tht validate bad words in the title
    document.getElementById('exerciseForm').addEventListener('submit', function(event) {
        event.preventDefault(); // останавливаем отправку
        
        let titleInput = document.querySelector('input[name="title"]');
        let titleValue = titleInput.value;
        let submitBtn = this.querySelector('button[type="submit"]');
        let originalBtnText = submitBtn.innerText;

        // блок кнопки
        submitBtn.innerText = "Validating...";
        submitBtn.disabled = true;

        //отправляем запрос к API
        fetch('https://www.purgomalum.com/service/json?text=' + encodeURIComponent(titleValue))
            .then(response => response.json())
            .then(data => {
                // если API нашел плохие слова, он заменит их на звездочки
                if (data.result.includes('*')) {
                    alert("Validation Error: Please use appropriate language in the title.");
                    submitBtn.innerText = originalBtnText;
                    submitBtn.disabled = false;
                } else {
                    // если все ок то отправляем форму
                    event.target.submit();
                }
            })
            .catch(error => {
                console.error('API Error:', error);
                // В случае ошибки API все равно отправляем форму, чтобы не блокировать работу
                event.target.submit(); 
            });
    });
</script>

</body>
</html>