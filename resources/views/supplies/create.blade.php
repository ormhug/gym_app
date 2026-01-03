<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Supply</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow col-md-8 mx-auto">
        <div class="card-header bg-white"><h4>Add New Supplement</h4></div>
        <div class="card-body">
            <form id="supplyForm" action="{{ route('supplies.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Product Name</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. Whey Protein Gold" required>
                </div>
                <div class="mb-3">
                    <label>Category</label>
                    <select name="category" class="form-select">
                        <option value="Protein">Protein</option>
                        <option value="Vitamins">Vitamins</option>
                        <option value="Pre-workout">Pre-workout</option>
                        <option value="Gear">Gear/Equipment</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Source Link (Optional)</label>
                    <input type="text" name="source" class="form-control" placeholder="https://amazon.com/...">
                </div>
                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3" required></textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success">Save Product</button>
                    
                </div>
            </form>
        </div>
    </div>
</div>


<script> //API tht validate bad words in the title
    document.getElementById('supplyForm').addEventListener('submit', function(event) {
        event.preventDefault(); 
        
        let titleInput = document.querySelector('input[name="title"]');
        let titleValue = titleInput.value;
        let submitBtn = this.querySelector('button[type="submit"]');
        let originalBtnText = submitBtn.innerText;

        submitBtn.innerText = "Validating...";
        submitBtn.disabled = true;

        fetch('https://www.purgomalum.com/service/json?text=' + encodeURIComponent(titleValue))
            .then(response => response.json())
            .then(data => {
                if (data.result.includes('*')) {
                    alert("Validation Error: Please use appropriate language in the title.");
                    submitBtn.innerText = originalBtnText;
                    submitBtn.disabled = false;
                } else {
                    event.target.submit();
                }
            })
            .catch(error => {
                event.target.submit(); 
            });
    });
</script>
</body>
</html>