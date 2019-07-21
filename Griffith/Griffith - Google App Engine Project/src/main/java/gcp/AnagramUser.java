package gcp;

import com.googlecode.objectify.Ref;
import com.googlecode.objectify.annotation.Entity;
import com.googlecode.objectify.annotation.Id;
import com.googlecode.objectify.annotation.Index;

@Entity
public class AnagramUser {
	@Id
	private String userId;

	@Index // makes the next variable searchable in the datastore
	private boolean quizMaster;
	
	private Ref<AnagramQuiz> selectedQuiz;

	public String getUserId() {
		return userId;
	}

	public void setUserId(String userId) {
		this.userId = userId;
	}

	public boolean isQuizMaster() {
		return quizMaster;
	}

	public void setQuizMaster(boolean quizMaster) {
		this.quizMaster = quizMaster;
	}
	
	public AnagramQuiz getSelectedQuiz() {
		if (selectedQuiz == null) {
			return null;
		}
		return selectedQuiz.get();
	}
	
	public void setSelectedQuiz(AnagramQuiz selectedQuiz) {
		this.selectedQuiz = Ref.create(selectedQuiz);
	}
}
