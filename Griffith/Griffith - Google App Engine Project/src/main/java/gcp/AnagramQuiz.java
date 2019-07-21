package gcp;

import java.util.Arrays;

import com.googlecode.objectify.Ref;
import com.googlecode.objectify.annotation.Entity;
import com.googlecode.objectify.annotation.Id;
import com.googlecode.objectify.annotation.Index;
import com.googlecode.objectify.annotation.Load;
@Entity
public class AnagramQuiz {

	@Id
	private String quizId;

	private String sortedKey;
	

	@Index
	private String word;

	@Index
	@Load
	private Ref<AnagramUser> quizOwner;

	public String getQuizId() {
		return quizId;
	}

	public void setQuizId(String quizId) {
		this.quizId = quizId;
	}

	public String getWord() {
		return word;
	}

	public void setWord(String word) {
		this.word = word;
	}

	public AnagramUser getQuizOwner() {
		return quizOwner.get();
	}

	public void setQuizOwner(AnagramUser quizOwner) {
		this.quizOwner = Ref.create(quizOwner);
	}

	public String getSortedKey() {
		return sortedKey;
	}

	public void setSortedKey(String sortedKey) {
		this.sortedKey = sortedKey;
	}

	
	/**
	 * lower cases a word, then sorts it and returns
	 * <p>
	 * Large = aelgr
	 * LAGER  = aelgr 
	 */
	public static String createKey(String userId, String word) {
		String sortedLowerCase = createSortedKey(word);
		
		return userId + "-" + sortedLowerCase;
	}

	public static String createSortedKey(String word) {
		char[] charArray = word.toLowerCase().toCharArray();
		Arrays.sort(charArray);
		String sortedLowerCase = new String(charArray);
		return sortedLowerCase;
	}
}
