package gcp;

import java.io.IOException;
import java.util.List;

import javax.servlet.RequestDispatcher;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import com.google.appengine.api.users.User;
import com.google.appengine.api.users.UserService;
import com.google.appengine.api.users.UserServiceFactory;

/**
 * This is the default servlet that will ensure the user is logged in
 * 
 *
 */
@WebServlet(name = "AnagramServlet", urlPatterns = { "/" })
public class AnagramServlet extends HttpServlet {

	private AnagramQuizService anagramQuizService = new AnagramQuizService();
	private AnagramUserService anagramUserService = new AnagramUserService();

	@Override
	public void doGet(HttpServletRequest request, HttpServletResponse response) throws IOException, ServletException {

		// set the contenxt type to html
		response.setContentType("text/html");
		// we need to get access to the google user service
		UserService us = UserServiceFactory.getUserService();
		User u = us.getCurrentUser();
		// the user service fives the login and logout urls
		String login_url = us.createLoginURL("/");
		String logout_url = us.createLogoutURL("/");
		AnagramUser anagramUser = null;
		if (u != null) {
			anagramUser = anagramUserService.getAnagramUser(u.getUserId());

			// any user whos login contains quizmaster.ie is a a quiz Master
			boolean isQuizMaster = u.getEmail().contains("quizmaster.ie");
			
			// if the employee does exist then create it
			if (anagramUser == null) {
				anagramUser = new AnagramUser();
				anagramUser.setUserId(u.getUserId());
				
				// If I am an quizmaster then set the quiz master level on creation
				if (isQuizMaster) {
					anagramUser.setQuizMaster(true);
				}
				
				// saving the user
				anagramUserService.saveAnagramUser(anagramUser);
			}
			// always set my quizes
			request.setAttribute("myQuizs", anagramQuizService.getQuizesForUser(anagramUser));

			if (anagramUser.getSelectedQuiz() != null) {
				request.setAttribute("myQuizResults", anagramQuizService.getAnagramQuizResults(anagramUser.getUserId(),
						anagramUser.getSelectedQuiz().getQuizId()));

				List<AnagramQuizResults> scores = anagramQuizService.getScores(anagramUser.getSelectedQuiz().getQuizId());
				request.setAttribute("scoreBoardResults",
						scores);

			}
		}

		// attach a few things to the request such that we can access them in the jsp
		request.setAttribute("loggedInUser", anagramUser);

		request.setAttribute("user", u);
		request.setAttribute("login_url", login_url);
		request.setAttribute("logout_url", logout_url);

		// If the tab is not set then
		if (request.getAttribute("activeTab") == null) {
			request.setAttribute("activeTab", "home");
		}

		// get a request dispatcher and launch a jsp that will render our page
		RequestDispatcher rd = request.getRequestDispatcher("/WEB-INF/root.jsp");
		rd.forward(request, response);
	}

	/**
	 * the doPost method is called for when a HTTP Post is called
	 */
	@Override
	public void doPost(HttpServletRequest request, HttpServletResponse response) throws IOException, ServletException {
		doGet(request, response);
	}

}