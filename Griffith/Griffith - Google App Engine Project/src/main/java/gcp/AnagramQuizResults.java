package gcp;

import java.util.HashSet;
import java.util.Set;

import com.googlecode.objectify.Ref;
import com.googlecode.objectify.annotation.Entity;
import com.googlecode.objectify.annotation.Id;
import com.googlecode.objectify.annotation.Index;
import com.googlecode.objectify.annotation.Load;
@Entity
public class AnagramQuizResults {
	@Id
	private String userQuizId;

	@Index
	private String quizId;
	
	private Set<String> answers = new HashSet<>();
	
	@Index
	@Load
	private Ref<AnagramUser> contestant;

	
	public String getUserQuizId() {
		return userQuizId;
	}

	public void setUserQuizId(String userQuizId) {
		this.userQuizId = userQuizId;
	}


	
	public Set<String> getAnswers() {
		return answers;
	}

	public void setAnswers(Set<String> answers) {
		this.answers = answers;
	}
	
	public int getAnswersCount() {
		return answers.size();
	}
	public void setAnswersCount(int i) {
	}

	public String getQuizId() {
		return quizId;
	}

	public void setQuizId(String quizId) {
		this.quizId = quizId;
	}


	public AnagramUser getContestant() {
		return contestant.get();
	}

	public void setContestant(AnagramUser contestant) {
		this.contestant = Ref.create(contestant);
	}

}
