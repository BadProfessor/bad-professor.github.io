package gcp;

import static com.googlecode.objectify.ObjectifyService.ofy;

/**
 */
public class AnagramUserService {

	public AnagramUser getAnagramUser(String userId) {
		AnagramUser team = ofy().load().type(AnagramUser.class).id(userId).now();
		return team;
	}
	
	public void saveAnagramUser(AnagramUser anagramUser) {
		ofy().save().entities(anagramUser).now();
	}
	
}
