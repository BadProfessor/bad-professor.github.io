package gcp;

import static com.googlecode.objectify.ObjectifyService.ofy;

import java.util.ArrayList;
import java.util.Collections;
import java.util.Comparator;
import java.util.List;

import com.googlecode.objectify.cmd.Query;

/**
 */
public class AnagramQuizService {

	public AnagramQuiz getAnagramQuiz(String quizId) {
		AnagramQuiz quiz = ofy().load().type(AnagramQuiz.class).id(quizId).now();
		return quiz;
	}
	
	public boolean isValidWordInDictionary(String word) {
		Dictionary wordcheck = ofy().load().type(Dictionary.class).id(word).now();
		
		if (wordcheck == null) {
			return false;
		}
		else return true;
	}
	
	public void saveAnagramQuiz(AnagramQuiz anagramQuiz) {
		ofy().save().entities(anagramQuiz).now();
	}
	
	
	public AnagramQuizResults getAnagramQuizResults(String userId, String quizId) {
		AnagramQuizResults results = ofy().load().type(AnagramQuizResults.class).id(userId + "-" + quizId).now();
		return results;
	}
	
	public void saveAnagramQuizResults(AnagramQuizResults anagramQuizResults) {
		ofy().save().entities(anagramQuizResults).now();
	}
	
	
	public List<AnagramQuizResults> getScores(String quizId)  {
		Query<AnagramQuizResults> results = ofy().load().type(AnagramQuizResults.class).filter("quizId", quizId);
		List<AnagramQuizResults> list = results.list();
		
		// now we must sort the list by number of scores
		Collections.sort(list, new Comparator<AnagramQuizResults>() {

			@Override
			public int compare(AnagramQuizResults o1, AnagramQuizResults o2) {
				return Integer.compare(o2.getAnswers().size(),o1.getAnswers().size());
			}
			
		});
		
		return list;
	}
	
	
	/**
	 * Allows the ability to search by first name
	 * 
	 * https://github.com/objectify/objectify/wiki/Queries#executing-queries
	 * 
	 * @param word
	 * @return
	 */
	public List<AnagramQuiz> searchQuizesByWord(String word) {
		// return new ArrayList<>();
		Query<AnagramQuiz> filter = ofy().load().type(AnagramQuiz.class).filter("word", word);
		return filter.list();
	}

	
	/**
	 * @return List of Quizes that are managers
	 */
	public List<AnagramQuiz> getQuizes() {
		Query<AnagramQuiz> filter = ofy().load().type(AnagramQuiz.class).order("word");
		return filter.list();		
	}

	/**
	 * @return List of Quizes created by a users
	 */
	public List<AnagramQuiz> getQuizesForUser(AnagramUser user) {
		Query<AnagramQuiz> filter = ofy().load().type(AnagramQuiz.class).filter("quizOwner", user).order("word");
		return filter.list();		
	}
}
