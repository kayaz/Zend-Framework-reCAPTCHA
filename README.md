# Zend-Framework-reCAPTCHA
Simple functions usign google reCAPTCHA for my CMS

application.ini
```
google.recaptcha.pagekey = ''
google.recaptcha.secret = ''
```

Place in `<head>` section:
```
<?php echo getRecaptchaBody(); ?>
```
  
Place in `<form>` section:
```
<?php echo getRecaptchaForm('action_name') ;?>
```

Check recaptcha response:
```
$grecaptcha = $this->_request->getPost('g-recaptcha-response');
if(getRecaptchaCheck($grecaptcha) === true){
// send form
}
```
