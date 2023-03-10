<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>File Upload</title>
  </head>
  <body>
    <h1>File Upload</h1>
    <input type="file" id="file-input">
    <button id="upload-button">Upload</button>
    <script src="script.js"></script>
	
	
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
		const uploadButton = document.querySelector('#upload-button');
		uploadButton.addEventListener('click', async () => {
		  const file = fileInput.files[0];
		  await uploadFile(file);
		});
	</script>
  </body>
</html>