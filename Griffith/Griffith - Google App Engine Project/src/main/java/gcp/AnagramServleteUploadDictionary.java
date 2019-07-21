package gcp;

import static com.googlecode.objectify.ObjectifyService.ofy;

import java.io.BufferedInputStream;
import java.io.BufferedReader;
import java.io.ByteArrayInputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.util.List;
import java.util.Map;

import javax.servlet.RequestDispatcher;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import com.google.appengine.api.blobstore.BlobInfo;
import com.google.appengine.api.blobstore.BlobKey;
import com.google.appengine.api.blobstore.BlobstoreService;
import com.google.appengine.api.blobstore.BlobstoreServiceFactory;

/**
 *
 */
@WebServlet(name = "AnagramServleteUploadDictionary", urlPatterns = { "/uploadDictionary" })
public class AnagramServleteUploadDictionary extends HttpServlet {

	private BlobstoreService blobstoreService = BlobstoreServiceFactory.getBlobstoreService();

	@Override
	public void doPost(HttpServletRequest request, HttpServletResponse response) throws IOException, ServletException {


		/****************************************************************************
		 * 1. Get data from request
		 ****************************************************************************/
		Map<String, List<BlobKey>> blobs = blobstoreService.getUploads(request);
		List<BlobKey> blobKeys = blobs.get("dictionary");
		Map<String, List<BlobInfo>> blobInfos = blobstoreService.getBlobInfos(request);
		List<BlobInfo> infoList = blobInfos.get("dictionary");
		/****************************************************************************
		 * 2. Perform business logic
		 ****************************************************************************/
		// if the image is uploaded then set it
		if (blobKeys != null && !blobKeys.isEmpty()) {
			BlobKey dictionary = blobKeys.get(0);
			BlobInfo dictionaryInfo = infoList.get(0);
			byte[] fetchData = blobstoreService.fetchData(dictionary, 0,dictionaryInfo.getSize() );
			try (BufferedReader br = new BufferedReader(new InputStreamReader(new ByteArrayInputStream(fetchData)))) {
				String line = null;
				while((line = br.readLine()) != null) {
					Dictionary d = new Dictionary();
					d.setDictionaryWord(line);
					ofy().save().entities(d).now();
				}
			} catch (Exception e) {
				request.setAttribute("errorMessage", "Unable to process dictionary");
			}
		}


		/****************************************************************************
		 * 3. optionally set data attributes on request
		 ****************************************************************************/

		/****************************************************************************
		 * 4. Set active tab and forward to /
		 ****************************************************************************/

		// set the active tab in the html page to stay on the change profile
		request.setAttribute("activeTab", "changeProfile");
		// forward to the root page for serving jsp
		RequestDispatcher rd = request.getRequestDispatcher("/");
		rd.forward(request, response);
	}

	@Override
	public void doGet(HttpServletRequest request, HttpServletResponse response) throws IOException, ServletException {
		doPost(request, response);
	}

}