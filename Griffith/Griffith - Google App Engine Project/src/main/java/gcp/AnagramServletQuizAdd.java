package gcp;

import java.io.IOException;

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
@WebServlet(name = "HRServletTeamAdd", urlPatterns = { "/quiz/add" })
public class AnagramServletQuizAdd extends HttpServlet {

	private AnagramQuizService anagramQuizService = new AnagramQuizService();
	private AnagramUserService anagramUserService = new AnagramUserService();

	@Override
	public void doPost(HttpServletRequest request, HttpServletResponse response) throws IOException, ServletException {
		/****************************************************************************
		 * 1. Get data from request
		 ****************************************************************************/
		String quizWord = request.getParameter("quizWord");

		/****************************************************************************
		 * 2. Perform business logic
		 ****************************************************************************/

		if (quizWord != null && quizWord.length() > 0) {
			UserService us = UserServiceFactory.getUserService();
			User u = us.getCurrentUser();
			AnagramUser anagramUser = anagramUserService.getAnagramUser(u.getUserId());

			AnagramQuiz anagramQuiz = new AnagramQuiz();
			anagramQuiz.setQuizId(AnagramQuiz.createKey(u.getUserId(), quizWord));
			anagramQuiz.setSortedKey(AnagramQuiz.createSortedKey(quizWord));
			anagramQuiz.setWord(quizWord);
			anagramQuiz.setQuizOwner(anagramUser);

			anagramQuizService.saveAnagramQuiz(anagramQuiz);
		} else {
			request.setAttribute("errorMessage", "A word must be provided");
		}

		/****************************************************************************
		 * 3. optionally set data attributes on request
		 ****************************************************************************/

		/****************************************************************************
		 * 4. Set active tab and forward to /
		 ****************************************************************************/
		// set the active tab in the html page to stay on the change profile
		request.setAttribute("activeTab", "quizView");
		// forward to the root page for serving jsp
		RequestDispatcher rd = request.getRequestDispatcher("/");
		rd.forward(request, response);
	}

}