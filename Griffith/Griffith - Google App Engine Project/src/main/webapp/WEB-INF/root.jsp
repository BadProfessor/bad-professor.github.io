<%@page import="com.google.appengine.api.blobstore.BlobstoreService"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%>


<%@ page import="java.util.List"%>
<%@ page
	import="com.google.appengine.api.blobstore.BlobstoreServiceFactory"%>

<%
	BlobstoreService blobstoreService = BlobstoreServiceFactory.getBlobstoreService();
%>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">


<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<script>

</script>

</head>
<title>Anagram Quiz Application</title>
</head>
<body>


	<!-- if the user is logged in then we need to render one version of the page
consequently if the user is logged out we need to render a different version
of the page
-->

	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">Amazing Anagram Quiz :D</a>
			</div>
			<ul class="nav navbar-nav">
				<c:choose>
					<c:when test="${user != null}">
						<li class="active"><a href="#">Welcome ${user.email}</a></li>

						<li class="active"><a href="${logout_url}">Logout</a></li>

					</c:when>
					<c:otherwise>
						<li class="active"><a href="${login_url}">Login</a></li>
					</c:otherwise>
				</c:choose>
			</ul>
		</div>
	</nav>




	<div class="container">
		<c:choose>
			<c:when test="${errorMessage != null}">
				<div class="alert  alert-warning fade in">
					<strong>Warning!</strong> ${errorMessage}
				</div>
			</c:when>
			<c:when test="${fyi != null}">
				<div class="alert  alert-info fade in">
					<strong>FYI </strong> ${fyi}
				</div>
			</c:when>
		</c:choose>



		<c:choose>
			<c:when test="${user != null}">

				<h2>Actions for you today</h2>


				<!--  The Tab Definitions  -->
				<ul class="nav nav-tabs">
					<!-- All logged in users see change profile and my teams -->
					<c:choose>
						<c:when test="${loggedInUser != null}">
							<li><a data-toggle="tab" href="#home">Home</a></li>
							<li><a data-toggle="tab" href="#quizSearch">Search
									Anagram Quizes</a></li>
							<li><a data-toggle="tab" href="#quizView">Current
									Anagram Quiz</a></li>
							<c:choose>
								<c:when test="${loggedInUser.quizMaster}">
									<li><a data-toggle="tab" href="#myQuizs">My Quizes</a></li>
									<li><a data-toggle="tab" href="#quizAdd">Add Quiz</a></li>
									<li><a data-toggle="tab" href="#upload">Upload Dictionary</a></li>
								</c:when>
							</c:choose>
						</c:when>
					</c:choose>
				</ul>

				<div class="tab-content">
					<div id="home" class="tab-pane fade in active">
						<h3>HOME</h3>
						<p>Welcome to the home page of the amazing Anagram Quiz Application</p>
					</div>



					<div id="quizView" class="tab-pane fade">
						<h1>Quiz for : ${loggedInUser.selectedQuiz.word}</h1>

						<form action="/quiz/enter" method="post">
							<!-- this is how you get a single line of text from the user -->
							<div class="form-group">
								<label for="usr">Word</label> <input type="text"
									class="form-control" name="word" id="word">
							</div>

							<!-- a submit button -->
							<input type="submit" class="btn btn-info" value="Enter Quiz" />
							<br />
						</form>


						<h1>My answers for : ${loggedInUser.selectedQuiz.word}</h1>
						<!-- display the list of anagrams if not null-->
						<c:choose>
							<c:when test="${myQuizResults != null}">
								<table class="table">
									<thead>
										<tr>
											<th>Word</th>
										</tr>
									</thead>

									<tbody>
											<!-- PUT MY ANSWERS HERE -->
										<c:forEach items="${myQuizResults.answers}" var="result">
											<tr>
												<td>${result}</td>
											</tr>
										</c:forEach>
									</tbody>
								</table>
							</c:when>
						</c:choose>

						<h1>Score board for : ${loggedInUser.selectedQuiz.word}</h1>
						<!-- display the list of anagrams if not null-->
						<c:choose>
							<c:when test="${myQuizResults != null}">
								<table class="table">
									<thead>
										<tr>
											<th>Score</th>
											<th>Is it you?</th>
										</tr>
									</thead>

									<tbody>
										<c:forEach items="${scoreBoardResults}" var="result">
											<tr>
												<td>${result.answersCount}</td>
												<c:choose>
													<c:when
														test="${result.contestant.userId == loggedInUser.userId}">
														<td>YES</td>
													</c:when>
													<c:otherwise>
														<td>no</td>
													</c:otherwise>
												</c:choose>
											</tr>
										</c:forEach>
									</tbody>
								</table>
							</c:when>
						</c:choose>
					</div>


					<div id="quizSearch" class="tab-pane fade">
						<form action="/quiz/search" method="post">
							<!-- this is how you get a single line of text from the user -->
							<div class="form-group">
								<label for="usr">Word</label> <input type="text"
									class="form-control" name="word" id="word">
							</div>

							<!-- a submit button -->
							<input type="submit" class="btn btn-info" value="Search" /> <br />
						</form>

						<!-- display the list of anagrams if not null-->
						<c:choose>
							<c:when test="${searchResults != null}">
								<table class="table">
									<thead>
										<tr>
											<th>Word</th>
											<th>Owner</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<c:forEach items="${searchResults}" var="quiz">
											<tr>
												<td>${quiz.word}</td>
												<td>${quiz.quizOwner}</td>
												<td><a href="/quiz/select?quizId=${quiz.quizId}">Select</a></td>
											</tr>
										</c:forEach>
									</tbody>
								</table>
							</c:when>
						</c:choose>
					</div>
					
					
					<!--  Only for Quiz Masters -->
					<c:choose>
						<c:when test="${loggedInUser.quizMaster}">

							<div id="myQuizs" class="tab-pane fade">
								<H1>My Quizes</H1>
								<c:choose>
									<c:when test="${myQuizs != null}">
										<table class="table">
											<thead>
												<tr>
													<th>Word</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<c:forEach items="${myQuizs}" var="quiz">
													<tr>
														<td>${quiz.word}</td>
														<td>${quiz.quizOwner}</td>
														<td><a href="/quiz/select?quizId=${quiz.quizId}">Select</a></td>
													</tr>
												</c:forEach>
											</tbody>		
										</table>
									</c:when>
								</c:choose>
							</div>
							
							
							<!--  START add Quiz -->
							<div id="quizAdd" class="tab-pane fade">
								<form action="/quiz/add" method="post">
									<div class="form-group">

										<!--  input the team Id -->
										<label for="usr">Word</label> <input type="text"
											class="form-control" name="quizWord" id="quizWord">

									</div>
									<!-- a submit button -->
									<input type="submit" class="btn btn-info" value="Add" /> <br />
								</form>



							</div>
							<!--  END add Team -->

							<!--  The section to upload the dictionary -->
							<div id="upload" class="tab-pane fade">
								<form action="<%= blobstoreService.createUploadUrl("/uploadDictionary") %>" method="post" enctype="multipart/form-data">
									<div class="form-group">

										<!--  input the team Id -->
										<label for="usr">Dictionary</label> 
										<input type="file" class="form-control" name="dictionary" id="dictionary">

									</div>
									<!-- submit the Dictionary file -->
									<input type="submit" class="btn btn-primary" value="Add" /> <br />
								</form>
							</div>
						
						</c:when>
					</c:choose>
				</div>




			</c:when>
			<c:otherwise>
				<p>
					Welcome! <a href="${login_url}">Sign in or register</a>
				</p>
			</c:otherwise>
		</c:choose>
	</div>


	<script>

	$(document).ready(function(){
		<c:choose> 
			<c:when test="${activeTab != null}">
				// Select tab by name
				$('.nav-tabs a[href="#${activeTab}"]').tab('show')
			</c:when>
			<c:otherwise>
				// Select tab by name
				$('.nav-tabs a[href="#home"]').tab('show')
			</c:otherwise>
		</c:choose>		
	});
</script>

</body>
</html>