<?php include "../inc/dbinfo.inc"; ?>
<?php
	// We need to use sessions, so you should always start sessions using the below code.
	session_start();
	// If the user is not logged in redirect to the login page...
	if (!isset($_SESSION['loggedin'])) {
		header('Location: index.html');
		exit;
	}	
	if ($_SESSION['code'] != 'activated') {
		header('Location: success.html');
	}
	
	$currusername = $_SESSION['name'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
	    <script src="https://unpkg.com/vue@1.0.28/dist/vue.js"></script>
		<script src="https://unpkg.com/axios@0.2.1/dist/axios.min.js"></script>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="Roberto Gentilini" />
        <title>Nuvola Cloud Storage</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body onload="javascript:show_contents();">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="index.html">Università di Pavia</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto py-4 py-lg-0">
                        <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="home.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="logout.php">Logout</a></li>
                        <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="profile.php"><?php echo $_SESSION['name'];?></a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page Header-->
        <header class="masthead" style="background-image: url('assets/img/home-bg.jpg')">
            <div class="container position-relative px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <div class="site-heading">
                            <h1>Nuvola</br>Cloud Storage</h1>
                            <span class="subheading"></span>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main Content-->
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
					<!--<div class="d-flex justify-content-end mb-4"><a class="btn btn-secondary text-uppercase" href="profile.php">User: ?php echo $_SESSION['name'];?</a></div>-->
                    <hr class="my-4" />
                    <div class="post-preview">
						<h2 class="post-title">Contents</h2>
						<!--<input type="submit" value="Show" id="btn" class="btn btn-primary text-uppercase" onclick="show_contents()">-->
						<br><p id="msgpar"></p>	
                    </div>
                    <!-- Divider-->
                    <hr class="my-4" />
                    <!-- Post preview-->
                    <div class="post-preview" id="app">
						<div v-if="!image">
							<a><h2>Upload file</h2></a>
							<input type="file" class="btn btn-primary text-uppercase" @change="onFileChange">
						</div>
						<div v-else>
							<img :src="image" width="500" />
							</br>
							<button v-if="!uploadURL" @click="removeImage" class="btn btn-primary text-uppercase">Remove file</button>
							<button v-if="!uploadURL" @click="uploadImage" class="btn btn-primary text-uppercase">Upload file</button>
						</div>
						<h2 v-if="uploadURL">Success! File uploaded to bucket.</h2>
                    </div>
                    <!-- Divider-->
                    <hr class="my-4" />
                    <!-- Pager-->
                </div>
            </div>
        </div>
        <!-- Footer-->
        <footer class="border-top">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <ul class="list-inline text-center">
                            <li class="list-inline-item">
                                <a href="#!">
                                    <span class="fa-stack fa-lg">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fab fa-twitter fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#!">
                                    <span class="fa-stack fa-lg">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fab fa-facebook-f fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#!">
                                    <span class="fa-stack fa-lg">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fab fa-github fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <div class="small text-center text-muted fst-italic">Copyright &copy; Nuvola Cloud Storage 2023</div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
		
		<script>
			const MAX_IMAGE_SIZE = 100000000
			const API_ENDPOINT = 'https://ciaxap8z77.execute-api.eu-central-1.amazonaws.com/uploads?filename=';
			const WEBSITE = 'https://sam-app-s3uploadbucket-1ut0y5lkfg694.s3.eu-central-1.amazonaws.com/';

			new Vue({
				el: "#app",
				data: {
					image: '',
					uploadURL: '',
					filename: ''
				},
				methods: {
					onFileChange (e) {
						let files = e.target.files || e.dataTransfer.files
						//if (!files.length) return
						this.createImage(files[0])
					},
					createImage (file) {
						let reader = new FileReader()
						reader.onload = (e) => {
							console.log('length: ')
							// Check if the uploaded file is too big
							if (e.target.result.length > MAX_IMAGE_SIZE) {
								return alert('File is loo large.')
							}
							// Check if the uploaded file is an image
							let extensionarray = ("gif jpg jpeg png");
							let nameextension = file.name.split('.').pop();
							if (extensionarray.includes(nameextension) == false) {
								return
							}
							this.image = e.target.result
							this.filename = file.name
						}
						reader.readAsDataURL(file)
					},
					removeImage: function (e) {
						console.log('Remove clicked')
						this.image = ''
						this.filename = ''
					},
					uploadImage: async function (e) {
						console.log('Upload clicked')
						// Get the pre-signed URL
						const response = await axios({
							method: 'GET',
							url: API_ENDPOINT + "<?php echo $currusername; ?>/" + this.filename
						})
						console.log('Response: ', response)
						console.log('Uploading: ', this.image)
						let binary = atob(this.image.split(',')[1])
						let array = []
						for (var i = 0; i < binary.length; i++) {
							array.push(binary.charCodeAt(i))
						}
						let blobData = new Blob([new Uint8Array(array)])
						console.log('Uploading to: ', response.uploadURL)
						const result = await fetch(response.uploadURL, {
							method: 'PUT',
							body: blobData
						})
						console.log('Result: ', result)
						// Final URL for the user (doesn't need the query string parameters)
						this.uploadURL = response.uploadURL.split('?')[0];
						console.log("usname: " + "<?php echo $currusername; ?>" + "; flname: " + this.filename);
						addToDatabase("<?php echo $currusername; ?>", this.filename);
						window.location.replace("home.php");
					}
				}
			})
		  
			

			function show_contents() {

				var requestOptions = {
				  method: 'GET',
				  redirect: 'follow'
				};

				name = "<?php echo $currusername ?>";

				fetch("https://j08lhrjnlk.execute-api.eu-central-1.amazonaws.com/default/get-items-in-bucket?searchedname=" + name, requestOptions)
				  .then(response => response.text())
				  
				  .then(result => {
					console.log(result);
					var files = result.toString().split('"filename":"');
					for (let i = files.length - 1; i >= 1; i--) {
						filename = files[i].split('","')[0];
						document.getElementById("msgpar").innerHTML = document.getElementById("msgpar").innerHTML + '<br><h4><a href="accessimg.php?' + name + "/" + filename + '">' + filename + '</a></h4> <input type="submit" value="Delete" id="delbtn" onclick="delete_file(' + "'" + name + "', '" + filename + "'" + ')"></br></br>';
					}
				  })
				  
				  .catch(error => console.log('error', error));

			}
			
			
			
			function delete_file(name, filename) {
				remFromDatabase(name, filename);
						
				var requestOptions = {
					method: 'DELETE',
					redirect: 'follow'
				};

				fetch("https://47ttwbrs8f.execute-api.eu-central-1.amazonaws.com/default/deleteitem?itemKey=" + name + "/" + filename, requestOptions)
				  .then(response => response.text())
				  .then(result => console.log(result))
				  .catch(error => console.log('error', error));
				
				window.location.replace("home.php");
			}
			
			
			
			function addToDatabase(usname, flname) {
				var requestOptions = {
				  method: 'POST',
				  redirect: 'follow'
				};

                console.log("https://0c3ycouajc.execute-api.eu-central-1.amazonaws.com/default/add-item-to-dynamodb?usname=" + usname + "&flname=" + flname);

                fetch("https://0c3ycouajc.execute-api.eu-central-1.amazonaws.com/default/add-item-to-dynamodb?usname=" + usname + "&flname=" + flname, requestOptions)
				  .then(response => response.text())
				  .then(result => console.log(result))
				  .catch(error => console.log('error', error));
			}
			
			
			
			function remFromDatabase(usname, flname) {
				var requestOptions = {
				  method: 'GET',
				  redirect: 'follow'
				};

				fetch("https://u0sw1444v3.execute-api.eu-central-1.amazonaws.com/default/delete-item-from-dynamodb?usname=" + usname + "&flname=" + flname, requestOptions)
				  .then(response => response.text())
				  .then(result => console.log(result))
				  .catch(error => console.log('error', error));
			}
		</script>		
    </body>
</html>

