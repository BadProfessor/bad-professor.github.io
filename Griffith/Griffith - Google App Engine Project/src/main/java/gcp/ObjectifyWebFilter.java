package gcp;

import javax.servlet.FilterConfig;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebFilter;

import com.googlecode.objectify.ObjectifyFilter;
import com.googlecode.objectify.ObjectifyService;

/**
 * Filter required by Objectify to clean up any thread-local transaction contexts and pending
 * asynchronous operations that remain at the end of a request.
 */
@WebFilter(urlPatterns = {"/*"})
public class ObjectifyWebFilter extends ObjectifyFilter {

	@Override
	public void init(FilterConfig filterConfig) throws ServletException {
		super.init(filterConfig);
		ObjectifyService.register(AnagramQuiz.class);
		ObjectifyService.register(AnagramQuizResults.class);
		ObjectifyService.register(AnagramUser.class);
		ObjectifyService.register(Dictionary.class);
	}
}