<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Multiple File Upload</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h3>Multiple File Upload</h3>
        <form id="fileUploadForm" method="POST" action="{{ route('file.upload') }}" enctype="multipart/form-data">
            @csrf
            <div id="fileList" class="mb-3">
                <!-- Dynamic file inputs will be added here -->
            </div>
            <button type="button" id="addFileButton" class="btn btn-primary">Add File</button>
            <button type="submit" class="btn btn-success">Upload Files</button>
        </form>
    </div>

    <!-- Bootstrap JS and Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <!-- JavaScript for Handling File Inputs -->
    <script>
        // Add file input fields one by one
        document.getElementById('addFileButton').addEventListener('click', function () {
            const fileList = document.getElementById('fileList');

            // Create a file input group with a remove button
            const fileGroup = document.createElement('div');
            fileGroup.classList.add('input-group', 'mb-2');
            
            // Create the file input
            const fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.name = 'files[]';
            fileInput.classList.add('form-control');
            
            // Create the remove button (cross symbol)
            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.classList.add('btn', 'btn-danger', 'removeFileButton');
            removeButton.innerHTML = '×'; // Cross symbol

            // Append the file input and remove button to the file group
            fileGroup.appendChild(fileInput);
            fileGroup.appendChild(removeButton);

            // Append the file group to the file list
            fileList.appendChild(fileGroup);

            // Add event listener for removing the file input group
            removeButton.addEventListener('click', function () {
                fileGroup.remove();
            });
        });

        // Handle form submission with AJAX
        document.getElementById('fileUploadForm').addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent default form submission

            const formData = new FormData(this);

            fetch("{{ route('file.upload') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Files uploaded successfully');
                    // Optionally, clear the file list after successful upload
                    document.getElementById('fileList').innerHTML = '';
                }
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>
