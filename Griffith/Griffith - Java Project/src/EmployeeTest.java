import static org.junit.Assert.*;
import org.junit.Test;

public class EmployeeTest {

	@Test
	public void testGetFirst_name() {
		Employee e = new Employee(1,java.sql.Date.valueOf("2018-01-01"), "Alan", "Anderson", "M", java.sql.Date.valueOf("2018-01-03"));
		assertEquals("Alan", e.getFirstName());
	}
	
	@Test
	public void testGetLast_name() {
		Employee e = new Employee(1, java.sql.Date.valueOf("2018-01-01"), "Alan", "Anderson", "M", java.sql.Date.valueOf("2018-01-03"));
		assertEquals("Anderson", e.getLastName());
	}
}
