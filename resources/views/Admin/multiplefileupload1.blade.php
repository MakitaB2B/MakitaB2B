<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- <form id="uploadForm" enctype="multipart/form-data">
        <label for="files">Choose Files:</label>
        <input type="file" id="files" name="files[]" multiple>
        <button type="submit">Upload Files</button>
    </form> -->
    <!-- <div id="progress"></div> -->


    <!-- <form id="fileUploadForm" method="POST" action="{{ route('file.upload') }}" enctype="multipart/form-data">
    @csrf
    <div id="fileInputs" class="mb-3">
        
    </div>
    <button type="button" id="addFileBtn" class="btn btn-primary">Add File</button>
    <button type="submit" class="btn btn-success">Upload Files</button>
    </form> -->

    <form id="fileUploadForm" method="POST" action="{{ route('file.upload') }}" enctype="multipart/form-data">
    @csrf
    <div id="fileList" class="mb-3">
        <!-- Files added will be displayed here -->
    </div>
    <button type="button" id="addFileButton" class="btn btn-primary">Add File</button>
    <button type="submit" class="btn btn-success">Upload Files</button>
</form>


    <script>
//     document.getElementById("uploadForm").addEventListener("submit", async function(e) {

//         console.log("hi");
//     e.preventDefault();
//     let formData = new FormData(this);

//     try {
//         let response = await fetch("/admin/upload-files", {
//             method: "POST",
//             body: formData,
//             headers: {
//                 "X-CSRF-TOKEN": "{{ csrf_token() }}"
//             }
//         });

//         if (response.ok) {
//             let result = await response.json();
//             alert("Files uploaded successfully!");
//         } else {
//             alert("Error uploading files.");
//         }
//     } catch (error) {
//         console.error("Upload failed", error);
//     }
// });


// let fileIndex = 0;

// document.getElementById('addFileBtn').addEventListener('click', function () {
//     const fileInputsDiv = document.getElementById('fileInputs');
//     const fileInputGroup = document.createElement('div');
//     fileInputGroup.classList.add('input-group', 'mb-2');
//     fileInputGroup.innerHTML = `
//         <input type="file" name="files[]" class="form-control" />
//         <button type="button" class="btn btn-danger removeFileBtn">Remove</button>
//     `;
//     fileInputsDiv.appendChild(fileInputGroup);

//     // Attach event listener to the remove button
//     fileInputGroup.querySelector('.removeFileBtn').addEventListener('click', function () {
//         fileInputGroup.remove();
//     });
// });


document.getElementById('addFileButton').addEventListener('click', function () {
    const fileList = document.getElementById('fileList');

    // Create a file input group
    const fileGroup = document.createElement('div');
    fileGroup.classList.add('input-group', 'mb-2');
    
    // Create the file input and remove button
    const fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.name = 'files[]';
    fileInput.classList.add('form-control');
    
    const removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.classList.add('btn', 'btn-danger', 'removeFileButton');
    removeButton.innerHTML = '×'; // Cross symbol

    // Append file input and remove button to file group
    fileGroup.appendChild(fileInput);
    fileGroup.appendChild(removeButton);

    // Append file group to file list
    fileList.appendChild(fileGroup);

    // Add event listener for the remove button
    removeButton.addEventListener('click', function () {
        fileGroup.remove();
    });
});




</script>
</body>
</html>