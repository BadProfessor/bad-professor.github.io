<?php
include_once("header.php");
?>
    <section class ="form_container">
      <form action="#" method="POST" class ="career_form">
  			<h1>CAREERS</h1>
        <p>Globo Gym are always on the look out for enthusiastic and committed staff to join our team.
          If you want to join our team then complete the form and send us your CV below.</p>
  			<label>FULLNAME*</label><input type="text" name="name" id="name" class ="form_control" size="20" maxlength="30" placeholder ="Prototype Non Functional">
        <label>EMAIL ADDRESS*</label><input type="email" name="email" class ="form_control" placeholder ="Prototype Example"/>
        <label>ADDRESS*</label> <input type="text" name="address" size="20" maxlength="200" class ="form_control" placeholder ="Prototype Example">
        <label>PHONE NUMBER*</label><input type="tel" name="phone" placeholder ="Prototype Example" class ="form_control"/>
        <label>WHY WOULD YOU LIKE TO WORK AT GLOBO GYM?</label><textarea class = "form_control" placeholder ="Prototype Example"></textarea>
        <label>UPLOAD YOUR CV HERE (KEEP YOUR FILE SIZE 2MB AND ONLY SEND PDF ONLY) </label><input type="file" name="myFile">
        <input type="submit" name="submit" value="SUBMIT FORM" class ="submit_form">
      </form>
    </section>
<?php
include_once("footer.php");
?>
