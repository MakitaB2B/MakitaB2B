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
                <!-- Dynamic file names will be added here -->
            </div>
            <button type="button" id="chooseFileButton" class="btn btn-primary">Choose Files</button>
            <button type="submit" class="btn btn-success">Upload Files</button>
        </form>
    </div>

    <!-- Bootstrap JS and Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <!-- JavaScript for Handling File Inputs -->
    <script>
        // Handle file selection
        document.getElementById('chooseFileButton').addEventListener('click', function () {
            const fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.name = 'files[]';
            fileInput.classList.add('form-control');
            fileInput.multiple = true; // Allow multiple file selection
            
            // Trigger the file input when the button is clicked
            fileInput.click();

            // Handle files selected by the user
            fileInput.addEventListener('change', function () {
                const files = fileInput.files;
                const fileListContainer = document.getElementById('fileList');
                
                // Display all selected files with a delete button
                for (let i = 0; i < files.length; i++) {
                    const fileItem = document.createElement('div');
                    fileItem.classList.add('input-group', 'mb-2');

                    // Create a label to show the file name
                    const fileLabel = document.createElement('span');
                    fileLabel.classList.add('form-control');
                    fileLabel.textContent = files[i].name;

                    // Create a remove button
                    const removeButton = document.createElement('button');
                    removeButton.type = 'button';
                    removeButton.classList.add('btn', 'btn-danger', 'removeFileButton');
                    removeButton.textContent = '×'; // Cross symbol

                    // Append the file label and remove button
                    fileItem.appendChild(fileLabel);
                    fileItem.appendChild(removeButton);
                    
                    // Append the file item to the list
                    fileListContainer.appendChild(fileItem);

                    // Add event listener for removing the file
                    removeButton.addEventListener('click', function () {
                        fileItem.remove(); // Remove the file from the list
                    });
                }
            });
        });

        // Handle form submission with AJAX (optional, can be omitted if not needed)
        document.getElementById('fileUploadForm').addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent the default form submission

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
