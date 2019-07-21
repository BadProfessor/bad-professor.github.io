$(document).ready(function(){
	$('.faq_question h3').click(function(){
		$(this).next('.faq_content').slideToggle();
		$(this).parent().toggleClass('active');
		$(this).parent().siblings().children('.faq_content').slideUp();
		$(this).parent().siblings().removeClass('active');
	});
});
