<!DOCTYPE html>
<html>
<head>
  <title>Upload File</title>
</head>
<body>
  <input type="file" id="file-input" />
  <script>
    const uploadFile = async (file) => {
      const endpoint = 'https://n6pjsuhak0.execute-api.eu-central-1.amazonaws.com/default/upload-item';
      const filename = file.name;
      const fileContent = await file.arrayBuffer();
      const formData = new FormData();
      formData.append('filename', filename);
      formData.append('file', new Blob([fileContent]));

      const response = await fetch(endpoint, {
        method: 'POST',
        body: formData
      });
      const result = await response.text();
      console.log(result);
    }

    const fileInput = document.querySelector('#file-input');
    fileInput.addEventListener('change', async (event) => {
      const file = event.target.files[0];
      await uploadFile(file);
    });
  </script>
</body>
</html>