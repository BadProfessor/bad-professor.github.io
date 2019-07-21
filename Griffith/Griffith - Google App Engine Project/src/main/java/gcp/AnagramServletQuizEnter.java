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
 * 
 *
 */
@WebServlet(name = "HRServletQuizEnter", urlPatterns = { "/quiz/enter" })
public class AnagramServletQuizEnter extends HttpServlet {

	private AnagramQuizService anagramQuizService = new AnagramQuizService();
	private AnagramUserService anagramUserService = new AnagramUserService();
	
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
		AnagramUser anagramUser = anagramUserService.getAnagramUser(u.getUserId());		
		
		AnagramQuiz selectedQuiz = anagramUser.getSelectedQuiz();
		
		if (selectedQuiz != null) {
			AnagramQuizResults anagramQuizResults = anagramQuizService.getAnagramQuizResults(u.getUserId(), selectedQuiz.getQuizId());
			if (anagramQuizResults == null) {
				anagramQuizResults  = new AnagramQuizResults();
				anagramQuizResults.setUserQuizId(u.getUserId() +"-" + selectedQuiz.getQuizId());
				anagramQuizResults.setQuizId(selectedQuiz.getQuizId());
				anagramQuizResults.setContestant(anagramUser);
			}
			
			// Only a valid anagram if it is of the same number of letters.
			String key = AnagramQuiz.createSortedKey(word);
			if (! key.equalsIgnoreCase(selectedQuiz.getSortedKey())) {
				request.setAttribute("errorMessage", "The word entered is not an anagram of  "  + selectedQuiz.getWord());
			} else if (!anagramQuizService.isValidWordInDictionary(word)) {
				request.setAttribute("errorMessage", word + " is not a valid word.");
			}
			
			else {
				// add the word to the quizzes
				anagramQuizResults.getAnswers().add(word);
			}
			anagramQuizService.saveAnagramQuizResults(anagramQuizResults);
			
		}
			
		/****************************************************************************
		 * 3. optionally set data attributes on request
		 ****************************************************************************/

		/****************************************************************************
		 * 4. Set active tab and forward to /
		 ****************************************************************************/
		
		// the active tab will be employeeEdit
		
		// set the active tab in the html page to stay on the change profile
		request.setAttribute("activeTab", "quizView" );
		// forward to the root page for serving jsp
		RequestDispatcher rd = request.getRequestDispatcher("/");
		rd.forward(request, response);
	}

	@Override
	public void doGet(HttpServletRequest request, HttpServletResponse response) throws IOException, ServletException {
		doPost(request, response);
	}
	
}