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
@WebServlet(name = "HRServletQuizSelect", urlPatterns = { "/quiz/select" })
public class AnagramServletQuizSelect extends HttpServlet {

	private AnagramQuizService anagramQuizService = new AnagramQuizService();
	private AnagramUserService anagramUserService = new AnagramUserService();
	
	@Override
	public void doPost(HttpServletRequest request, HttpServletResponse response) throws IOException, ServletException {

		/****************************************************************************
		 * 1. Get data from request
		 ****************************************************************************/
		String quizId = request.getParameter("quizId");
		/****************************************************************************
		 * 2. Perform business logic
		 ****************************************************************************/
		UserService us = UserServiceFactory.getUserService();
		User u = us.getCurrentUser();
		AnagramUser anagramUser = anagramUserService.getAnagramUser(u.getUserId());		
		
		
		// we need to get access to the google user service
		AnagramQuiz quiz = anagramQuizService.getAnagramQuiz(quizId);
		
		// now set the currently selected user
		anagramUser.setSelectedQuiz(quiz);
		
		// save the user
		anagramUserService.saveAnagramUser(anagramUser);

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