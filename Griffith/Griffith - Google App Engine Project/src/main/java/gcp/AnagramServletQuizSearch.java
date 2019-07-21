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
 * 
 *
 */
@WebServlet(name = "HRServletQuizSearch", urlPatterns = { "/quiz/search" })
public class AnagramServletQuizSearch extends HttpServlet {

	private AnagramQuizService anagramQuizService = new AnagramQuizService();

	@Override
	public void doPost(HttpServletRequest request, HttpServletResponse response) throws IOException, ServletException {

		/****************************************************************************
		 * 1. Get data from request
		 ****************************************************************************/
		String word = request.getParameter("word");

		/****************************************************************************
		 * 2. Perform business logic
		 ****************************************************************************/
		UserService us = UserServiceFactory.getUserService();
		User u = us.getCurrentUser();

		// we need to get access to the google user service
		List<AnagramQuiz> searchResults = null;

		if (word != null && word.length() > 0) {
			searchResults = anagramQuizService.searchQuizesByWord(word);
		} else {
			searchResults = anagramQuizService.getQuizes();
		}
		/****************************************************************************
		 * 3. optionally set data attributes on request
		 ****************************************************************************/
		request.setAttribute("searchResults", searchResults);

		/****************************************************************************
		 * 4. Set active tab and forward to /
		 ****************************************************************************/

		// the active tab will be employeeEdit

		// set the active tab in the html page to stay on the change profile
		request.setAttribute("activeTab", "quizSearch");
		// forward to the root page for serving jsp
		RequestDispatcher rd = request.getRequestDispatcher("/");
		rd.forward(request, response);
	}

	@Override
	public void doGet(HttpServletRequest request, HttpServletResponse response) throws IOException, ServletException {
		doPost(request, response);
	}

}